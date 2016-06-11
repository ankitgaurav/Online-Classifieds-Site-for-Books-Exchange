<?php
include 'files/config.php';

if (isset($_GET["p_id"]))
    {
    $post_id = test_input($_GET["p_id"]);
    if (isset($_SESSION["post_id"]))
        {
        unset($_SESSION["post_id"]);
        }
    }
  else
    {
    header('Location:home');
    }

$sql1 = "SELECT * FROM post WHERE post_id='$post_id'";
$row1 = mysqli_query($conn, $sql1);
$book_details = mysqli_fetch_assoc($row1);
$poster_id = $book_details['user_id'];
$sql2 = "SELECT * FROM users WHERE user_id='$poster_id'";
$row2 = mysqli_query($conn, $sql2);
$poster_details = mysqli_fetch_assoc($row2);
$poster_name = $poster_details["name"];
$poster_id = $poster_details["user_id"];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Handybooks: Book Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="jquery-1.11.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <style type="text/css">
    .display-none{
        display: none;
    }
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
        <a href="post_a_book" class="btn btn-primary navbar-btn navbar-left" style="margin-right:5px;">Sell a Book</a>
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
    <!-- Search Container -->
    <div class="container" id="main_content">
        <div class="row">
            <div class="col-md-9">
            <div class="row"><!--Book Info Dialog-->
            <div class="col-md-11 "><br />
                <h3>
                <?php
echo $book_details['post_name'];

if ($book_details['user_id'] == 1)
    {
    echo ' <a href="#" data-toggle="tooltip" title="Handybooks Verified Book" data-placement="right"><span class="text-primary fa-stack" style="font-size:14px;"><i class="fa fa-certificate fa-stack-2x"></i><i class="fa fa-check fa-stack-1x fa-inverse "></i></span></a>';
    }

if (isset($_SESSION['user_id']) && $book_details['user_id'] == $_SESSION['user_id'])
    {
    echo '<a type="button" class="btn btn-info pull-right" id="reply_btn" href="dashboard?to=transactions"><i class="fa fa-edit"></i> Manage</a>';
    }
  else
    {

    // echo '<button type="button" class="btn btn-warning pull-right" id="reply_btn"  data-toggle="modal" data-target="#reply_modal"> Reply to This Ad <i class="fa fa-reply"></i></button>';

    if ($book_details['user_id'] == 1)
        {
        echo '<button type="button" class="btn btn-success pull-right" id="confirm_btn"  data-toggle="modal" data-target="#order_modal"> Place an order <i class="fa fa-shopping-cart"></i></button>';
        }
      else
        {
        echo '<button type="button" class="btn btn-warning pull-right" id="reply_btn"  data-toggle="modal" data-target="#reply_modal"> Reply to This Ad <i class="fa fa-reply"></i></button>';
        }
    }

?>
                </h3><hr>
                <div class="row">
                    <div class="col-md-2">
                    <?php
if ($book_details["image_path"] != "") echo "<img src='" . $book_details["image_path"] . "' width='100px' height='100px'>";
  else echo "<i class='fa fa-book fa-5x'></i>";
?>
                    </div>
                    <div class="col-md-7">
                    <h4>Book Details</h4>
                    <?php

if ($book_details["post_category"] == "academic")
    {
    echo "Title: " . $book_details["post_name"] . "<br />Author/Publication: " . $book_details["post_author"] . "<br />Department: " . $book_details["post_department"] . "<br />Year :" . $book_details["post_year"] . "<br />Description :" . $book_details["post_description"];
    }
elseif ($book_details["post_category"] == "novel")
    {
    echo "Title: " . $book_details["post_name"] . "<br />Author: " . $book_details["post_author"] . "<br />Genre: " . $book_details["post_genre"] . "<br />Description :" . $book_details["post_description"];
    }
elseif ($book_details["post_category"] == "magazine")
    {
    echo "Title: " . $book_details["post_name"] . "<br />Genre: " . $book_details["post_genre"] . "<br />Issue: " . $book_details["post_issue"] . "<br />Description :" . $book_details["post_description"];
    }
  else
    {
    echo "Title: " . $book_details["post_name"] . "<br />Description: " . $book_details["post_description"];
    }

?>
                    </div>
                    <div class="col-md-3">
                        <?php

