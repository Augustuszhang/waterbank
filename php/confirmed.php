<!DOCTYPE html>
<html>
<head>
<title>Water Bank</title>
<link rel="shortcut icon" type="image/x-icon" ref="image/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="../css/mid.css"/>
<link rel="stylesheet" type="text/css" href="../css/fot.css"/>
<link rel="stylesheet" type="text/css" href="../css/top.css"/>
<?php
	session_start(); 
	$quantity=$_SESSION['quantity'];
	$delivery=$_SESSION['delivery'];
	$userName=$_SESSION['userName'];
	$phoneNumber=$_SESSION['phoneNumber'];
	$address=$_SESSION['address'];
	$postCode=$_SESSION['postCode'];
	$totalPrice=$_SESSION['totalPrice'];
				?>
	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../js/jQuery_tools.js"></script>
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
</head>
<body>
<div id="mid">
	<div id="top">
		<img id="logo" src="../image/logo.GIF">
	</div>
	<div id="recipt">
		<p><strong>Delivery:</strong>		<?php	echo $delivery; ?> </p>
		<p><strong>Name:</strong>			<?php	echo $userName; ?> </p>
		<p><strong>Phone Number:</strong>	<?php	echo $phoneNumber; ?> </p>
		<p><strong>Address:</strong>			<?php	echo $address; ?> </p>
		<p><strong>Postal Code:</strong>		<?php	echo $postCode; ?> </p>
		<p><strong>Total Price:</strong>		<?php	echo $totalPrice; ?> </p>
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