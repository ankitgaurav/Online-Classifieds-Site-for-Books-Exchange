<?php
	include ('files/config.php');
	$post_id = test_input($_REQUEST["reported_post_id"]);
	$sql = "UPDATE post SET reported_count=reported_count+1 WHERE post_id=$post_id";
	if($result = mysqli_query($conn,$sql)){
		echo '<br><div class="alert alert-warning">You have reported this post and we will soon scrutinize it and take action. Thanks for helping us make sharing books easier. Regards.</div>';
		$sql1 = "SELECT reported_count FROM post WHERE post_id=$post_id";
		$row1 = mysqli_query($conn, $sql1);
		$extract1 = mysqli_fetch_assoc($row1);
		if($extract1["reported_count"]==5){
			$sql2 = "UPDATE post SET deleted=1 WHERE post_id=$post_id";
			$result2 = mysqli_query($conn,$sql2);
		}
	}
	else{
		echo '<br><div class="alert alert-warning">Sorry. A problem occured when reporting this post. Please try again after sometime.</div>';
	}
?>