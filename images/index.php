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
                    
                    header("Location:$redir");
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
    <meta property="og:url"           content="http://www.handybooks.in/" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="The best place to exchange second hand books" />
    <meta property="og:description"   content="Buy, Sell, Donate and Exchange second hand easily in Handybooks.in. You can sell your old books or buy a second hand book easily with handybooks.in " />
    <meta property="og:image"         content="http://handybooks.in/images/logo.png" />
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style type="text/css">
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
            visibility: hidden;
            border-radius: 5px;
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

    </style>
    
    <script>
function on_m_dn(){
document.getElementById("password").type = "text";
}
function on_m_up(){
document.getElementById("password").type = "password";
}

function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("inner").innerHTML = "";
        document.getElementById("hints").style.display = "none";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("hints").style.visibility = "visible";
                document.getElementById("hints").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "quicksearch.php?search_text=" + str, true);
        xmlhttp.send();
    }
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
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1075301472498825";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="row" id="mast_head">
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
        <!-- <a href="post_a_book" class="btn btn-primary navbar-btn navbar-left" style="margin-right:5px;" id="post_ad_btn">Sell a Book</a> -->
        <li>
            <a href="how_it_works"><strong>HOW IT WORKS</strong></a>
        </li>
        <li>
            <a href="#content"><strong>BROWSE</strong></a>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><strong>LOGIN</strong><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li style="padding:10px;">
              <form class="form" name="login_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div class="form-group">
                  <input type = "text" class="form-control input-md" name="login_email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <input type = "password" class="form-control input-md" name="login_password" placeholder="Password" required>
                </div>
                  <input type="submit" class="form-control btn btn-md btn-primary" value="Login">
                  
              </form>
            </li>
          </ul>
        </li>
        </ul>
    </div>
    </div>
    </nav>
    <!-- Masthead Container -->
        <div class="container" style="padding-top:10px;">
            <div class="col-md-9">
            <div class="jumbotron" style="background-color:transparent;">
                <h1 class="tagline" style="color:#333333;text-shadow: 2px 2px 8px white;font-weight:500;">Exchanging used books was never so easy.</h1>
            </div>
            </div>
            <div class="col-md-3">
            <div id="signup_div">
                    <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" name="signup_form">
                        <h4 style="color:#333333">New here? Create an account for Free!</h4>
                        <div class="form-group"><div class="input-group">
                            <input class="form-control" name="signup_name" type="text" placeholder="Name" required><span class="input-group-addon"><i class="fa fa-user"></i></span>
                        </div></div>
                        <div class="form-group"><div class="input-group">
                            <input class="form-control" name="signup_email" type="email" placeholder="Email Address" required><span class="input-group-addon"><i class="fa fa-envelope"> </i></span>
                        </div></div>
                        <div class="form-group"><div class="input-group">
                            <input class="form-control" id="password" name="signup_password" type="password" placeholder="Choose a password" required><span class="input-group-addon" onmouseup="on_m_up()" onmousedown="on_m_dn()" id="show_password" role="button"><i class="fa fa-eye"></i></span>
                        </div></div>
                        <div class="form-group">
                            <input class="btn btn-primary" role="button" type="submit" value="Sign up"><br>
                            <small>By signing up, you agree to the <a href="terms"><u>Terms of Use</u></a> of handybooks</small>
                        </div>
                    </form>
                </div>
            </div><br>
            </div>
            </div>
                        <!-- Main Content div starts here -->
            <div class="row">
            <div class="container" id="content" style="padding-top:20px;">
            <div class="col-md-4" style="background-color:#FAFAFA;padding-bottom:20px;">
            <h4>Search or Browse Old Books</h4>
            <form class="form-search" action="search_results" method="GET">                
                <div class="input-group input-group-md" id="search_box">
                <input type="text" name="search_keyword" placeholder="Title, Author or Genre" onkeyup="showHint(this.value)" value="" class="form-control" onfocus="showHints()" required autocomplete="off">
                <span class="input-group-btn">
                <button class="btn btn-default btn-md btn-default" type="submit">
                    <i class="fa fa-search"></i>
                    Search
                    </button>
                </span>
                </div>
                <div id="hints"></div>
            </form>
            
            <div  id="browse_categories" style="margin-top:10px;padding:10px;border:1px #EEEEEE solid;border-radius:3px;height:auto;width:100%">
                <!-- <button type="button" class="btn btn-default browse-buttons " value= "Engineering"onclick="loadfeeds(this)">Engineering</button> -->
                <button type   ="button" class="btn btn-default browse-buttons" href="#" value= "Computer Scinece Engineering" onclick="loadfeeds(this)">Computer Scinece</button>
                <button type="button" class="btn btn-default browse-buttons" value= "Electrical Engineering" onclick="loadfeeds(this)">Electrical</button>
                <button type="button" class="btn btn-default browse-buttons" value= "Mechanical Engineering" onclick="loadfeeds(this)">Mechanical</button>
                <button type="button" class="btn btn-default browse-buttons" value= "Automobile Engineering" onclick="loadfeeds(this)">Automobile</button>
                <button type="button" class="btn btn-default browse-buttons" value= "Electrical Engineering" onclick="loadfeeds(this)">Electrical</button>
                <button type="button" class="btn btn-default browse-buttons" value= "Information Technology Engineering" onclick="loadfeeds(this)">IT Engineering</button>
                <button type="button" class="btn btn-default browse-buttons" value= "civil Engineering" onclick="loadfeeds(this)">Civil Engineering</button>
                <button type="button" class="btn btn-default browse-buttons" value= "Electronics and Communication Engineering" onclick="loadfeeds(this)">Electronics & Communication </button>
                
                <button type="button" class="btn btn-default browse-buttons" value= "Any Branch" onclick="loadfeeds(this)">Any Branch</button>
                
            </div><hr>
            <h4>Share Your Old Course Books, Novels or Magazines</h4>
            
            <div class="btn-group btn-group btn-group-justified" role="group" aria-label="...">
                <a role="button" href="post_a_book" class="btn btn-default" ><strong class=" text-success">Sell A Book</strong></a>
                <a role="button" href="post_a_book" class="btn btn-default" ><strong class=" text-success">Donate</strong></a>
                <a role="button" href="post_a_book" class="btn btn-default" ><strong class=" text-success">Exchange</strong></a>
            </div>
            </div>   

