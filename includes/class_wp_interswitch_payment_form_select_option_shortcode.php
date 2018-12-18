<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    if ( ! class_exists( 'WP_Interswitch_Payment_Form_Select_Option_Shortcode' ) ) {
        class WP_Interswitch_Payment_Form_Select_Option_Shortcode extends WP_Intersitch_Base{

            public static function init() {
                $class = __CLASS__;
                return new $class;
            }

            public function __construct() { }

            public function setup ( $atts, $content = null )  {
                return $this->render_view( 'payment-form-select-option', $atts);
            }
        }
    }