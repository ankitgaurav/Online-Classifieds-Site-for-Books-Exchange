<?php
include 'files/config.php';
//Showing message or alert
if(isset($_GET["msg"])){
    if(isset($_GET["from"])){
            $redirection = $_GET["from"];
    }
    if ($_GET["msg"]=="notloggedin") {
        $msg = "You need to login first.";
    }    
}
else{
    $msg=null;
    //Redirecting to where required if FROM value is specified
    if(isset($_GET["from"]) && $_GET["from"]!=null){
        $redirection = $_GET["from"];
        if($redirection=="messages"){
            $redir = "messages";
        }
        elseif($redirection=="dashboard"){
            $redir = "dashboard";
        }
        elseif ($redirection=="feeds") {
            $msg = "There was some error. You need to login again.";
        }
    }
    else{//Redirecting to feeds if FROM is not specified
    $redirection = null;
    $redir = "feeds";
    }
}
//checking whether already logged in
if(isset($_SESSION["email"])){
    header('Location:feeds');
}
//checking if form is submitted
if(isset($_POST["email"])){
//checking if email and password field are empty
    if($_POST["email"]!="" and $_POST["password"]!=""){

            $email=test_input($_POST["email"]);
            $password=test_input($_POST["password"]);
//querying the email from database
            $query = "SELECT * FROM users WHERE `email`='$email'" ;
            $result=mysqli_query($conn,$query);
            if(mysqli_num_rows($result)){
                $row=mysqli_fetch_assoc($result);
                $pass = $row["hash"];
                // echo password_hash('cat', PASSWORD_DEFAULT);
                // echo password_hash('cat', PASSWORD_DEFAULT);
                if(password_verify($password,$pass)){
                    $form = false;
                    //Setting session variables
                    $one=1;
                     $user_id=$row['user_id'];
                    $sql190 = "SELECT * FROM chats WHERE (to_user='$user_id' and displayble='$one' and to_user_read=0) ";
                    $result190 = mysqli_query($conn,$sql190) or mysqli_error($conn);
                    $_SESSION['no_of_unread_msg']= mysqli_num_rows($result190);
                    $_SESSION["user_id"] = $row['user_id'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["name"] = $row['name'];
                    
                    header("Location:$redir");
                }
                else{
                    $form = true;
                    $msg = "Wrong password";
                    $forgot_password = true;
                }            
        }
        else{
            $form= true;
            $msg = "Email id not yet registered!";
        }
    }
    else{
        $form = true;
        $msg = "Please fill both email and password fields!";
    }
}
   else{
//showing the form
       $form = true;
   }
       if($form == true){
       ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
        <link rel="stylesheet" href="styles/default_lp.css">
        <link rel="stylesheet"  type="text/css" href="footer.css">
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
        <div class="container" id="main_content">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3"> 
            <div class="panel panel-success">
        <div class="panel-heading"><h3 class="tagline"><strong>Login here</strong></h3></div>
        <div class="panel-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
<!--show message here-->
<?php
if($msg!=null){
echo "<div class='error_msg alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>
$msg
                </div>";
            }
?>
<!-- End of message-->
            <form role="form" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']."?from=".$redirection);?>' method="post">
                <label for="email" style="visibility:hidden">Email</label>
                    <div class="input-group">
                    <input class="input-md col-lg-2 form-control" type="email" placeholder="Enter your Email" name="email" required <?php
                            if(isset($email)){
                                echo 'value="'.$email.'"';
                            }
                        ?>><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                </div>
                <div class="form-group ">
                <label for="password" style="visibility:hidden">Password</label>
                <div class="input-group">
                    <input id="password" class="input-md col-lg-2 form-control" type="password" placeholder="Your Password" name="password" required><span class="input-group-btn"><button onmouseup="on_m_up()" onmousedown="on_m_dn()" class="btn btn-default" id="show_password" type="button"><i class="fa fa-eye"></i></button></span>
                    </div>
                </div>
                <div class="form-group">
            <button type="submit" class="btn btn-info btn-md form-control" value="Login">Login&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
                <span>New user? <a href="signup">Register here.</a></span>
                <br><span>Trouble logging in? <a href="forgot_password.php">Click here</a></span>
                <br><br>
            </form>
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