if ($book_details["post_type"] == "donate")
    {
    echo "<strong><span class='text-success pull-right'>Available for free</span></strong>";
    }
elseif ($book_details["post_type"] == "exchange")
    {
    echo "<span class='text-success pull-right'>Available on exchange.</span> <i class='fa fa-alert' class='exchange_info'></i>";
    }
  else
    {
    if ($book_details['user_id'] != 1)
        {
        echo "<span class='pull-right'>On sale for<br />&#x20b9;. " . $book_details['post_price'] . "</span>";
        }
      else
        {
        echo '<span class="pull-right text-success"><strong>On sale for 50% of MRP</strong></span>';
        }
    }

?>
                    </div>
                </div>
                <hr>
                <?php

if ($book_details['user_id'] != 1)
    {
    echo '<h4>Seller Details</h4>';
    if (($poster_details["name"]) != null)
        {
        echo "<i class='fa fa-user'></i> Posted by: " . $poster_name . "<br />";
        }
      else
        {
        echo "<i class='fa fa-user'></i> Posted by: Anonymous<br />";
        }

    if (($poster_details["institution"]) != null)
        {
        echo "<i class='fa fa-bank'></i> Institution: " . $poster_details["institution"] . "<br />";
        }

    if (($poster_details["city"]) != null)
        {
        echo "<i class='fa fa-map-marker'></i> Location: " . $poster_details["city"];
        }

    if (($poster_details["state"]) != null)
        {
        echo ", " . $poster_details["state"] . "<br />";
        }

    if (($poster_details["phone"]) != null)
        {
        echo "<br /><i class='fa fa-phone'></i> Phone: " . $poster_details["phone"] . "<br />";
        }

    echo '<br /><a href="#" onclick="report_post(' . $book_details["post_id"] . ')" role="button" id="report_btn" class="btn btn-default btn-sm"><i class="fa fa-ban"></i><strong> Report this post</strong></a>';
    }
  else
    {
    echo '<h4>Seller Details</h4>Sold by <i class="fa fa-user"></i>: Handybooks<br />Contact No <i class="fa fa-phone"></i>: +919874839107<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                              <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  Books Policy
                                </a>
                              </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                              <div class="panel-body">
                                We maintain a high standard for our books. Books are in most readable condition.<br />We do not sell torn or tampered books.
                              </div>
                            </div>
                          </div>
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                              <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  Delivery & Return Policy
                                </a>
                              </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                              <div class="panel-body">
                                The books will be delivered to the customers at their specified address( preferably their institutes). They are expected to be available when contacted through their given contact numbers.<br />The books will have to be cross-checked by the customer at the time of delivery. Request for return of books that are not in good condition will not be entertained.
                              </div>
                            </div>
                          </div>
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                              <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Pricing Policy
                                </a>
                              </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                              <div class="panel-body">
                                The books from handybooks are available at 50% of the printed MRP. We ensure that our customers are not overcharged or deceived.
                              </div>
                            </div>
                          </div>
                        </div>';
    }

?>
            <div id="report_success" style="display:inline-block"></div>
            </div>
            </div>
            </div>            
<!-- Book Info Dialog Ends Here -->
            
            <!-- Reply Modal Starts Here -->
            <div id="reply_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reply to Ad: <?php
echo $book_details['post_name']; ?></h4>
      </div>
      <div class="modal-body" id="modal-body">
        <form role="form" name="message_form">
            <div class="form-group"><label for="poster_name">To:</label>
            <input type="text" name="poster_name" class="input-md form-control" readonly value="<?php
echo $poster_name; ?>">
            </div>
            <div class="form-group">
            <input type="text" name="poster_id" style="display:none;" class="input-md form-control" readonly value="<?php
echo $poster_id; ?>">
            </div>
            <?php

if (!isset($_SESSION["email"]))
    {
    echo '<div class="form-group"><label for="msg">Your Email id:</label>
                    <input type="email" class="input-md form-control" name="buyer_email" autofocus>
                    </div>';
    echo '<div class="form-group"><label for="msg">Your Password:</label>
                    <input type="password" class="input-md form-control" name="buyer_password">
                    </div>';
    }
  else
    {
    echo '<div class="form-group"><input type="text" class="input-md form-control" name="buyer_email" style="display:none;" value=' . $_SESSION['user_id'] . ' readonly>
            </div>';
    echo '<div class="form-group"><input type="password" class="input-md form-control" name="buyer_password" style="display:none;" value=' . $_SESSION['user_id'] . ' readonly>
            </div>';
    }

