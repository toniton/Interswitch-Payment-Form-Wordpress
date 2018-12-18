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
        _e( 'No payments have been made yet.', 'ipf-payment' );
      }
      
      // public function column_tx_ref( $item ) {
      //   $title = '<strong>' . get_post_meta( $item->ID, '_ptr-paytron_payment_tx_ref', true ) . '</strong>';
      //   $actions = array(
      //     'delete' => sprintf( '<a href="%s">Delete</a>', get_delete_post_link( absint( $item->ID ) ) )
      //   );
      //   return $title . $this->row_actions( $actions );
      // }
      // public function column_amount( $item ) {
      //   $amount = get_post_meta( $item->ID, '_ptr-paytron_payment_amount', true );
      //   return number_format( $amount, 2 );
      // }
      
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
          'created_at'    => __( 'Date', 'ipf-payment' ),
        );
        return $columns;
      }
      
      public function column_cb( $item ) {
        return sprintf(
          '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item->ID
        );
      }
      
      public function column_amount( $item ) {
        return $item->amount.' ('. $item->currency.')';
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
        $this->items = $this->get_payments( $per_page, $current_page );
      }
      
      public function set_screen( $status, $option, $value ) {
        return $value;
      }
      
      public function get_payments( $post_per_page = 20, $page_number = 1 ) {
        $offset = (($page_number - 1) * $post_per_page);
        $db = WP_Interswitch_Payment_Database::init();
        return $db->get_transactions( 'created_at', 'DESC', $offset, $post_per_page);
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