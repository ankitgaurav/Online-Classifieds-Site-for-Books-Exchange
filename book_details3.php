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
    $poster_id = $book_details['user_id'];
    
    $sql2 = "SELECT * FROM users WHERE user_id='$poster_id'";
    $row2 = mysqli_query($conn, $sql2);
    $poster_details = mysqli_fetch_assoc($row2);
    $poster_name = $poster_details["name"];
    $poster_id = $poster_details["user_id"];
    $poster_institute = $poster_details["institution"];
    $poster_city = $poster_details["city"];
    $poster_phone = $poster_details["phone"];
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
    <link rel="stylesheet" type="text/css" href="book_details.css">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/pure/0.6.0/forms-min.css">
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
	    	<div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-11 ">
                            <h3>
<?php
echo $book_details["post_name"];
echo '<span class=" pull-right text-success"><i class=""></i>On Sale for &#x20b9; '.$post_price.'</span>';
// echo '<a role="button" id="showForm" class="btn btn-success pull-right" href="#replyForm">Reply to this post</a>';  
?>                           </h3><hr>
                            <div class="row" style="padding-left:20px;margin-bottom:20px;">
<?php
    if($poster_city!=""){
    echo '<span class="text-muted"><i class="fa fa-map-marker"></i> Locality:</span> '.$poster_city;
    if($poster_institute!=""){
    echo '<span class="text-muted" style="padding-left:20px;"><i class="fa fa-bank"></i> institution:</span> '.$poster_institute.'<br>';
}
}
?>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
<?php
if ($book_details["image_path"] != "")
    echo "<div style='border:1px solid #E8E8E8;padding:3px;width:500px;height:400px;'>
            <a data-toggle='modal' data-target='#show_image'>
            <img src='" . $book_details["image_path"] . "' width='98%' height='98%'>
            <span class='text-muted'><center>Click to zoom <i class='fa fa-eye'></i></center></span>
            </a>
        </div>";
else 
    echo '<i class="fa fa-book fa-5x"></i>';
?>
                                </div>
                                
                                <div class="col-md-4">
                                    <h4><i class="fa fa-user"></i> <?php echo $poster_name;?></h4><hr>
                                    <h4><i class="fa fa-phone"></i> <?php echo $poster_phone;?></h4><hr>
                                    <div id="replyForm">
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="pure-form">
                                            <fieldset class="pure-group">
                                                <textarea class="pure-input-1" placeholder="Your Message" rows="4"></textarea>
                                                <input type="text" class="pure-input-1" placeholder="Your Email-id">
                                            </fieldset>
                                            <div class="form-group"><button type="submit" role="button" class="form-control btn btn-warning">Reply</button></div>
                                        </form>
                                    </div>
                                    
                                </div>

                            </div>
<hr><h4 class="text-muted">Book Details</h4>
<?php
echo "<span class='text-muted'>Title:</span> " . $book_details["post_name"] . "<br/>";
if($post_category!=""){
    echo '<span class="text-muted">Category:</span> <a href="search_books?search_tag='.$post_category.'">'.$post_category.'</a><br>';
}
if($post_department!=""){
    echo '<span class="text-muted">Department:</span> <a href="search_books?search_tag='.$post_department.'">'.$post_department.'</a><br>';
}
if($post_year!=""){
    echo '<span class="text-muted">Year/Class:</span> <a href="search_books?search_tag='.$post_year.'">'.$post_year.'</a><br>';
}
if($post_genre!=""){
    echo '<span class="text-muted">Genre:</span> <a href="search_books?search_tag='.$post_genre.'">'.$post_genre.'</a><br>';
}
if($post_description!=""){
    echo "<span class='text-muted'>Description:</span> " . $post_description.'<br>';
}

?> <hr>

                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <h4 style="color:#9197A3;">Other Related Books</h4><hr>
<?php
if($post_category=="Academic"){
$filter = "post_category='$post_category' and post_year='$post_year' and post_department='$post_department'";
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