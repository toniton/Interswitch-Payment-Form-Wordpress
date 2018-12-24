<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    if ( ! class_exists( 'WP_Interswitch_Payment_Form_Shortcode' ) ) {
        class WP_Interswitch_Payment_Form_Shortcode extends WP_Intersitch_Base{

            public static function init() {
                $class = __CLASS__;
                return new $class;
            }

            public function __construct() {
                global $admin_settings;
                $this->start_session();
            }

            public function setup ( $attr, $content = null )  {
                global $admin_settings;
                $this->start_session();

                $atts = shortcode_atts( array(
                    'amount'    => 0,
                    'btn_text' => 'MAKE PAYMENT',
                    'currency'  => isset($attr['currency'])? $attr['currency'] : 'NGN',
                    'product_id'  => $admin_settings->get_option_value( 'product_id' ),
                    'pay_item_id'  => $admin_settings->get_option_value( 'pay_item_id' ),
                    'mac'  => $admin_settings->get_option_value( 'mac' ),
                    'footnotes'  => $admin_settings->get_option_value( 'footnotes' ),
                    'payment_redirect_url' => $this->get_payment_url($admin_settings->get_option_value( 'mode' ))
                ), $attr );
                $atts = array_merge($atts, $_POST);

                if(isset($_POST["confirm-payment"])) {
                    $_SESSION['amount'] = $atts['amount'];
                    $this->save_transaction( $atts );
                    $atts['currency'] = $this->get_currency_code($atts['currency']);
                    return $this->render_confirmation_form( $atts );
                }
                
                if(isset($_POST['txnref']) || isset($_GET['resp'])) {
                    // Do not try to conform params
                    $transaction = array(
                        'productid' => $_SESSION['product_id'],
                        'txnref' => isset($_POST['txnref']) ? $_POST['txnref'] : $_GET['txnRef'],
                        'payref' => isset($_POST['payRef']) ? $_POST['payRef'] : $_GET['payRef'],
                        'amount' => $_SESSION['amount'] * 100,
                        'mac'  => $admin_settings->get_option_value( 'mac' ),
                        'payment_redirect_url' => $this->get_payment_url($admin_settings->get_option_value( 'mode' ))
                    );
                    $status = $this->get_transaction_status($transaction);
                    $atts['code'] = $status->ResponseCode;
                    $atts['response'] = $status->ResponseDescription;
                    $atts['txn_ref'] = $transaction['txnref'];
                    $atts['pay_ref'] = $transaction['payref'];
                    $this->update_transaction( $atts );
                    return $this->render_payment_status( $atts );
                }
                $atts['txn_ref'] = uniqid();
                if(!isset($atts['email']) || empty($atts['email'])){
                    $atts['email'] = $this->get_current_user_email( $attr );
                }
                $_SESSION['product_id'] = $atts['product_id'];
                return $this->render_payment_form( $atts, $content );
            }

            private function get_current_user_email( $attr ) {
                if(isset( $attr['use_current_user_email'] ) && $attr['use_current_user_email'] === 'yes'){
                    return wp_get_current_user()->user_email;
                }
                return '';
            }
    
            private function save_transaction($atts) {
                $db = WP_Interswitch_Payment_Database::init();
                $data['email'] = $atts['email'];
                $data['pay_item_id'] = $atts['pay_item_id'];
                $data['product_id'] = $atts['product_id'];
                $data['currency'] = $atts['currency'];
                $data['amount'] = $atts['amount'];
                $data['txn_ref'] = $atts['txn_ref'];
                $data['created_at'] = date("Y-m-d H:i:s");
                if(isset($atts['meta']) && !empty($atts['meta'])){
                    $data['meta'] = json_encode($atts['meta']);
                }
                $db->save_transaction( $data );
            }
    
            private function update_transaction($atts) {
                $db = WP_Interswitch_Payment_Database::init();
                $data['pay_ref'] = $atts['pay_ref'];
                $data['code'] = $atts['code'];
                $data['response'] = $atts['response'];
                $data['updated_at'] = date("Y-m-d H:i:s");
                $db->update_transaction( $data, array('txn_ref' => $atts['txn_ref']));
            }

            public function render_payment_form( $atts, $content = null ) {
                $data_attr = '';
                foreach ($atts as $att_key => $att_value) {
                    $data_attr .= ' data-' . $att_key . '="' . $att_value . '"';
                }
                $atts['form_id'] = $this->gen_rand_string();
                return $this->render_view( 'payment-form', $atts, $content );
            }
    
            public function render_confirmation_form( $atts ) {
                // $this->load_js_files();
                global $wp;
                $atts['form_id'] = $this->gen_rand_string();
                $atts['payment_redirect_url'] = $atts['payment_redirect_url'].'/'.IPF_PAY_ENDPOINT;
                $atts['site_redirect_url'] = home_url( add_query_arg($_GET,$wp->request) );
                return $this->render_view( 'payment-confirmation', $atts );
            }
    
            public function render_payment_status( $atts ) {
                $atts['site_home_url'] = home_url();
                $atts['amount'] = $_SESSION['amount'];
                return $this->render_view( 'payment-status', $atts );
            }

            private function get_transaction_status($transaction) {
                $nhash = $transaction['mac'] ; // the mac key sent to you
                $hashv = $transaction['productid'].$transaction['txnref'].$nhash;
                $thash = hash('sha512',$hashv); 
                $params = '?'.http_build_query(array(
                        "productid"=>$transaction['productid'],
                        "transactionreference"=>$transaction['txnref'],
                        "amount"=>$transaction['amount']
                ));
                $url = $transaction['payment_redirect_url'].'/'.IPF_STATUS_ENDPOINT.$params;

                $headers = array(
                    "Keep-Alive" => "300",
                    "Connection" => "keep-alive",
                    "Hash" => $thash
                );
                $response = wp_remote_get( $url, array( 'headers' => $headers) );
                $body = wp_remote_retrieve_body( $response );
                return json_decode($body);
            }

            private function gen_rand_string( $len = 4 ) {
                if ( version_compare( PHP_VERSION, '5.3.0' ) <= 0 ) {
                    return substr( md5( rand() ), 0, $len );
                }
                return bin2hex( openssl_random_pseudo_bytes( $len/2 ) );
            }
        }
    }