<footer id="colophon">
  <div class="wrap">
    <div class="footer-main">

      <!-- Brand -->
      <div class="footer-brand">
        <?php get_template_part('template-parts/logo'); ?>
        <p>
          Association loi 1901 de veille citoyenne sur la régulation audiovisuelle française.
          Indépendant, transparent, sans publicité.
        </p>
      </div>

      <!-- Nav -->
      <div class="footer-col">
        <h5>L'OCA</h5>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/association')); ?>">Notre mission</a></li>
          <li><a href="<?php echo esc_url(home_url('/association')); ?>#bureau">Le bureau</a></li>
          <li><a href="<?php echo esc_url(home_url('/association')); ?>#documents">Documents PDF</a></li>
          <li><a href="<?php echo esc_url(home_url('/nous-soutenir')); ?>">Adhérer</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h5>Nos actions</h5>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>">Comprendre l'ARCOM</a></li>
          <li><a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>#carte-tnt">Carte TNT</a></li>
          <li><a href="<?php echo esc_url(home_url('/nos-actions/signaler')); ?>">Signalements</a></li>
          <li><a href="<?php echo esc_url(home_url('/nos-actions/comprendre')); ?>#newsletter">Newsletter</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h5>Contact</h5>
        <p class="footer-address">
          OCA — Observatoire Citoyen<br>
          de l'Audiovisuel<br>
          9 rue du comte Even<br>
          29260 Lesneven
        </p>
        <div style="margin-top:.75rem;">
          <a href="mailto:contact@observatoire-citoyen-de-l-audiovisuel.fr"
             style="font-size:.78rem; color:var(--navy);">
            contact@observatoire-citoyen-de-l-audiovisuel.fr
          </a>
        </div>
      </div>

    </div>
  </div>

  <div class="footer-bottom">
    <div class="wrap" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:.5rem; width:100%;">
      <span>&copy; <?php echo date('Y'); ?> Observatoire Citoyen de l'Audiovisuel — Association loi 1901</span>
      <div class="footer-bottom-links">
        <a href="#">Mentions légales</a>
        <a href="#">Politique de confidentialité</a>
        <a href="<?php echo esc_url(home_url('/contact')); ?>#presse">Presse</a>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
