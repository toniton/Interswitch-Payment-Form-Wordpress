<?php
    class WP_Interswitch_Payment_Form {
        public function __construct() {
        }

        public static function init() {
            // Setup base class
            if ( !class_exists( 'WP_Intersitch_Base' ) ){
                require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_base.php' );
            }

            if ( is_admin() ) {
                // Setup Admin Menu
                if ( !class_exists( 'WP_Interswitch_Payment_Menu_Options' ) ){
                    require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_menu_options.php' );
                }
                add_filter( 'set-screen-option', array( WP_Interswitch_Payment_Menu_Options::init(), 'set_screen' ), 10, 3 );
                add_action( 'admin_menu', array( WP_Interswitch_Payment_Menu_Options::init(), 'setup_menu' ) );
            }

            // Setup settings for the admin
            if ( !class_exists( 'WP_Interswitch_Payment_Admin_Settings' ) ){
                require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_admin_settings.php' );
            }
            add_action( 'admin_init', array( WP_Interswitch_Payment_Admin_Settings::init(), 'register_settings' ) );

            // Initialize the shortcode for paymrnt form
            if ( !class_exists( 'WP_Interswitch_Payment_Form_Shortcode' ) ){
                require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_form_shortcode.php');
            }
            add_shortcode( 'interswitch-payments-form', array( WP_Interswitch_Payment_Form_Shortcode::init(), 'setup' ) );
        }
 
    }