<?php
  /**
   * Paytron Payment List
   */
  if ( ! defined( 'ABSPATH' ) ) { exit; }
  
  if( ! class_exists( 'WP_Intersitch_Base_Table' ) ) {
    require_once ( IPF_DIR_PATH . 'includes/class_wp_interswitch_base.php');
  }

  if ( ! class_exists( 'WP_Interswitch_Payment_Admin_Transaction_List' ) ) {
    
    class WP_Interswitch_Payment_Admin_Transaction_List extends WP_Intersitch_Base_Table {

      public static function init() {
        $class = __CLASS__;
        return new $class;
      }
      
      public function __construct() {
        global $status, $page;
        parent::__construct( array(
          'singular' => __( 'Payment List', 'ipf-payment' ),
          'plural'   => __( 'Payment Lists', 'ipf-payment' ),
          'ajax'     => false
        ) );
      }
      
      public function setup() {
        $this->render_admin_view('admin-transaction-list', $this);
      }

      public function no_items() {
        _e( 'No payments found.', 'ipf-payment' );
      }
      
      public function column_txn_ref( $item ) {
        $title = '<strong>' . $item->txn_ref . '</strong>';
        $link = add_query_arg(
          array(
              'page' => 'ipf-transaction-view',
              'txn_ref' => $item->txn_ref
          ),
          admin_url('admin.php')
        );
        $actions = array(
          'view' => sprintf( '<a href="%s">View</a>', $link )
        );
        return $title . $this->row_actions( $actions );
      }
      
      public function column_default($item, $column_name){
        return $item->{$column_name};
      }
      
      function get_columns() {
        global $admin_settings;
        $columns = array(
          'cb'      => '<input type="checkbox" />',
          'txn_ref'  => __( 'Transaction Ref', 'ipf-payment' ),
          'email'  => __( 'Email', 'ipf-payment' ),
          'amount'  => __( 'Amount', 'ipf-payment' ),
          'pay_ref'  => __( 'Pay Ref', 'ipf-payment' ),
          'created_at'    => __( 'Date', 'ipf-payment' ),
        );
        return $columns;
      }

      public function get_sortable_columns() {
        $sortable_columns = array(
          'email' => array('email', true),
          'amount' => array('amount', false),
          'created_at' => array('created_at', false),
        );
        return $sortable_columns;
      }
      
      public function column_cb( $item ) {
        return sprintf(
          '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item->ID
        );
      }
      
      public function column_amount( $item ) {
        return $item->amount.' ('. $item->currency.')';
      }
      
      public function column_created_at( $item ) {
        return date_format(date_create($item->created_at),"D, M d, Y H:ia");
      }
      public function prepare_items() {
        $this->_column_headers = array( 
             $this->get_columns(),
             array(),
             $this->get_sortable_columns(),
        );
        $this->process_bulk_action();
        $per_page     = $this->get_items_per_page( 'payments_per_page' );
        $current_page = $this->get_pagenum();
        $total_items  = $this->record_count();
        
        $this->set_pagination_args( array(
          'total_items' => $total_items,
          'per_page'    => $per_page,
          'total_pages' => ceil($total_items / $per_page)
        ) );
        $query = '';
        if(isset($_GET['s']) && !empty(isset($_GET['s']))) {
          $query = $_GET['s'];
        }
        $this->items = $this->get_payments( $query, $per_page, $current_page );
      }

      public function set_screen( $status, $option, $value ) {
        return $value;
      }
      
      public function get_payments( $query = '', $post_per_page = 20, $page_number = 1 ) {
        $offset = (($page_number - 1) * $post_per_page);
        $db = WP_Interswitch_Payment_Database::init();
        return $db->get_transactions( $query, 'created_at', 'DESC', $offset, $post_per_page);
      }
      
      public static function delete_payment( $payment_id ) {
        // wp_delete_post( $payment_id );
      }
      
      public function record_count() {
        $db = WP_Interswitch_Payment_Database::init();
        return $db->count();
      }
    }
  }
?>