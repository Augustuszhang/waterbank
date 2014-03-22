<?php
	include('variable.php');
	include('mysql.php');
	include('paypal.php');	
	include('filter.php');
	
	
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		
		$quantity=$_POST['quantity'];
		$delivery=$_POST['delivery'];
		$userName=$_POST['userName'];
		$phoneNumber=$_POST['phoneNumber'];
		$address=$_POST['address'];
		$postCode=$_POST['postCode'];
		$paypal=$_POST['paypal'];
		
		$myFilter = new filter();
		$jump = $myFilter -> make_ready($quantity,$delivery,$userName,$phoneNumber,$address,$postCode,$paypal);
		
		if($jump == '0'){
			session_start();
			$_SESSION['userName']=$userName;
			$_SESSION['phoneNumber']=$phoneNumber;
			$_SESSION['address']=$address;
			$_SESSION['postCode']=$postCode;
			
			header('Location: http://waterbank.ca/index.php');
		}elseif($jump == '1'){
			$totalPrice = $myFilter -> get_total($quantity,$itemPrice);
			
			session_start();
			$_SESSION['quantity']=$quantity;
			$_SESSION['delivery']=$delivery;
			$_SESSION['userName']=$userName;
			$_SESSION['phoneNumber']=$phoneNumber;
			$_SESSION['address']=$address;
			$_SESSION['postCode']=$postCode;
			$_SESSION['totalPrice']=$totalPrice;
		
			$sql="INSERT INTO temp SET quantity='$quantity',delivery='$delivery',userName='$userName',phoneNumbe='$phoneNumber',address='$address',postCode='$postCode',pay='0',PAYERID='$transactionID'";
			$result=mysql_query($sql);
				
			if($result){
				header('Location: http://waterbank.ca/php/confirmed.php');
			}
		}elseif($jump == '2'){
			$totalPrice = $myFilter -> get_total($quantity,$itemPrice);
	
			
			session_start();
			$_SESSION['quantity']=$quantity;
			$_SESSION['delivery']=$delivery;
			$_SESSION['userName']=$userName;
			$_SESSION['phoneNumber']=$phoneNumber;
			$_SESSION['address']=$address;
			$_SESSION['postCode']=$postCode;
			$_SESSION['totalPrice']=$totalPrice;
			
			$padata =   '&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
						'&PAYMENTACTION=Sale'.
						'&ALLOWNOTE=1'.
						'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
						'&PAYMENTREQUEST_0_AMT='.urlencode($totalPrice).
						'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($totalPrice).
						'&L_PAYMENTREQUEST_0_QTY0='. urlencode($quantity).
						'&L_PAYMENTREQUEST_0_AMT0='.urlencode($itemPrice).
						'&L_PAYMENTREQUEST_0_NAME0='.urlencode($itemName).
						'&AMT='.urlencode($totalPrice).
						'&RETURNURL='.urlencode($PayPalReturnURL ).
						'&CANCELURL='.urlencode($PayPalCancelURL);
						
			$connect= new MyPayPal();
			$httpParsedResponseAr = $connect->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature);
			
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){

				$paypalurl ='https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';//sandbox
				header('Location: '.$paypalurl);
			}
		}
	}

	if(isset($_GET["token"]) && isset($_GET["PayerID"])){

		$token = $_GET["token"];
		$playerid = $_GET["PayerID"];
		
		session_start();
		$quantity=$_SESSION['quantity'];
		$delivery=$_SESSION['delivery'];
		$userName=$_SESSION['userName'];
		$phoneNumber=$_SESSION['phoneNumber'];
		$address=$_SESSION['address'];
		$postCode=$_SESSION['postCode'];
		$totalPrice=$_SESSION['totalPrice'];
		
		$padata =   '&TOKEN='.urlencode($token).
                    '&PAYERID='.urlencode($playerid).
                    '&PAYMENTACTION='.urlencode("SALE").
                    '&AMT='.urlencode($totalPrice).
                    '&CURRENCYCODE='.urlencode($PayPalCurrencyCode);

		$connect= new MyPayPal();
		$httpParsedResponseAr = $connect->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature);

		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
	
            $transactionID = urlencode($httpParsedResponseAr["TRANSACTIONID"]);
            $nvpStr = "&TRANSACTIONID=".$transactionID;
				
            $connect= new MyPayPal();
            $httpParsedResponseAr = $connect->PPHttpPost('GetTransactionDetails', $nvpStr, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature);

            if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
					
                $sql="INSERT INTO temp SET quantity='$quantity',delivery='$delivery',userName='$userName',phoneNumbe='$phoneNumber',address='$address',postCode='$postCode',pay='1',PAYERID='$transactionID'";
				$result=mysql_query($sql);
				
				if($result){
					header('Location: http://waterbank.ca/php/confirmed.php');
				}
			}
		}
    }
?>