?>
            <div class="form-group"><label for="msg">Your message:</label>
            <textarea class="form-control" rows=3 id="msg" name="msg" placeholder="I want to buy your book titled: &quot;<?php
echo $book_details["post_name"]; ?>&quot;. Reply when available."></textarea>
            </div>
            <a href="#" class="btn btn-primary pull-right" onclick="sendMessage()">Send <i class="fa fa-arrow-right"></i></a>
        </form>
      </div>
      <div class="modal-footer">        
      </div>
    </div>
  </div>
</div><!-- Reply Modal Ends Here -->
<!--order modal begins-->
 <div id="order_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm Order</h4>
      </div>
      <div class="modal-body" id="modal-body">        
            <?php

if (isset($_SESSION['user_id']))
    {
    echo '<div class="checkbox">
            <label><input type="checkbox" value="" onclick="showdiv()">By clicking you agree with our terms and conditions</label>
        </div>';
    $user_id = $_SESSION['user_id'];
    $sql10 = "SELECT * FROM users WHERE user_id='$user_id'";
    $result10 = mysqli_query($conn, $sql10);
    $row10 = mysqli_fetch_assoc($result10);
    $user_name = $row10['name'];
    $user_email = $row10['email'];
    $user_institution = $row10['institution'];
    echo '<div id="credentials" class="display-none"><form role="form" name="order_form">';
    echo "Please provide your correct information so that you may be contacted by our college representative";
    echo ' <div class="form-group"><label for="order_name">Name</label>
                        <input type="text" name="order_name" class="input-md form-control" value="' . $user_name . '">
                        </div>';
    echo ' <div class="form-group"><label for="order_email">Email</label>
                        <input type="email" name="order_email" class="input-md form-control"  value="' . $user_email . '">
                        </div>';
    /*echo ' <div class="form-group"><label for="order_institution">College</label>
    <input type="text" name="order_institution" class="input-md form-control" value="'.$user_institution.'">
    </div>';*/
    echo '<div class="form-group">
                                        <label for="order_institution">College</label>
                                        <input id="order_institution" list="institutions" name="order_institution" class="form-control" value="' . $user_institution . '">
                                        <datalist id="institutions">
                                            <option>Academy of Technology</option>
                                            <option>Acharyya Prafulla Chandra Ray Polytechnic</option>
                                            <option>Aryabhatta Institute of Engineering and Management</option>
                                            <option>Asansol Engineering College</option>
                                            <option>B.P. Poddar Institute of Management and Technology</option>
                                            <option>Bankura Unnayani Institute of Engineering</option>
                                            <option>Bengal College of Engineering and Technology</option>
                                            <option>Bengal Engineering College</option>
                                            <option>Bengal Institute of Technology</option>
                                            <option>Bengal Institute of Technology and Management</option>
                                            <option>Birbhum Institute of Engineering and Technology</option>
                                            <option>Birla Institute of Technology, Kolkata</option>
                                            <option>Calcutta Institute of Engineering and Management</option>
                                            <option>Calcutta Institute of Technology</option>
                                            <option>Camellia Institute of Technology</option>
                                            <option>Central Calcutta Polytechnic</option>
                                            <option>College of Engineering and Management</option>
                                            <option>Dr. B.C. Roy Engineering College</option>
                                            <option>Dream Institute of Technology</option>
                                            <option>Dumkal Institute of Engineering and Technology</option>
                                            <option>Durgapur Institute of Advanced Technology and Management</option>
                                            <option>Faculty of Agriculrtal Engineering Mohanpur, Bidhan Chandra Krishi ViswaVidyalaya</option>
                                            <option>Faculty of Technology, Uttar Banga Krishi Vishwavidyalaya</option>
                                            <option>Future Institute of Engineering and Management</option>
                                            <option>Government College of Engineering and Ceramic Technology</option>
                                            <option>Government College of Engineering and Leather Technology</option>
                                            <option>Government College of Engineering And Textile Technology</option>
                                            <option>Government College of Engineering and Textile Technology Serampore</option>
                                            <option>Gurunanak Institute of Technology</option>
                                            <option>Haldia Institute of Technology</option>
                                            <option>Heritage Institute of Technology</option>
                                            <option>Hooghly Engineering and Technology College</option>
                                            <option>IMPS College of Engineering and Technology</option>
                                            <option>Indian Institute of Technology, Kharagpur</option>
                                            <option>Institute of Engineering and Management</option>
                                            <option>Institute of Jute Technology</option>
                                            <option>Institute of Science and Technology</option>
                                            <option>Institute of Technology and Marine Engineering</option>
                                            <option>Jadavpur University</option>
                                            <option>Jalpaiguri Government Engineering College</option>
                                            <option>JIS College of Engineering</option>
                                            <option>Kalyani Government Engineering College</option>
                                            <option>M.B.C. Institute of Engineering &amp; Technology</option>
                                            <option>Mallabhum Institute of Technology</option>
                                            <option>Marine Enginnering and Research Institute</option>
                                            <option>MCKV Institute of Engineering</option>
                                            <option>Meghnad Saha Institute of Technology</option>
                                            <option>Murshidabad College of Engineering and Technology</option>
                                            <option>Narula Institute of Technology</option>
                                            <option>National Institute of Technical Teachers Training And Research</option>
                                            <option>National Institute of Technology</option>
                                            <option>National Power Training Institute</option>
                                            <option>Netaji Subhash Engineering College</option>
                                            <option>North Calcutta Polytechnic</option>
                                            <option>RCC Institute of Information Technology</option>
                                            <option>Sanaka Educational Trusts Group of Institutions</option>
                                            <option>Saroj Mohan Institute of Technology</option>
                                            <option>Seacom Engineering College</option>
                                            <option>Siliguri Institute of Technology</option>
                                            <option>St. Thomas College of Engineering and Technology</option>
                                            <option>Surendra Institute of Engineering And Management</option>
                                            <option>Techno India College of Technology</option>
                                            <option>University College of Science and Technology</option>
                                            <option>University Institute of Techonology</option>
                                            <option>University Instrumentation. Centre University of Kalyani Nadia,</option>
                                            <option>West Bengal University of Animal and Fishery</option>
                                            <option>West Bengal University of Technology</option>
                                        </datalist>
                                    </div>';
    echo ' <div class="form-group"><label for="order_phone">Mobile Number:</label>
                        <input type="text" name="order_phone" class="input-md form-control">
                        </div>';
    echo '<a href="#" class="btn btn-primary pull-right" onclick="confirm_order()">Send <i class="fa fa-arrow-right"></i></a>';
    }
  else
    {
    echo "You  need to <a href='login.php?from=book_details&p_id=" . $post_id . "'>login first</a>";
    }

