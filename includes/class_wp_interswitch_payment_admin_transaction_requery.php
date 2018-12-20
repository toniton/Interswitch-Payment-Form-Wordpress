<?php
  /**
   * Paytron Payment List
   */
  if ( ! defined( 'ABSPATH' ) ) { exit; }
  
  if( ! class_exists( 'WP_Intersitch_Base' ) ) {
    require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_base.php');
  }

  if ( ! class_exists( 'WP_Interswitch_Payment_Admin_Transaction_Requery' ) ) {
    
    class WP_Interswitch_Payment_Admin_Transaction_Requery extends WP_Intersitch_Base {

      public static function init() {
        $class = __CLASS__;
        return new $class;
      }
      
      public function __construct() {
        global $admin_settings;
      }
      
      public function setup() {
        $attr = array(
          'txn_ref'=> ''
        );
        $attr = array_merge($attr,$_GET);
        if(isset($_GET['txn_ref']) && !empty($_GET['txn_ref'])){
          $attr = array_merge($attr, $this->query_server($_GET['txn_ref']));
        }
        $this->render_admin_view('admin-transaction-requery', $attr);
      }

      private function query_server($txn_ref){
        global $admin_settings;
        $mac  = $admin_settings->get_option_value( 'mac' );
        $transaction = $this->get_transaction($txn_ref);
        $string_to_hash = $transaction->product_id.$transaction->txn_ref.$mac;
        $hash = hash('sha512',$string_to_hash);
        $params = '?'.http_build_query(array(
                "productid"=>$transaction->product_id,
                "transactionreference"=>$transaction->txn_ref,
                "amount"=>$transaction->amount
        ));
        $payment_redirect_url = $this->get_payment_url($admin_settings->get_option_value( 'mode' ));
        $url = $payment_redirect_url.'/'.IPF_STATUS_ENDPOINT.$params;

        $headers = array(
            "Keep-Alive" => "300",
            "Connection" => "keep-alive",
            "Hash" => $hash
        );
        $response = wp_remote_get( $url, array( 'headers' => $headers) );
        $body = wp_remote_retrieve_body( $response );
        return array_merge(((array) $transaction), json_decode($body, true));
      }

      private function get_transaction($txn_ref){
        $db = WP_Interswitch_Payment_Database::init();
        return $db->get_transaction( $txn_ref);
      }
    }
  }
?>