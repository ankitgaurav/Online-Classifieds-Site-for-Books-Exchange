<?php
include ('files/config.php');
if(isset($_SESSION["user_id"])){
    header('Location:feeds');
}
else{
    //processing login form
if(isset($_POST["login_email"])){
//checking if email and password field are empty
    if($_POST["login_email"]!="" and $_POST["login_password"]!=""){
            $email=test_input($_POST["login_email"]);
            $password=test_input($_POST["login_password"]);
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
                    
                    header("Location:home");
                }
                else{
                    
                    $msg = "Wrong password";
                    header("Location:login.php?from=feeds");
                }            
        }
        else{
            $msg = "Email id not yet registered!";
            header("Location:login.php?from=feeds");
        }
    }
    else{
        $msg = "Please fill both email and password fields!";
        header("Location:login.php?from=feeds");
    }
}
    //login form process ends
    //checking if signup_form has been sent
    elseif(isset($_POST["signup_name"]) && $_POST['signup_email']!="" && $_POST["signup_password"]){
        //checking if fields are empty
        if($_POST["signup_name"]!="" or $_POST["email"]!="" or $_POST["password"]!=""){
            //sanitizing and validating form inputs
            $name = test_input($_POST["signup_name"]);
            $email = test_input($_POST["signup_email"]);
            $password =test_input($_POST["signup_password"]);

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
    <title>Handybooks.in - Best place to buy, sell, donate or exchange used/ second-hand books</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="description"   content="Buy, Sell, Donate and Exchange second hand easily in Handybooks.in. You can sell your old books or buy a second hand book easily with handybooks.in " />
    <meta property="og:url"           content="http://www.handybooks.in/" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="The best place to exchange second hand books" />
    <meta property="og:description"   content="Buy, Sell, Donate and Exchange second hand easily in Handybooks.in. You can sell your old books or buy a second hand book easily with handybooks.in " />
    <meta property="og:image"         content="http://handybooks.in/images/logo.png" />
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    
    <style type="text/css">
        .categories_list li{
            list-style: none;
            padding: 15px 15px 15px 10px;
            border-bottom: 1px solid #e7e7e7;
        }
        .categories_list{
            padding-left: 0px !important;
        }
        .post_icons{
            color:#888888;
        }
    	.cta_btns{
    		min-width:250px;
    	}
        .tagline{
            font-family: 'Open Sans', sans-serif;
            }
        #mast_head{
            background: url(images/mast_head1.jpg) no-repeat;
            background-size: cover;

        }
        #hints{
            background-color: white;
            border: 1px #CCCCCC solid;
            border-radius: 5px;
            position: absolute;
            z-index: 999;
            width: 100%;
            display: none
        }
        a .txt_decor_no hover{
            text-decoration: none;
        }
        .browse-buttons{
            margin: 3px;
            border-color: #A9D8B2;
        }
        .browse-buttons:hover{
            background-color: #E9F2EB;
        }
        .browse-buttons:active{
            background-color: #E9F2EB !important;
        }
        .book_photos{
            max-height: 100px;
            max-width: 50px;
        }
    </style>
    <script>
