<?php
    class WP_Interswitch_Payment_Form {
        public function __construct() {
        }

        public static function init() {
            // Setup settings for the admin
            if ( !class_exists( 'Interswitch_Payment_Admin_Settings' ) ){
                require_once( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_admin_settings.php' );
            }
            add_action( 'admin_init', array( Interswitch_Payment_Admin_Settings::init(), 'register_settings' ) );

            // Initialize the shortcode for paymrnt form
            if ( !class_exists( 'WP_Interswitch_Payment_Form_Shortcode' ) ){
                require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_form_shortcode.php');
            }
            add_shortcode( 'interswitch-payments-form', array( WP_Interswitch_Payment_Form_Shortcode::init(), 'setup' ) );
        }
 
    }