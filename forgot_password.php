<?php
include 'files/config.php';
if(isset($_SESSION["user_id"])){
	header ("Location:dashboard.php");
}
$msg = null;
$done = false;
if (isset($_POST["email"])){
	$email = test_input($_POST["email"]);
	$sql1 = "SELECT email,name,user_id from users WHERE email='$email'";
	$row1 = mysqli_query($conn, $sql1);
	$extract1 = mysqli_fetch_assoc($row1);
	if($email_exists=mysqli_num_rows($row1)){
		include ("generateRandomString.php");
		$pass_reset_string =  generateRandomString();
		$sql2 = "UPDATE users SET pass_reset_string='$pass_reset_string' WHERE email='$email'";
		$row2 = mysqli_query($conn,$sql2);
		//sending password reset mail
			$to_user_id = $extract1["user_id"];
			$to_name = $extract1["name"];
			$to = $email;
			$subject = "Password reset";
			$message = 'Hello '.$to_name.',<br>Your password reset link is:<a href="http://handybooks.in/password_reset.php?id='.$to_user_id.'&token='.$pass_reset_string.'">Click to reset password</a><br>';
			$header = "From:support@handybooks.in \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";
			$retval = mail ($to,$subject,$message,$header);
			// if( $retval == true )  
			// {
			//   echo "Message sent successfully from support@handybooks.in";
			// }
			// else
			// {
			//   echo "Message could not be sent...";
			// }
		
		$msg = "A password reset link has been sent to your email-id.<br>Follow the link to change your password.";
		$done = true;

	}
	else{
		$msg = "Sorry the Email-id you entered is not yet registered.";
		$page = true;
	}
}
else{
	$page = true;
}
if($page = true){
?>
<!DOCTYPE html>
<html>
<head>
	<title>Handybooks: Forgot Password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" href="styles/default_lp.css">
	<link rel="stylesheet" href="footer.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
	<style type="text/css">
	    .tagline{
	    font-family: 'Open Sans', sans-serif;
	    }
	</style>
	<script src="jquery-1.11.2.min.js"></script>
	<script src="bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <a href="home" onmouseover = "document.getElementById('in').style.visibility='visible'" onmouseout = "document.getElementById('in').style.visibility='hidden'" class="logo_text"><strong>handybooks</strong><small id="in" style="visibility:hidden;">.in</small></a>
                </div>
            <div>
                <ul class="nav navbar-nav navbar-right">
                <li><a href="home"><i class="fa fa-home"></i> Home</a></li>
                </ul>
            </div>
            </div>
        </nav>
        <!-- Login container -->
        <div class="container" id="main_content">
        <div class="row" style="margin-top:100px;">
            <div class="col-sm-6 col-sm-offset-3"> 
            <div class="panel panel-success">
        <div class="panel-heading"><h3 class="tagline"><strong>Reset Your Password</strong></h3></div>
        <div class="panel-body">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
<!--show message here-->
<?php
if($msg!=null){
echo "<div class='error_msg alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>
$msg
                </div>";
            }
?>
<!-- End of message-->
<?php
if ($done==false){
?>
            <form role="form" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'] 	);?>' method="post">
            <div class="form-group">
                <label for="email" style="visibility:hidden;">Enter your Registered Email-id</label>
                    <div class="input-group">
                    <input class="input-md col-lg-2 form-control" type="email" placeholder=" Enter your Registered Email-id here" name="email" required <?php
                            if(isset($email)){
                                echo 'value="'.$email.'"';
                            }
                        ?>><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                </div>
                 </div>
                <div class="form-group">
            <button type="submit" class="btn btn-info btn-md form-control" value="Reset Password">Reset Password&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </form>
            <?php
}
            ?>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
        </div>
        <div id="footer">
        <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6 footer_columns">
                <div class="row_heading">Handybooks</div>
                <ul>
                    <li><a href="about_us">
                        About us
                        </a>
                    </li>
                    <li><a href="our_story">
                        Our story
                    </li>
                    <!-- <li>
                        Mobile site
                    </li> -->
                    <!-- <li>
                        Blog
                    </li> -->
                    <li>
                        Handybooks app <i class="text-muted">( Coming Soon )</i>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 footer_columns">
                <div class="row_heading">Support</div>
                <ul>
                    <li><a href="how_it_works">
                        Get started
                        </a>
                    </li>
                    <li>
                    <a href="contact">
                        Contact
                        </a>
                    </li>
                    <li><a href="feedback">
                        Feedback
                        </a>
                    </li>
                </ul>   
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 footer_columns">
                    
                <div class="row_heading">Legal</div>
                <ul>
                    <li><a href="terms">
                        Terms and Conditions
                        </a>
                    </li>
                    <li>
                    <a href="privacy">
                        Privacy
                        </a>
                    </li>
                </ul>   
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 footer_columns">
                
                    <div class="row_heading">
                        Connect with Handybooks
                    </div>
                <ul>    
                    <li>
                    <a href="http://twitter.com/handybooksin"><span>
                    <i class="fa fa-twitter fa-2x"></i>&nbsp;&nbsp; 
                    </span>Follow us on twitter
                    </a>
                    </li>
                    <li>
                    <a href="http://www.facebook.com/handybooks"><span>
                    <i class="fa fa-facebook  fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>Like us on facebook
                    </a>
                    </li>
                    <li>
                        <a href="http://plus.google.com/+HandybooksIn"><span>
                    <i class="fa fa-google-plus  fa-2x"></i>&nbsp;&nbsp;
                    </span>
                        Digg on Google+
                    </a>
                    </li>
                </ul>   
            </div>
        </div>
</body>
</html>
<?php
}
?>