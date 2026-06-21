<?php get_header(); ?>

<main id="primary">

  <!-- ── HERO ──────────────────────────────────────────────────────────────── -->
  <section class="hero">
    <div class="container">
      <div class="hero-grid">

        <div class="hero-content">
          <div class="hero-eyebrow">
            <?php echo esc_html(get_option('oca_semaine_label', 'Semaine 25 — juin 2026')); ?>
          </div>

          <h1>
            <span class="alert-text"><?php echo esc_html(get_option('oca_kpi_signalements','65')); ?> infractions documentées</span><br>
            cette semaine sur <span class="highlight">CNews</span>.<br>
            Transmises à l'ARCOM.
          </h1>

          <p class="hero-lead">
            L'OCA surveille les conventions audiovisuelles et documente chaque manquement.
            Parce que réguler les médias, c'est l'affaire de tous les citoyens.
          </p>

          <div class="hero-actions">
            <a href="<?php echo esc_url(home_url('/nos-actions/signaler')); ?>" class="btn btn-primary btn-lg">
              Voir les signalements
            </a>
            <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>" class="btn btn-outline btn-lg">
              Comprendre l'ARCOM
            </a>
          </div>
        </div>

        <!-- KPI panel -->
        <div class="hero-kpi-panel">
          <h3>📊 Tableau de bord — semaine en cours</h3>
          <div class="kpi-list">
            <div class="kpi-item">
              <span class="kpi-label">Signalements documentés</span>
              <span class="kpi-value alert" id="kpi-signalements">
                <?php echo esc_html(get_option('oca_kpi_signalements','65')); ?>
              </span>
            </div>
            <div class="kpi-item">
              <span class="kpi-label">Émissions concernées</span>
              <span class="kpi-value" id="kpi-emissions">
                <?php echo esc_html(get_option('oca_kpi_emissions','23')); ?>
              </span>
            </div>
            <div class="kpi-item">
              <span class="kpi-label">Transmissions à l'ARCOM</span>
              <span class="kpi-value cyan" id="kpi-transmissions">
                <?php echo esc_html(get_option('oca_kpi_transmissions','12')); ?>
              </span>
            </div>
          </div>
          <?php $updated = get_option('oca_kpi_updated',''); if ($updated): ?>
            <span class="kpi-update">Mis à jour le <?php echo esc_html($updated); ?></span>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </section>

  <div class="accent-bar"></div>

  <!-- ── KPI BAND ──────────────────────────────────────────────────────────── -->
  <div class="kpi-band">
    <div class="container">
      <div class="kpi-band-grid">
        <div class="kpi-band-item">
          <div class="kpi-band-number alert">500+</div>
          <div class="kpi-band-label">Signalements depuis 2023</div>
        </div>
        <div class="kpi-band-item">
          <div class="kpi-band-number">25</div>
          <div class="kpi-band-label">Chaînes TNT surveillées</div>
        </div>
        <div class="kpi-band-item">
          <div class="kpi-band-number cyan">47</div>
          <div class="kpi-band-label">Dossiers transmis ARCOM</div>
        </div>
        <div class="kpi-band-item">
          <div class="kpi-band-number">3</div>
          <div class="kpi-band-label">Chaînes sous surveillance active</div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── TOP INFRACTIONS (newsletter preview) ──────────────────────────────── -->
  <section class="section">
    <div class="container">
      <div style="display:grid; grid-template-columns:1fr 360px; gap:2.5rem; align-items:start;">

        <div>
          <div class="section-header">
            <span class="section-tag">Derniers signalements</span>
            <h2 class="section-title">Top infractions de la semaine</h2>
            <p class="section-lead">Manquements documentés par l'OCA, avec verbatim horodaté et référence de convention ARCOM.</p>
          </div>

          <?php
          $infractions = new WP_Query([
              'post_type'      => 'infraction',
              'posts_per_page' => 3,
              'post_status'    => 'publish',
          ]);
          if ($infractions->have_posts()):
            while ($infractions->have_posts()): $infractions->the_post();
              $chaines = get_the_terms(get_the_ID(), 'chaine');
              $types   = get_the_terms(get_the_ID(), 'type_infraction');
              $conv    = get_post_meta(get_the_ID(), 'convention_arcom', true);
              $verbatim= get_post_meta(get_the_ID(), 'verbatim', true);
          ?>
          <div class="infraction-card" style="margin-bottom:1rem;">
            <div class="chain">
              <?php echo $chaines ? esc_html($chaines[0]->name) : 'Chaîne inconnue'; ?>
            </div>
            <h4><?php the_title(); ?></h4>
            <?php if ($verbatim): ?>
              <div class="verbatim">"<?php echo esc_html($verbatim); ?>"</div>
            <?php endif; ?>
            <div class="meta">
              <?php if ($types): ?>
                <span class="tag tag--type"><?php echo esc_html($types[0]->name); ?></span>
              <?php endif; ?>
              <?php if ($conv): ?>
                <span class="tag tag--conv">Convention <?php echo esc_html($conv); ?></span>
              <?php endif; ?>
              <span class="tag tag--date"><?php echo get_the_date('d/m/Y'); ?></span>
            </div>
          </div>
          <?php
            endwhile; wp_reset_postdata();
          else:
          ?>
          <div class="infraction-card">
            <div class="chain">CNews</div>
            <h4>Exemple — propos non contradictés sur l'immigration (à renseigner)</h4>
            <div class="verbatim">"Verbatim horodaté à saisir depuis wp-admin → Infractions → Ajouter"</div>
            <div class="meta">
              <span class="tag tag--type">Non-contradiction</span>
              <span class="tag tag--conv">Convention art. 3.1</span>
              <span class="tag tag--date">21/06/2026</span>
            </div>
          </div>
          <p style="font-size:.82rem; color:var(--gray-400); margin-top:1rem;">
            → Ajoutez de vraies infractions depuis <strong>wp-admin → Infractions → Ajouter</strong>
          </p>
          <?php endif; ?>

          <div style="margin-top:1.5rem;">
            <a href="<?php echo esc_url(home_url('/nos-actions/signaler')); ?>" class="btn btn-ghost">
              Voir tous les signalements →
            </a>
          </div>
        </div>

        <!-- Newsletter sidebar -->
        <div class="newsletter-preview">
          <h3>📧 Newsletter OCA</h3>
          <p style="font-size:.875rem; color:rgba(255,255,255,.75); line-height:1.65; margin-bottom:1.25rem;">
            Chaque semaine : top 5 infractions, analyse, référence convention ARCOM.
            Aucune publicité. Indépendant.
          </p>
          <div class="subscribe-bar" style="flex-direction:column; max-width:100%;">
            <?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
            <p style="font-size:.7rem; color:rgba(255,255,255,.35); margin-top:.5rem;">
              Désabonnement à tout moment. Données hébergées en France.
            </p>
          </div>

          <div style="margin-top:1.5rem; padding-top:1.25rem; border-top:1px solid rgba(255,255,255,.1);">
            <p style="font-size:.72rem; text-transform:uppercase; letter-spacing:.08em; color:var(--cyan); font-weight:700; margin-bottom:.75rem;">
              Dernière newsletter
            </p>
            <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>"
               style="font-size:.875rem; color:rgba(255,255,255,.8); display:block; padding:.5rem 0; border-bottom:1px solid rgba(255,255,255,.07);">
              → Semaine 24 : CNews et le traitement de l'immigration
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ── CARTE TNT aperçu ───────────────────────────────────────────────────── -->
  <section class="section section--gray">
    <div class="container">
      <div class="section-header" style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:1rem;">
        <div>
          <span class="section-tag">Cartographie</span>
          <h2 class="section-title">Carte des groupes TNT</h2>
          <p class="section-lead">25 chaînes nationales, 5 groupes propriétaires. Cliquez pour voir les conventions ARCOM.</p>
        </div>
        <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>" class="btn btn-ghost">
          Voir la carte complète →
        </a>
      </div>

      <!-- Preview chaînes sous surveillance -->
      <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1rem; margin-top:1rem;">

        <?php
        $chaines_preview = [
            ['nom'=>'CNews',        'groupe'=>'Vivendi / Bolloré', 'statut'=>'alert', 'part'=>'3.1%'],
            ['nom'=>'C8',           'groupe'=>'Vivendi / Bolloré', 'statut'=>'alert', 'part'=>'3.0%'],
            ['nom'=>'TF1',          'groupe'=>'Bouygues',          'statut'=>'ok',    'part'=>'20.2%'],
            ['nom'=>'M6',           'groupe'=>'Bertelsmann',        'statut'=>'ok',    'part'=>'9.8%'],
            ['nom'=>'France 2',     'groupe'=>'France Télévisions', 'statut'=>'ok',    'part'=>'13.4%'],
            ['nom'=>'BFM TV',       'groupe'=>'Altice / SFR',       'statut'=>'ok',    'part'=>'3.2%'],
        ];
        foreach ($chaines_preview as $ch):
            $is_alert = $ch['statut'] === 'alert';
        ?>
        <div style="background:<?php echo $is_alert ? 'rgba(230,57,70,.06)' : 'var(--white)'; ?>;
                    border:1px solid <?php echo $is_alert ? 'rgba(230,57,70,.25)' : 'var(--gray-200)'; ?>;
                    border-radius:var(--r-md);
                    padding:1rem 1.1rem;
                    box-shadow:var(--shadow-sm);">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:.35rem;">
            <strong style="font-size:.95rem; color:var(--marine);"><?php echo esc_html($ch['nom']); ?></strong>
            <?php if ($is_alert): ?>
              <span style="font-size:.68rem; background:var(--alert); color:white; padding:.15rem .45rem; border-radius:999px; font-weight:700;">⚠ Surveillance</span>
            <?php endif; ?>
          </div>
          <div style="font-size:.75rem; color:var(--gray-400);"><?php echo esc_html($ch['groupe']); ?></div>
          <div style="font-size:.78rem; font-weight:600; color:var(--france); margin-top:.3rem;"><?php echo esc_html($ch['part']); ?> d'audience</div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ── PROFILS VISITEURS ─────────────────────────────────────────────────── -->
  <section class="section section--dark">
    <div class="container">
      <div class="section-header section-header--center" style="margin-bottom:2rem;">
        <h2 class="section-title section-title--white">Qui sommes-nous ?</h2>
      </div>
      <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem;">

        <?php
        $profils = [
            ['ico'=>'🧑‍💻','titre'=>'Citoyen curieux','texte'=>'Comprendre comment fonctionne la régulation des médias, qui décide et pourquoi c\'est important pour la démocratie.','lien'=>home_url('/nos-actions/comprendre'),'label'=>'Comprendre l\'ARCOM'],
            ['ico'=>'📰','titre'=>'Journaliste / Média','texte'=>'Accéder à nos données sourcées, notre méthodologie et contacter notre responsable presse pour toute demande.','lien'=>home_url('/contact'),'label'=>'Contact presse'],
            ['ico'=>'⚖️','titre'=>'Décideur / ARCOM','texte'=>'Consulter nos dossiers documentés avec références légales précises et numéros de conventions audiovisuelles.','lien'=>home_url('/nos-actions/signaler'),'label'=>'Nos dossiers'],
        ];
        foreach ($profils as $p):
        ?>
        <div style="background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.10); border-radius:var(--r-xl); padding:1.75rem;">
          <div style="font-size:2rem; margin-bottom:.75rem;"><?php echo $p['ico']; ?></div>
          <h3 style="font-size:1.05rem; font-weight:800; color:var(--white); margin-bottom:.5rem;"><?php echo esc_html($p['titre']); ?></h3>
          <p style="font-size:.85rem; color:rgba(255,255,255,.6); line-height:1.65; margin-bottom:1.1rem;"><?php echo esc_html($p['texte']); ?></p>
          <a href="<?php echo esc_url($p['lien']); ?>" class="btn btn-primary btn-sm"><?php echo esc_html($p['label']); ?></a>
        </div>
        <?php endforeach; ?>

      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
