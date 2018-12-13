<?php
  /**
   * Interswitch Payment Admin Settings Page Class
   */
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  if ( ! class_exists( 'WP_Interswitch_Payment_Menu_Options' ) ) {
    
    class WP_Interswitch_Payment_Menu_Options extends WP_Intersitch_Base {
      protected $options;

      public static function init() {
          $class = __CLASS__;
          return new $class;
      }
      
      private function __construct() {
        global $admin_settings;
        $admin_settings = $this;
      }

      public function setup_menu() {
        add_menu_page(
          __( 'Interswitch Settings Page', 'ptr-payments' ),
          'Interswitch',
          'manage_options',
          'ipf-payment-form',
          array( WP_Interswitch_Payment_Admin_Settings::init(), 'setup' ),
          IPF_DIR_URL . 'assets/interswitch-icon-small.png',
          50
        );
        
        // add_submenu_page(
        //   'ipf-payment-form',
        //   __( 'Settings', 'ipf-payment' ),
        //   __( 'Settings', 'ipf-payment' ),
        //   'manage_options',
        //   'ipf-payment-form',
        //   array( WP_Interswitch_Payment_Admin_Settings::init(), 'setup' )
        // );
        
        $hook = add_submenu_page(
            'ipf-payments-form',
            __( 'Transactions', 'ipf-payment' ),
            __( 'Transactions', 'ipf-payment' ),
            'manage_options',
            'ipf-transaction-list',
            array( $this, 'plugin_transaction_page' )
          );
        add_action( "load-$hook", array( $this, 'screen_option' ) );
      }
  
      public function admin_configuration_page() {
        return $this->render_view( 'admin-settings' );
      }

      public function set_screen( $status, $option, $value ) {
        return $value;
      }
    }
  }
?>