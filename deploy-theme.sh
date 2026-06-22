#!/usr/bin/env bash
# Déploie le thème OCA v2 sur le VPS depuis /opt/oca-deploy
set -euo pipefail

THEME_SRC="$(cd "$(dirname "${BASH_SOURCE[0]}")/theme" && pwd)"
THEME_DST="/var/www/observatoire-citoyen-de-l-audiovisuel.fr/wp-content/themes/oca-theme"
WP="wp --path=/var/www/observatoire-citoyen-de-l-audiovisuel.fr --allow-root"

echo "▶ Synchronisation du thème…"
rsync -av --delete "${THEME_SRC}/" "${THEME_DST}/"

echo "▶ Correction des permissions…"
chown -R www-data:www-data "$THEME_DST"
find "$THEME_DST" -type f -exec chmod 644 {} \;
find "$THEME_DST" -type d -exec chmod 755 {} \;

echo "▶ Activation du thème…"
$WP theme activate oca-theme

echo "▶ Création des pages avec les bons templates…"

create_page() {
  local title="$1" slug="$2" template="$3"
  local existing
  existing=$($WP post list --post_type=page --name="$slug" --field=ID 2>/dev/null | head -1)
  if [ -z "$existing" ]; then
    local id
    id=$($WP post create \
      --post_type=page \
      --post_title="$title" \
      --post_name="$slug" \
      --post_status=publish \
      --porcelain)
    echo "  Créée : $title (ID $id)"
    existing=$id
  fi
  $WP post meta update "$existing" "_wp_page_template" "$template" 2>/dev/null || true
  echo "  Template '$template' appliqué à '$title' (ID $existing)"
}

create_page "L'Association"  "association"   "page-templates/page-association.php"
create_page "Comprendre"     "comprendre"    "page-templates/page-comprendre.php"
create_page "Signaler"       "signaler"      "page-templates/page-signaler.php"
create_page "Contact"        "contact"       "page-templates/page-contact.php"
create_page "Nous soutenir"  "nous-soutenir" "page-templates/page-nous-soutenir.php"

# Page parente "Nos actions"
NOS_ACTIONS_ID=$($WP post list --post_type=page --name="nos-actions" --field=ID 2>/dev/null | head -1)
if [ -z "$NOS_ACTIONS_ID" ]; then
  NOS_ACTIONS_ID=$($WP post create \
    --post_type=page \
    --post_title="Nos actions" \
    --post_name="nos-actions" \
    --post_status=publish \
    --porcelain)
  echo "  Créée : Nos actions (ID $NOS_ACTIONS_ID)"
fi

# Rattacher Comprendre et Signaler à Nos actions
for slug in comprendre signaler; do
  child_id=$($WP post list --post_type=page --name="$slug" --field=ID 2>/dev/null | head -1)
  if [ -n "$child_id" ]; then
    $WP post update "$child_id" --post_parent="$NOS_ACTIONS_ID" 2>/dev/null || true
    echo "  '$slug' rattaché à 'nos-actions'"
  fi
done

echo "▶ Construction des menus…"

# Supprimer l'ancien menu principal et le recréer
$WP menu delete "Menu principal" 2>/dev/null || true
$WP menu create "Menu principal"

ACCUEIL_ID=$($WP post list --post_type=page --name="accueil" --field=ID 2>/dev/null | head -1)
ASSOC_ID=$($WP post list --post_type=page --name="association" --field=ID 2>/dev/null | head -1)
ACTIONS_ID="$NOS_ACTIONS_ID"
COMPRENDRE_ID=$($WP post list --post_type=page --name="comprendre" --field=ID 2>/dev/null | head -1)
SIGNALER_ID=$($WP post list --post_type=page --name="signaler" --field=ID 2>/dev/null | head -1)
CONTACT_ID=$($WP post list --post_type=page --name="contact" --field=ID 2>/dev/null | head -1)
SOUTENIR_ID=$($WP post list --post_type=page --name="nous-soutenir" --field=ID 2>/dev/null | head -1)

[ -n "$ACCUEIL_ID" ]   && $WP menu item add-post menu-principal "$ACCUEIL_ID"
[ -n "$ASSOC_ID" ]     && $WP menu item add-post menu-principal "$ASSOC_ID"

# Nos actions avec sous-menu
if [ -n "$ACTIONS_ID" ]; then
  ACTIONS_ITEM=$($WP menu item add-post menu-principal "$ACTIONS_ID" --porcelain)
  [ -n "$COMPRENDRE_ID" ] && $WP menu item add-post menu-principal "$COMPRENDRE_ID" --parent-id="$ACTIONS_ITEM"
  [ -n "$SIGNALER_ID" ]   && $WP menu item add-post menu-principal "$SIGNALER_ID"   --parent-id="$ACTIONS_ITEM"
fi

[ -n "$CONTACT_ID" ]   && $WP menu item add-post menu-principal "$CONTACT_ID"
[ -n "$SOUTENIR_ID" ]  && $WP menu item add-post menu-principal "$SOUTENIR_ID"

$WP menu location assign menu-principal primary

echo "▶ Enregistrement des options OCA…"
$WP option update oca_kpi_signalements "65"
$WP option update oca_kpi_emissions    "23"
$WP option update oca_kpi_transmissions "12"
$WP option update oca_kpi_updated      "21 juin 2026"
$WP option update oca_semaine_label    "Semaine 25 — juin 2026"
$WP option update oca_alert_ticker     "CNews : 65 infractions documentées cette semaine — dossier transmis à l'ARCOM"

echo "▶ Import image hero…"
HERO_SRC="${THEME_DST}/assets/images/hero.jpg"
if [ -f "$HERO_SRC" ]; then
  existing_hero=$($WP option get oca_hero_image_id 2>/dev/null || echo "")
  if [ -z "$existing_hero" ] || ! $WP post get "$existing_hero" --field=ID 2>/dev/null; then
    hero_id=$($WP media import "$HERO_SRC" \
      --title="Hero OCA — conférence de presse" \
      --alt="Journaliste lors d'une conférence de presse audiovisuelle" \
      --porcelain 2>/dev/null || echo "")
    if [ -n "$hero_id" ]; then
      $WP option update oca_hero_image_id "$hero_id"
      echo "  Image hero importée (ID $hero_id)"
    fi
  else
    echo "  Image hero déjà importée (ID $existing_hero)"
  fi
else
  echo "  ⚠ hero.jpg absent de ${THEME_DST}/assets/images/ — image ignorée"
fi

echo "▶ Flush des règles de réécriture…"
$WP rewrite flush

echo ""
echo "✅ Déploiement terminé !"
echo "   Site    : https://observatoire-citoyen-de-l-audiovisuel.fr"
echo "   Admin   : https://observatoire-citoyen-de-l-audiovisuel.fr/wp-admin"
echo ""
echo "Prochaines étapes manuelles :"
echo "  1. wp-admin → Réglages OCA : mettre à jour les KPIs chaque semaine"
echo "  2. wp-admin → Infractions → Ajouter : saisir les infractions documentées"
echo "  3. Installer MailPoet + WPForms + Yoast SEO"
echo "  4. Configurer le formulaire MailPoet (shortcode [mailpoet_form id=\"1\"])"
echo "  5. Configurer le formulaire WPForms (shortcode [wpforms id=\"1\"])"
echo "  6. Déposer carte-tnt-oca.html dans /var/www/observatoire-citoyen-de-l-audiovisuel.fr/"
