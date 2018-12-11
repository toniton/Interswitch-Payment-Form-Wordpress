<?php
  if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<?php
    if(isset($_POST["email"])) {
        echo $_POST["email"];
        ?>
        <p> <?php $_POST["email"] ?> </p>
<?php
    }
?>

<form method="POST" action="">
    <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" placeholder="Email Address"/>
        <br/>
    </div>
    <div>
        <label for="amount">Amount (Currency)</label>
        <input id="amount" name="amount" type="number" placeholder="0"/>
        <br/>
    </div>
    <input id="confirm-payment" name="confirm-payment" type="hidden"/>
    <?php wp_nonce_field( 'ipf-interswitch-nonce', 'ipf_sec_code' ); ?>
    <button type="submit">MAKE PAYMENT</button>
</form>