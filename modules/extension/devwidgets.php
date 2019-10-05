<?php

// Szerver információk megjelenítése

if ( ! class_exists( 'Serverinfowidget_class' ) ) {

  class Serverinfowidget_class {

    public function __construct() {

      if ( is_admin() && current_user_can( 'administrator' ) ) {

        add_action( 'wp_dashboard_setup', array( $this, 'add_to_dashboard_widgets' ) );
        add_action( 'admin_footer', array( $this, 'render_style' ), 10, 1 );

      }

    }

    public function add_to_dashboard_widgets() {

      global $wp_meta_boxes;

      wp_add_dashboard_widget( 'serverinfo_widget', 'Szerver információk', array( $this, 'render_serverinfo_dashboard' ) );

    }

    public function render_serverinfo_dashboard() {

      global $wpdb;

      echo '
      <table id="server-info-table">
        <tr>
          <td><strong>Apache verzió:</strong><br/><small>'.$_SERVER['SERVER_SOFTWARE'].'</small></td>
          <td><strong>PHP verzió:</strong><br/><small>'.phpversion().'</small></td>
        </tr>
        <tr>
          <td><strong>Max feltöltési méret:</strong><br/><small>'.$this->convert( $this->let_to_num( ini_get( 'post_max_size' ) ) ).'</small></td>
          <td><strong>PHP Időkorlát:</strong><br/><small>'.ini_get( 'max_execution_time' ).' mp</small></td>
        </tr>
        <tr>
          <td><strong>PHP max. bemeneti változók:</strong><br/><small>'.ini_get( 'max_input_vars' ).'</small></td>
          <td><strong>Feltölthető file max. mérete:</strong><br/><small>'.size_format( wp_max_upload_size() ).'</small></td>
        </tr>
        <tr>
          <td><strong>Alapértelmezett időzóna:</strong><br/><small>'.date_default_timezone_get().'</small></td>
          <td><strong>Gzip:</strong><br/><small>'.$this->enable_disable( is_callable( 'gzopen' ) ).'</small></td>
        </tr>
        <tr>
          <td><strong>Multibyte String:</strong><br/><small>'.$this->enable_disable( extension_loaded( 'mbstring' ) ).'</small></td>
          <td><strong>MySQL verzió:</strong><br/><small>'.$wpdb->db_version().'</small></td>
        </tr>
      </table>';

    }

    public function render_style() {

      echo '<style>
        #serverinfo_widget .inside { padding: 0; margin-top: 0;}
        #serverinfo_widget .hndle { border-bottom: 1px solid #e5e5e5; }
        #server-info-table { width: 100%; border: 0; border-collapse: collapse; }
        #server-info-table td { padding: 5px 7px; font-size: 13px; width: 50%; vertical-align: top; }
        #server-info-table td strong { font-weight: 700; color: #2e4053; }
        #server-info-table td small { color: #d35400; }
        #server-info-table tr td { border-bottom: 1px solid #e5e5e5; }
        #server-info-table tr td:nth-child(1) { border-right: 1px solid #e5e5e5; }
        #server-info-table tr:last-child td { border-bottom: 0; }
      </style>';

    }

    private function convert( $size ) {

      $unit=array('B','KB','MB','GB','TB','PB');
      return @round( $size / pow( 1024, ( $i = floor( log( $size, 1024 ) ) ) ),2 ).' '.$unit[$i];

    }

    private function let_to_num( $size ) {

      $l     = substr( $size, -1 );
      $ret   = substr( $size, 0, -1 );

      switch( strtoupper( $l ) ) {
        case 'P':
          $ret *= 1024;
        case 'T':
          $ret *= 1024;
        case 'G':
          $ret *= 1024;
        case 'M':
          $ret *= 1024;
        case 'K':
          $ret *= 1024;
      }

      return $ret;

    }

    private function enable_disable( $input ) {

      return ( $input == 1 ) ? 'Elérhető' : 'Nem elérhető';

    }

  }

}


// Adatbázis információk

if ( ! class_exists( 'Databaseinfowidget_class' ) ) {

  class Databaseinfowidget_class {

    public function __construct() {

      if ( is_admin() && current_user_can( 'administrator' ) ) {

        add_action( 'wp_dashboard_setup', array( $this, 'add_to_dashboard_widgets' ) );
        add_action( 'admin_footer', array( $this, 'render_style' ), 10, 1 );

      }

    }

    public function add_to_dashboard_widgets() {

      global $wp_meta_boxes;

      wp_add_dashboard_widget( 'databaseinfo_widget', 'Adatbázis információk', array( $this, 'render_serverinfo_dashboard' ) );

    }

    public function render_serverinfo_dashboard() {


      echo '
      <table id="database-info-table">
        <tr>
          <td><strong>Változatok:</strong><br/><small>'.$this->get_posts_revisions().'</small></td>
          <td><strong>Vázlatok:</strong><br/><small>'.$this->get_posts_drafts().'</small></td>
        </tr>
        <tr>
          <td><strong>Lomtárban:</strong><br/><small>'.$this->get_posts_trash().'</small></td>
          <td><strong>Auto vázlatok:</strong><br/><small>'.$this->get_posts_autodrafts().'</small></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Árva posztmeták:</strong><br/><small>'.$this->get_orphan_postmeta().'</small></td>
        </tr>
      </table>';

    }

    public function render_style() {

      echo '<style>
        #databaseinfo_widget .inside { padding: 0; margin-top: 0;}
        #databaseinfo_widget .hndle { border-bottom: 1px solid #e5e5e5; }
        #database-info-table { width: 100%; border: 0; border-collapse: collapse; }
        #database-info-table td { padding: 5px 7px; font-size: 13px; width: 50%; vertical-align: top; }
        #database-info-table td strong { font-weight: 700; color: #2e4053; }
        #database-info-table td small { color: #d35400; }
        #database-info-table tr td { border-bottom: 1px solid #e5e5e5; }
        #database-info-table tr td:nth-child(1) { border-right: 1px solid #e5e5e5; }
        #database-info-table tr:last-child td { border-bottom: 0; }
      </style>';

    }

    private function get_posts_revisions() {

      global $wpdb;

      $query = "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='revision'";

      return $wpdb->get_var( $query );

    }

    private function get_posts_drafts() {

      global $wpdb;

      $query = "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='draft'";

      return $wpdb->get_var( $query );

    }

    private function get_posts_autodrafts() {

      global $wpdb;

      $query = "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='auto-draft'";

      return $wpdb->get_var( $query );

    }

    private function get_posts_trash() {

      global $wpdb;

      $query = "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='trash'";

      return $wpdb->get_var( $query );

    }

    private function get_orphan_postmeta() {

      global $wpdb;

      $query = "SELECT COUNT(*) FROM {$wpdb->postmeta} LEFT JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id WHERE {$wpdb->posts}.ID IS NULL";

      return $wpdb->get_var( $query );

    }

  }

}


new Serverinfowidget_class();
new Databaseinfowidget_class();
