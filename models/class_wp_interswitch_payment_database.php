<?php
  /**
   * Interswitch Payment Model Database Class
   */
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  if ( ! class_exists( 'WP_Interswitch_Payment_Database' ) ) {
    
    class WP_Interswitch_Payment_Database {
      private $table_name;
      public static function init() {
          $class = __CLASS__;
          return new $class;
      }
      
      private function __construct() {
        global $wpdb;
        $this->$table_name = $wpdb->prefix . IPF_TABLE_NAME;
      }
      
      public function activate()  {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE ".$this->$table_name." (
          id int(11) NOT NULL AUTO_INCREMENT,
          email varchar(320) NOT NULL,
          pay_item_id int(11) NOT NULL,
          product_id int(11) NOT NULL,
          currency varchar(4) NOT NULL,
          amount decimal(12,2) NOT NULL,
          txn_ref varchar(50) NOT NULL,
          pay_ref varchar(100) NULL,
          card_number varchar(24) NULL,
          meta text NULL,
          code varchar(4) NULL,
          response varchar(255) NULL,
          created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          updated_at datetime DEFAULT '0000-00-00 00:00:00' NULL,
          status tinyint(1) DEFAULT '0' NOT NULL,
          UNIQUE KEY txn_ref (txn_ref),
          UNIQUE KEY pay_ref (pay_ref),
          PRIMARY KEY  (id)
        ) $charset_collate;";
        $this->exec($sql);
      }

      private function exec($sql) {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
      }

      public function get_transaction($txn_ref) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$this->$table_name." WHERE txn_ref = '".esc_sql($txn_ref)."' LIMIT 1", ARRAY_A));
      }

      public function get_transactions($query, $orderby = 'created_at', $order = 'DESC', $offset = 0, $limit = 30) {
        global $wpdb;
        $query = "'%".esc_sql($query)."%'";
        return $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$this->$table_name." WHERE txn_ref LIKE ".$query." OR email LIKE ".$query." ORDER BY ".esc_sql($orderby)." ".esc_sql($order)." LIMIT ".esc_sql($offset).", ".esc_sql($limit), ARRAY_A));
      }

      public function count() {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM ".$this->$table_name);
      }
      
      public function save_transaction($data) {
        global $wpdb;
        // $wpdb->show_errors();
        $wpdb->insert($this->$table_name, $data);
        // $wpdb->print_error();
        // die(var_dump($wpdb->last_query));
      }

      public function update_transaction($data, $where) {
        global $wpdb;
        $wpdb->update($this->$table_name, $data, $where);
      }

      public function deactivate() {
        global $wpdb;
        $sql = "DROP TABLE IF EXISTS ".$this->$table_name;
        $wpdb->query($sql);
      }
    }
  }
?>