<!--             right content
 --> 
            <div class="col-md-8" id="posts_lists"><h4>
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active">
                        <a href="#latest_posts_div" onclick="showLatestPosts()">Latest Book Posts</a>
                    </li>
                    <li role="presentation">
                        <a href="#">Latest Book Requests</a>
                    </li>
                </ul></h4><br>
                    <div id="latest_posts_div">         
                    <?php
                    //for pagination and displaying latest posts
                        $query = "SELECT * FROM post WHERE user_id<> '0' and deleted=false";
                        $total_pages = mysqli_num_rows(mysqli_query($conn,$query));
                        $targetpage = "home";
                        $limit = 5;
                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                            $start = ($page - 1) * $limit;
                        }   
                        else{
                            $page = 0;
                            $start = 0;
                        }

                            $sql = "SELECT * FROM post WHERE user_id<> '0' and deleted=false ORDER BY post_time DESC LIMIT $start, $limit";
                            $row = mysqli_query($conn,$sql);
                            while($posts = mysqli_fetch_assoc($row)){
                                $link='book_details?p_id='.$posts["post_id"];
                                 if($posts["post_type"]=="donate"){
                                    $price = "Free: On Donate";
                                }
                                elseif ($posts["post_type"]=="exchange") {
                                    $price = "On Exchange";
                                }
                                else{
                                    $price = "On sale for Rs. ".$posts["post_price"];
                                }

                                $time = $posts["post_time"];
                                $time = strtotime($time);
                                $time = date("jS M", $time);

                                echo "<div style='display:block;' href='$link' class='latest_posts alert alert-default'>";
                                if ($posts['post_category']=="Academic" or $posts['post_category']=="uncategorized") {
                                    echo '<div class="row"><div class="col-md-2"><i class="fa fa-5x fa-leanpub" style="color:#777777"></i></div>';
                                } 
                                elseif($posts['post_category']=="Novel"){
                                    echo '<div class="row"><div class="col-md-2"><i class="fa fa-5x fa-book" style="color:#7C6F62;"></i></div>';
                                }
                                else{
                                    echo '<div class="row"><div class="col-md-2"><i class="fa fa-5x fa-newspaper-o"></i></div>';
                                }
                                if($posts['post_author']!=""){
                                    $author = "by ".$posts["post_author"];
                                }
                                else{
                                    $author = "";
                                }
                                echo '<div class="col-md-10"><h4 style="text-transform:capitalize;"><a href='.$link.'>'.$posts['post_name']." ".$author.'</a><a href="'.$link.'"role="button" class="pull-right btn btn-xs btn-default"style="font-size: 14px;">See more</a></h4>';
                                echo '<small class="text-success">'.$price.'</small><br>';

                                //block for creating the tags string starts here
                                $tags = "";
                                if($posts['post_genre']!=""){
                                    $tags = $posts['post_genre'].", ";
                                }
                                if ($posts["post_subject"]!="") {
                                    $tags = $tags.$posts["post_subject"].", ";
                                }
                                if ($posts["post_department"]!="") {
                                    $tags = $tags.$posts["post_department"].", ";
                                }
                                if($posts['post_category']!=""){
                                    $tags = $tags.$posts["post_category"].", ";
                                }
                                if ($posts['post_class']!="") {
                                    $tags = $tags.$posts["post_class"].", ";
                                }
                                if($posts['post_subject']!=""){
                                    $tags = $tags.$posts["post_subject"].", ";
                                }
                                if($posts['post_year']!=""){
                                    $tags = $tags.$posts["post_year"].", ";
                                }
                                //tags string creation ends here
                                echo "<small style='color: #7d7d7d'>Tags: </small>".$tags;
                                if($posts["post_description"]!=""){
                                    echo "<br><small style='color: #7d7d7d'>Description:</small> ".$posts["post_description"]."<br>";
                                }
                                // echo "<div class='pull-right text-success'>".$price."</div>";
                                echo "</div></div></div>";
                            }
                            echo '<ul class="pager">';
