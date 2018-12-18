<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div>
    <h3>Transaction Status</h3>
    <p><small> Reference : <b><?php echo $atts['txn_ref'] ?></b></small></p>
    <p> Your payment of : <b><?php echo $atts['amount'] ?> </b></p>
    <p> Via : <b><?php echo $atts['pay_ref'] ?></b>
    <div>
        <small> <?php echo $atts['response'] ?> - CODE: <?php echo $atts['code'] ?></small>
    </div>
</div>
<div class="footnotes"> <?php echo $atts['footnotes']; ?></div>