<?php
include 'files/config.php';
if(isset($_SESSION["email"])){
$user_email = test_input($_SESSION["email"]);
$name = test_input($_REQUEST['name']);
$institution = test_input($_REQUEST['institution']);
$city = test_input($_REQUEST['city']);
$from = test_input($_REQUEST['from']);

$sql1 = "UPDATE users SET name='$name', institution='$institution', city='$city' WHERE email='$user_email'";
if(mysqli_query($conn,$sql1)){
	echo "Your profile updated successfully.<br>";
	$_SESSION["name"] = $name;
	if($from=="feeds"){
		$link = "feeds";
	}
	else{
		$link = "dashboard";
	}
	echo '<a href="'.$link.'" class="btn btn-primary pull-right" onclick="save_user_info()">Ok</a>';
}
else{
	echo "Something went wrong. Profile could not be updated.";
}
}
else{
	echo '<a href="login.php?from=dashboard&msg=notloggedin" class="btn btn-primary" role="button">Log in</a>';
}