if ($page == 0) $page = 1;
$prev = $page - 1;
$next = $page + 1; 
$lastpage = ceil($total_pages/$limit);
$lpm1 = $lastpage - 1;
$pagination = "";
if($lastpage > 1)
{ 
    if($page>1){
        echo '<li class="previous"><a href="'.$targetpage.'?page='.$prev.'">Newer</a></li>';
    }
    else{
        echo '<li class="previous"><a role="button" class="btn btn-default "href="'.$targetpage.'?page='.$prev.'" disabled="disabled">Newer</a></li>';
    }
    if ($page < $lastpage) 
        echo '<li class="next"><a href="'.$targetpage.'?page='.$next.'">Older</a></li>';
    else
        echo '<li class="next"><a href="'.$targetpage.'?page='.$next.'" role="button" class="btn btn-default"disabled="disabled">Older</a></li>';
}
    
                    echo '</ul>';
                    ?>
                    </div>
                    <!--latest_posts_div ends-->
                    <div id="latest_requests_div">
                        
                    </div>
            </div>

<!--                 right content ends here-->            
            </div> 
            </div>
            <!-- Content div ends here--> 
        </div></div></div>
        <div id="footer" style= "margin-bottom:0px;">
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
                        <a href=<?php echo htmlspecialchars('http://facebook.com/handybooks');?>><i class="fa fa-facebook-official fa-2x    "></i></a>
                    </li>                    
                </ul>
            </div>
        </div>
        <script src="jquery-1.11.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
<script type="text/javascript">

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
      </script>     

    </body>
</html>

<?php
}
?>