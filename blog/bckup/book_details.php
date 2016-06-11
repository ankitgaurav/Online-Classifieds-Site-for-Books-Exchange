<?php
include 'files/config.php';
    $post_id = test_input($_GET["p_id"]);
    $sql1 = "SELECT * FROM post WHERE post_id='$post_id'";
    $row1 = mysqli_query($conn,$sql1);
    $book_details = mysqli_fetch_assoc($row1);
    $poster_id = $book_details['user_id'];
    $sql2 = "SELECT * FROM users WHERE user_id='$poster_id'";
    $row2 = mysqli_query($conn,$sql2);
    $poster_details = mysqli_fetch_assoc($row2);
    $poster_name = $poster_details["name"];
    $poster_id = $poster_details["user_id"];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Index</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="jquery-1.11.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script>
        function sendMessage(){
            if(message_form.buyer_email.value==""){
                alert("Please enter email id");
                return;
            }
            else{
                var buyer_email = message_form.buyer_email.value;
                var poster_id = message_form.poster_id.value;
                var msg = message_form.msg.value;
                if(msg==""){
                    msg = message_form.msg.placeholder;
                }
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                        document.getElementById("modal-body").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('POST', 'process_message_to_poster.php?buyer_email='+buyer_email+'&poster_id='+poster_id+'&msg='+msg, true);
                xmlhttp.send();
            }
        }
        function report_post(reported_post_id){
            var reported_post_id = reported_post_id;
            var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                        document.getElementById("report_success").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET', 'process_report_post.php?reported_post_id='+reported_post_id, true);
                xmlhttp.send();
                $("#report_btn").addClass("disabled");
                $("#report_btn").html("Reported<i class='fa fa-tick'></i>");
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
    <!-- Search Container -->
    <div class="container">
        <div class="row">
            <div class="col-md-9">
            
            <div class="row"><!--Book Info Dialog-->
            <div class="col-md-11 "><br>
                <h3>
                <?php 
                    echo $book_details['post_name'];
                    if (isset($_SESSION['user_id']) && $book_details['user_id']==$_SESSION['user_id']){
                        echo '<a type="button" class="btn btn-info pull-right" id="reply_btn" href="dashboard?to=transactions"><i class="fa fa-edit"></i> Manage</a>';
                    }
                    else{
                        echo '<button type="button" class="btn btn-warning pull-right" id="reply_btn"  data-toggle="modal" data-target="#reply_modal"> Reply to This Ad <i class="fa fa-reply"></i></button>';
                    }
                ?>
                </h3><hr>
                <div class="row">
                    <div class="col-md-2">
                    <i class="fa fa-book fa-5x"></i>
                    </div>
                    <div class="col-md-7">
                    <h4>Book Details</h4>
                    <?php
                    
                    if($book_details["post_category"]=="academic"){
                        echo "Title: ".$book_details["post_name"].
                        "<br>Author/Publication: ".$book_details["post_author"].
                        "<br>Department: ".$book_details["post_department"].
                        "<br>Year :".$book_details["post_year"].
                        "<br>Description :".$book_details["post_description"];                      
                    }
                    elseif($book_details["post_category"]=="novel"){
                        echo "Title: ".$book_details["post_name"].
                        "<br>Author: ".$book_details["post_author"].
                        "<br>Genre: ".$book_details["post_genre"].
                        "<br>Description :".$book_details["post_description"];
                    }
                    elseif($book_details["post_category"]=="magazine"){
                        echo "Title: ".$book_details["post_name"].
                        "<br>Genre: ".$book_details["post_genre"].
                        "<br>Issue: ".$book_details["post_issue"].
                        "<br>Description :".$book_details["post_description"];
                    }
                    else{
                        echo "Title: ".$book_details["post_name"].
                        "<br>Description: ".$book_details["post_description"].
                        "<br>Price: Rs.".$book_details["post_price"];
                    }                  
                    ?>
                    </div>
                    <div class="col-md-3">
                        <?php 
                            if($book_details["post_type"]=="donate"){
                        echo "<strong><span class='text-success pull-right'>Available for free</span></strong>";
                        }
                        elseif ($book_details["post_type"]=="exchange") {
                        echo "<span class='text-success pull-right'>Available on exchange.</span> <i class='fa fa-alert' class='exchange_info'></i>";
                        }
                        else{
                        echo "<span class='pull-right'>Available on sale for<br>Rs. ".$book_details['post_price']."</span>";
                        }
                         ?>
                    </div>
                </div>
                <hr>
                <h4>Seller Details</h4>
                <?php
                    if(($poster_details["name"])!=null){
                        echo "<i class='fa fa-user'></i> Posted by: ".$poster_name."<br>";
                    }
                    else{
                        echo "<i class='fa fa-user'></i> Posted by: Anonymous<br>";
                    }
                    if(($poster_details["institution"])!=null){
                        echo "<i class='fa fa-bank'></i> Institution: ".$poster_details["institution"]."<br>";
                    }
                    if(($poster_details["city"])!=null){
                        echo "<i class='fa fa-map-marker'></i> Location: ".$poster_details["city"];
                    }
                    if(($poster_details["state"])!=null){
                        echo ", ".$poster_details["state"]."<br>";
                    }
                    echo '<br><a href="#" onclick="report_post('.$book_details["post_id"].')" role="button" id="report_btn" class="btn btn-default btn-sm"><i class="fa fa-ban"></i><strong> Report this post</strong></a>';

                ?>
            <div id="report_success" style="display:inline-block"></div>
            </div>
            </div><!-- Book Info Dialog Ends Here -->
            <!-- Reply Modal Starts Here -->
            <div id="reply_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reply to Ad: <?php echo $book_details['post_name']; ?></h4>
      </div>
      <div class="modal-body" id="modal-body">
        <form role="form" name="message_form">
            <div class="form-group"><label for="poster_name">To:</label>
            <input type="text" name="poster_name" class="input-md form-control" readonly value="<?php echo $poster_name;?>">
            </div>
            <div class="form-group">
            <input type="text" name="poster_id" style="display:none;" class="input-md form-control" readonly value="<?php echo $poster_id;?>">
            </div>
            <?php
                if(!isset($_SESSION["email"])){
                    echo '<div class="form-group"><label for="msg">Your Email id:</label>
            		<input type="email" class="input-md form-control" name="buyer_email" autofocus>
            		</div>';
            		echo '<div class="form-group"><label for="msg">Your Password:</label>
            		<input type="password" class="input-md form-control" name="buyer_password">
            		</div>';
                }
                else{
                    echo '<div class="form-group"><input type="text" class="input-md form-control" name="buyer_email" style="display:none;" value='.$_SESSION['user_id'].' readonly>
            </div>';
            echo '<div class="form-group"><input type="password" class="input-md form-control" name="buyer_password" style="display:none;" value='.$_SESSION['user_id'].' readonly>
            </div>';
                }

            ?>
            <div class="form-group"><label for="msg">Your message:</label>
            <textarea class="form-control" rows=3 id="msg" name="msg" placeholder="I want to buy your book titled: &quot;<?php echo $book_details["post_name"];?>&quot;. Reply when available."></textarea>
            </div>
            <a href="#" class="btn btn-primary pull-right" onclick="sendMessage()">Send <i class="fa fa-arrow-right"></i></a>
        </form>
      </div>
      <div class="modal-footer">        
      </div>
    </div>
  </div>
</div><!-- Reply Modal Ends Here -->
            </div>
            </div>
            
        </div>
        <div id="footer" style="margin-bottom:0px;margin-top:200px;">
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
                        <a href="https://www.facebook.com/handybooks"><i class="fa fa-1x fa-facebook"></i>
                    </li>
                </ul> 
                
            
            </div>
        </div>
    </body>
</html>