<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
    $product_id = $atts['product_id'];		
    $pay_item_id = $atts['pay_item_id'];
    $txn_ref = $atts['txn_ref'];
    $mac    = $atts['mac'];
    $currency    = $atts['currency'];
    $site_redirect_url = $atts['site_redirect_url'];
    $amount = $_POST["amount"] * 100;
    $hashv  = $txn_ref . $product_id . "101" . $amount . $site_redirect_url . $mac;
    $hash  = hash('sha512',$hashv);
?>
<?php if ( isset( $atts['css'] ) && '' !== $atts['css'] ) { ?>
    <style>
        <?php echo wp_unslash( $atts['css'] ) ?>
    </style>
<?php } ?>

<form method="POST" action="<?php echo $atts['payment_redirect_url'] ?>">
    <!-- REQUIRED HIDDEN FIELDS -->
    <h3>Confirm Payment</h3>
    <p>You are about to make a payment of <b><?php echo $amount; ?></b> on this website.</p>
    <small>By clicking the "Make Payment" button below, you have agreed to pay the above sum to the owner/merchants of this website.</small>
    <input name="product_id" type="hidden" value="<?php echo $product_id; ?>" />
    <input name="pay_item_id" type="hidden" value="<?php echo $pay_item_id; ?>" />
    <input name="amount" type="hidden" value="<?php echo $amount; ?>" />
    <input name="currency" type="hidden" value="<?php echo $currency ?>" />
    <input name="site_redirect_url" type="hidden" value="<?php echo $site_redirect_url ?>" />
    <input name="txn_ref" type="hidden" value="<?php echo $txn_ref; ?>" />
    <input name="cust_id" type="hidden" value="1759"/>
    <input name="site_name" type="hidden" value=""/>
    <input name="hash" type="hidden" id="hash" value="<?php echo $hash;  ?>" />
    <br/><br/>
    <a href="<?php echo $atts['site_redirect_url'] ?>">Back</a>
    <input type="submit" value="Make Payment"/>
</form> 
<div class="footnotes"> <?php echo $atts['footnotes']; ?></div>