<?php
include ("files/config.php");
echo "hi";
for($n=222; $n<=294; $n++){
	$sql = "UPDATE post SET deleted=0 WHERE post_id='$n'";
	if(mysqli_query($conn,$sql)){
		echo "Done<br>";
	}
	else{
		echo "Failed<br>";
	}
}
?>