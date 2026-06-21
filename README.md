# WordPress OCA – Infrastructure & Thème

Dépôt de déploiement WordPress pour **observatoire-citoyen-de-l-audiovisuel.fr**.

## Structure

```
.
├── install.sh                          # Script d'installation complet (Ubuntu 22.04+)
├── nginx/
│   └── observatoire-citoyen-de-l-audiovisuel.fr.conf   # Vhost Nginx
└── theme/
    ├── style.css                       # Thème principal + design tokens OCA
    ├── functions.php                   # Setup, enqueue, widgets
    ├── index.php                       # Template accueil / archive
    ├── single.php                      # Article unique
    ├── page.php                        # Page statique
    ├── header.php
    ├── footer.php
    ├── template-parts/
    │   ├── hero.php                    # Bannière d'accueil
    │   ├── card.php                    # Carte article
    │   └── stats-band.php             # Bandeau statistiques
    └── assets/js/main.js              # JS léger (menu mobile, scroll)
```

## Installation rapide

```bash
# 1. Cloner le dépôt sur le VPS
git clone https://github.com/louisrenaudlgo-cmd/n8n-server.git /opt/oca-deploy
cd /opt/oca-deploy

# 2. Rendre le script exécutable
chmod +x install.sh

# 3. Lancer en tant que root
sudo bash install.sh
```

Le script :
- Installe **PHP 8.2-FPM** (et ses extensions WordPress)
- Installe et configure **MariaDB** (base `wordpress_oca`, utilisateur dédié)
- Installe **Nginx** et déploie le vhost du domaine
- Télécharge et configure **WordPress** (préfixe `oca_`, HTTPS, sel de sécurité)
- Installe le **thème OCA** et l'active via WP-CLI
- Obtient le **certificat SSL** Let's Encrypt via Certbot

À la fin, le script affiche les identifiants générés aléatoirement (DB, admin WP).

## Prérequis

- Ubuntu 22.04 LTS (ou 24.04)
- Accès root
- Le domaine `observatoire-citoyen-de-l-audiovisuel.fr` **pointant vers l'IP du VPS** (A/AAAA) avant de lancer Certbot

## Couleurs OCA

| Rôle         | Variable CSS       | Hex       |
|--------------|--------------------|-----------|
| Bleu marine  | `--oca-navy`       | `#0d2c6b` |
| Cyan         | `--oca-cyan`       | `#00c8e8` |
| Rouge        | `--oca-red`        | `#d42b2b` |

## Post-installation

- **WP-Admin** : `https://observatoire-citoyen-de-l-audiovisuel.fr/wp-admin`
- Aller dans *Apparence → Menus* pour créer les menus "principal" et "footer"
- Aller dans *Apparence → Widgets* pour alimenter les sidebars footer
- Remplacer `theme/screenshot.php` par une vraie capture `screenshot.png` (1200×900)
