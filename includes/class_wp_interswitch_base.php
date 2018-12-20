<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    if ( ! class_exists( 'WP_Intersitch_Base' ) ) {
        abstract class WP_Intersitch_Base {
            abstract protected static function init();

            protected function render_view($file, $atts = null, $content = null) {
                ob_start();
                require ( IPF_DIR_PATH . 'templates/' . $file .'.php');
                $view = ob_get_clean();
                return $view;
            }

            protected function render_admin_view($file, $attr = null) {
                include ( IPF_DIR_PATH . 'templates/' . $file .'.php');
            }

            protected function get_payment_url( $mode ) {
                $modes = array(
                    'test' => IPF_TEST_URL,
                    'live' => IPF_LIVE_URL,
                    'sandbox' => IPF_SANDBOX_URL
                );
                return $modes[$mode];
            }

            protected function get_currency_code( $currency ) {
                $codes = array(
                    'NGN' => '566',
                    'USD' => '840',
                    'GBP' => '826'
                );
                return $codes[strtoupper($currency)];
            }

            protected function start_session() {
                if (!session_id()) {
                    session_start();
                }
            }
        }
    }

    if ( ! class_exists( 'WP_Intersitch_Base_Table' ) ) {
        if( ! class_exists( 'WP_List_Table' ) ) {
          require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
        }
        abstract class WP_Intersitch_Base_Table extends WP_List_Table{
            abstract protected static function init();

            protected function render_view($file, $atts = null, $content = null) {
                ob_start();
                require ( IPF_DIR_PATH . 'templates/' . $file .'.php');
                $view = ob_get_clean();
                return $view;
            }

            protected function render_admin_view($file, $attr = null) {
                include ( IPF_DIR_PATH . 'templates/' . $file .'.php');
            }

            protected function start_session() {
                if (!session_id()) {
                    session_start();
                }
            }
        }
    }