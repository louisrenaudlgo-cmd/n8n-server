#!/usr/bin/env bash
# WordPress installation script for observatoire-citoyen-de-l-audiovisuel.fr
# Run as root on Ubuntu 22.04+

set -euo pipefail

DOMAIN="observatoire-citoyen-de-l-audiovisuel.fr"
WP_DIR="/var/www/${DOMAIN}"
DB_NAME="wordpress_oca"
DB_USER="wp_oca"
DB_PASS=""
WP_ADMIN_USER="admin"
WP_ADMIN_EMAIL="admin@${DOMAIN}"
PHP_VER="8.2"

# ── Helpers ──────────────────────────────────────────────────────────────────
red()   { echo -e "\033[0;31m$*\033[0m"; }
green() { echo -e "\033[0;32m$*\033[0m"; }
info()  { echo -e "\033[0;36m▶ $*\033[0m"; }

require_root() {
  [[ $EUID -eq 0 ]] || { red "Run as root (sudo bash install.sh)"; exit 1; }
}

generate_password() {
  openssl rand -base64 18 | tr -d '/+='
}

# ── Main ──────────────────────────────────────────────────────────────────────
require_root

info "Generating database password..."
DB_PASS=$(generate_password)
WP_ADMIN_PASS=$(generate_password)

info "Updating system packages..."
apt-get update -qq
apt-get upgrade -y -qq

# ── PHP ───────────────────────────────────────────────────────────────────────
info "Installing PHP ${PHP_VER} and extensions..."
apt-get install -y -qq software-properties-common
add-apt-repository -y ppa:ondrej/php
apt-get update -qq
apt-get install -y -qq \
  php${PHP_VER}-fpm \
  php${PHP_VER}-mysql \
  php${PHP_VER}-xml \
  php${PHP_VER}-mbstring \
  php${PHP_VER}-curl \
  php${PHP_VER}-zip \
  php${PHP_VER}-gd \
  php${PHP_VER}-intl \
  php${PHP_VER}-imagick \
  php${PHP_VER}-opcache \
  php${PHP_VER}-bcmath \
  php${PHP_VER}-soap

# PHP-FPM tuning
PHP_INI="/etc/php/${PHP_VER}/fpm/php.ini"
sed -i 's/^upload_max_filesize.*/upload_max_filesize = 64M/' "$PHP_INI"
sed -i 's/^post_max_size.*/post_max_size = 64M/' "$PHP_INI"
sed -i 's/^max_execution_time.*/max_execution_time = 300/' "$PHP_INI"
sed -i 's/^memory_limit.*/memory_limit = 256M/' "$PHP_INI"

systemctl enable "php${PHP_VER}-fpm"
systemctl restart "php${PHP_VER}-fpm"

# ── MariaDB ───────────────────────────────────────────────────────────────────
info "Installing MariaDB..."
apt-get install -y -qq mariadb-server

systemctl enable mariadb
systemctl start mariadb

info "Configuring database..."
mysql -u root <<SQL
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;
SQL

# ── Nginx ─────────────────────────────────────────────────────────────────────
info "Installing Nginx..."
apt-get install -y -qq nginx

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
NGINX_CONF="/etc/nginx/sites-available/${DOMAIN}"

# Deploy HTTP-only config first (certs don't exist yet – Certbot adds HTTPS)
cat > "$NGINX_CONF" <<NGINXEOF
server {
    listen 80;
    listen [::]:80;
    server_name ${DOMAIN} www.${DOMAIN};
    root ${WP_DIR};
    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$args;
    }

    location ~ \.php$ {
        include        snippets/fastcgi-php.conf;
        fastcgi_pass   unix:/run/php/php${PHP_VER}-fpm.sock;
        fastcgi_param  SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include        fastcgi_params;
    }

    location ~ /\. { deny all; }
}
NGINXEOF

ln -sf "$NGINX_CONF" "/etc/nginx/sites-enabled/${DOMAIN}"
rm -f /etc/nginx/sites-enabled/default

nginx -t
systemctl enable nginx
systemctl restart nginx

# ── WordPress ─────────────────────────────────────────────────────────────────
info "Downloading WordPress..."
apt-get install -y -qq curl wget unzip

mkdir -p "$WP_DIR"
curl -sL https://wordpress.org/latest.tar.gz | tar xz -C /tmp
rsync -a --delete /tmp/wordpress/ "${WP_DIR}/"
rm -rf /tmp/wordpress

info "Configuring WordPress..."
cp "${WP_DIR}/wp-config-sample.php" "${WP_DIR}/wp-config.php"

# DB credentials
sed -i "s/database_name_here/${DB_NAME}/"   "${WP_DIR}/wp-config.php"
sed -i "s/username_here/${DB_USER}/"         "${WP_DIR}/wp-config.php"
sed -i "s/password_here/${DB_PASS}/"         "${WP_DIR}/wp-config.php"

