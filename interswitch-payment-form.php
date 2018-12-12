<?php
/*
  Plugin Name:  Interswitch Payment Form
  Plugin URI:   https://github.com/toniton/interswitch-payment-form
  Description:  Interswitch Payment Form allows you create forms to receive payments from clients for goods and services via Interswitch.
  Version:      0.1.0
  Author:       Toniton
  Author URI:   https://github.com/toniton/
  License:      GPL-2.0+
  License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
*/
// If this file is called directly, abort.
if ((! defined('WPINC') )  || ( ! defined( 'ABSPATH' ) )) {
    exit;
}

if ( ! defined( 'IPF_PAY_PLUGIN_FILE' ) ) {
    define( 'IPF_PAY_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'IPF_DIR_PATH' ) ) {
    define( 'IPF_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
  
if ( ! defined( 'IPF_DIR_URL' ) ) {
    define( 'IPF_DIR_URL', plugin_dir_url( __FILE__ ) );
}
  
if ( ! defined( 'IPF_SANDBOX_URL' ) ) {
    define( 'IPF_SANDBOX_URL', 'https://sandbox.interswitchng.com/webpay' );
}
  
if ( ! defined( 'IPF_TEST_URL' ) ) {
    define( 'IPF_TEST_URL', 'https://stageserv.interswitchng.com/test_paydirect' );
}
  
if ( ! defined( 'IPF_LIVE_URL' ) ) {
    define( 'IPF_LIVE_URL', 'https://webpay.interswitchng.com/paydirect' );
}
  
if ( ! defined( 'IPF_PAY_ENDPOINT' ) ) {
    define( 'IPF_PAY_ENDPOINT', 'pay' );
}
  
if ( ! defined( 'IPF_STATUS_ENDPOINT' ) ) {
    define( 'IPF_STATUS_ENDPOINT', 'api/v1/gettransaction.json' );
}

add_action( 'plugins_loaded', 'interswitch_payment_form_plugins_loaded' );

function interswitch_payment_form_plugins_loaded() {
    // Startup the entry point to the plugin
    if ( !class_exists( 'WP_Interswitch_Payment_Form' ) ){
        require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_payment_form.php');
    }
    add_action( 'init', array( 'WP_Interswitch_Payment_Form', 'init' ) );
}
