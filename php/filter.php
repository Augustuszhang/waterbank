<?php
class filter{
	private function test_input($data){
	
		$data = strip_tags($data);
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
		
	public function make_ready(&$quantity,&$delivery,&$userName,&$phoneNumber,&$address,&$postCode,&$paypal){
		$load = true;
		
		$quantity = $this -> test_input($quantity);
		$delivery =  $this -> test_input($delivery);
		$userName =  $this -> test_input($userName);
		$phoneNumber =  $this -> test_input($phoneNumber);
		$address =  $this -> test_input($address);
		$postCode =  $this -> test_input($postCode);
		$paypal =  $this -> test_input($paypal);
		$userNameErr = '';
		$phoneNumberErr = '';
		$addressErr = '';
		$postCodeErr = '';
		
		if(empty($_POST["userName"])){
			$userNameErr = "Name is required";	
			$load = false;
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$userName)){
			$userNameErr = "Only letters and white space allowed"; 
			$load = false;
		}
		
		if(empty($_POST["phoneNumber"])){
			$phoneNumberErr = "Phone Number is required";
			$load = false;
		}elseif(!preg_match("/^[0-9]{10}$/",$phoneNumber)){
			$phoneNumberErr = "Invalid Phone Number"; 
			$load = false;
		}
		
		if(empty($_POST["address"])){
			$addressErr = "Address is required";	
			$load = false;
		}
		
		if(empty($_POST["postCode"])){
			$postCodeErr = "Post Code is required";	
			$load = false;
		}elseif(!preg_match("/^[0-9A-Za-z]{3}[ ]?[0-9A-Za-z]{3}$/",$postCode)){
			$postCodeErr = "Invalid Post Code"; 	
			$load = false;
		}
		
		if(($paypal == "1") && $load){
			return "2";
		}elseif(($paypal == "0") && $load){
			return "1";
		}else{	
			$userName = $userNameErr;
			$phoneNumber = $phoneNumberErr;
			$address = $addressErr;
			$postCode = $postCodeErr;
			return "0";
		}
	}
	
	public function get_total($quantity,$itemPrice){
		return intval($quantity) * intval($itemPrice);
	}
}
?>