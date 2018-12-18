<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<form method="POST" action="">
    <?php echo do_shortcode($content); ?>
    <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" placeholder="Email Address" required/>
        <br/>
    </div>
    <div>
        <label for="amount">Amount (Currency)</label>
        <input id="amount" name="amount" type="number" placeholder="" required/>
        <br/>
    </div>
    <input id="confirm-payment" name="confirm-payment" type="hidden"/>
    <input id="txn_ref" name="txn_ref" value="<?php echo $atts['txn_ref']; ?>" type="hidden"/>
    <?php wp_nonce_field( 'ipf-interswitch-nonce', 'ipf_sec_code' ); ?>
    <button type="submit">MAKE PAYMENT</button>
</form>
<div class="footnotes"> <?php echo $atts['footnotes']; ?></div>