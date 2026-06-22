<?php
/**
 * Template Name: Nous soutenir
 */
get_header(); ?>

<div class="page-hero">
  <div class="wrap">
    <p class="page-hero-tag">Nous soutenir</p>
    <h1>Rejoignez l'OCA</h1>
    <p>Adhérez, faites un don ou devenez bénévole de veille. L'OCA est indépendant parce que vous le financez.</p>
  </div>
</div>
<div class="accent-bar"></div>

<main id="primary">

  <!-- Pourquoi adhérer -->
  <section class="section">
    <div class="wrap">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:3rem; align-items:center;">
        <div>
          <div class="section-header">
            <span class="section-tag">Indépendance</span>
            <h2 class="section-title">Pourquoi adhérer à l'OCA ?</h2>
          </div>
          <div style="display:flex; flex-direction:column; gap:1rem;">
            <?php
            $raisons = [
                ['🔍','Soutenir une veille indépendante','L\'OCA n\'accepte aucune subvention publique ni financement privé lié aux médias. Votre cotisation est notre seule ressource.'],
                ['⚖️','Peser sur la régulation','Plus nous sommes nombreux, plus nos dossiers ARCOM ont du poids. L\'ARCOM prend davantage en compte les associations structurées.'],
                ['📖','Accéder aux contenus membres','Les adhérents reçoivent la newsletter complète avec analyses approfondies et accès à la base de données des signalements.'],
                ['🗳️','Voter en Assemblée Générale','Chaque adhérent vote sur les orientations, l\'élection du bureau et les priorités de surveillance.'],
            ];
            foreach ($raisons as [$ico, $titre, $desc]):
            ?>
            <div style="display:flex; gap:1rem; align-items:flex-start;">
              <span style="font-size:1.4rem; flex-shrink:0; line-height:1.2;"><?php echo $ico; ?></span>
              <div>
                <strong style="font-size:.9rem; color:var(--marine); display:block; margin-bottom:.2rem;"><?php echo esc_html($titre); ?></strong>
                <span style="font-size:.82rem; color:var(--gray-700); line-height:1.55;"><?php echo esc_html($desc); ?></span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Tarifs cotisation -->
        <div>
          <div style="background:var(--gray-50); border-radius:var(--r-xl); padding:2rem; border:1px solid var(--gray-200);">
            <h3 style="font-size:.78rem; text-transform:uppercase; letter-spacing:.08em; color:var(--france); font-weight:700; margin-bottom:1.25rem;">Cotisations annuelles</h3>
            <?php
            $tarifs = [
                ['Tarif solidaire',   '5 €/an',  'Pour les personnes en situation précaire', false],
                ['Adhésion standard', '15 €/an', 'Tarif de référence recommandé',            true],
                ['Adhésion soutien',  '30 €/an', 'Pour soutenir plus fortement notre action',false],
                ['Adhésion bienfaiteur','50+ €/an','Mention dans nos rapports annuels',      false],
            ];
            foreach ($tarifs as [$label, $prix, $desc, $featured]):
            ?>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:1rem;
                        background:<?php echo $featured ? 'var(--france)' : 'var(--white)'; ?>;
                        color:<?php echo $featured ? 'white' : 'inherit'; ?>;
                        border-radius:var(--r-md); margin-bottom:.5rem;
                        border:1px solid <?php echo $featured ? 'transparent' : 'var(--gray-200)'; ?>;
                        box-shadow:<?php echo $featured ? 'var(--shadow-md)' : 'none'; ?>;">
              <div>
                <strong style="font-size:.875rem; display:block;"><?php echo esc_html($label); ?></strong>
                <span style="font-size:.75rem; opacity:.7;"><?php echo esc_html($desc); ?></span>
              </div>
              <strong style="font-size:1.1rem; white-space:nowrap;"><?php echo esc_html($prix); ?></strong>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- HelloAsso adhésion + don -->
  <section class="section section--gray">
    <div class="wrap">
      <div class="section-header section-header--center">
        <span class="section-tag">Action</span>
        <h2 class="section-title">Adhérer ou faire un don</h2>
        <p class="section-lead">Paiement sécurisé via HelloAsso. Reçu fiscal automatique pour les dons.</p>
      </div>

      <div class="support-grid" style="max-width:900px; margin:0 auto;">

        <div class="support-card" style="border-top:4px solid var(--france);">
          <h3>Adhérer à l'OCA</h3>
          <p>
            Rejoignez l'association, participez aux AG et soutenez notre travail de façon durable.
            Cotisation à partir de 5 €/an.
          </p>
          <!-- Remplacer par le widget HelloAsso réel -->
          <div style="background:var(--gray-50); border-radius:var(--r-md); padding:1.5rem; text-align:center; border:2px dashed var(--gray-200);">
            <p style="font-size:.82rem; color:var(--gray-400); margin-bottom:.75rem;">
              Widget HelloAsso — formulaire d'adhésion
            </p>
            <a href="https://www.helloasso.com" target="_blank" rel="noopener" class="btn btn-primary">
              Adhérer via HelloAsso →
            </a>
          </div>
        </div>

        <div class="support-card" style="border-top:4px solid var(--cyan);">
          <h3>Faire un don libre</h3>
          <p>
            Tout don à une association loi 1901 reconnue d'utilité publique est déductible
            à 66% de vos impôts. Reçu fiscal automatique.
          </p>
          <div style="background:var(--gray-50); border-radius:var(--r-md); padding:1.5rem; text-align:center; border:2px dashed var(--gray-200);">
            <p style="font-size:.82rem; color:var(--gray-400); margin-bottom:.75rem;">
              Widget HelloAsso — formulaire de don
            </p>
            <a href="https://www.helloasso.com" target="_blank" rel="noopener" class="btn btn-ghost">
              Faire un don →
            </a>
          </div>
          <p style="font-size:.75rem; color:var(--gray-400); margin-top:.75rem; line-height:1.5;">
            Exemple : un don de 15 € vous coûte seulement 5,10 € après déduction fiscale.
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- Bénévolat de veille -->
  <section class="section">
    <div class="wrap wrap--sm">
      <div class="section-header section-header--center">
        <span class="section-tag">Bénévolat</span>
        <h2 class="section-title">Devenir bénévole de veille</h2>
        <p class="section-lead">
          Pas le temps pour une adhésion complète ? Vous pouvez contribuer en signalant
          des manquements depuis chez vous.
        </p>
      </div>

      <div class="explainer-grid" style="margin-bottom:2rem;">
        <?php
        $missions = [
            ['📺','Surveiller des émissions','Regarder et noter les propos potentiellement problématiques sur les chaînes TNT.'],
            ['📝','Documenter des verbatims','Horodater et transcrire les passages signalés selon notre grille d\'analyse.'],
            ['🔗','Relayer sur les réseaux','Partager nos publications pour augmenter la visibilité de nos dossiers.'],
        ];
        foreach ($missions as [$ico,$titre,$desc]):
        ?>
        <div class="explainer-item">
          <div class="explainer-icon"><?php echo $ico; ?></div>
          <h4><?php echo esc_html($titre); ?></h4>
          <p><?php echo esc_html($desc); ?></p>
        </div>
        <?php endforeach; ?>
      </div>

      <div style="background:var(--marine); border-radius:var(--r-xl); padding:2rem; color:var(--white); text-align:center;">
        <h3 style="font-size:1.1rem; font-weight:800; margin-bottom:.5rem;">Intéressé·e ?</h3>
        <p style="font-size:.875rem; color:rgba(255,255,255,.7); margin-bottom:1.25rem;">
          Envoyez-nous un message en précisant votre disponibilité et les chaînes que vous regardez.
        </p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">
          Proposer ma candidature →
        </a>
      </div>
    </div>
  </section>

  <!-- Formulaire adhésion complet (WPForms) -->
  <section class="section section--gray">
    <div class="wrap wrap--sm">
      <div class="section-header section-header--center">
        <span class="section-tag">Formulaire loi 1901</span>
        <h2 class="section-title">Formulaire d'adhésion</h2>
      </div>
      <?php echo do_shortcode('[wpforms id="2"]'); ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>
