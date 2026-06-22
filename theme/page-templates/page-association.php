<?php
/**
 * Template Name: L'Association
 */
get_header(); ?>

<div class="page-hero">
  <div class="wrap">
    <p class="page-hero-tag">Qui sommes-nous</p>
    <h1>L'Observatoire Citoyen de l'Audiovisuel</h1>
    <p>Association loi 1901 de veille citoyenne sur la régulation audiovisuelle française</p>
  </div>
</div>
<div class="accent-bar"></div>

<main id="primary">

  <!-- Mission -->
  <section class="section">
    <div class="wrap">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:3rem; align-items:center;">
        <div>
          <div class="section-header">
            <span class="section-tag">Notre mission</span>
            <h2 class="section-title">Surveiller. Documenter. Alerter.</h2>
          </div>
          <div style="font-size:1rem; color:var(--gray-700); line-height:1.8;">
            <p style="margin-bottom:1rem;">
              L'OCA est une association citoyenne indépendante qui surveille l'application des
              <strong>conventions audiovisuelles ARCOM</strong> par les chaînes de la TNT nationale.
            </p>
            <p style="margin-bottom:1rem;">
              Nous documentons chaque manquement — discours de haine, désinformation,
              absence de contradictoire, atteinte au pluralisme — et transmettons les dossiers
              à l'ARCOM pour demander l'application des sanctions prévues par la loi.
            </p>
            <p>
              Notre surveillance porte aujourd'hui en priorité sur <strong>CNews</strong>,
              dont les manquements répétés ont fait l'objet de nombreuses mises en demeure
              de l'autorité de régulation.
            </p>
          </div>
          <div style="margin-top:1.75rem; display:flex; gap:1rem; flex-wrap:wrap;">
            <a href="<?php echo esc_url(home_url('/nous-soutenir')); ?>" class="btn btn-primary">Nous rejoindre</a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-ghost">Nous contacter</a>
          </div>
        </div>
        <div>
          <div style="background:var(--marine); border-radius:var(--r-xl); padding:2rem; color:var(--white);">
            <div style="font-size:.72rem; text-transform:uppercase; letter-spacing:.1em; color:var(--cyan); font-weight:700; margin-bottom:1.25rem;">En chiffres</div>
            <?php
            $stats = [
                ['v'=>'2023',  'l'=>'Année de création'],
                ['v'=>'Loi 1901','l'=>'Statut associatif'],
                ['v'=>'500+',  'l'=>'Signalements documentés'],
                ['v'=>'47',    'l'=>'Dossiers transmis à l\'ARCOM'],
                ['v'=>'3',     'l'=>'Membres du bureau'],
            ];
            foreach ($stats as $s): ?>
            <div style="display:flex; justify-content:space-between; padding:.75rem 0; border-bottom:1px solid rgba(255,255,255,.07);">
              <span style="font-size:.85rem; color:rgba(255,255,255,.6);"><?php echo esc_html($s['l']); ?></span>
              <strong style="color:var(--cyan);"><?php echo esc_html($s['v']); ?></strong>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mot du président -->
  <section class="section section--gray">
    <div class="wrap wrap--sm">
      <div class="section-header section-header--center">
        <span class="section-tag">Éditorial</span>
        <h2 class="section-title">Mot du président</h2>
      </div>
      <div style="background:var(--white); border-radius:var(--r-xl); padding:2.5rem; box-shadow:var(--shadow-card); border-left:4px solid var(--france); position:relative;">
        <div style="font-size:3rem; color:var(--france); opacity:.15; position:absolute; top:1rem; left:1.5rem; line-height:1; font-family:Georgia,serif;">"</div>
        <blockquote style="font-size:1.05rem; line-height:1.8; color:var(--gray-700); font-style:italic; margin-bottom:1.5rem; padding-left:1.5rem;">
          L'audiovisuel français n'est pas la propriété de quelques milliardaires.
          Il est concédé par la collectivité à des groupes privés via des conventions,
          en échange du respect de règles précises : pluralisme, équilibre, rigueur factuelle.
          L'OCA est là pour vérifier que ces règles sont respectées — et alerter quand elles ne le sont pas.
          C'est une mission citoyenne, pas partisane.
        </blockquote>
        <div style="display:flex; align-items:center; gap:1rem; padding-left:1.5rem;">
          <div style="width:48px; height:48px; background:linear-gradient(135deg,var(--marine),var(--france)); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:800; flex-shrink:0;">LR</div>
          <div>
            <div style="font-weight:800; color:var(--marine);">Louis RENAUD</div>
            <div style="font-size:.78rem; color:var(--france); font-weight:600;">Président de l'OCA</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Bureau -->
  <section class="section">
    <div class="wrap">
      <div class="section-header section-header--center">
        <span class="section-tag">Gouvernance</span>
        <h2 class="section-title">Le bureau</h2>
      </div>
      <div class="bureau-grid" style="max-width:900px; margin:0 auto;">

        <?php
        $bureau = [
            ['initiales'=>'LR','nom'=>'Louis RENAUD',      'role'=>'Président',                              'detail'=>'Initiateur du projet, coordinateur général de la surveillance'],
            ['initiales'=>'MM','nom'=>'Manon MONCHATRE',   'role'=>'Vice-Présidente & Secrétaire Générale',  'detail'=>'Organisation administrative et communication'],
            ['initiales'=>'XG','nom'=>'Xavier DE GOUBERVILLE','role'=>'Trésorier',                           'detail'=>'Gestion financière et comptes de l\'association'],
        ];
        foreach ($bureau as $m):
        ?>
        <div class="bureau-card">
          <div class="bureau-avatar"><?php echo esc_html($m['initiales']); ?></div>
          <div class="bureau-name"><?php echo esc_html($m['nom']); ?></div>
          <div class="bureau-role"><?php echo esc_html($m['role']); ?></div>
          <p style="font-size:.8rem; color:var(--gray-400); margin-top:.6rem; line-height:1.5;"><?php echo esc_html($m['detail']); ?></p>
        </div>
        <?php endforeach; ?>

      </div>
    </div>
  </section>

  <!-- Documents -->
  <section class="section section--gray">
    <div class="wrap wrap--sm">
      <div class="section-header">
        <span class="section-tag">Transparence</span>
        <h2 class="section-title">Documents officiels</h2>
        <p class="section-lead">Tous nos documents statutaires sont publics et téléchargeables.</p>
      </div>
      <div class="pdf-list">
        <?php
        $docs = [
            ['titre'=>'Statuts de l\'association',            'desc'=>'Version déposée en préfecture — janvier 2023',  'url'=>'#'],
            ['titre'=>'Règlement intérieur',                   'desc'=>'Adopté en AG — mars 2023',                      'url'=>'#'],
            ['titre'=>'Compte-rendu AG 2024',                  'desc'=>'Assemblée Générale ordinaire — juin 2024',       'url'=>'#'],
            ['titre'=>'Compte-rendu AG 2025',                  'desc'=>'Assemblée Générale ordinaire — juin 2025',       'url'=>'#'],
        ];
        foreach ($docs as $d):
        ?>
        <a href="<?php echo esc_url($d['url']); ?>" class="pdf-item" target="_blank" rel="noopener">
          <div class="pdf-icon">📄</div>
          <div class="pdf-info">
            <strong><?php echo esc_html($d['titre']); ?></strong>
            <span><?php echo esc_html($d['desc']); ?></span>
          </div>
          <span style="font-size:.75rem; color:var(--france); font-weight:700;">Télécharger PDF ↓</span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Adresse -->
  <section class="section">
    <div class="wrap wrap--sm" style="text-align:center;">
      <span class="section-tag">Localisation</span>
      <h2 class="section-title" style="margin:0 auto .75rem;">Siège social</h2>
      <div style="background:var(--marine-10); border-radius:var(--r-lg); padding:1.5rem; display:inline-block; margin-top:1rem;">
        <p style="font-size:1.05rem; font-weight:700; color:var(--marine);">9 rue du comte Even</p>
        <p style="font-size:1.05rem; color:var(--france);">29260 Lesneven — Bretagne</p>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
