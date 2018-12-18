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
                if ( !class_exists( 'WP_Interswitch_Payment_Admin_Transaction_List' ) ){
                    require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_admin_transaction_list.php');
                }
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

            // Initialize the shortcode for payment form
            if ( !class_exists( 'WP_Interswitch_Payment_Form_Shortcode' ) ){
                require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_form_shortcode.php');
            }
            add_shortcode( 'ipf_payment', array( WP_Interswitch_Payment_Form_Shortcode::init(), 'setup' ) );
            
            // Initialize the shortcode for payment input
            if ( !class_exists( 'WP_Interswitch_Payment_Form_Input_Shortcode' ) ){
                require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_form_input_shortcode.php');
            }
            add_shortcode( 'ipf_input', array( WP_Interswitch_Payment_Form_Input_Shortcode::init(), 'setup' ) );

            // Initialize the shortcode for payment input -> select -> option
            if ( !class_exists( 'WP_Interswitch_Payment_Form_Select_Option_Shortcode' ) ){
                require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_form_select_option_shortcode.php');
            }
            add_shortcode( 'ipf_select_option', array( WP_Interswitch_Payment_Form_Select_Option_Shortcode::init(), 'setup' ) );
        }
 
    }