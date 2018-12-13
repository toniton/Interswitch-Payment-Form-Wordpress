<?php
  /**
   * Interswitch Payment Model Database Class
   */
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  if ( ! class_exists( 'WP_Interswitch_Payment_Database' ) ) {
    
    class WP_Interswitch_Payment_Database {
      public static function init() {
          $class = __CLASS__;
          return new $class;
      }
      
      private function __construct() { }
      
      public function activate()  {
        global $wpdb;
        $table_name = $wpdb->prefix . IPF_TABLE_NAME;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
          id int(11) NOT NULL AUTO_INCREMENT,
          email tinytext NOT NULL,
          pay_item_id tinyint(4) NOT NULL,
          product_id tinyint(4) NOT NULL,
          amount decimal(12,4) NOT NULL,
          txn_ref varchar(50) NOT NULL,
          payment_ref varchar(100) NULL,
          card_number varchar(10) NULL,
          retrieval_ref_num varchar(20) NULL,
          meta text NULL,
          response_code varchar(4) NULL,
          response_description varchar(255) NULL,
          created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          completed_at datetime DEFAULT '0000-00-00 00:00:00' NULL,
          status tinyint(1) DEFAULT '0' NOT NULL,
          UNIQUE KEY txn_ref (txn_ref),
          UNIQUE KEY payment_ref (payment_ref),
          PRIMARY KEY  (id)
        ) $charset_collate;";
        $this->exec($sql);
      }

      private function exec($sql) {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
      }

      public function deactivate() {
        global $wpdb;
        $table_name = $wpdb->prefix . IPF_TABLE_NAME;
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
      }
    }
  }
?>