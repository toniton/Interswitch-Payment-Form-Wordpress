<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    if ( ! class_exists( 'WP_Interswitch_Payment_Admin_Settings' ) ) {
        abstract class WP_Intersitch_Base {
            abstract protected static function init();

            protected function render_view($file, $atts = null) {
                ob_start();
                require_once ( IPF_DIR_PATH . 'templates/' . $file .'.php');
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