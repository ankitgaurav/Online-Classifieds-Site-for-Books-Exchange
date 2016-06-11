<?php
if(isset($poster_name)){
   $to_name = $poster_name;
}
else{
   $to_name = "user";
}
$sql_reply = "SELECT * FROM users WHERE user_id = '$poster_id'";
$row_reply = mysqli_query($conn,$sql_reply);
if($extract = mysqli_fetch_assoc($row_reply)){
  $to = $extract["email"];
}
 $subject = "New Replies to Your Ad Post";
 $message = '
  <h1>New Replies</h1><hr>
  <p><strong>Hello '.$to_name.'.</strong><br>
  You have new replies to the book posted on handybooks<br>
  <hr>Your latest reply id<br><i>'.$reply_msg.'.<hr>
  Click <a href="http://handybooks.in/login">here</a> to view the messages now.
  <br></p>';
 $header = "From:support@handybooks.in \r\n";
 $header .= "MIME-Version: 1.0\r\n";
 $header .= "Content-type: text/html\r\n";
 $retval = mail ($to,$subject,$message,$header);
?>