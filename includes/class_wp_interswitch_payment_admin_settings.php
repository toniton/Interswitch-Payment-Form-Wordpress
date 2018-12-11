<?php
  /**
   * Interswitch Payment Admin Settings Page Class
   */
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  if ( ! class_exists( 'Interswitch_Payment_Admin_Settings' ) ) {
    
    class Interswitch_Payment_Admin_Settings {
      protected $options;
      
      public static function init() {
        $class = __CLASS__;
        return new $class;
      }

      private function __construct() {
        global $admin_settings;
        $admin_settings = $this;
      }
      
      public function register_settings() {
        register_setting( 'interswitch_payment_options_group', 'interswitch_payment_options' );
        register_setting( 'interswitch_payment_options_group', 'payment-type', 'modal' );  // Or redirect
        register_setting( 'interswitch_payment_options_group', 'mode', 'testing' ); // Or production
        register_setting( 'interswitch_payment_options_group', 'sandbox-url', 'modal' ); // Or redirect 
        $this->init_settings();
      }
      private function init_settings() {
        if ( false == get_option( 'interswitch_payment_options' ) ) {
          update_option( 'interswitch_payment_options', array() );
        }
      }
      
      public function get_option_value( $attr ) {
        $options = get_option( 'interswitch_payment_options' );
        if ( array_key_exists($attr, $options) ) {
          return $options[$attr];
        }
        return '';
      }
    }
  }
?>