<?php
include ('files/config.php');
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
    <link rel="stylesheet" type="text/css" href="footer.css">
	<style type="text/css">
	    #hints{
	        background-color: white;
            border: 1px #CCCCCC solid;
            border-radius: 5px;
            position: absolute;
            width: 100%;
            display: none;
            z-index: 999;
	    }
	</style>
    <script src="jquery-1.11.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="js/show_hints.js"></script>

    </head>
    <body>
    <div >
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
						<li><a href="post_ad.php" style="margin-right:5px;">Sell a Book</a></li>
						<?php

						if (isset($_SESSION["email"]))
						{
						echo '<li><a href="messages"><i class="fa fa-comments"></i> Messages</a></li>
						<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> ' . $_SESSION["name"] . '<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="dashboard">Profile</a></li>
						<li><a href="dashboard?to=transactions">Transactions</a></li>
						<li><a href="dashboard?to=book_requests">Book Requests</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="auth.php">Logout</a></li>
						</ul>
						</li>';
						}
						else
						{
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
		<div class="container" id="main_content">
			<div class="row">
				<div class="col-md-9">
					<div class="row">    
						<div class="col-md-8 col-md-offset-1">
						<form class="form-search" action="search_books" method="GET">
							<div class="row">
								<div class="input-group input-group-md">
								<input type="search" name="search_keyword" placeholder="Search by book title, author" onkeyup="showHint(this.value)"  class="form-control" required autocomplete="off" value="<?php if (!isset($_GET['search_keyword'])) echo "";
										else echo $_GET['search_keyword'];
									?>">
								<span class="input-group-btn">
								<button class="btn btn-primary btn-md" type="submit">
								<i class="fa fa-search"></i> Search
								</button>
								</span>
								</div>
							</div>
							<div class="row" id="hints"></div>
						</form>
						</div>            
					</div>
				</div>
			</div>
			<div class="row">
	            <div class="col-md-9">
	            	<?php
	            		if (isset($_GET["search_keyword"])){
	    					$search_keyword = test_input($_GET["search_keyword"]);
	    					$query = "SELECT * FROM post WHERE user_id<> '0' and deleted=false AND post_name LIKE '%" . $search_keyword . "%'";
	                        $total_pages = mysqli_num_rows(mysqli_query($conn,$query));
	                        if ($total_pages == 0){
								echo "<hr><h4>Sorry, there isn't any book post matching your search.<br /> You can <a href='book_request'>post a request</a> for this book and we will notify you once we have it in handybooks.</h4>";
							}
							else{
							    echo '<div style="border-bottom:1px solid #EEEEEE; padding:10px;margin-top:20px;margin-bottom:20px;">'.$total_pages .' matches<span class="pull-right">Price <i class="fa fa-sort-amount-asc"></i>&nbsp;&nbsp; Date <i class="fa fa-sort-desc"></i></span></div>';
							    $targetpage = "search_books?search_keyword=".$search_keyword;
	                        	$limit = 5;
		                        if(isset($_GET['page'])){
		                            $page = $_GET['page'];
		                            $start = ($page - 1) * $limit;
		                        }   
		                        else{
		                            $page = 0;
		                            $start = 0;
		                        }
		    				$sql = "SELECT * FROM post WHERE user_id<> '0' and deleted=false AND post_name LIKE '%" . $search_keyword . "%' ORDER BY post_time DESC LIMIT $start, $limit";
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
	                                $price = "On sale for &nbsp;<i class='fa fa-inr'></i>' ".$posts["post_price"];
	                            }
	                            $time = $posts["post_time"];
	                            $time = strtotime($time);
	                            $time = " ".date("jS M", $time);
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
	                            $user_id = $posts["user_id"];
	                            $sql_user = "SELECT * FROM users WHERE user_id='$user_id'";
	                            $row_user = mysqli_query($conn,$sql_user);
	                            $extract_user=mysqli_fetch_assoc($row_user);
	                            $user_institution = $extract_user["institution"];
	                            $user_locality = $extract_user["city"];
	                            if($user_institution!=""){
	                                $institution= " ".$user_institution;
	                            }
	                            else{
	                                $institution= "";
	                            }
	                            if($user_locality!=""){
	                                $user_locality= " ".$user_locality;
	                            }
	                            else{
	                                $user_locality= "";
	                            }
	                            echo '<div class="col-md-10"><h4 style="text-transform:capitalize;"><a href='.$link.'>'.$posts['post_name']." ".$author.'</a><a href="'.$link.'"role="button" class="pull-right btn btn-xs btn-default"style="font-size: 14px;">See more</a></h4>';
	                            echo '<p><small ><span class="text-success">' . $price . '</span> &nbsp;<span class="pull-right"><i class="fa fa-clock-o"></i> '.$time.'</span><br><i class="fa fa-institution"></i> '.$institution.' &nbsp;&nbsp;<i class="fa fa-map-marker"></i> '.$user_locality.'</small></p>';

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
	                                if($tags!=""){
	                                	$tags = "<i class='fa fa-tags'></i> ".$tags;
	                                }
	                                //tags string creation ends here
	                                echo $tags;
	                                if($posts["post_description"]!=""){
	                                    echo "<p>Description: ".$posts['post_description']."</p>";
	                                }
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
	                                    echo '<li class="previous"><a href="'.$targetpage.'&page='.$prev.'">Newer</a></li>';
	                                }
	                                else{
	                                    echo '<li class="previous"><a role="button" class="btn btn-default "href="'.$targetpage.'&page='.$prev.'" disabled="disabled">Newer</a></li>';
	                                }
	                                if ($page < $lastpage){
	                                    echo '<li class="next"><a href="'.$targetpage.'&page='.$next.'">Older</a></li>';
	                                }
	                                else{
	                                    echo '<li class="next"><a href="'.$targetpage.'&page='.$next.'" role="button" class="btn btn-default"disabled="disabled">Older</a></li>';
	                                }
	                            }
	                            echo '</ul>';
	    				}
	    				}
	  					else{
	    					$search_keyword = "";
	    				}
	            	?>
	            </div>
	            <div class="col-md-3">
	            	<div class="row">
	            		<div id="Request_div" style="margin-left:20px;margin-top:20px;border:1px solid #EEEEEE;padding:20px;border-radius:5px;">
		            		<h4 class="text-success">Didn't Get the Book You Searched for?</h4>
		            		<p>You can <a href="book_request">Post a Request</a> for it.<br>We will deliver you the book at 50% of its MRP within 2-3 days.</p>
		            		<a role="button" class="btn btn-primary btn-lg cta_btns" href="book_request.php"><strong>Request for a Book &nbsp;</strong><i class="fa fa-shopping-cart"></i></a><br>
	            		</div>
	            	</div>
	            	
	            </div>
			</div>
		</div>
	</div>
	<?php
		include('footer.php');
	?>

	</body>
</html>