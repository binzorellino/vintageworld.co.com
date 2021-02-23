<?php

// -- START - Általános beállítások egyedi szekciók és mezők
  add_action('admin_init', 'my_general_section');  
  function my_general_section() {  
    add_settings_section(  
      'my_settings_section', // Section ID 
      'My Options Title', // Section Title
      'my_section_options_callback', // Callback
      'general' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
      'option_1', // Option ID
      'Option 1', // Label
      'my_textbox_callback', // !important - This is where the args go!
      'general', // Page it will be displayed (General Settings)
      'my_settings_section', // Name of our section
      array( // The $args
          'option_1' // Should match Option ID
      )
    ); 

    add_settings_field( // Option 2
      'option_2', // Option ID
      'Option 2', // Label
      'my_textbox_callback', // !important - This is where the args go!
      'general', // Page it will be displayed
      'my_settings_section', // Name of our section (General Settings)
      array( // The $args
          'option_2' // Should match Option ID
      )
    ); 

    register_setting('general','option_1', 'esc_attr');
    register_setting('general','option_2', 'esc_attr');
  }

  function my_section_options_callback() { // Section Callback
      echo '<p>A little message on editing info</p>';  
  }

  function my_textbox_callback($args) {  // Textbox Callback
      $option = get_option($args[0]);
      echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
  }
// -- END - Általános beállítások egyedi szekciók és mezők

// -- START - Általános beállítások egyedi almenü
  function vw_register_theme_settings() {
    add_option( 'vw_theme_option_name', '');
    register_setting( 'vw_theme_options_group', 'vw_theme_option_name', 'vw_theme_callback' );
  }
  add_action( 'admin_init', 'vw_register_theme_settings' );

  function vw_register_theme_options_page() {
    add_options_page('Page Title', 'Egyedi sablon beállítások', 'manage_options', 'vw_theme', 'vw_theme_options_page');
  }
  add_action('admin_menu', 'vw_register_theme_options_page');

  function vw_theme_options_page() {
  ?>
  <div>
    <?php screen_icon(); ?>
    <h2>A VW sablon egyedi beállításai</h2>
      <hr>
      <form method="post" action="options.php">
        <?php settings_fields( 'vw_theme_options_group' ); ?>
        <h3>Feljéc beállításai:</h3>
        <table style="width:100%;">
          <tr valign="top">
            <th style="width:auto;white-space: nowrap;" scope="row">
              <label for="myplugin_option_name">Felső sáv szövege:</label>
            </th>
            <td style="width:100%;">
              <input style="width:100%;" type="text" id="myplugin_option_name" name="vw_theme_option_name" value="<?php echo get_option('vw_theme_option_name'); ?>" />
            </td>
          </tr>
        </table>
        <?php  submit_button(); ?>
    </form>
  </div>
  <?php
  }
// -- END - Általános beállítások egyedi almenü

// -- START - a sablon admin beállításai --
  function my_admin_menu() {
    add_menu_page(
      __( 'VW tartalmi beállítások', TEXTDOMAIN ),
      __( 'VW tartalmi beállítások', TEXTDOMAIN ),
      '',
      'vw-custom-setings-page',
      '',
      'dashicons-schedule',
      1
    );
    add_submenu_page(
      'vw-custom-setings-page',
      __( 'VW fejléc beállítások', TEXTDOMAIN ),
      __( 'VW fejléc beállítások', TEXTDOMAIN ),
      'manage_options',
      'vw-custom-setings-header',
      'vw_custom_setings_page'
    );
  }

  add_action( 'admin_menu', 'my_admin_menu' );

  function vw_custom_setings_page() { ?>
    <div>
      <?php screen_icon(); ?>
      <h2>A VW sablon egyedi beállításai</h2>
      <hr>
      <form method="post" action="options.php">
        <?php settings_fields( 'vw_theme_options_group' ); ?>
        <h3>Feljéc beállításai:</h3>
        <table style="width:100%;">
          <tr valign="top">
            <th style="width:auto;white-space: nowrap;" scope="row">
              <label for="myplugin_option_name">Felső sáv szövege:</label>
            </th>
            <td style="width:100%;">
              <input style="width:100%;" type="text" id="vw_theme_option_name" name="vw_theme_option_name" value="<?php echo get_option('vw_theme_option_name'); ?>" />
            </td>
          </tr>
        </table>
        <?php  submit_button(); ?>
      </form>
    </div>
  <?php
  }
// -- a sablon admin beállításai - END --

?>