function on_m_dn(){
document.getElementById("password").type = "text";
}
function on_m_up(){
document.getElementById("password").type = "password";
}
        function save_user_info(){
                var name = edit_form.name.value;
                var institution = edit_form.institution.value;                
                var city = edit_form.city.value;
                var feeds = "feeds";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                        document.getElementById("modal-body").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('POST', 'process_save_user_info.php?name='+name+'&institution='+institution+'&city='+city+'&from='+feeds, true);
                xmlhttp.send();
            }

            function showLatestPosts(){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                        document.getElementById("latest_posts_div").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('POST', 'process_show_latest_posts.php', true);
                xmlhttp.send();
            }
    </script>
    </head>
    <body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=410824605770189";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
       <nav class="navbar navbar-default" style="margin-bottom:0;   ">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                    <a href="home" onmouseover = "document.getElementById('in').style.visibility='visible'" onmouseout = "document.getElementById('in').style.visibility='hidden'" class="logo_text">
                        <strong>handybooks</strong>
                        <small id="in" style="visibility:hidden;">.in</small>
                    </a>
            </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> Sign In<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Existing User</li>
                <li><a href="login">Log In</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">New User</li>
                <li><a href="signup">Register</a></li>
              </ul>
            </li>
            </ul>
        </div>
        </div>
        </nav>
    <!-- Masthead Container -->
    <div class="row" id="mast_head" style="margin-left:0;margin-right:0;">
        <div class="container" style="padding-top:10px; padding-bottom:10px;">
            <div class="col-md-9">
            <div class="jumbotron" style="background-color:transparent;">
                <h1 class="tagline" style="color:#333333;text-shadow: 2px 2px 8px white;font-weight:500;">Buy & Sell Second-hand Books Easily</h1>
            </div>
            </div>
            <div class="col-md-3" style="padding-top:50px;">
            <a role="button" class="btn btn-danger btn-lg cta_btns" href="post_a_book"><strong>Sell Your Used Books&nbsp; </strong><i class="fa fa-book"></i></a><br><br>
            <!-- <a role="button" class="btn btn-primary btn-lg cta_btns" href="#content"><strong>Browse Books to Buy &nbsp;</strong><i class="fa fa-search"></i></a><br><br> -->
            <a role="button" class="btn btn-primary btn-lg cta_btns" href="book_request"><strong>Request for a Book &nbsp;</strong><i class="fa fa-shopping-cart"></i></a><br>
            </div><br>
        </div>
    </div>
                        <!-- Main Content div starts here -->
            <div class="row" style="padding-top:30px;">
                <div class="container">
                    <div class="col-md-3" style="background-color:#FAFAFA;">
                        <h4 class="text-danger">Browse by Category</h4>
                        <ul class="categories_list"><h5 class="text-muted">
                            <li><a href="#">Engineering</a></li>
                            <li>Medical</li>
                            <li>Commerce</li>
                            <li>Arts</li>
                            <li>Science</li>
                            <li>School Books</li>
                            </h5>
                        </ul>
                        <h4 style="padding-top:20px;">Like Us on Facebook</h4>
                        <div class="fb-page" data-href="https://www.facebook.com/handybooks.in" data-height="220" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/handybooks.in"><a href="https://www.facebook.com/handybooks.in">handybooks.in</a></blockquote></div></div>
                    </div>
                    <div class="col-md-9" style="padding-left:40px;">
                        <div class="search_box" style="padding-top:25px;padding-right:20px;padding-left:20px;">
                            <div class="row">
                                <div class="row">
                                <form class="form-search" action="search_books" method="GET">
                                <div class="input-group input-group-lg" id=search_box>
                                <input type=text name=search_keyword placeholder="Search books by title or author" onkeyup="showHint(this.value)" class="form-control" onfocus="show_hints()" required autocomplete="off"> <span class=input-group-btn> <button class="btn btn-default btn-lg btn-default" type=submit> <i class="fa fa-search"></i> Search </button> </span> </div>
                                </form>
                                <div id="hints"></div>

                                </div>
                                
                            </div>
                                
 
                        </div>
                        <div class="row book_shelf" style="padding-top:20px;">
                                <h3 style="padding-left:20px;" class="text-danger text-muted">Engineering Books</h3><hr>
                                <div class="col-sm-4 col-xs-6 col-md-3">
                                <div class="thumbnail">
                                <img src="images/organiser.jpeg" alt="..." height="200px" width="200px">
                                <div class="caption">
                                <h5>WBUT Organiser for 4th Semester</h5>
                                <p><a href="#" class="btn btn-info btn-sm" role="button">Buy</a><span class="text-success"> 50% of MRP</span></p>
                                </div>
                                </div>
                                </div>
                                <div class="col-sm-4 col-xs-6 col-md-3">
                                <div class="thumbnail">
                                <img src="images/organiser.jpeg" alt="..." height="200px" width="200px">
                                <div class="caption">
                                <h5>WBUT Organiser for 4th Semester</h5>
                                <p><a href="#" class="btn btn-warning btn-sm" role="button">Buy</a><span class="text-success"> 50% of MRP</span></p>
                                </div>
                                </div>
                                </div>
                                <div class="col-sm-4 col-xs-6 col-md-3">
                                <div class="thumbnail">
                                <img src="images/organiser.jpeg" alt="..." height="200px" width="200px">
                                <div class="caption">
                                <h5>WBUT Organiser for 4th Semester</h5>
                                <p><a href="#" class="btn btn-warning btn-sm" role="button">Buy</a><span class="text-success"> 50% of MRP</span></p>
                                </div>
                                </div>
                                </div>
                                <div class="col-sm-4 col-xs-6 col-md-3">
                                <div class="thumbnail">
                                <img src="images/organiser.jpeg" alt="..." height="200px" width="200px">
                                <div class="caption">
                                <h5>WBUT Organiser for 4th Semester</h5>
                                <p><a href="#" class="btn btn-warning btn-sm" role="button">Buy</a><span class="text-success"> 50% of MRP</span></p>
                                </div>
                                </div>
                                </div>
                            <!-- starting novels row here -->
                                    <h3 style="padding-left:20px" class="text-danger">Novels on Sale</h3>
                                    <hr>
                                    <div class="col-sm-4 col-xs-6 col-md-3" >
                                    <div class="thumbnail">
                                    <img src="images/organiser.jpeg" alt="..." height="200px" width="200px">
                                    <div class="caption">
                                    <h5>WBUT Organiser for 4th Semester</h5>
                                    <p><a href="#" class="btn btn-warning btn-sm" role="button">Buy</a><span class="text-success"> 50% of MRP</span></p>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 col-md-3">
                                    <div class="thumbnail">
                                    <img src="images/organiser.jpeg" alt="..." height="200px" width="200px">
                                    <div class="caption">
                                    <h5>WBUT Organiser for 4th Semester</h5>
                                    <p><a href="#" class="btn btn-warning btn-sm" role="button">Buy</a><span class="text-success"> 50% of MRP</span></p>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 col-md-3">
                                    <div class="thumbnail">
                                    <img src="images/organiser.jpeg" alt="..." height="200px" width="200px">
                                    <div class="caption">
                                    <h5>WBUT Organiser for 4th Semester</h5>
                                    <p><a href="#" class="btn btn-warning btn-sm" role="button">Buy</a><span class="text-success"> 50% of MRP</span></p>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 col-md-3">
                                    <div class="thumbnail">
                                    <img src="images/organiser.jpeg" alt="..." height="200px" width="200px">
                                    <div class="caption">
                                    <h5>WBUT Organiser for 4th Semester</h5>
                                    <p><a href="#" class="btn btn-warning btn-sm" role="button">Buy</a><span class="text-success"> 50% of MRP</span></p>
                                    </div>
                                    </div>
                                    </div>                                 
                        </div>
                    </div>
                </div>
            </div>
            
