<?php
   $to = $to_user_email;
   $subject = "New reply to your ad on Handybooks";
   $message = 'You have got a new reply to the ad posted by you.<br>
   Click <a href=http://handybooks.in/messages>here</a> to view your messsages.';
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