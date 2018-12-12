<?php
  if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<h4>Transaction Status</h4>
<hr/>
<p> Transaction Reference : <b><?php echo $atts['txnref'] ?></b>
<p> Your payment of : <b><?php echo $atts['amount'] ?> </b></p>
<p> Via : <b><?php echo $atts['payref'] ?></b>
<div><small> <?php echo $atts['response'] ?> - CODE: <?php echo $atts['code'] ?></small></div>