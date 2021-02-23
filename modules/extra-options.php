<?php

  class new_general_setting{

    function new_general_setting(){
      // Általános beállítások - Telefonszám megadása
      add_filter('admin_init', array(&$this, 'register_fields__phone'));
      // Általános beállítások - E-mail cím megadása
      add_filter('admin_init', array(&$this, 'register_fields__email'));
      // Általános beállítások - Cégnév megadása
      add_filter('admin_init', array(&$this, 'register_fields__companyname'));
      // Általános beállítások - Készítő (DC meta elem) megadása
      add_filter('admin_init', array(&$this, 'register_fields__creator'));

      add_filter('admin_init', array(&$this, 'register_fields__keyword'));
      // Általános beállítások - Faceboolin megadása
      add_filter('admin_init', array(&$this, 'register_fields__facebook'));
      // Általános beállítások - Instagram link megadása
      add_filter('admin_init', array(&$this, 'register_fields__instagram'));
      // Általános beállítások - Pinterest link megadása
      add_filter('admin_init', array(&$this, 'register_fields__pinterest'));
      // Általános beállítások - Tik-Tok link megadása
      add_filter('admin_init', array(&$this, 'register_fields__tiktok'));
    }


    function register_fields__phone(){
      register_setting('general', 'general_option_phone', 'esc_attr');
      add_settings_field('general_option_phone', '<label for="general_option_phone">Telefonszám</label>', array(&$this, 'fields__phone_html'), 'general');
    }
    function fields__phone_html(){
      $value = get_option('general_option_phone', '');
      echo '<input class="regular-text code" type="text" id="general_option_phone" name="general_option_phone" value="'.$value.'">';
    }

    function register_fields__email(){
      register_setting('general', 'general_option_email', 'esc_attr');
      add_settings_field('general_option_email', '<label for="general_option_email">E-mail cím</label>', array(&$this, 'fields__email_html'), 'general');
    }
    function fields__email_html(){
      $value = get_option('general_option_email', '');
      echo '<input class="regular-text code" type="text" id="general_option_email" name="general_option_email" value="'.$value.'">';
    }

    function register_fields__companyname(){
      register_setting('general', 'general_option_companyname', 'esc_attr');
      add_settings_field('general_option_companyname', '<label for="general_option_companyname">Cégnév</label>', array(&$this, 'fields__companyname_html'), 'general');
    }
    function fields__companyname_html(){
      $value = get_option('general_option_companyname', '');
      echo '<input class="regular-text code" type="text" id="general_option_companyname" name="general_option_companyname" value="'.$value.'">';
    }

    function register_fields__creator(){
      register_setting('general', 'general_option_creator', 'esc_attr');
      add_settings_field('general_option_creator', '<label for="general_option_creator">Készítő (DC meta elem)</label>', array(&$this, 'fields__creator_html'), 'general');
    }
    function fields__creator_html(){
      $value = get_option('general_option_creator', '');
      echo '<input class="regular-text code" type="text" id="general_option_creator" name="general_option_creator" value="'.$value.'">';
    }

    function register_fields__keyword(){
      register_setting('general', 'general_option_keyword', 'esc_attr');
      add_settings_field('general_option_keyword', '<label for="general_option_keyword">Kulcsszavak <small>(DC meta és META keyword elem)</small></label>', array(&$this, 'fields__keyword_html'), 'general');
    }
    function fields__keyword_html(){
      $value = get_option('general_option_keyword', '');
      echo '<textarea rows="5" class="regular-text code" id="general_option_keyword" name="general_option_keyword" value="'.$value.'"></textarea>';
    }

    function register_fields__facebook(){
      register_setting('general', 'general_option_facebook', 'esc_attr');
      add_settings_field('general_option_facebook', '<label for="general_option_facebook">Facebook lnk</label>', array(&$this, 'fields__facebook_html'), 'general');
    }
    function fields__facebook_html(){
      $value = get_option('general_option_facebook', '');
      echo '<input class="regular-text code" type="text" id="general_option_facebook" name="general_option_facebook" value="'.$value.'">';
    }

    function register_fields__instagram(){
      register_setting('general', 'general_option_instagram', 'esc_attr');
      add_settings_field('general_option_instagram', '<label for="general_option_instagram">Instagram link</label>', array(&$this, 'fields__instagram_html'), 'general');
    }
    function fields__instagram_html(){
      $value = get_option('general_option_instagram', '');
      echo '<input class="regular-text code" type="text" id="general_option_instagram" name="general_option_instagram" value="'.$value.'">';
    }

    function register_fields__pinterest(){
      register_setting('general', 'general_option_pinterest', 'esc_attr');
      add_settings_field('general_option_pinterest', '<label for="general_option_pinterest">Pinterest link</label>', array(&$this, 'fields__pinterest_html'), 'general');
    }
    function fields__pinterest_html(){
      $value = get_option('general_option_pinterest', '');
      echo '<input class="regular-text code" type="text" id="general_option_pinterest" name="general_option_pinterest" value="'.$value.'">';
    }

    function register_fields__tiktok(){
      register_setting('general', 'general_option_tiktok', 'esc_attr');
      add_settings_field('general_option_tiktok', '<label for="general_option_tiktok">Tik Tok link</label>', array(&$this, 'fields__tiktok_html'), 'general');
    }
    function fields__tiktok_html(){
      $value = get_option('general_option_tiktok', '');
      echo '<input class="regular-text code" type="text" id="general_option_tiktok" name="general_option_tiktok" value="'.$value.'">';
    }

  }

  $new_general_setting = new new_general_setting();

?>