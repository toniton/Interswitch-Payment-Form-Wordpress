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
        
        add_submenu_page(
          null,
          __( 'Transactions', 'ipf-payment' ),
          __( 'Transactions', 'ipf-payment' ),
          'manage_options',
          'ipf-transaction-view',
          array( WP_Interswitch_Payment_Admin_Transaction_View::init(), 'setup' )
        );
        
        $hook = add_submenu_page(
            'ipf-payment-form',
            __( 'Transactions', 'ipf-payment' ),
            __( 'Transactions', 'ipf-payment' ),
            'manage_options',
            'ipf-transaction-list',
            array( WP_Interswitch_Payment_Admin_Transaction_List::init(), 'setup' )
          );
        add_action( "load-$hook", array( $this, 'set_screen' ) );
      }

      public function set_screen( $status, $option=null, $value=null ) {
        return $value;
      }
    }
  }
?>