<footer class="site-footer">
  <?php
  /* átmenetileg szükségtelen
  <div class="site-footer__top">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p class="site-footer__legal-notice"><?php _e(get_option('general_option_footer_legal'), 'vintageworld'); ?></p>
        </div>
      </div>
    </div>
  </div>
  */
  ?>
  <div class="site-footer__bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="site-footer__menu-container">
            <?php wp_nav_menu( array( 'theme_location' => 'lablecmenu', 'depth' => 1, 'menu_id' => 'lablec-menu' ) ); ?>

          </nav>
          <p class="site-footer__legal-copyright">© Copyright - <?php echo date('Y'); ?> - <?php $copyright_text = get_option('general_option_footer_copyright'); _e($copyright_text, 'vintageworld'); ?></p>
        </div>
      </div>
    </div>
  </div>
</footer>

</div><!-- #site-canvas -->
</main><!-- #main -->

<?php wp_footer(); ?>

</body>

</html>
