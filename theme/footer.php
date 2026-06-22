<footer id="colophon">

  <div class="wrap">
    <div class="footer-main">

      <!-- Col 1 — Brand -->
      <div>
        <span class="footer-brand-name">OCA</span>
        <span class="footer-brand-tagline">Observatoire Citoyen de l'Audiovisuel<br>Surveillance des conventions ARCOM</span>
        <span class="footer-brand-mention">Association loi 1901 — indépendant, sans publicité</span>
      </div>

      <!-- Col 2 — L'OCA -->
      <div class="footer-col">
        <h5>L'OCA</h5>
        <a href="<?php echo esc_url(home_url('/association')); ?>">Mission</a>
        <a href="<?php echo esc_url(home_url('/association')); ?>#bureau">Bureau</a>
        <a href="<?php echo esc_url(home_url('/association')); ?>#documents">Documents</a>
        <a href="<?php echo esc_url(home_url('/nous-soutenir')); ?>">Adhérer</a>
      </div>

      <!-- Col 3 — Nos actions -->
      <div class="footer-col">
        <h5>Nos actions</h5>
        <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>">ARCOM</a>
        <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>#carte-tnt">Carte TNT</a>
        <a href="<?php echo esc_url(home_url('/nos-actions/signaler')); ?>">Signalements</a>
        <a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>#newsletter">Newsletter</a>
      </div>

      <!-- Col 4 — Contact -->
      <div class="footer-col">
        <h5>Contact</h5>
        <a href="mailto:contact@observatoire-citoyen-de-l-audiovisuel.fr">contact@oca.fr</a>
        <a href="mailto:presse@observatoire-citoyen-de-l-audiovisuel.fr">presse@oca.fr</a>
        <a href="<?php echo esc_url(home_url('/contact')); ?>">Formulaire de contact</a>
        <span style="font-size:12px; color:#888; display:block; margin-top:8px; line-height:1.5;">
          9 rue du comte Even<br>29260 Lesneven
        </span>
      </div>

    </div>
  </div>

  <div class="wrap">
    <div class="footer-bottom">
      <span class="footer-bottom-copy">
        &copy; <?php echo date('Y'); ?> Observatoire Citoyen de l'Audiovisuel — Association loi 1901
      </span>
      <div class="footer-bottom-links">
        <a href="#">Mentions légales</a>
        <a href="#">Données personnelles</a>
        <a href="<?php echo esc_url(home_url('/contact')); ?>#presse">Presse</a>
      </div>
    </div>
  </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
