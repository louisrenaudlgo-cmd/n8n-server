<?php get_header(); ?>

<main id="primary">

  <!-- ═══ HERO ═══════════════════════════════════════════════════════════════ -->
  <section class="hero">
   <div class="wrap">
    <div class="hero-inner">

    <!-- Colonne gauche : contenu texte -->
    <div class="hero-left">

      <p class="hero-eyebrow">
        <?php echo esc_html(get_option('oca_semaine_label', 'Semaine 25 — juin 2026')); ?>
      </p>

      <h1>
        <span class="hero-num"><?php echo esc_html(get_option('oca_kpi_signalements', '65')); ?> infractions</span>
        documentées cette<br>
        semaine sur <span class="hero-chain">CNews</span>.<br>
        Dossier transmis à l'ARCOM.
      </h1>

      <p class="hero-intro">
        <?php
        // Texte modifiable dans Gutenberg → page Accueil → champ "Extrait"
        $front_id = get_option('page_on_front');
        $excerpt  = $front_id ? get_post_field('post_excerpt', $front_id) : '';
        echo $excerpt
          ? esc_html($excerpt)
          : 'L\'OCA surveille les conventions audiovisuelles et documente chaque manquement avec verbatim horodaté. Parce que réguler les médias, c\'est l\'affaire de tous les citoyens.';
        ?>
      </p>

      <div class="stats-row">
        <div class="stat-block">
          <span class="stat-num red"><?php echo esc_html(get_option('oca_kpi_signalements', '65')); ?></span>
          <span class="stat-label">Signalements cette semaine</span>
        </div>
        <div class="stat-block">
          <span class="stat-num"><?php echo esc_html(get_option('oca_kpi_emissions', '23')); ?></span>
          <span class="stat-label">Émissions concernées</span>
        </div>
        <div class="stat-block">
          <span class="stat-num"><?php echo esc_html(get_option('oca_kpi_transmissions', '12')); ?></span>
          <span class="stat-label">Transmis à l'ARCOM</span>
        </div>
      </div>

      <div class="hero-cta">
        <a href="<?php echo esc_url(home_url('/nos-actions/signaler')); ?>" class="btn btn-primary">
          Voir les signalements
        </a>
        <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>" class="btn btn-outline">
          Comprendre l'ARCOM
        </a>
      </div>

    </div>

    <!-- Colonne droite : photo -->
    <div class="hero-image">
      <?php
      // Photo modifiable dans Gutenberg → page Accueil → "Image à la une"
      $front_id     = get_option('page_on_front');
      $thumb_id     = $front_id ? get_post_thumbnail_id($front_id) : 0;

      // Fallback : ancienne option oca_hero_image_id
      if (!$thumb_id) $thumb_id = get_option('oca_hero_image_id');

      $hero_img_url = $thumb_id
        ? wp_get_attachment_image_url($thumb_id, 'oca-hero')
        : get_template_directory_uri() . '/assets/images/hero-placeholder.svg';
      ?>
      <img
        src="<?php echo esc_url($hero_img_url); ?>"
        alt="<?php echo $thumb_id ? esc_attr(get_post_meta($thumb_id, '_wp_attachment_image_alt', true)) : 'Photo hero OCA'; ?>"
        loading="eager"
      >
    </div>

    </div><!-- .hero-inner -->
   </div><!-- .wrap -->
  </section>

  <!-- ═══ SIGNALEMENTS ════════════════════════════════════════════════════════ -->
  <section class="section">
    <div class="wrap">

      <div class="section-hdr">
        <span class="section-hdr-label">Derniers signalements</span>
        <a href="<?php echo esc_url(home_url('/nos-actions/signaler')); ?>" class="section-hdr-link">Tous →</a>
      </div>

      <?php
      $infractions = new WP_Query([
        'post_type'      => 'infraction',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
      ]);

      $type_classes = [
        'non-contradiction' => 'tag--red',
        'pluralisme'        => 'tag--blue',
        'desinformation'    => 'tag--grey',
        'décision'          => 'tag--blue',
        'alerte'            => 'tag--red',
      ];

      if ($infractions->have_posts()):
        while ($infractions->have_posts()): $infractions->the_post();
          $chaines = get_the_terms(get_the_ID(), 'chaine');
          $types   = get_the_terms(get_the_ID(), 'type_infraction');
          $type_class = 'tag--grey';
          if ($types) {
            $slug = sanitize_title($types[0]->name);
            foreach ($type_classes as $k => $v) {
              if (str_contains($slug, $k)) { $type_class = $v; break; }
            }
          }
      ?>
      <div class="infraction-row">
        <span class="infraction-date"><?php echo get_the_date('d/m/Y'); ?></span>
        <?php if ($chaines): ?>
          <span class="tag tag--blue"><?php echo esc_html($chaines[0]->name); ?></span>
        <?php endif; ?>
        <?php if ($types): ?>
          <span class="tag <?php echo esc_attr($type_class); ?>"><?php echo esc_html($types[0]->name); ?></span>
        <?php endif; ?>
        <a href="<?php the_permalink(); ?>" class="infraction-title"><?php the_title(); ?></a>
      </div>
      <?php
        endwhile; wp_reset_postdata();
      else:
      ?>
      <div class="infraction-row">
        <span class="infraction-date">21/06/2026</span>
        <span class="tag tag--blue">CNews</span>
        <span class="tag tag--red">Non-contradiction</span>
        <span class="infraction-title" style="color:var(--text-4); font-style:italic;">
          À renseigner depuis wp-admin → Infractions → Ajouter
        </span>
      </div>
      <?php endif; ?>

    </div>
  </section>

  <!-- ═══ CHAÎNES ════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div class="wrap">

      <div class="section-hdr">
        <span class="section-hdr-label">Chaînes sous surveillance</span>
        <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>#carte-tnt" class="section-hdr-link">Carte TNT →</a>
      </div>

      <div class="chaines-grid">
        <?php
        $chaines = [
          ['nom' => 'CNews',    'prop' => 'Vivendi / Bolloré', 'statut' => 'surv', 'aud' => '3.1 %'],
          ['nom' => 'C8',       'prop' => 'Vivendi / Bolloré', 'statut' => 'surv', 'aud' => '3.0 %'],
          ['nom' => 'TF1',      'prop' => 'Bouygues',          'statut' => 'obs',  'aud' => '20.2 %'],
          ['nom' => 'M6',       'prop' => 'Bertelsmann',        'statut' => 'obs',  'aud' => '9.8 %'],
          ['nom' => 'France 2', 'prop' => 'France Télévisions', 'statut' => 'obs',  'aud' => '13.4 %'],
          ['nom' => 'BFM TV',   'prop' => 'Altice / SFR',       'statut' => 'obs',  'aud' => '3.2 %'],
        ];
        foreach ($chaines as $ch):
          $active = $ch['statut'] === 'surv';
        ?>
        <div class="chaine-card<?php echo $active ? ' active' : ''; ?>">
          <span class="chaine-card-nom"><?php echo esc_html($ch['nom']); ?></span>
          <span class="chaine-card-prop"><?php echo esc_html($ch['prop']); ?></span>
          <?php if ($active): ?>
            <span class="badge-surv">Surveillance</span>
          <?php else: ?>
            <span class="badge-obs">Observée</span>
          <?php endif; ?>
          <span class="chaine-card-aud"><?php echo esc_html($ch['aud']); ?> d'audience</span>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- ═══ PROFILS ════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div class="wrap">

      <div class="section-hdr">
        <span class="section-hdr-label">Qui sommes-nous ?</span>
      </div>

      <div class="profils-grid">
        <?php
        $profils = [
          ['titre' => 'Citoyen curieux',    'desc' => 'Comprendre comment fonctionne la régulation des médias, qui décide et pourquoi c\'est essentiel pour la démocratie.',  'lien' => home_url('/nos-actions/comprendre'), 'label' => 'Comprendre l\'ARCOM'],
          ['titre' => 'Journaliste / Média', 'desc' => 'Accéder à nos données sourcées, notre méthodologie et contacter notre responsable presse pour toute demande d\'interview.', 'lien' => home_url('/contact'),                'label' => 'Espace presse'],
          ['titre' => 'Décideur / ARCOM',   'desc' => 'Consulter nos dossiers documentés avec références légales précises et numéros de conventions audiovisuelles.',              'lien' => home_url('/nos-actions/signaler'),   'label' => 'Nos dossiers'],
        ];
        foreach ($profils as $p):
        ?>
        <div class="profil-card">
          <h3><?php echo esc_html($p['titre']); ?></h3>
          <p><?php echo esc_html($p['desc']); ?></p>
          <a href="<?php echo esc_url($p['lien']); ?>" class="profil-link">
            <?php echo esc_html($p['label']); ?> →
          </a>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- ═══ NEWSLETTER ══════════════════════════════════════════════════════════ -->
  <section class="section">
    <div class="wrap">

      <div class="newsletter-row">

        <div class="newsletter-left">
          <span class="section-hdr-label" style="display:block; margin-bottom:8px;">Newsletter hebdomadaire</span>
          <h2>Recevoir le bulletin de l'OCA</h2>
          <p>Chaque semaine : top infractions, analyse, référence convention ARCOM. Aucune publicité. Indépendant.</p>
        </div>

        <div class="newsletter-right">
          <?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
          <?php if (!shortcode_exists('mailpoet_form')): ?>
          <form class="newsletter-form" action="#" method="post">
            <input type="email" name="email" placeholder="votre@email.fr" required>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
          </form>
          <p class="newsletter-note">Désabonnement à tout moment. Données hébergées en France.</p>
          <?php endif; ?>
        </div>

      </div>

    </div>
  </section>

</main>

<?php get_footer(); ?>
