<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div>
    <h3>Transaction Status</h3>
    <p><small> Reference : <b><?php echo $atts['txnref'] ?></b></small></p>
    <p> Your payment of : <b><?php echo $atts['amount'] ?> </b></p>
    <p> Via : <b><?php echo $atts['payref'] ?></b>
    <div>
        <small> <?php echo $atts['response'] ?> - CODE: <?php echo $atts['code'] ?></small>
    </div>
</div>