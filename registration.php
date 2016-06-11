<?php
include ('files/config.php');
$sql = "SELECT * FROM users WHERE deleted=0";
$row = mysqli_query($conn,$sql);
while($extract=mysqli_fetch_assoc($row)){
  if(isset($extract["name"])){
    $to_name = $extract["name"];
  }
  else{
    $to_name = "user";
  }
   $to = $extract["email"];
   $subject = "Welcome to Handybooks";
   $message = '
    <h1>Welocome to Handybooks </h1><hr>
    <p><strong>Greetings, '.$to_name.'.</strong><br>
    Let&apos;s get started with handybooks<hr><br>
    Thanks for signing up for handybooks.in<br>
    You can do the following things now.<br>
    <ul>
    <li><a href="http://handybooks.in/feeds">Buy a second-hand Book</li>
    <li><a href="http://handybooks.in/post_a_book">Sell an old book you don&apos;t need</a></li>
    <li><a href="http://handybooks.in/dashboard">Check out your profile</li>
    </ul>
    <br></p>';
   $header = "From:support@handybooks.in \r\n";
   $header .= "MIME-Version: 1.0\r\n";
   $header .= "Content-type: text/html\r\n";
   $retval = mail ($to,$subject,$message,$header);
   if( $retval == true )  
   {
      echo "Message sent successfully from support@handybooks.in";
   }
   else
   {
      echo "Message could not be sent...";
   }
}

?>