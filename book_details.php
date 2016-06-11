<?php 
    include 'files/config.php';
    if (isset($_GET["p_id"])){
        $post_id = test_input($_GET["p_id"]);
        if (isset($_SESSION["post_id"]))
            {
            unset($_SESSION["post_id"]);
            }
        }
      else{
        header('Location:search_books');
        }
    $sql = "SELECT * FROM post WHERE post_id='$post_id'";
    $row = mysqli_query($conn, $sql);
    $book_details = mysqli_fetch_assoc($row);
    $post_id = $book_details["post_id"];
    $post_category = $book_details["post_category"];
    $post_name = $book_details["post_name"];
    $post_description = $book_details["post_description"];
    $post_department = $book_details["post_department"];
    $post_author = $book_details["post_author"];
    $post_year = $book_details["post_year"];
    $post_genre = $book_details["post_genre"];
    $post_price = $book_details["post_price"];
    $post_time = $book_details["post_time"];
    $poster_id = $book_details['user_id'];
    
    $sql2 = "SELECT * FROM users WHERE user_id='$poster_id'";
    $row2 = mysqli_query($conn, $sql2);
    $poster_details = mysqli_fetch_assoc($row2);
    $poster_name = $poster_details["name"];
    $poster_id = $poster_details["user_id"];
    $poster_institute = $poster_details["institution"];
    $poster_city = $poster_details["city"];
    $poster_phone = $poster_details["phone"];
    $msg = null;
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['reply_logged'])) {
            if($_POST["reply_msg"]!=""){
                $to_user=test_input($_POST['poster_id']);
                $reply_msg=test_input($_POST['reply_msg']);
                $reply_msg = "Reply to the book post ".$post_name.' posted on '.$post_time.'<hr>'.$reply_msg;
                $msg_empty="";
                $zero=0;
                $from_user=$_SESSION['user_id'];
                $sql200="INSERT INTO chats(from_user , msg, to_user, from_user_read) VALUES ('$from_user','$reply_msg', '$to_user', true)";
                $row200=mysqli_query($conn,$sql200);
                $sql1000="INSERT INTO chats(from_user , msg, to_user, displayble) VALUES ('$to_user','$msg_empty', '$from_user', '$zero')";
                $row1000=mysqli_query($conn,$sql1000);
                include("reply_email.php");
                $msg = "Your message sent successfully.<br>You can view your <a href='messages.php'>messages</a> now.";
                $form = true;
            }
            else{
                $msg = "Please type in something to reply.";
                $form = true;
            }
        }
        elseif(isset($_POST['reply_unlogged'])){
            if($_POST["reply_msg"]!="" or $_POST["buyer_email"]!=""){
                $buyer_email = test_input($_POST["buyer_email"]);
                $sql = "SELECT * FROM users WHERE email = '$buyer_email'";
                $row = mysqli_query($conn,$sql);
                if($email_exists=mysqli_num_rows($row)){//existing user
                    $extract = mysqli_fetch_assoc($row);
                    $from_user = $extract["user_id"];
                    $to_user=test_input($_POST['poster_id']);
                    $reply_msg=test_input($_POST['reply_msg']);
                    $reply_msg = "Reply to the book post ".$post_name.' posted on '.$post_time.'<hr>'.$reply_msg;
                    $msg_empty="";
                    $zero=0;
                    $sql200="INSERT INTO chats(from_user , msg, to_user, from_user_read) VALUES ('$from_user','$reply_msg', '$to_user', true)";
                    $row200=mysqli_query($conn,$sql200);
                    $sql1000="INSERT INTO chats(from_user , msg, to_user, displayble) VALUES ('$to_user','$msg_empty', '$from_user', '$zero')";
                    $row1000=mysqli_query($conn,$sql1000);
                    include("reply_email.php");
                    $msg = "Your message sent successfully.<br>You can view your <a href='messages.php'>messages</a> now.";
                    $form = true;
                }
                else{//new user
                    //generating random password
                        function generateRandomString(){
                        $length = 8;
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                        return $randomString;
                        }
                    //random password generated
                    $pass = generateRandomString();
                    //hashing passwords
                    $password = password_hash($pass, PASSWORD_DEFAULT);
                    //passsword hashed
                    $sql = "INSERT INTO users(email,hash) VALUES('$buyer_email','$password')";
                    if($result = mysqli_query($conn,$sql)){
                        $sql_id = "SELECT user_id FROM users WHERE email = '$buyer_email'";
                        $row_id = mysqli_query($conn,$sql_id);
                        if($extract_id=mysqli_fetch_assoc($row_id)){
                            $from_user = $extract_id["user_id"];
                        }
                        $to_user=test_input($_POST['poster_id']);
                        $reply_msg=test_input($_POST['reply_msg']);
                        $reply_msg = "Reply to the book post ".$post_name.' posted on '.$post_time.'<hr>'.$reply_msg;
                        $msg_empty="";
                        $zero=0;
                        $sql200="INSERT INTO chats(from_user , msg, to_user, from_user_read) VALUES ('$from_user','$reply_msg', '$to_user', true)";
                        $row200=mysqli_query($conn,$sql200);
                        $sql1000="INSERT INTO chats(from_user , msg, to_user, displayble) VALUES ('$to_user','$msg_empty', '$from_user', '$zero')";
                        $row1000=mysqli_query($conn,$sql1000);
                        //sending signup email to user
                        include ('signup_mail.php');
                        include("reply_email.php");
                        $msg = "Your message has been sent successfully.<br><a href='login'>Log in</a> to see your messages.<br>Your auto-generated password is: ".$pass;
                        $form = true;
                        }
                    else{
                        $msg = "Something went wrong. Please try again in a while.";
                        $form = true;
                    }
                }
            }
            else{
                $msg = "Please fill in the both the fields to reply.";
                $form = true;
            }
        }
        
    }
    else{
        $form = true;
    }
    if($form){
?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Handybooks: Books Details</title>
 	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
<!--     <link rel="stylesheet" type="text/css" href="book_details.css">
 -->    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/pure/0.6.0/forms-min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="jquery-1.11.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script type="text/javascript">
        // $(document).ready(function(){
        //     $("#showForm").click(function(){
        //         $("#replyForm").toggle();
        //     });
        // });
        function showForm(){
            document.getElementById("replyForm").style.display = "block";
        }
    </script>
    <style type="text/css">
        /*#replyForm{
            display:none;
        }*/
    </style>
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
<div id="show_image" class="modal fade" role="dialog">
<div class="modal-dialog">
    <div class='modal-content'>
        <a class="close" data-dismiss="modal" class="pull-right" style="padding-right:10px;position:absolute;right:0px;background-color:transparent;"><i class="fa fa-times-circle"></i></a>
        <img src="<?php echo $book_details["image_path"];?>" style="height:100%;width:100%;">
        <div class="modal-caption"><p><center><?php echo $book_details["post_name"];?></center></p></div>
    </div>
</div>
    
</div>
 	<div class="wrapper">
	 	<nav class="navbar navbar-default">
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
	            <form class="navbar-form navbar-left" role="search" action="search_books" method="GET">
	                <div class="input-group">
	                    <input name="search_keyword" type="text" class="form-control" placeholder="Search" >
	                    <span class="input-group-btn">
	                    <button class="btn btn-default" type="submit">
	                    <i class="fa fa-search"></i> Search
	                    </button>
	                    </span>
	                </div>
	            </form>
	    <div class="collapse navbar-collapse" id="myNavbar">
	        <ul class="nav navbar-nav navbar-right">
	        <!-- <a href="post_a_book" class="btn btn-primary navbar-btn navbar-left" style="margin-right:5px;">Sell a Book</a> -->
	        <?php
	                if(isset($_SESSION["email"])){
	                    echo '<li><a href="messages"><i class="fa fa-comments"></i> Messages</a></li>
	        
	        <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> '.$_SESSION["name"].'<span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="dashboard">Profile</a></li>
	            <li><a href="dashboard?to=transactions">Transactions</a></li>
	            <li><a href="dashboard?to=book_requests">Book Requests</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="logout">Logout</a></li>
	          </ul>
	        </li>';
	    }
	        else{
	            echo '<li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> Sign In<span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li class="dropdown-header">Existing User</li>
	            <li><a href="login">Log In</a></li>
	            <li class="divider"></li>
	            <li class="dropdown-header">New User</li>
	            <li><a href="signup">Register</a></li>
	          </ul>
	        </li>';
	        }
	        ?>
	        </ul>
	    </div>
	    </div>
	    </nav>
	</div>

	<div class="container" id="main_content">
<?php
    if($msg!=null){
        echo "<div class='row'><div class='col-sm-10 col-sm-offset-1'><div class='error_msg alert alert-warning fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>
        $msg
        </div></div></div>";
    }
?>
	    	<div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-11 ">
                            <h3>
<?php
echo $book_details["post_name"];
if($post_price!=""){
    echo "<span class='pull-right'>On Sale for &#x20b9; " . $post_price.'<br></span>';
}
?>                           </h3><hr>
                            <div class="row">
                                <div class="col-md-3">
<?php
if ($book_details["image_path"] != "")
    echo "<div style='border:1px solid #E8E8E8;padding:3px;width:160px;'><a data-toggle='modal' data-target='#show_image'><img src='" . $book_details["image_path"] . "' width='150px' height='150px'><span class='text-muted'><center>Click to zoom <i class='fa fa-eye'></i></center></span></a></div>";
else 
    echo '<i class="fa fa-book fa-5x"></i>';
?>
                                </div>
                                <div class="col-md-5">
                                    <h4 class="text-muted">Book Info</h4>
<?php
echo "<span class='text-muted'>Book Title:</span> " . $book_details["post_name"] . "<br/>";
if($post_author!=""){
    echo '<span class="text-muted">Author/Publication:</span> '.$post_author.'<br>';
}
if($post_category!=""){
    echo '<span class="text-muted">Category:</span> '.$post_category.'<br>';
}
if($post_department!=""){
    echo '<span class="text-muted">Department:</span> '.$post_department.'<br>';
}
if($post_year!=""){
    echo '<span class="text-muted">Year/Class:</span> '.$post_year.'<br>';
}
if($post_genre!=""){
    echo '<span class="text-muted">Genre:</span> '.$post_genre.'<br>';
}
if($post_description!=""){
    echo "<span class='text-muted'>Description:</span> " . $post_description.'<br>';
}
?>
                                </div>
                                <div class="col-md-4">
                                    <div id="replyForm">
<?php
    if($poster_phone!=""){
        echo '<h4 style="text-align:right;"><i class="fa fa-phone"></i> '.$poster_phone.'</h4>';
        }
    if(isset($_SESSION["user_id"])){
        echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'?p_id='.$post_id.'" method="post" class="pure-form">
                                            <fieldset>
                                                <input name="poster_id" value="'.$poster_id.'" style="display:none;">
                                                <textarea name="reply_msg" class="pure-input-1" placeholder="Reply to this book post" rows="3" required></textarea>
                                                
                                            </fieldset>
                                            <div class="form-group"><button  name="reply_logged" type="submit" role="button" class="form-control btn btn-warning">Reply</button></div>
                                        </form>';
    }
    else{
        echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'?p_id='.$post_id.'" method="post" class="pure-form">
                <fieldset class="pure-group">
                    <textarea name="reply_msg" class="pure-input-1" placeholder="Reply to this book post" rows="3" required></textarea>
                    <input name="buyer_email" type="email" class="pure-input-1" placeholder="Your Email-id" required>
                </fieldset>
                <input name="poster_id" value="'.$poster_id.'" style="display:none;">
                <div class="form-group"><button name="reply_unlogged" type="submit" role="button" class="form-control btn btn-warning">Reply</button></div>
            </form>';
    }
?>
                                    

                                        
                                    </div>
                                    
                                </div>

                            </div>
<hr><h4 class="text-muted">Seller Info</h4>
<?php
echo "<span class='text-muted'><i class='fa fa-user'></i> Posted by:</span> " . $poster_name . "<br/>";
if($poster_city!=""){
    echo '<span class="text-muted"><i class="fa fa-map-marker"></i> Locality:</span> '.$poster_city.'<br>';
}
if($poster_institute!=""){
    echo '<span class="text-muted"><i class="fa fa-bank"></i> institution:</span> '.$poster_institute.'<br>';
}
?>

                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <h4 style="color:#9197A3;">Other Related Books</h4><hr>
<?php
if($post_category=="Academic"){
$filter = "post_category='$post_category' and (post_year='$post_year' or post_department='$post_department')";
}
else{
$filter = "post_category='$post_category' and post_genre='$post_genre'";
}
$sql3 = "SELECT * FROM post WHERE user_id=1 and post_id<>$post_id and ".$filter." LIMIT 4";
$row = mysqli_query($conn,$sql3);
while($extract = mysqli_fetch_assoc($row)){
    $link='book_details2.php?p_id='.$extract["post_id"];
    if($extract["post_author"]!=""){
        $author = 'By '.$extract["post_author"];
    }
    echo '<a href="'.$link.'"><h5>'.$extract["post_name"].'</h5></a><small class="text-muted">'.$author.'<br>'.$extract["post_description"].'</small><hr>';
}
?>
                <div style="height=220px"><!-- <h4 style="color:#9197A3;">Like Our FB Page</h4> --><div class="fb-page" data-href="https://www.facebook.com/handybooks.in" data-height="220" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/handybooks.in"><a href="https://www.facebook.com/handybooks.in">handybooks.in</a></blockquote></div></div></div>
                </div>
            </div>

	</div>
    
<?php
include('footer.php');
?>

 </body>
 </html>
 <?php
}
?>