<?php
include ('footer.php');
?>
<script src="jquery-1.11.2.min.js"></script>
<script src="bootstrap.min.js"></script>
<script src="js/show_hints.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
      var val,val1;
      function showLatestPosts(){
        document.getElementById("latest_posts_div").innerHTML = '<center><i class="fa fa-3x fa-spinner fa-pulse"></i></center>';
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    $('html,body').animate({
                        scrollTop: $("#posts_lists").offset().top},
                        'slow');
                document.getElementById("latest_posts_div").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "loadfeeds.php", true);
        xmlhttp.send();
      }
      function loadfeeds(val)
      {
        $('.browse-buttons').on("click",function(){  
        $('.browse-buttons').not(this).removeClass('active');
        $(this).toggleClass('active');
        });
        document.getElementById("latest_posts_div").innerHTML = '<center><i class="fa fa-3x fa-spinner fa-pulse"></i></center>';
        val1=val.value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    $('html,body').animate({
                        scrollTop: $("#posts_lists").offset().top},
                        'slow');
                document.getElementById("latest_posts_div").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "loadfeeds.php?category="+val1, true);
        xmlhttp.send();
    }
var $checkboxes = $("input:checkbox");
$checkboxes.on("change", function(){
var opts = getFilters();
updatePosts(opts);
});

function getFilters(){
var opts = [];
$checkboxes.each(function(){
if(this.checked){
opts.push(this.value);
}
});
return opts;
}

function updatePosts(opts){
document.getElementById("latest_posts_div").innerHTML = '<center><i class="fa fa-3x fa-spinner fa-pulse"></i></center>';
var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    $('html,body').animate({
                        scrollTop: $("#posts_lists").offset().top},
                        'slow');
                document.getElementById("latest_posts_div").innerHTML = xmlhttp.responseText;
            }
        }
        var length=opts.length;
        xmlhttp.open("GET", "updatePosts.php?filter="+opts, true);
        xmlhttp.send();
}
</script>     
    </body>
</html>
<?php
}
?>