?>
        </div>
      </div>
      <div class="modal-footer">        
      </div>
    </div>
  </div>
</div>
<!--order modal ends-->
            <div class="col-md-3">
                <div class="fb-page" data-href="https://www.facebook.com/handybooks.in" data-height="220" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/handybooks.in"><a href="https://www.facebook.com/handybooks.in">handybooks.in</a></blockquote></div></div>
            </div>
         </div></div>
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
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    function sendMessage(){
        if(message_form.buyer_email.value==""){
            alert("Please enter email id");
            return;
        }
        else{
            var buyer_email = message_form.buyer_email.value;
             var buyer_password = message_form.buyer_password.value;
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
            xmlhttp.open('POST', 'process_message_to_poster.php?buyer_email='+buyer_email+'&poster_id='+poster_id+'&msg='+msg+'&buyer_password='+buyer_password , true);
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
    function showdiv(){
        $("#credentials").toggleClass("display-none");
    }

    function confirm_order(){
        var user_name = order_form.order_name.value;
        var user_email = order_form.order_email.value;
        var user_institution = order_form.order_institution.value;
        var user_phone=order_form.order_phone.value;
        if(user_email=="" ||user_email=="" ||user_institution==""){
            alert("Please enter your details");
            return;
        }
        else{
            var poster_id = <?php
echo $_GET["p_id"]; ?>;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                    document.getElementById("credentials").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open('POST', 'confirm_order.php?buyer_email='+user_email+'&poster_id='+poster_id+'&poster_name='+user_name+'&poster_institution='+user_institution+'&poster_phone='+user_phone , true);
            xmlhttp.send();
        }
    }
</script>
    </body>
</html>