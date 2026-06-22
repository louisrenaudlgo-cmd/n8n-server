<?php
/**
 * Template Name: Comprendre
 */
get_header(); ?>

<div class="page-hero">
  <div class="wrap">
    <p class="page-hero-tag">Nos actions — Comprendre</p>
    <h1>Pourquoi réguler l'audiovisuel ?</h1>
    <p>Comprendre les conventions ARCOM, les pouvoirs du régulateur et la carte des groupes TNT.</p>
  </div>
</div>
<div class="accent-bar"></div>

<main id="primary">

  <!-- Explainer ARCOM -->
  <section class="section">
    <div class="wrap">
      <div class="section-header">
        <span class="section-tag">Pédagogie</span>
        <h2 class="section-title">Les conventions ARCOM</h2>
        <p class="section-lead">
          Chaque chaîne de la TNT signe une convention avec l'ARCOM qui définit ses obligations.
          Ce contrat est public, contraignant et assorti de sanctions.
        </p>
      </div>

      <div class="explainer-grid">
        <div class="explainer-item">
          <div class="explainer-icon">📋</div>
          <h4>Qu'est-ce qu'une convention ?</h4>
          <p>Document contractuel entre l'ARCOM et chaque éditeur TNT. Il fixe les obligations
          en matière de pluralisme, d'honnêteté de l'information, de protection du public
          et de conditions de diffusion.</p>
        </div>
        <div class="explainer-item">
          <div class="explainer-icon">👁</div>
          <h4>Ce que surveille l'OCA</h4>
          <p>Nous vérifions l'article 3 (pluralisme politique), l'article 5 (honnêteté de l'information),
          les dispositions anti-discours de haine et les obligations de non-contradiction systématique.</p>
        </div>
        <div class="explainer-item">
          <div class="explainer-icon">⚖️</div>
          <h4>Le rôle de l'ARCOM</h4>
          <p>L'Autorité de Régulation de la Communication Audiovisuelle et Numérique est une autorité
          administrative indépendante. Elle attribue les fréquences TNT et contrôle le respect des conventions.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Ce que peut/ne peut pas faire l'ARCOM -->
  <section class="section section--gray">
    <div class="wrap">
      <div class="section-header section-header--center">
        <h2 class="section-title">Les pouvoirs de l'ARCOM</h2>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; max-width:960px; margin:0 auto;">

        <div>
          <h3 style="font-size:.85rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#22c55e; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem;">
            <span style="width:24px;height:24px;background:#22c55e;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:white;font-size:.8rem;">✓</span>
            Ce que l'ARCOM PEUT faire
          </h3>
          <?php
          $peut = [
              'Mise en garde (pas de publicité)',
              'Mise en demeure (rendue publique)',
              'Sanction financière (jusqu\'à 3% du CA)',
              'Réduction de la durée de convention',
              'Retrait de la fréquence TNT (cas extrême)',
              'Saisine du CSA / tribunaux administratifs',
          ];
          foreach ($peut as $item): ?>
          <div style="display:flex; align-items:flex-start; gap:.75rem; padding:.65rem 0; border-bottom:1px solid var(--gray-200);">
            <span style="color:#22c55e; flex-shrink:0; font-weight:700; margin-top:.1rem;">→</span>
            <span style="font-size:.875rem; color:var(--gray-700);"><?php echo esc_html($item); ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <div>
          <h3 style="font-size:.85rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--alert); margin-bottom:1rem; display:flex; align-items:center; gap:.5rem;">
            <span style="width:24px;height:24px;background:var(--alert);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:white;font-size:.8rem;">✗</span>
            Ce que l'ARCOM NE PEUT PAS faire
          </h3>
          <?php
          $nepeut = [
              'Censurer un contenu avant diffusion',
              'Ordonner le retrait immédiat d\'une émission',
              'Poursuivre pénalement un journaliste',
              'Contraindre une ligne éditoriale',
              'Révoquer un directeur de rédaction',
              'Agir sans procédure contradictoire préalable',
          ];
          foreach ($nepeut as $item): ?>
          <div style="display:flex; align-items:flex-start; gap:.75rem; padding:.65rem 0; border-bottom:1px solid var(--gray-200);">
            <span style="color:var(--alert); flex-shrink:0; font-weight:700; margin-top:.1rem;">✗</span>
            <span style="font-size:.875rem; color:var(--gray-700);"><?php echo esc_html($item); ?></span>
          </div>
          <?php endforeach; ?>
        </div>

      </div>
    </div>
  </section>

  <!-- Carte TNT -->
  <section class="section">
    <div class="wrap">
      <div class="section-header">
        <span class="section-tag">Cartographie</span>
        <h2 class="section-title">Carte interactive des groupes TNT</h2>
        <p class="section-lead">
          25 chaînes nationales gratuites organisées par groupe propriétaire.
          Cliquez sur une chaîne pour consulter sa convention ARCOM et ses sanctions.
        </p>
      </div>

      <!-- La carte HTML externe est intégrée ici via iframe ou include -->
      <div style="border-radius:var(--r-xl); overflow:hidden; box-shadow:var(--shadow-lg); border:1px solid var(--gray-200);">
        <?php
        $carte_path = '/var/www/observatoire-citoyen-de-l-audiovisuel.fr/carte-tnt-oca.html';
        if (file_exists($carte_path)):
        ?>
        <iframe
          src="/carte-tnt-oca.html"
          width="100%"
          height="700"
          style="border:none; display:block;"
          title="Carte interactive TNT — OCA"
          loading="lazy">
        </iframe>
        <?php else: ?>
        <div style="background:var(--marine); color:white; padding:2.5rem; text-align:center;">
          <p style="margin-bottom:.5rem; color:var(--cyan); font-weight:700;">Carte TNT à intégrer</p>
          <p style="font-size:.875rem; color:rgba(255,255,255,.6);">
            Copiez <code>carte-tnt-oca.html</code> dans
            <code>/var/www/observatoire-citoyen-de-l-audiovisuel.fr/</code>
          </p>
        </div>
        <?php endif; ?>
      </div>

      <!-- Légende groupes -->
      <div style="display:flex; flex-wrap:wrap; gap:.75rem; margin-top:1.5rem;">
        <?php
        $groupes = [
            ['TF1 / Bouygues',         '#1e40af'],
            ['M6 / Bertelsmann',        '#7c3aed'],
            ['CNews·C8 / Vivendi·Bolloré','#dc2626'],
            ['BFM·RMC / Altice·SFR',   '#d97706'],
            ['France Télévisions (public)','#16a34a'],
        ];
        foreach ($groupes as [$label, $color]): ?>
        <div style="display:flex; align-items:center; gap:.4rem; font-size:.75rem; color:var(--gray-700);">
          <span style="width:10px;height:10px;background:<?php echo $color; ?>;border-radius:50%;flex-shrink:0;"></span>
          <?php echo esc_html($label); ?>
        </div>
        <?php endforeach; ?>
        <div style="display:flex; align-items:center; gap:.4rem; font-size:.75rem; color:var(--alert); font-weight:700;">
          <span style="width:10px;height:10px;background:var(--alert);border-radius:50%;flex-shrink:0;"></span>
          ⚠ Sous surveillance ARCOM active
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="section section--dark">
    <div class="wrap">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:3rem; align-items:center;">
        <div>
          <span class="section-tag" style="color:var(--cyan);">Newsletter mensuelle</span>
          <h2 class="section-title section-title--white">Restez informé chaque semaine</h2>
          <p style="color:rgba(255,255,255,.7); line-height:1.7; margin-top:.5rem; font-size:.95rem;">
            Chaque semaine dans votre boîte mail :
          </p>
          <ul style="margin-top:1rem; display:flex; flex-direction:column; gap:.5rem;">
            <?php foreach (['Top 5 infractions de la semaine','Verbatim horodaté + analyse','Référence de convention ARCOM','Statut du dossier ARCOM'] as $li): ?>
            <li style="font-size:.875rem; color:rgba(255,255,255,.65); display:flex; align-items:center; gap:.5rem;">
              <span style="color:var(--cyan); font-size:.8rem;">→</span> <?php echo esc_html($li); ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div>
          <?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
