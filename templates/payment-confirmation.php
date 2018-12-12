<?php
    echo "Post Details:";	print_r($_POST);	echo "</br>";
	
	$product_id = 6205;		
    $txn_ref = "JB"  . intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); // random(ish) 7 digit int. WEBPAY MAX - 50 characters
    $mac    = "D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F";
    $site_redirect_url = $atts['site_redirect_url'];
    $amount = $_POST["amount"] * 100;
    $hashv  = $txn_ref . $product_id . "101" . $amount . $site_redirect_url . $mac;
    $customerName = $_POST["FirstName"]." ".$_POST["LastName"];
    $hash  = hash('sha512',$hashv);       
    $_SESSION["amount"] = $amount;	//Store amount for use in GetTransaction
    
?>

<form method="POST" action="<?php echo $atts['payment_redirect_url'] ?>">
    <!-- REQUIRED HIDDEN FIELDS -->
    <input name="product_id" type="hidden" value="<?php echo $product_id; ?>" />
    <input name="pay_item_id" type="hidden" value="101" />
    <input name="amount" type="hidden" value="<?php echo $amount; ?>" />
    <input name="currency" type="hidden" value="566" />
    <input name="site_redirect_url" type="hidden" value="<?php echo $site_redirect_url ?>" />
    <input name="txn_ref" type="hidden" value="<?php echo $txn_ref; ?>" />
    <input name="cust_id" type="hidden" value="1759"/>
    <input name="site_name" type="hidden" value=""/>
    <input name="cust_name" type="hidden" value="<?php echo $customerName; ?>" />
    <input name="hash" type="hidden" id="hash" value="<?php echo $hash;  ?>" />
    </br></br>
    <a href="<?php echo $atts['site_redirect_url'] ?>">Back</a>
    <input type="submit" value="Make Payment"/>
</form> 