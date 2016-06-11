<?php
include 'files/config.php';
if(isset($_SESSION["user_id"])){
	header ("Location:dashboard.php");
}
$msg = null;
$done = false;
if(isset($_POST["password"])){
if (isset($_POST["id"], $_POST["token"])){
    $user_id = test_input($_POST["id"]);
    $pass_reset_string = test_input($_POST["token"]);
    $password = test_input($_POST["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT user_id, pass_reset_string FROM users WHERE user_id='$user_id'";
    $row = mysqli_query($conn, $sql);
    if($user_exists=mysqli_num_rows($row)){
        $extract = mysqli_fetch_assoc($row);
        if($pass_reset_string==$extract["pass_reset_string"]){
            $sql1 = "UPDATE users SET hash='$password' WHERE user_id='$user_id'";
            if($result1 = mysqli_query($conn, $sql1)){
               $msg =  "Password change success.<br><a href='login.php'>Login</a> now.<br>";
            }
            else{
                $msg = "Some error.<br>";
            }
            $done = true;
        }
        else{
            echo "Bad behaviour of password reset.<br>";
        }
    }
    else{
        echo "No such user.<br>";
    }
    
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
	<title>Handybooks: Reset Password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" href="styles/default_lp.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
	<style type="text/css">
	    .tagline{
	    font-family: 'Open Sans', sans-serif;
	    }
	</style>
	<script src="jquery-1.11.2.min.js"></script>
	<script src="bootstrap.min.js"></script>
    <script>
        function on_m_dn(){
        document.getElementById("password").type = "text";
    }
    function on_m_up(){
        document.getElementById("password").type = "password";
    }

        </script>
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
        <div class="container">
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
                    <input  type="text"  name="id"  style="display:none;" value="<?php echo $_REQUEST['id'];?>">
                    <input  type="text"  name="token"  style="display:none;" value="<?php echo $_REQUEST['token'];?>">
                
            <div class="form-group">
                <label for="email" style="visibility:hidden;">Enter your new password</label>
                    
                    <div class="input-group">
                    <input id="password" class="input-md col-lg-2 form-control" type="password" placeholder="Your Password" name="password" required><span class="input-group-btn"><button onmouseup="on_m_up()" onmousedown="on_m_dn()" class="btn btn-default" id="show_password" type="button">show</button></span>
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
        <div id="footer" style="margin-top:150px;margin-bottom:0px;">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12" id="footer-main">
                <ul> 
                    <li>
                        <a href=<?php echo htmlspecialchars('about_us');?>>:: About Us ::</a>
                    </li> 
                    <li>
                        <a href=<?php echo htmlspecialchars('about_us');?>>The Story ::</a></li> 
                    <li>
                        <a href=<?php echo htmlspecialchars('terms');?>>Terms ::</a>
                    </li> 
                    <li>
                        <a href=<?php echo htmlspecialchars('terms');?>>Privacy Policy ::</a>
                    </li> 
                    <li>
                        <a href="https://www.facebook.com/handybooks"><i class="fa fa-1x fa-facebook"></i>
                    </li>
                </ul> 
                
            
            </div>
        </div>
</body>
</html>
<?php
}
?>