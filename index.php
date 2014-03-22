<!DOCTYPE html>
<html>
<head>
<title>Water Bank</title>
<?php 
	include('php/time.php');
	session_start(); 
	$userName=$_SESSION['userName'];
	$phoneNumber=$_SESSION['phoneNumber'];
	$address=$_SESSION['address'];
	$postCode=$_SESSION['postCode'];
?>
<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ICO"/>
<link rel="stylesheet" type="text/css" href="css/mid.css"/>
<link rel="stylesheet" type="text/css" href="css/log.css"/>
<link rel="stylesheet" type="text/css" href="css/fot.css"/>
<link rel="stylesheet" type="text/css" href="css/left.css"/>
<link rel="stylesheet" type="text/css" href="css/top.css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#top").click(function(){
				$(this).animate({
					opacity:"0.5"
				},"slow");
				$(this).animate({
					opacity:"1"
				},"slow");
				$("#logo").delay("3000").animate({
					right:"330px",
					height:"65px",
					width:"65px"
				},"slow");
				$("#top").delay("1950").animate({
					height:"70px"
				});
			});
			$("#top").trigger("click");
		});
	</script>
<style>*{margin:0;padding:0;}</style>
</head>
<body>
<div id="mid">
	<div id="top">
			<img id="logo" src="image/logo.GIF">
	</div>
	<div id="left">
		<ul>
			<li><div><a href="#">1</a></div>
				<img src="3yiC6Yq.jpg">
			</li>
			<li><div><a href="#">2</a></div>
				<img src="40Ly3VB.jpg">
			</li>
			<li><div><a href="#">3</a></div>
				<img src="00kih8g.jpg">
			</li>
			<li><div><a href="#">4</a></div>
				<img src="2rT2vdx.jpg">
			</li>
			<li><div><a href="#">5</a></div>
				<img src="8k3N3EL.jpg">
			</li>
		</ul>
	</div>
	<div id="log">
		<form method="post" action="php/main.php">
			<span><p><strong>Order Information:</strong></p></span>
			<select name="quantity">
				<option value="1">One pack</option>
				<option value="2">Two pack</option>
				<option value="3">Three pack</option>
				<option value="4">Four pack</option>
			</select>	
			<select name="delivery">
				<?php
					if($deadLine > 12){
						echo "<option value=\"$today\">$today 20:00 ~ 22:00</option>";
						}
				?>
				<option value="<?php echo "$tomorrow";?>">
					<?php echo "$tomorrow";?> 20:00 ~ 22:00
				</option>
			</select>
			<span><p><strong>Delivery Information:</strong></p></span>	
			<input type="text" name="userName" maxlength="20" placeholder="Name:">
			<input type="text" name="phoneNumber" maxlength="20" placeholder="Phone Number:">
			<input type="text" name="address" maxlength="20" placeholder="Address:">
			<input type="text" name="postCode" maxlength="20" placeholder="Post Code:">
			<select name="paypal" >
				<option value="1">Paypal</option>
				<option value="0">Cash</option>
			</select>
			<input type="submit" value="Buy Now">
			<div style="color:red;padding-top:10px;">
				<?php 
					echo "<div>$userName</div>","<div>$phoneNumber</div>","<div>$address</div>","<div>$postCode</div>";
				?>
			</div>
		</form>
	</div>
	<div id="fot">
		<hr />
		<ul>
			<li>&copy2014 WaterBank Inc</li>
			<li><a href="http://google.ca">Why Bottled Water</a></li>
			<li><a href="http://google.ca">Shipping Policies</a></li>
			<li><a href="http://google.ca">Customer Service</a></li>
		</ul>
	</div>
</div>
</body>
</html>
