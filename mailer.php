<html>
<head>
<title>Sending email using PHP</title>
</head>
<body>
<?php
   $to_name = "Ankit";
   $to = "ankitgaurav@outlook.com";
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
?>
</body>
</html>