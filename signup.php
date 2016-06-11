<?php
include ("files/config.php");
if(isset($_GET["msg"])){
    if(test_input($_GET["msg"])=="notloggedin" && test_input($_GET["from"])=="book_request"){
        $msg = "You need to be logged in to be able to request books.";
    };
}
else{
    $msg=null;
}
if(isset($_SESSION["user_id"])){
    header('Location:dashboard');
}
else{
    //checking if form has been sent
    if(isset($_POST["email"]) && $_POST['email']!=""){
        //checking if fields are empty
        if($_POST["email"]!="" or $_POST["password"]!="" or $_POST["name"]){
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
                    header('Location:dashboard?msg=greetings');
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
                $msg="Email id already taken";
            }
            
        }
    }
            else{
                $form = true;
            }
}
if($form == true){
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Handybooks: Signup here</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap.min.css">
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
<!-- Signup container -->
        <div class="container">            
            <div class="row">
          <div class="col-sm-6 col-sm-offset-3">            
            <div class="panel panel-success">
            <div class="panel-heading"><h3 class="tagline"><strong>Register here</strong></h3></div>
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
            <form role="form" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?sgn_up";?>' method="post"><br>
                <div class="form-group"><label for="name" style="display:none">Name</label>
                <div class="input-group">                
                    <input id="name" class="input-md col-lg-2 form-control" type="text" placeholder="What is your name?" name="name" autofocus required <?php
                            if(isset($name)){
                                echo 'value="'.$name.'"';
                            }
                        ?>
                    ><span class="input-group-addon"><i class="fa fa-user"></i></span>
                </div>
                </div>
                <div class="form-group"><label for="email" style="display:none">Email</label>
                <div class="input-group">                
                    <input id="email" class="input-md col-lg-2 form-control" type="email" placeholder="Enter your email-id" name="email" required><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                </div>
                </div>
                <div class="form-group ">
                <label for="password" style="display:none;">Password</label>
                <div class="input-group">
                    <input id="password" class="input-md col-lg-2 form-control" type="password" placeholder="Choose a password" name="password" required><span class="input-group-btn"><button onmouseup="on_m_up()" onmousedown="on_m_dn()" class="btn btn-default" id="show_password" type="button"><i class="fa fa-eye"></i></button></span>
                    </div>
                </div>
                <div class="form-group">
                <button type="submit" class="btn btn-info btn-md form-control" value="Signup">Sign up &nbsp;<i class="fa fa-user-plus"></i></button>
                </div><span>Already registered? <a href="login">Login Instead</a></span>
                <br><br>
            </form>
            </div>            
        </div>            
        </div>            
        </div></div>
        </div></div>   
         <div id="footer" style="margin-top:100px;margin-bottom:0px;">
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
                        <a href="https://www.facebook.com/handybooks"><i class="fa fa-1x fa-facebook-official"></i>
                    </li>
                </ul> 
                
            
            </div>
        </div>         
    </body>
</html>
<?php
   }
?>