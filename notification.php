<?php
include 'files/config.php';
	if(!isset($_SESSION["user_id"])) {
		header('Location:login.php?from=messages&msg=notloggedin');
	} 
	else {

		$one=1;
$user_id=$_SESSION["user_id"];
//code for unread messages
$sql190 = "SELECT * FROM chats WHERE (to_user='$user_id' and displayble='$one' and to_user_read=0) ";
$result190 = mysqli_query($conn,$sql190) or mysqli_error($conn);
$_SESSION['no_of_unread_msg']= mysqli_num_rows($result190);
$no_of_msg=$_SESSION['no_of_unread_msg'];
//end of code for unread messages
//code for unread notifications
$sql290 = "SELECT * FROM notification WHERE (user_id='$user_id' and read_yes=0) ";
$result290 = mysqli_query($conn,$sql290) or mysqli_error($conn);
$_SESSION['no_of_notifications']= mysqli_num_rows($result290);
$no_of_notifications=$_SESSION['no_of_notifications'];
//end of code for unread notifications
?>
<!DOCTYPE html>
<html>
<head>
	<title>Handybooks: Notification</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" type="text/css" href="notification.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="jquery-1.11.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
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
	            <form class="navbar-form navbar-left" role="search" action="search_results" method="GET">
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
	        		<a href="post_a_book" class="btn btn-primary navbar-btn navbar-left" style="margin-right:5px;">Sell a Book</a>
	                <li><a href="messages"><i class="fa fa-comments"></i> Messages <?php if ($no_of_msg) {
          echo "<span class='badge'>".$no_of_msg."</span>";
          			}?>
          			</a></li>
		        	<li><a href="notification.php"><i class="fa fa-bell"></i> Notifications <?php if ($no_of_notifications) {
          echo "<span class='badge'>".$no_of_notifications."</span>";
          			}?></a></li>
		        	<li class="dropdown">
		          		<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i><?php echo $_SESSION["name"];?><span class="caret"></span></a>
		          		<ul class="dropdown-menu">
		            		<li><a href="dashboard">Profile</a></li>
		            		<li><a href="dashboard?to=transactions">Transactions</a></li>
		            		<li><a href="dashboard?to=book_requests">Book Requests</a></li>
		            		<li role="separator" class="divider"></li>
		            		<li><a href="auth.php">Logout</a></li>
		          		</ul>
		        	</li>
	        	</ul>
	    	</div>
	    </div>
    </nav>
   <div class="container" id="main_content">
   	<div class="row">
   		<div class="col-md-3">
   			<ul>
   				<li>
   					<strong>All Notifications</strong>
   				</li>
   				<li>
   					All
            <hr>
   				</li>
   			</ul>
   			<ul>
   				<li>
   					<strong>Filter</strong>
            <hr>
   				</li>
   				<li>
   					<a href="#" value= "book_request" onclick="loadnotifications('book_request')">Book requests</a>	
   				</li>
   				<li>
   					<a href="#" value= "orders" onclick="loadnotifications('orders')">Your orders</a>	

   				</li>
   				<li>
   					<a href="#" value= "admin" onclick="loadnotifications('admin')">Admin</a>	
   				</li>
   			</ul>
   		</div>
   		<h3>My Notifications</h3>
   		<hr style="height:1px;">
   		<div class="col-md-9" id="notification_block">
   			<?php
   				$user_id=$_SESSION['user_id'];
   				$query="SELECT * FROM notification WHERE user_id='$user_id'";
   				$result=mysqli_query($conn,$query);
   				while($row=mysqli_fetch_assoc($result)){
   				$notification=$row['notification'];
   				$time = $row["time"];
				$time = strtotime($time);
				$time = date("d M h:i a", $time);
   				if ($row['tag']=="book_request") {
   					echo '
   					<div class="row notification_container">
   						<div class="col-md-1 col-icons">
   							<span class="icons"><i class="fa fa-comments-o fa-2x"></i></span>
   						</div>
   						<div class="col-md-11 col-content">
   							<h4><strong>You recieved a book request</strong></h4>
   							<p>
   								'.$notification.' <a href="messages.php">messages</a><br>
   								<span class="display_time"><i class="fa fa-clock-o"></i>'.$time.'</span>
   							</p>
   						</div>
   					</div>

   					';
   				}
   				else if($row['tag']=="order")
   				{
   					echo '
   					<div class="row notification_container">
   						<div class="col-md-1 col-icons">
   							<span class="icons"><i class="fa fa-comments-o fa-2x"></i></span>
   						</div>
   						<div class="col-md-11 col-content">
   							<h4><strong>You recieved a book request</strong></h4>
   							<p>
   								'.$notification.' <a href="messages.php">messages</a><br>
   								<span class="display_time"><i class="fa fa-clock-o"></i>'.$time.'</span>
   							</p>
   						</div>
   					</div>

   					';
   				}
   				else
   				{

   				}
        }
   			?>
   		</div>
   	</div>
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
        <script type="text/javascript">
        var val;
        function loadnotifications(val){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("notification_block").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "loadnotification.php?tag="+val, true);
        xmlhttp.send();
        }
        </script>
</body>
</html>
<?php
//code to update notifications
$sql390="UPDATE notification SET read_yes=1 WHERE (user_id='$user_id' and read_yes=0)";
$result390=mysqli_query($conn,$sql390);
//end of code to update notifications
}
?>