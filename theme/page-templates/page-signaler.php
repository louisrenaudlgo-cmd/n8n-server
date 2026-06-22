<?php
/**
 * Template Name: Signaler
 */
get_header(); ?>

<div class="page-hero">
  <div class="wrap">
    <p class="page-hero-tag">Nos actions — Signaler</p>
    <h1>Tableau de bord des signalements</h1>
    <p>Infractions documentées semaine par semaine, dossiers transmis à l'ARCOM et statuts de traitement.</p>
  </div>
</div>
<div class="accent-bar"></div>

<main id="primary">

  <!-- KPIs hebdomadaires -->
  <div class="kpi-band">
    <div class="wrap">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
        <span style="font-size:.72rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(255,255,255,.4); font-weight:600;">
          Semaine en cours — <?php echo esc_html(get_option('oca_kpi_updated', 'mise à jour chaque lundi')); ?>
        </span>
        <?php if (current_user_can('manage_options')): ?>
          <a href="<?php echo esc_url(admin_url('options-general.php?page=oca-settings')); ?>"
             style="font-size:.72rem; color:var(--cyan); font-weight:600;">
            ✏ Mettre à jour les KPIs
          </a>
        <?php endif; ?>
      </div>
      <div class="kpi-band-grid">
        <div class="kpi-band-item">
          <div class="kpi-band-number alert"><?php echo esc_html(get_option('oca_kpi_signalements','65')); ?></div>
          <div class="kpi-band-label">Signalements documentés</div>
        </div>
        <div class="kpi-band-item">
          <div class="kpi-band-number"><?php echo esc_html(get_option('oca_kpi_emissions','23')); ?></div>
          <div class="kpi-band-label">Émissions concernées</div>
        </div>
        <div class="kpi-band-item">
          <div class="kpi-band-number cyan"><?php echo esc_html(get_option('oca_kpi_transmissions','12')); ?></div>
          <div class="kpi-band-label">Transmissions à l'ARCOM</div>
        </div>
        <div class="kpi-band-item">
          <div class="kpi-band-number">CNews</div>
          <div class="kpi-band-label">Chaîne principale surveillée</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Répartition par type -->
  <section class="section">
    <div class="wrap">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; align-items:start;">

        <div>
          <div class="section-header">
            <span class="section-tag">Analyse</span>
            <h2 class="section-title">Répartition par type d'infraction</h2>
          </div>

          <?php
          $types = [
              ['label'=>'Discours de haine',          'n'=>18, 'pct'=>28, 'color'=>'var(--alert)'],
              ['label'=>'Désinformation / faux faits', 'n'=>22, 'pct'=>34, 'color'=>'#f97316'],
              ['label'=>'Non-contradiction systématique','n'=>17,'pct'=>26,'color'=>'var(--france)'],
              ['label'=>'Atteinte au pluralisme',      'n'=>8,  'pct'=>12, 'color'=>'var(--cyan)'],
          ];
          foreach ($types as $t):
          ?>
          <div style="margin-bottom:1rem;">
            <div style="display:flex; justify-content:space-between; font-size:.82rem; font-weight:600; color:var(--marine); margin-bottom:.3rem;">
              <span><?php echo esc_html($t['label']); ?></span>
              <span><?php echo $t['n']; ?> (<?php echo $t['pct']; ?>%)</span>
            </div>
            <div style="background:var(--gray-200); border-radius:999px; height:6px; overflow:hidden;">
              <div style="width:<?php echo $t['pct']; ?>%; height:100%; background:<?php echo $t['color']; ?>; border-radius:999px;"></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Top chaînes -->
        <div>
          <div class="section-header">
            <span class="section-tag">Classement</span>
            <h2 class="section-title">Top infractions par chaîne</h2>
          </div>
          <div class="chain-table-wrap">
            <table class="chain-table">
              <thead>
                <tr>
                  <th>Chaîne</th>
                  <th>Infractions</th>
                  <th>Transmissions</th>
                  <th>Statut</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $chaines_data = [
                    ['CNews','47','9','alert','Sous surveillance'],
                    ['C8',   '12','3','alert','Sous surveillance'],
                    ['BFM',  '4', '0','ok',   'RAS'],
                    ['TF1',  '2', '0','ok',   'RAS'],
                ];
                foreach ($chaines_data as [$nom, $inf, $trans, $status, $label]):
                ?>
                <tr>
                  <td class="chain-name"><?php echo esc_html($nom); ?></td>
                  <td><?php echo esc_html($inf); ?></td>
                  <td><?php echo esc_html($trans); ?></td>
                  <td>
                    <?php if ($status === 'alert'): ?>
                      <span class="status-alert">⚠ <?php echo esc_html($label); ?></span>
                    <?php else: ?>
                      <span class="status-ok">✓ <?php echo esc_html($label); ?></span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Liste des infractions documentées -->
  <section class="section section--gray">
    <div class="wrap">
      <div class="section-header">
        <span class="section-tag">Documentation</span>
        <h2 class="section-title">Infractions documentées</h2>
        <p class="section-lead">Chaque signalement comprend verbatim horodaté, analyse et référence de convention.</p>
      </div>

      <?php
      $query = new WP_Query([
          'post_type'      => 'infraction',
          'posts_per_page' => 10,
          'post_status'    => 'publish',
          'orderby'        => 'date',
          'order'          => 'DESC',
      ]);

      // Filtre par chaîne
      $selected_chain = sanitize_text_field($_GET['chaine'] ?? '');
      if ($selected_chain) {
          $query = new WP_Query([
              'post_type'      => 'infraction',
              'posts_per_page' => 10,
              'post_status'    => 'publish',
              'tax_query'      => [['taxonomy'=>'chaine','field'=>'slug','terms'=>$selected_chain]],
          ]);
      }

      // Filtres
      $all_chains = get_terms(['taxonomy'=>'chaine','hide_empty'=>true]);
      if ($all_chains && !is_wp_error($all_chains)):
      ?>
      <div style="display:flex; gap:.5rem; flex-wrap:wrap; margin-bottom:1.5rem;">
        <a href="?" class="btn btn-sm <?php echo !$selected_chain ? 'btn-primary' : 'btn-ghost'; ?>">Toutes</a>
        <?php foreach ($all_chains as $chain): ?>
        <a href="?chaine=<?php echo esc_attr($chain->slug); ?>"
           class="btn btn-sm <?php echo $selected_chain === $chain->slug ? 'btn-primary' : 'btn-ghost'; ?>">
          <?php echo esc_html($chain->name); ?>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <div style="display:flex; flex-direction:column; gap:1rem;">
        <?php if ($query->have_posts()):
          while ($query->have_posts()): $query->the_post();
            $chaines  = get_the_terms(get_the_ID(), 'chaine');
            $types    = get_the_terms(get_the_ID(), 'type_infraction');
            $conv     = get_post_meta(get_the_ID(), 'convention_arcom', true);
            $verbatim = get_post_meta(get_the_ID(), 'verbatim', true);
            $statut   = get_post_meta(get_the_ID(), 'statut_arcom', true);
        ?>
        <div class="infraction-card">
          <div class="chain">
            <?php echo $chaines ? esc_html($chaines[0]->name) : ''; ?>
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
              <span class="tag tag--conv">Conv. <?php echo esc_html($conv); ?></span>
            <?php endif; ?>
            <span class="tag tag--date"><?php echo get_the_date('d/m/Y'); ?></span>
            <?php if ($statut): ?>
              <span class="tag" style="background:var(--cyan-10); color:#0090aa;"><?php echo esc_html($statut); ?></span>
            <?php endif; ?>
          </div>
          <?php if (get_the_content()): ?>
            <div style="margin-top:.75rem; font-size:.82rem; color:var(--gray-700);">
              <?php the_excerpt(); ?>
            </div>
          <?php endif; ?>
        </div>
        <?php endwhile; wp_reset_postdata();
        else: ?>
        <div style="background:var(--alert-10); border:1px solid rgba(230,57,70,.2); border-radius:var(--r-lg); padding:2rem; text-align:center;">
          <p style="font-size:.9rem; color:var(--gray-700);">
            Aucune infraction publiée pour le moment.<br>
            <a href="<?php echo esc_url(admin_url('post-new.php?post_type=infraction')); ?>" style="color:var(--france); font-weight:700;">
              → Ajouter la première depuis wp-admin
            </a>
          </p>
        </div>
        <?php endif; ?>
      </div>

      <?php
      $total_pages = $query->max_num_pages;
      if ($total_pages > 1):
      ?>
      <div class="pagination" style="margin-top:2rem;">
        <?php echo paginate_links(['total'=>$total_pages,'current'=>max(1,get_query_var('paged'))]); ?>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Statut dossiers ARCOM -->
  <section class="section">
    <div class="wrap wrap--sm">
      <div class="section-header">
        <span class="section-tag">Suivi</span>
        <h2 class="section-title">Statut des dossiers transmis à l'ARCOM</h2>
      </div>
      <div class="chain-table-wrap">
        <table class="chain-table">
          <thead>
            <tr><th>Dossier</th><th>Date envoi</th><th>Chaîne</th><th>Type</th><th>Statut ARCOM</th></tr>
          </thead>
          <tbody>
            <?php
            $dossiers = [
                ['CNews — Propos sur l\'immigration sem. 24','16/06/2026','CNews','Non-contradiction','En attente de réponse'],
                ['CNews — Invités déséquilibrés sem. 22',   '02/06/2026','CNews','Pluralisme',       'Accusé de réception'],
                ['C8 — Discours non contredit sem. 20',     '19/05/2026','C8',   'Discours de haine','Mise en demeure envoyée'],
                ['CNews — Chiffres erronés sem. 18',        '05/05/2026','CNews','Désinformation',   'Classé sans suite'],
            ];
            foreach ($dossiers as [$titre, $date, $chaine, $type, $statut]):
              $statut_color = str_contains($statut, 'demeure') ? 'var(--alert)' : (str_contains($statut, 'réception') ? 'var(--france)' : 'var(--gray-400)');
            ?>
            <tr>
              <td style="font-size:.82rem; max-width:280px;"><?php echo esc_html($titre); ?></td>
              <td style="font-size:.78rem; white-space:nowrap;"><?php echo esc_html($date); ?></td>
              <td><strong style="color:var(--marine);"><?php echo esc_html($chaine); ?></strong></td>
              <td><span class="tag tag--type"><?php echo esc_html($type); ?></span></td>
              <td><span style="font-size:.75rem; color:<?php echo $statut_color; ?>; font-weight:600;"><?php echo esc_html($statut); ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