# Security keys (fetched from WordPress API)
SALT=$(curl -sL https://api.wordpress.org/secret-key/1.1/salt/)
# Replace the placeholder block
PHP_SALT_BLOCK=$(cat <<'PHPEOF'
define('AUTH_KEY',         'placeholder');
define('SECURE_AUTH_KEY',  'placeholder');
define('LOGGED_IN_KEY',    'placeholder');
define('NONCE_KEY',        'placeholder');
define('AUTH_SALT',        'placeholder');
define('SECURE_AUTH_SALT', 'placeholder');
define('LOGGED_IN_SALT',   'placeholder');
define('NONCE_SALT',       'placeholder');
PHPEOF
)
python3 - "${WP_DIR}/wp-config.php" "$SALT" <<'PYEOF'
import sys, re
path, salt = sys.argv[1], sys.argv[2]
with open(path) as f:
    content = f.read()
pattern = r"define\( *'AUTH_KEY'.*?define\( *'NONCE_SALT'[^;]*;"
content = re.sub(pattern, salt.strip(), content, flags=re.DOTALL)
with open(path, 'w') as f:
    f.write(content)
PYEOF

# HTTPS / table prefix
sed -i "s/\$table_prefix = 'wp_';/\$table_prefix = 'oca_';/" "${WP_DIR}/wp-config.php"
cat >> "${WP_DIR}/wp-config.php" <<'PHPEOF'

define('WP_HOME',    'https://__DOMAIN__');
define('WP_SITEURL', 'https://__DOMAIN__');
define('FORCE_SSL_ADMIN', true);
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
PHPEOF
sed -i "s|__DOMAIN__|${DOMAIN}|g" "${WP_DIR}/wp-config.php"

# Install OCA theme
info "Installing OCA theme..."
mkdir -p "${WP_DIR}/wp-content/themes/oca-theme"
cp -r "${SCRIPT_DIR}/theme/"* "${WP_DIR}/wp-content/themes/oca-theme/"

# Permissions
chown -R www-data:www-data "$WP_DIR"
find "$WP_DIR" -type d -exec chmod 755 {} \;
find "$WP_DIR" -type f -exec chmod 644 {} \;
chmod 600 "${WP_DIR}/wp-config.php"

# ── WP-CLI ────────────────────────────────────────────────────────────────────
info "Installing WP-CLI..."
curl -sL https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -o /usr/local/bin/wp
chmod +x /usr/local/bin/wp

info "Running WordPress installer..."
WP_ADMIN_PASS_DISPLAY="$WP_ADMIN_PASS"
sudo -u www-data wp core install \
  --path="$WP_DIR" \
  --url="https://${DOMAIN}" \
  --title="Observatoire Citoyen de l'Audiovisuel" \
  --admin_user="$WP_ADMIN_USER" \
  --admin_password="$WP_ADMIN_PASS" \
  --admin_email="$WP_ADMIN_EMAIL" \
  --skip-email

sudo -u www-data wp theme activate oca-theme --path="$WP_DIR"
sudo -u www-data wp option update blogdescription "Pour un audiovisuel citoyen et responsable" --path="$WP_DIR"

# ── Certbot / SSL ─────────────────────────────────────────────────────────────
info "Installing Certbot..."
apt-get install -y -qq certbot python3-certbot-nginx

info "Requesting SSL certificate for ${DOMAIN} and www.${DOMAIN}..."
certbot --nginx \
  -d "$DOMAIN" \
  -d "www.${DOMAIN}" \
  --non-interactive \
  --agree-tos \
  --email "$WP_ADMIN_EMAIL" \
  --redirect

# Replace with hardened final config (certs now exist)
cp "${SCRIPT_DIR}/nginx/${DOMAIN}.conf" "$NGINX_CONF"
sed -i "s|__PHP_VER__|${PHP_VER}|g" "$NGINX_CONF"
sed -i "s|__WP_DIR__|${WP_DIR}|g"   "$NGINX_CONF"
sed -i "s|__DOMAIN__|${DOMAIN}|g"   "$NGINX_CONF"

nginx -t && systemctl reload nginx

# ── Summary ───────────────────────────────────────────────────────────────────
green ""
green "╔══════════════════════════════════════════════════════════╗"
green "║          Installation terminée avec succès !             ║"
green "╚══════════════════════════════════════════════════════════╝"
green ""
green "  Site       : https://${DOMAIN}"
green "  Admin WP   : https://${DOMAIN}/wp-admin"
green "  Admin user : ${WP_ADMIN_USER}"
green "  Admin pass : ${WP_ADMIN_PASS_DISPLAY}"
green "  DB name    : ${DB_NAME}"
green "  DB user    : ${DB_USER}"
green "  DB pass    : ${DB_PASS}"
green ""
red   "  ⚠ Notez ces identifiants — ils ne seront pas réaffichés."
green ""
