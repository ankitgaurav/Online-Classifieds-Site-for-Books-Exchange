<?php
include 'files/config.php';
if(isset($_GET['buyer_email']))
{
	 
	$post_id= $_GET['poster_id'];
	$email= $_GET['buyer_email'];
	$name= $_GET['poster_name'];
	$phone=$_GET['poster_phone'];
	$institution= $_GET['poster_institution'];
	if (isset($_SESSION['user_id'])) 
	{
		$user=$_SESSION['user_id'];
		$sql= "UPDATE users SET email='$email',institution='$institution',name='$name',phone='$phone' WHERE user_id='$user'";
		$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		$sql4="INSERT INTO requests(req_name ,user_id,deleted) VALUES('$post_id','$user',0)";
		$result4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
		$msg = $name." has ordered"." for Book id:".$post_id." from College:".$institution."<br>Phone number:".$phone;
		$sql5 = "INSERT INTO chats(from_user, msg, to_user) VALUES('$user','$msg', 1)";
		if($result5 = mysqli_query($conn,$sql5))
		echo "Your request has been posted successfully you will be contacted by your college representative";
		$sql6="INSERT INTO chats(from_user , msg, to_user, displayble) VALUES (1,'', '$user', 0)";
		$row6=mysqli_query($conn,$sql6);
	}
	else
	{
		echo "You  need to <a href='login.php'>login first</a>";
	}

}
else
{
	echo "You  need to <a href='login.php'>Login first</a>";
	/*$request_id=$_GET['poster_id'];
	$email=$_GET['buyer_email'];
	if (isset($_SESSION['id'])) 
	{
		$user=$_SESSION['id'];
		$sql= "UPDATE users SET email='$email' WHERE user_id='$user'";
		$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	}
	else
	{
		$sql1="SELECT * FROM users WHERE email='$email'";
		$row1=mysqli_query($conn,$sql1);
		$result1=mysqli_fetch_assoc($row1);
		if(mysqli_num_rows($row1)==0)
		{
			//new user
			$sql2="INSERT INTO users(email) VALUES ('$email')";
			$row2=mysqli_query($conn,$sql2);
			$sql3="SELECT * FROM users WHERE email='$email'";
			$row3=mysqli_query($conn,$sql3);
			$result3=mysqli_fetch_assoc($row3);
			$_SESSION["user_id"]=$result3["user_id"];
			$_SESSION["email"]=$result3["email"];
			$_SESSION["name"]="Anonymous";
			$user=$_SESSION["user_id"];
			$sql4="INSERT INTO requests(req_name ,user_id,deleted) VALUES('$request_id','$user',1)";
			if ($row4=mysqli_query($conn,$sql4)) 
			{
				echo "Your request has been sent successfully.";
				echo '<a href="dashboard.php" class="btn btn-primary pull-right">Go Home</a>';
			}
			else
			{
				echo "Something went wrong please try again";
			}
		}
		else
		{
			echo "Your email id already exists you need to <a href='login.php'>log in </a> first";
		}

	}
	*/
	

}

?>