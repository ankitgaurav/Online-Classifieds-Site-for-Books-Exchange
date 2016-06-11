<?php
include('files/config.php');
$msg = null;
if(isset($_SESSION["user_id"])){
    header("Location:post_a_book");
}
else{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['login'])) {
        // Logging in user
        if($_POST["email"]!="" and $_POST["password"]!=""){
                $email=test_input($_POST["email"]);
                $password=test_input($_POST["password"]);
                //querying the email from database
                $query = "SELECT * FROM users WHERE `email`='$email'" ;
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                    $row=mysqli_fetch_assoc($result);
                    $pass = $row["hash"];
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
                        header("Location:post_a_book");
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
      else if(isset($_POST['signup'])) {
        // Signing up user 
        if($_POST["email"]!="" or $_POST["password"]!=""){
                //sanitizing and validating form inputs
                $name = test_input($_POST["name"]);
                $email = test_input($_POST["email"]);
                $password =test_input($_POST["password"]);

                //hashing passwords
                $password = password_hash($password, PASSWORD_DEFAULT);
                //checking if email exists
                $result = $conn->query('SELECT user_id FROM users WHERE email ="'.$email.'"');        
                $count = $result->num_rows;
                if($count==0){
                    //data insert here
                    $sql = "INSERT INTO users (name, email, hash) VALUES ('$name', '$email', '$password')";

                    if($conn->query($sql)=== TRUE){
                        $form = false;

                        //Setting session variables
                        $sql2 = "SELECT * FROM users WHERE `email`='$email'";
                        $row = mysqli_query($conn,$sql2);
                        $user_data = mysqli_fetch_assoc($row);

                        $_SESSION["user_id"] = $user_data['user_id'];
                        $_SESSION["email"] = $user_data['email'];
                        $_SESSION["name"] = $user_data['name'];
                        $_SESSION["first_login"] = true;

                        //sending signup email to user
                        include ('signup_mail.php');
                        header('Location:post_a_book');
                    }
                    else 
                    {
                        $form = true;
                        $msg = "Something went wrong. Data could not be inserted properly" . $conn->error;
                    }
                }
                else{
                    $form = true;
                    $name = $name;
                    $msg="Email id already taken.<br> You should try to log in instead.";
                } 
            }
            else{
                $form = true;
                $msg = "Please fill out all the fields.<br>";
            }
      }
    }
    else{//form is not submitted
        $form = true;
    }
}
if($form){
?>
<!DOCTYPE html>
<html lang=en>
<head>
    <title>Sell Old Books: Handybooks.in</title>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<script src="jquery-1.11.2.min.js"></script>
<script src="bootstrap.min.js"></script>
<script>
    function on_m_dn() {
        document.getElementById("password").type = "text"
    }
    function on_m_up() {
        document.getElementById("password").type = "password"
    };
</script>
</head>
<body>
    <nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header"> <a href=home onmouseover="document.getElementById('in').style.visibility='visible'" onmouseout="document.getElementById('in').style.visibility='hidden'" class=logo_text><strong>handybooks</strong><small id="in" style="visibility:hidden">.in</small></a> </div>
        <div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href=index.php><i class="fa fa-home"></i> Home</a>
                </li>
            </ul>
        </div>
    </div>
    </nav>
    <div class="container wrapper">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="panel panel-default" style="padding-bottom:30px;">
                    <div class="panel-heading">
                        <h3 style="text-align:center">Post Free Ad for Your Used Books <i class="fa fa-book"></i></h3>
                    </div>
                    <div class="panel-body">
                        <span class="text-center"><h5>Fill in your details to be able to post your books for sale</h5></span><br>
                        <!--show message here-->
                        <?php
                            if($msg!=null){
                            echo "<div class='row'><div class='col-sm-10 col-sm-offset-1'><div class='error_msg alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>
                            $msg
                                            </div></div></div>";
                                        }

                            ?>
                        <!-- End of message--> 
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a data-toggle="tab" href="#new_user_form">New User</a></li>
                                    <li><a data-toggle="tab" href="#registered_user_form">Registered User</a></li>
                                </ul>

                                <div class="tab-content" style="min-height:217px;">
                                    <div id="new_user_form" class="tab-pane fade in active">
                                        <form class="form-horizontal" role="form" style="padding-top:20px; border:1px solid #DDDDDD; border-top:transparent" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                                <div class="form-group">
                                <!--                 <label class="control-label col-sm-2" for="name">Name:</label>
                                 -->                <div class="col-sm-offset-1 col-sm-10">
                                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                <!--                 <label class="control-label col-sm-2" for="email">Email:</label>
                                 -->                <div class="col-sm-offset-1 col-sm-10">
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email-id" required>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                <!--                 <label class="control-label col-sm-2" for="email">Password:</label>
                                 -->                <div class="col-sm-offset-1 col-sm-10">
                                                <input type="password" name="password"  class="form-control" id="password" placeholder="Choose a password" required>
                                                </div>
                                                </div>
                                                <div class="form-group"> 
                                                <div class="col-sm-offset-1 col-sm-10">
                                                <button type="submit" class="btn btn-success form-control" value="signup" name="signup">Proceed to Post Ad</button>
                                                </div>
                                                </div>
                                        </form>
                                    </div>
                                    <div id="registered_user_form" class="tab-pane fade">
                                        <form class="form-horizontal" role="form" style="padding-top:20px; border:1px solid #DDDDDD; border-top:transparent" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                                <div class="form-group">
                                                    <div class="col-sm-10 col-sm-offset-1"> 
                                                        <div class="input-group">
                                                            <input class="input-md form-control" type="email" placeholder="Email" name="email" required 
                                                            <?php
                                                                 if(isset($email)){
                                                                  echo 'value="'.$email.'"';
                                                                 }
                                                            ?>
                                          s                  >
                                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-10 col-sm-offset-1"> 
                                                        <div class="input-group">
                                                            <input id="password" class="input-md col-lg-2 form-control" type="password" placeholder="Password" name="password" required>
                                                            <span class="input-group-btn"><button onmouseup="on_m_up()" onmousedown="on_m_dn()" class="btn btn-default" id="show_password" type="button"><i class="fa fa-eye"></i></button></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-10 col-sm-offset-1"> 
                                                        <input type="submit" class="btn btn-success btn-md form-control" name="login" value="Proceed to Post Ad">
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                                <br><center>By clicking on submit you agree to accept out <a href="terms">terms and conditions</a></center>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="push"></div>
    </div>
    <div id="footer" class="footer">
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
        <div class="row">
            <a href="home" onmouseover = "document.getElementsByClassName("in").style.visibility='visible'" onmouseout = "document.getElementsByClassName("in").style.visibility='hidden'" class="logo_text">
                <strong>handybooks</strong>
                <small class="in">.in</small>
            </a>
            <i>Happy Reading...</i>
        </div>
        </div>
    </div>

</body>
</html>
<?php
}
?>