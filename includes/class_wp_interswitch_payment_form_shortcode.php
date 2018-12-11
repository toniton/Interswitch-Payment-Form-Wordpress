<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    if ( ! class_exists( 'WP_Interswitch_Payment_Form_Shortcode' ) ) {
        class WP_Interswitch_Payment_Form_Shortcode {

            public static function init() {
                $class = __CLASS__;
                return new $class;
            }
        
            public function __construct() {
                global $admin_settings;
            }

            public function setup ( $attr )  {
                global $admin_settings;
                // $btn_text = $this->get_pay_button_text();
                // $email = $this->get_current_user_email( $attr );
                $atts = shortcode_atts( array(
                'amount'    => '',
                'payment_types' => '',
                'email'     => $email,
                'currency'  => $admin_settings->get_option_value( 'currency' ),
                ), $attr );

                if(isset($_POST["confirm-payment"])) {
                    return $this->render_confirmation_form( $atts );
                }
                return $this->render_payment_form( $atts );
            }

            private function get_pay_button_text() {
                global $admin_settings;
                $text = $admin_settings->get_option_value( 'btn_text' );
                return empty( $text ) ? 'MAKE PAYMENT' : $text;
            }

            private function get_current_user_email( $attr ) {
                if(isset( $attr['use_current_user_email'] ) && $attr['use_current_user_email'] === 'yes'){
                    return wp_get_current_user()->user_email;
                }
                return '';
            }
    
            public function render_payment_form( $atts ) {
                $data_attr = '';
                foreach ($atts as $att_key => $att_value) {
                    $data_attr .= ' data-' . $att_key . '="' . $att_value . '"';
                }
                $atts['form_id'] = $this->gen_rand_string();
                return $this->render_view( 'templates/payment-form.php' );
            }
    
            public function render_confirmation_form( $atts ) {
                // $this->load_js_files();
                $atts['form_id'] = $this->gen_rand_string();
                return $this->render_view( 'templates/payment-confirmation.php' );
            }

            private function render_view($file) {
                ob_start();
                require_once( IPF_DIR_PATH . $file );
                $form = ob_get_contents();
                ob_end_clean();
                return $form;
            }

            private function gen_rand_string( $len = 4 ) {
                if ( version_compare( PHP_VERSION, '5.3.0' ) <= 0 ) {
                    return substr( md5( rand() ), 0, $len );
                }
                return bin2hex( openssl_random_pseudo_bytes( $len/2 ) );
            }
        }
    }