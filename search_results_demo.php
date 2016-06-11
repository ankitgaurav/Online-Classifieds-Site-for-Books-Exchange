<?php
include 'files/config.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Handybooks: Book Search</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="jquery-1.11.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <style type="text/css">
	#hints{
            background-color: white;
            border: 1px #CCCCCC solid;
            width: 100%;
            visibility: hidden;
            border-radius: 5px;
	}
    </style>
    <script>
function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("inner").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("hints").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "quicksearch.php?search_text=" + str, true);
        xmlhttp.send();
    }
}
function show_hints(){
    document.getElementById("hints").style.visibility = "visible";
}
function hide_hints(){
    document.getElementById("hints").style.visibility = "hidden";
}
</script>
    </head>
    <body>
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
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
        <a href="post_ad.php" class="btn btn-primary navbar-btn navbar-left" style="margin-right:5px;">Sell a Book</a>
        <?php
                if(isset($_SESSION["email"])){
                    echo '<li><a href="messages"><i class="fa fa-comments"></i> Messages</a></li>
        
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> '. $_SESSION["name"].'<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="dashboard">Profile</a></li>
            <li><a href="dashboard?to=transactions">Transactions</a></li>
            <li><a href="dashboard?to=book_requests">Book Requests</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="auth.php">Logout</a></li>
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
    <!-- Results Container -->
    <div class="container" style="display:block;height:80%">

        <div class="row">
            <div class="col-md-9">

            <div class="row">    
            <div class="col-md-8 col-md-offset-2">
			        <form class="form-search" action="search_results_demo.php" method="GET">

                <!-- <h2><small>Type in the box below to find any book</small></h2> -->
                <div class="row">
                <div class="input-group input-group-md">
                <input type="search" name="search_keyword" placeholder="Search any book here" onkeyup="showHint(this.value)"  class="form-control"  onfocus="show_hints()" onfocusout="hide_hints()"required autofocus autocomplete="off" value="<?php
                echo $_GET['search_keyword'];
                ?>">
                <span class="input-group-btn">
                <button class="btn btn-default btn-md" type="submit">
                    <i class="fa fa-search"></i>Search
                    </button>
                </span>
                </div></div>
                <div class="row" id="hints"></div>
				        </form>
            </div>            
            </div>
            
            <div class="row">
            <div class="col-md-11 "><br>
            <?php
			
if(isset($_GET["search_keyword"])){
        $search_keyword = test_input($_GET["search_keyword"]);
        $sql0 = "SELECT COUNT(*) as num FROM post WHERE user_id<>'0' and deleted=0 AND post_name LIKE '%".$search_keyword."%' ORDER BY post_time DESC";
        $row0 = mysqli_query($conn,$sql0) or die(mysqli_error($conn));
    }
                    $matches = mysqli_num_rows($row0);
                    if($matches==0){
                        echo "<hr><h5>Sorry, there isn't any book post matching your search.<br> You can <a href='request_a_book'>post a request</a> for this book and we will notify you once we have it in handybooks.</h5>";
                    }
                    else{
                        echo "<h4>Search Results: ".$matches." matches found.</h4><hr>";
                        while($posts = mysqli_fetch_assoc($row0)){
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

                                echo "<div style='display:block;' href='$link' class='latest_posts alert alert-default col-md-11'>";
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
						//echo '<div class="row">
                         //       <ul class="pager">
                         //       <li ><a href="#">Older</a></li>
                         //       <li ><a href="#">Newer</a></li>
                          //      </ul>
                          //      </div>';
                    }
			
								echo '</div>
            </div>';
			?>
            

            </div>
            <div class="col-md-3">
                <h3>Related Books</h3><hr>
            </div>
            </div>
        </div>
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
					<style>
						#fb-logo a{
							color:black;
						}
						#fb-logo a:hover{
							color: blue;
							text-decoration:none;
						}
					</style>
					<li id="fb-logo">
                        <a href=<?php echo htmlspecialchars('http://handybooks.in/handybooks');?>><i class="fa fa-facebook-official fa-2x"></i></a>
                    </li>                    
                </ul>
            </div>
       
    </body>
</html>