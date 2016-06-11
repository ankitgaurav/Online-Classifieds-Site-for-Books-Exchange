<?php include('files/config.php');
$from_user_email=test_input($_REQUEST['buyer_email']);
$from_user_password=test_input($_REQUEST['buyer_password']);
$to_user=test_input($_REQUEST['poster_id']);
$msg=test_input($_REQUEST['msg']);
$notification=test_input($_REQUEST['notification']);

$msg_empty="";
$zero=0;
//for notification
$notification=test_input($_REQUEST['notification']);
$tag="book_request";
//end of for notification
if(isset($_SESSION['user_id']))
{
$from_user=$_SESSION['user_id'];
$sql200="INSERT INTO chats(from_user , msg, to_user, from_user_read) VALUES ('$from_user','$msg', '$to_user', true)";
$row200=mysqli_query($conn,$sql200);
$sql1000="INSERT INTO chats(from_user , msg, to_user, displayble) VALUES ('$to_user','$msg_empty', '$from_user', '$zero')";
$row1000=mysqli_query($conn,$sql1000);
//sending notification
$notifications=$_SESSION['name']." ".$notification;
$sql850="INSERT INTO notification (user_id, notification, tag, read_yes) VALUES ('$to_user','$notifications','$tag',0) ";
$row850=mysqli_query($conn,$sql850);
//notification sent
echo "Your message sent successfully.<br>You can view your <a href='messages.php'>messages</a> now.";
}
else
{
$password = password_hash($from_user_password, PASSWORD_DEFAULT);
$sql1="SELECT * FROM users WHERE email='$from_user_email'";
$row1=mysqli_query($conn,$sql1);
$result1=mysqli_fetch_assoc($row1);
if(mysqli_num_rows($row1)==0)
{
$sql2="INSERT INTO users(email , hash) VALUES ('$from_user_email', '$password')";
$row2=mysqli_query($conn,$sql2);
$sql3="SELECT * FROM users WHERE email='$from_user_email'";
$row3=mysqli_query($conn,$sql3);$result3=mysqli_fetch_assoc($row3);
$_SESSION["email"]=$result3["email"];
$_SESSION["user_id"]=$result3["user_id"];
$_SESSION["name"]="Anonymous";
$from_user=$result3["user_id"];
$sql3="INSERT INTO chats(from_user , msg, to_user) VALUES ('$from_user','$msg', '$to_user')";$row3=mysqli_query($conn,$sql3);
$sql1001="INSERT INTO chats(from_user , msg, to_user, displayble) VALUES ('$to_user','$msg_empty', '$from_user', '$zero')";
$row1001=mysqli_query($conn,$sql1001);
//sending notification
$notifications=$_SESSION['name']." ".$notification;
$sql850="INSERT INTO notification (user_id, notification, tag, read_yes) VALUES ('$to_user','$notifications','$tag',0) ";
$row850=mysqli_query($conn,$sql850);
//notification sent
echo "Your message sent successfully.<br>You can view your <a href='messages.php'>messages</a> now.<br>";
echo '<a href="dashboard.php" class="btn btn-primary pull-right">Go Home</a>';
}
else
{
$sql4="SELECT * FROM users WHERE email='$from_user_email'";
$row4=mysqli_query($conn,$sql4);
$result4=mysqli_fetch_assoc($row4);
$pass=$result4["hash"];
 if(password_verify($from_user_password,$pass)){
	$_SESSION["email"]=$result4["email"];
$_SESSION["user_id"]=$result4["user_id"];
$_SESSION["name"]=$result4["name"];
$from_user=$_SESSION["user_id"];
$sql5="INSERT INTO chats(from_user , msg, to_user) VALUES ('$from_user','$msg', '$to_user')";$row5=mysqli_query($conn,$sql5);
$sql1002="INSERT INTO chats(to_user , msg, from_user, displayble) VALUES ('$from_user','$msg_empty', '$to_user', '$zero')";
$row1002=mysqli_query($conn,$sql1002);
//sending notification
$notifications=$_SESSION['name']." ".$notification;
$sql850="INSERT INTO notification (user_id, notification, tag, read_yes) VALUES ('$to_user','$notifications','$tag',0) ";
$row850=mysqli_query($conn,$sql850);
//notification sent
echo "Your message sent successfully.<br>You can view your <a href='messages.php'>messages</a> now.<br>";
echo '<a href="dashboard.php" class="btn btn-primary pull-right">Go Home</a>';
}
else
{
	echo "You entered wrong email id/password need to <a href='login.php?from=feeds.php'>log in</a> first.";	
}	
}
}
?>