<?php
/**
 * Template Name: Contact
 */
get_header(); ?>

<div class="page-hero">
  <div class="wrap">
    <p class="page-hero-tag">Contact</p>
    <h1>Contactez l'OCA</h1>
    <p>Citoyens, journalistes, médias, chercheurs — nous répondons à tous les messages.</p>
  </div>
</div>
<div class="accent-bar"></div>

<main id="primary">

  <section class="section">
    <div class="wrap">
      <div style="display:grid; grid-template-columns:1fr 340px; gap:3rem; align-items:start;">

        <!-- Formulaire -->
        <div>
          <div class="section-header">
            <span class="section-tag">Formulaire</span>
            <h2 class="section-title">Envoyez-nous un message</h2>
          </div>
          <?php echo do_shortcode('[wpforms id="1"]'); ?>
          <div style="background:var(--gray-50); border-radius:var(--r-lg); padding:1.25rem; margin-top:1.5rem; font-size:.82rem; color:var(--gray-400); line-height:1.6;">
            Vos données sont traitées conformément au RGPD. Elles ne sont jamais cédées à des tiers.
            <a href="#" style="color:var(--france);">Politique de confidentialité</a>
          </div>
        </div>

        <!-- Sidebar contacts -->
        <div style="display:flex; flex-direction:column; gap:1.25rem;">

          <div style="background:var(--marine); color:var(--white); border-radius:var(--r-xl); padding:1.75rem;">
            <h3 style="font-size:.78rem; text-transform:uppercase; letter-spacing:.08em; color:var(--cyan); font-weight:700; margin-bottom:1.25rem;">Contacts directs</h3>

            <?php
            $contacts = [
                ['📧','Contact général',      'contact@observatoire-citoyen-de-l-audiovisuel.fr', 'mailto:contact@observatoire-citoyen-de-l-audiovisuel.fr'],
                ['📰','Contact presse',       'presse@observatoire-citoyen-de-l-audiovisuel.fr',  'mailto:presse@observatoire-citoyen-de-l-audiovisuel.fr'],
                ['📍','Adresse postale',      '9 rue du comte Even\n29260 Lesneven',               null],
            ];
            foreach ($contacts as [$ico, $label, $val, $href]):
            ?>
            <div style="padding:.85rem 0; border-bottom:1px solid rgba(255,255,255,.07); <?php echo $href ? '' : 'border:none; padding-bottom:0;'; ?>">
              <div style="font-size:.72rem; color:rgba(255,255,255,.4); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.3rem;">
                <?php echo $ico; ?> <?php echo esc_html($label); ?>
              </div>
              <?php if ($href): ?>
                <a href="<?php echo esc_url($href); ?>" style="font-size:.875rem; color:var(--cyan); word-break:break-all;"><?php echo esc_html($val); ?></a>
              <?php else: ?>
                <span style="font-size:.875rem; color:rgba(255,255,255,.75); white-space:pre-line;"><?php echo esc_html($val); ?></span>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
          </div>

          <!-- Réseaux sociaux -->
          <div style="background:var(--white); border:1px solid var(--gray-200); border-radius:var(--r-xl); padding:1.5rem;">
            <h3 style="font-size:.78rem; text-transform:uppercase; letter-spacing:.08em; color:var(--france); font-weight:700; margin-bottom:1rem;">Nous suivre</h3>
            <div style="display:flex; flex-direction:column; gap:.5rem;">
              <?php
              $socials = [
                  ['𝕏 Twitter / X',    '#', 'Actualités et signalements en temps réel'],
                  ['LinkedIn',          '#', 'Publications et veille institutionnelle'],
                  ['Mastodon',          '#', 'Réseau fédéré, sans algorithme'],
              ];
              foreach ($socials as [$name, $url, $desc]):
              ?>
              <a href="<?php echo esc_url($url); ?>"
                 style="display:flex; align-items:center; gap:.75rem; padding:.6rem .75rem; border-radius:var(--r-md); background:var(--gray-50); text-decoration:none; transition:background .2s;"
                 target="_blank" rel="noopener">
                <span style="font-size:.9rem; font-weight:700; color:var(--marine); flex-shrink:0; min-width:80px;"><?php echo esc_html($name); ?></span>
                <span style="font-size:.75rem; color:var(--gray-400);"><?php echo esc_html($desc); ?></span>
              </a>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Kit presse -->
          <a href="#" class="pdf-item" style="display:flex; align-items:center; gap:1rem; padding:1.1rem 1.25rem; background:var(--white); border:1px solid var(--gray-200); border-radius:var(--r-md); box-shadow:var(--shadow-sm); text-decoration:none; color:inherit;">
            <div class="pdf-icon">🗂</div>
            <div class="pdf-info">
              <strong>Kit presse OCA</strong>
              <span>Logos, visuels, communiqués de presse</span>
            </div>
            <span style="font-size:.75rem; color:var(--france); font-weight:700; white-space:nowrap;">Télécharger ↓</span>
          </a>

        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="section section--gray">
    <div class="wrap wrap--sm" style="text-align:center;">
      <span class="section-tag">Newsletter</span>
      <h2 class="section-title" style="margin:0 auto .5rem;">S'abonner à la newsletter</h2>
      <p style="color:var(--gray-400); margin-bottom:1.5rem;">Infractions de la semaine, analyses et alertes ARCOM — chaque lundi.</p>
      <?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>
