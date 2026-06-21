<?php get_header(); ?>

<main id="primary">

  <!-- ── HERO ──────────────────────────────────────────────────────────────── -->
  <section class="hero">
    <div class="wrap">

      <p class="hero-eyebrow">
        <?php echo esc_html(get_option('oca_semaine_label', 'Semaine 25 — juin 2026')); ?>
      </p>

      <h1>
        <span class="hero-num"><?php echo esc_html(get_option('oca_kpi_signalements','65')); ?> infractions</span>
        documentées cette semaine sur <span class="hero-chain">CNews</span>.<br>
        Dossier transmis à l'ARCOM.
      </h1>

      <p class="hero-intro">
        L'OCA surveille les conventions audiovisuelles et documente chaque manquement.
        Parce que réguler les médias, c'est l'affaire de tous les citoyens.
      </p>

      <div class="hero-stats">
        <div class="stat-block">
          <div class="stat-value"><?php echo esc_html(get_option('oca_kpi_signalements','65')); ?></div>
          <div class="stat-label">Signalements cette semaine</div>
        </div>
        <div class="stat-block">
          <div class="stat-value"><?php echo esc_html(get_option('oca_kpi_emissions','23')); ?></div>
          <div class="stat-label">Émissions concernées</div>
        </div>
        <div class="stat-block">
          <div class="stat-value"><?php echo esc_html(get_option('oca_kpi_transmissions','12')); ?></div>
          <div class="stat-label">Transmissions à l'ARCOM</div>
        </div>
      </div>

      <div class="hero-cta">
        <a href="<?php echo esc_url(home_url('/nos-actions/signaler')); ?>" class="btn btn-primary">
          Voir les signalements
        </a>
        <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>" class="btn btn-secondary">
          Comprendre l'ARCOM
        </a>
      </div>

    </div>
  </section>

  <!-- ── DERNIERS SIGNALEMENTS ─────────────────────────────────────────────── -->
  <section class="section">
    <div class="wrap">

      <div class="section-header">
        <h2>Derniers signalements</h2>
        <a href="<?php echo esc_url(home_url('/nos-actions/signaler')); ?>" class="section-link">
          Tous les signalements →
        </a>
      </div>

      <?php
      $infractions = new WP_Query([
          'post_type'      => 'infraction',
          'posts_per_page' => 5,
          'post_status'    => 'publish',
      ]);
      if ($infractions->have_posts()):
        while ($infractions->have_posts()): $infractions->the_post();
          $chaines = get_the_terms(get_the_ID(), 'chaine');
          $types   = get_the_terms(get_the_ID(), 'type_infraction');
      ?>
      <div class="infraction-row">
        <span class="infraction-date"><?php echo get_the_date('d/m/Y'); ?></span>
        <?php if ($chaines): ?>
          <span class="tag-pill"><?php echo esc_html($chaines[0]->name); ?></span>
        <?php endif; ?>
        <?php if ($types): ?>
          <span class="tag-pill tag-pill--type"><?php echo esc_html($types[0]->name); ?></span>
        <?php endif; ?>
        <a href="<?php the_permalink(); ?>" class="infraction-title"><?php the_title(); ?></a>
      </div>
      <?php
        endwhile; wp_reset_postdata();
      else:
      ?>
      <div class="infraction-row">
        <span class="infraction-date">21/06/2026</span>
        <span class="tag-pill">CNews</span>
        <span class="tag-pill tag-pill--type">Non-contradiction</span>
        <span class="infraction-title" style="color:var(--gray-400); font-style:italic;">
          Exemple — à saisir depuis wp-admin → Infractions → Ajouter
        </span>
      </div>
      <?php endif; ?>

    </div>
  </section>

  <!-- ── CHAÎNES SOUS SURVEILLANCE ────────────────────────────────────────── -->
  <section class="section section--gray">
    <div class="wrap">

      <div class="section-header">
        <h2>Chaînes sous surveillance</h2>
        <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>" class="section-link">
          Carte TNT complète →
        </a>
      </div>

      <div class="chaines-grid">
        <?php
        $chaines_preview = [
            ['nom'=>'CNews',    'groupe'=>'Vivendi / Bolloré', 'alert'=>true,  'part'=>'3.1%'],
            ['nom'=>'C8',       'groupe'=>'Vivendi / Bolloré', 'alert'=>true,  'part'=>'3.0%'],
            ['nom'=>'TF1',      'groupe'=>'Bouygues',          'alert'=>false, 'part'=>'20.2%'],
            ['nom'=>'M6',       'groupe'=>'Bertelsmann',        'alert'=>false, 'part'=>'9.8%'],
            ['nom'=>'France 2', 'groupe'=>'France Télévisions', 'alert'=>false, 'part'=>'13.4%'],
            ['nom'=>'BFM TV',   'groupe'=>'Altice / SFR',       'alert'=>false, 'part'=>'3.2%'],
        ];
        foreach ($chaines_preview as $ch):
        ?>
        <div class="chaine-card<?php echo $ch['alert'] ? ' chaine-card--alert' : ''; ?>">
          <div class="chaine-card-top">
            <strong><?php echo esc_html($ch['nom']); ?></strong>
            <?php if ($ch['alert']): ?>
              <span class="tag-pill tag-pill--alert">Surveillance</span>
            <?php endif; ?>
          </div>
          <div class="chaine-card-groupe"><?php echo esc_html($ch['groupe']); ?></div>
          <div class="chaine-card-part"><?php echo esc_html($ch['part']); ?> d'audience</div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- ── QUI SOMMES-NOUS ──────────────────────────────────────────────────── -->
  <section class="section">
    <div class="wrap">

      <div class="section-header">
        <h2>Qui sommes-nous ?</h2>
      </div>

      <div class="profils-grid">
        <?php
        $profils = [
            ['titre'=>'Citoyen curieux',    'texte'=>'Comprendre comment fonctionne la régulation des médias, qui décide et pourquoi c\'est important pour la démocratie.', 'lien'=>home_url('/nos-actions/comprendre'), 'label'=>'Comprendre l\'ARCOM'],
            ['titre'=>'Journaliste / Média', 'texte'=>'Accéder à nos données sourcées, notre méthodologie et contacter notre responsable presse pour toute demande.',         'lien'=>home_url('/contact'),                'label'=>'Contact presse'],
            ['titre'=>'Décideur / ARCOM',   'texte'=>'Consulter nos dossiers documentés avec références légales précises et numéros de conventions audiovisuelles.',          'lien'=>home_url('/nos-actions/signaler'),   'label'=>'Nos dossiers'],
        ];
        foreach ($profils as $p):
        ?>
        <div class="profil-card">
          <h3><?php echo esc_html($p['titre']); ?></h3>
          <p><?php echo esc_html($p['texte']); ?></p>
          <a href="<?php echo esc_url($p['lien']); ?>" class="btn btn-primary btn-sm">
            <?php echo esc_html($p['label']); ?>
          </a>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- ── NEWSLETTER ───────────────────────────────────────────────────────── -->
  <section class="section section--gray">
    <div class="wrap wrap--sm">
      <div class="newsletter-block">
        <h2>Newsletter hebdomadaire</h2>
        <p>Chaque semaine : top infractions, analyse, référence convention ARCOM. Aucune publicité. Indépendant.</p>
        <?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
        <p class="newsletter-legal">Désabonnement à tout moment. Données hébergées en France.</p>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
