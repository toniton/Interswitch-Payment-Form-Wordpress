<?php
  /**
   * Interswitch Payment Admin Settings Page Class
   */
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  if ( ! class_exists( 'WP_Interswitch_Payment_Admin_Settings' ) ) {
    
    class WP_Interswitch_Payment_Admin_Settings extends WP_Intersitch_Base {
      protected $options;

      public static function init() {
          $class = __CLASS__;
          return new $class;
      }
      
      private function __construct() {
        global $admin_settings;
        $admin_settings = $this;
      }
      
      public function setup ( )  {
        global $admin_settings;
        $attr = array(
          'mac' => $admin_settings->get_option_value( 'mac' ),
          'product_id' => $admin_settings->get_option_value( 'product_id' ),
          'pay_item_id' => $admin_settings->get_option_value( 'pay_item_id' ),
          'mode' => $admin_settings->get_option_value( 'mode' ),
          'footnotes' => $admin_settings->get_option_value( 'footnotes' ),
          'mode_options' => $this->get_mode_options()
        );
        $this->render_admin_settings($attr);
      }

      private function get_mode_options() {
        $options = array(
          array(
            'name' => 'Live',
            'key'  => 'live'
          ),
          array(
            'name' => 'Test',
            'key'  => 'test'
          ),
          array(
            'name' => 'SandBox',
            'key'  => 'sandbox'
          )
        );
        return $options;
      }
      
      public function render_admin_settings ( $attr )  {
        $this->render_admin_view('admin-settings', $attr);
      }

      public function register_settings() {
        register_setting( 'ipf_options_group', 'ipf_options' );
        $this->init_settings();
      }
      private function init_settings() {
        if ( false == get_option( 'ipf_options' ) ) {
          update_option( 'ipf_options', array() );
        }
      }
      
      public function get_option_value( $attr ) {
        $options = get_option( 'ipf_options' );
        if ( array_key_exists($attr, $options) ) {
          return $options[$attr];
        }
        return '';
      }
    }
  }
?>