<?php
    // session_start();

	//WEBPAY DEMO ACCOUNT
		//product_id = 6205
		//pay_item_id = 101, 102, 103, 104
		//mac    = "D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F";
	
    echo "Post Details:";	print_r($_POST);	echo "</br>";
    echo "Session Details:";	print_r($_SESSION);	
	
	$product_id = 6205;		
	$site_redirect_url = "http://localhost/demopay4/redirect4.php";
    $txn_ref = "JB"  . intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); // random(ish) 7 digit int. WEBPAY MAX - 50 characters
    $mac    = "D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F";
    //$mac    = "DE29269C3523CC8446DF9AF42B4C443E6FFE6956AA66FFDAE37FD6D4D2A5255461C1DD3CA5B095A27B58975646385E6D802709E9A92AAD12BA6F45C61783D906";
    $amount = $_POST["amount"] * 100;
    $hashv  = $txn_ref . $product_id . "101" . $amount . $site_redirect_url . $mac;
    $customerName = $_POST["FirstName"]." ".$_POST["LastName"];
    $hash  = hash('sha512',$hashv);       
    $_SESSION["amount"] = $amount;	//Store amount for use in GetTransaction
    
?>

<!-- LIVE URL => https://webpay.interswitchng.com/paydirect/pay          -->
<!-- TEST URL => https://stageserv.interswitchng.com/test_paydirect/pay  -->

<form method="post" action="https://sandbox.interswitchng.com/webpay/pay">
    <!-- REQUIRED HIDDEN FIELDS -->
<!--COLLEGEPAY	<input name="product_id" type="hidden" value="6204" />  COLLEGEPAY-->
    <input name="product_id" type="hidden" value="<?php echo $product_id; ?>" />
    <input name="pay_item_id" type="hidden" value="101" />
    <input name="amount" type="hidden" value="<?php echo $amount; ?>" />
    <input name="currency" type="hidden" value="566" />
    <!-- <input name="site_redirect_url" type="hidden" value="http://localhost/demopay4/redirect4.php" /> -->
    <input name="site_redirect_url" type="hidden" value="<?php echo $site_redirect_url; ?>" />
    <input name="txn_ref" type="hidden" value="<?php echo $txn_ref; ?>" />
    <input name="cust_id" type="hidden" value="1759"/>
    <input name="site_name" type="hidden" value=""/>
    <input name="cust_name" type="hidden" value="<?php echo $customerName; ?>" />
    <input name="hash" type="hidden" id="hash" value="<?php echo $hash;  ?>" />
    </br></br>
    <a href="http://localhost/demopay4/">Back</a>
    <input type="submit" value="Make Payment"></input>
</form> 