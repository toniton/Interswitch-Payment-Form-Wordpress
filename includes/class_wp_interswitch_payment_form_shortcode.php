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
                $this->start_session();
            }

            public function setup ( $attr )  {
                global $admin_settings;
                $this->start_session();

                $atts = shortcode_atts( array(
                    'amount'    => '',
                    'payment_types' => '',
                    'email'     => $this->get_current_user_email( $attr ),
                    'btn_text' => 'MAKE PAYMENT',
                    'currency'  => $admin_settings->get_option_value( 'currency' ),
                    'payment_redirect_url' => IPF_SANDBOX_URL
                ), $attr );

                if(isset($_POST["confirm-payment"])) {
                    // TODO: STORE FEW REQUIRED DATA IN SESSION
                    // TODO: SAVE TRANSACTION TO DATABASE HERE ON SUBMIT
                    return $this->render_confirmation_form( $atts );
                }
                
                if(isset($_POST['txnref'])) {
                    $transaction = array(
                        'productid' => $_SESSION['productid'],
                        'txnref' => $_POST['txnref'],
                        'amount' => $_SESSION['amount']
                    );
                    $status = $this->get_transaction_status($transaction);
                    $atts['code'] = $status->ResponseCode;
                    $atts['response'] = $status->ResponseDescription;
                    $atts['txnref'] = $_POST['txnref'];
                    $atts['payref'] = $_POST['payRef'];
                    return $this->render_payment_status( $atts );
                }
                $_SESSION['productid'] = 6205;
                return $this->render_payment_form( $atts );
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
                return $this->render_view( 'templates/payment-form.php', $atts );
            }
    
            public function render_confirmation_form( $atts ) {
                // $this->load_js_files();
                global $wp;
                $atts['form_id'] = $this->gen_rand_string();
                $atts['payment_redirect_url'] = IPF_SANDBOX_URL.'/'.IPF_PAY_ENDPOINT;
                $atts['site_redirect_url'] = home_url( add_query_arg($_GET,$wp->request) );
                return $this->render_view( 'templates/payment-confirmation.php', $atts );
            }
    
            public function render_payment_status( $atts ) {
                $atts['site_home_url'] = home_url();
                $atts['amount'] = $_SESSION['amount'];
                return $this->render_view( 'templates/payment-status.php', $atts );
            }

            private function render_view($file, $atts) {
                ob_start();
                require_once( IPF_DIR_PATH . $file );
                $form = ob_get_contents();
                ob_end_clean();
                return $form;
            }

            private function get_transaction_status($transaction) {
                $nhash = "D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F" ; // the mac key sent to you
                $hashv = $transaction['productid'].$transaction['txnref'].$nhash;
                $thash = hash('sha512',$hashv); 
                $params = '?'.http_build_query(array(
                        "productid"=>$transaction['productid'],
                        "transactionreference"=>$transaction['txnref'],
                        "amount"=>$transaction['amount']
                ));
                $url = IPF_SANDBOX_URL.'/'.IPF_STATUS_ENDPOINT.$params;

                $headers = array(
                    "Host" => "sandbox.interswitchng.com",
                    "Keep-Alive" => "300",
                    "Connection" => "keep-alive",
                    "Hash" => $thash
                );
                $response = wp_remote_get( $url, array( 'headers' => $headers) );
                $body = wp_remote_retrieve_body( $response );
                return json_decode($body);
            }

            private function start_session() {
                if (!session_id()) {
                    session_start();
                }
            }

            private function gen_rand_string( $len = 4 ) {
                if ( version_compare( PHP_VERSION, '5.3.0' ) <= 0 ) {
                    return substr( md5( rand() ), 0, $len );
                }
                return bin2hex( openssl_random_pseudo_bytes( $len/2 ) );
            }
        }
    }