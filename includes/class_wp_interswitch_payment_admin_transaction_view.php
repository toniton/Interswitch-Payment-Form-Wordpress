<?php
  /**
   * Paytron Payment List
   */
  if ( ! defined( 'ABSPATH' ) ) { exit; }
  
  if( ! class_exists( 'WP_Intersitch_Base' ) ) {
    require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_base.php');
  }

  if ( ! class_exists( 'WP_Interswitch_Payment_Admin_Transaction_View' ) ) {
    
    class WP_Interswitch_Payment_Admin_Transaction_View extends WP_Intersitch_Base {

      public static function init() {
        $class = __CLASS__;
        return new $class;
      }
      
      public function __construct() {
      }
      
      public function setup() {
        $this->render_admin_view('admin-transaction-view', $this->get_payment($_GET['txn_ref']));
      }
      
      public function get_payment( $txn_ref ) {
        $db = WP_Interswitch_Payment_Database::init();
        return $db->get_transaction( $txn_ref);
      }
    }
  }
?>