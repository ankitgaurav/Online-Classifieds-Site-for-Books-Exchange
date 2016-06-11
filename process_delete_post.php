<?php
include 'files/config.php';
function test($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;	
}
$post_id = test($_REQUEST['post_id']);
$user_id = $_SESSION['user_id'];
$sql = "SELECT `user_id` FROM `post` WHERE `post_id`='$post_id'";
$row = mysqli_query($conn,$sql);
$extract = mysqli_fetch_assoc($row);
	if($user_id == $extract['user_id']){
		$sql1 = "UPDATE post SET deleted=true WHERE post_id=$post_id";
		if($row = mysqli_query($conn,$sql1)){
			header("Location:dashboard.php?to=transactions&msg=deleted_post");
	}
	}
	else{
		echo "You can't delete others' posts. You can still <a href=report_post.php?post_id=".$post_id.">report</a> it, if you think it is abusive.";
	}
?>