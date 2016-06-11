<?php
if(isset($_SESSION["name"])){
   $to_name = $_SESSION['name'];
}
else{
   $to_name = "user";
}
if(isset($pass)){
  $rand_pass = "Your auto-generated password is: ".$pass."<br>You can use it to <a href='http://handybooks.in/login'>login</a> to your account.";
}
 $to = $buyer_email;
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
?>