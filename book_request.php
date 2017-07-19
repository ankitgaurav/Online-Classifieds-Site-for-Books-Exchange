<?php
include ('files/config.php');
  $msg = null;
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST["description"]!="" and $_POST["institution"]!="" and $_POST["email"]!="" and $_POST["phone"]!=""){
      // $user_id = $_SESSION["user_id"];
      if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION["user_id"];
      }
      else{
        $user_id = 0;
      }
      // $request_title = test_input($_POST["title"]);
      $request_description = test_input($_POST["description"]);
      $request_institution = test_input($_POST["institution"]);
      $email = test_input($_POST["email"]);
      $institution = test_input($_POST["institution"]);
      $phone = test_input($_POST["phone"]);

      $sql = "INSERT INTO requests(user_id, req_description, req_email, req_institute, req_phone) VALUES('$user_id', '$request_description', '$email', '$institution', '$phone')";
      if($result = mysqli_query($conn, $sql)){
        $form = true;
        $to = "ankitgaurav@outlook.com";
        $subject = "Book request from Handybooks";
        $message = $email." from ".$institution." has requested for a book: ".$request_description;
        $header = "From:support@handybooks.in \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        $retval = mail ($to,$subject,$message,$header);
        $to = $email;
        $subject = "Book Request Confirmation";
        $message = "<strong>Hello user.</strong><hr>Your request for the book: ".$request_description." has been accepted and will be processed soon. <br>";
        $msg = "Thanks. Your request has been accepted.<br>A confirmation mail has been sent to your email-id for your request.";
        $retval = mail ($to,$subject,$message,$header);
      }
      else{
        $form = true;
        $msg = "Sorry, your request could not be processed.<br> Please try again in a bit.";
      }

    }
    else{
      $msg = "Please fill all the fields.<br>";
      $form = true;
    }
  }
  else{
    $form = true;
  }
// }
if($form==true){
?>
<!DOCTYPE html>
<html>
<head>
  <title>Handybooks:Book Request</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="styles/default_lp.css">
  <link rel="stylesheet" type="text/css" href="footer.css">

</head>
<body>
  <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
            <a href="home" onmouseover = "document.getElementById('in').style.visibility='visible'" onmouseout = "document.getElementById('in').style.visibility='hidden'" class="logo_text"><strong>handybooks</strong><small id="in" style="visibility:hidden;">.in</small></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <?php
              //code for unread messages
              if (isset($_SESSION['no_of_unread_msg']) && $_SESSION['no_of_unread_msg']!=0)
              {
                $no_of_msg= $_SESSION['no_of_unread_msg'];
              }
              else {
                $no_of_msg=0;
              };
              //end of code for unread messages
              if(isset($_SESSION["user_id"]))
              {
                echo '
                <li><a href="home"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="messages"><i class="fa fa-comments"></i> Messages';
                if ($no_of_msg)
                {
                        echo "<span class='badge'>".$no_of_msg."</span>";
                };
                echo '</a></li>
                  <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> '.$_SESSION["name"].'
                  <span class="caret"></span></a>
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
                echo '<li><a href="home"><i class="fa fa-home"></i> Home</a></li>';
              }
            ?>
          </ul>
        </div>
      </div>
  </nav>
  <div class="container wrapper">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="jumbotron" style="border:1px solid black">
        <!--show message here-->
<?php
if($msg!=null){
echo "<div class='error_msg alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>
$msg</div>";
            }
?>
<!-- End of message-->
        <h2 class="text-danger">Request a Book <i class="fa fa-shopping-cart"></i></h2>
        <hr>
        <h4>Fill in the details of the book you want and we will fetch the book in 2-3 business days.</h4>
          <div>
            <div>
              <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <!-- <div class="form-group">
                  <label for="title" class="col-sm-3 control-label">Request for:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title/s of book/s you want" required>
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="description" class="col-sm-3 control-label"><i class="fa fa-book"></i> Book/s Details</label>
                  <div class="col-sm-9">
                   <textarea class="form-control"  id="description" name="description" placeholder="Enter few details of your book/s like name, subject, author, publication, year etc." title="Enter details:
                   Year & Department
                   Subject
                   Author
                   Edition etc."required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="College" class="col-sm-3 control-label"><i class="fa fa-institution"></i> College</label>
                  <div class="col-sm-9">
                   <input id="institution" list="institutions" name="institution" class="form-control" placeholder="Select Your Institute" required>
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
                        <option >Faculty of Technology, Uttar Banga Krishi Vishwavidyalaya</option>
                        <option>Future Institute of Engineering and Management</option>
                        <option >Government College of Engineering and Ceramic Technology</option>
                        <option>Government College of Engineering and Leather Technology</option>
                        <option >Government College of Engineering And Textile Technology</option>
                        <option >Government College of Engineering and Textile Technology Serampore</option>
                        <option >Gurunanak Institute of Technology</option>
                        <option >Haldia Institute of Technology</option>
                        <option >Heritage Institute of Technology</option>
                        <option >Hooghly Engineering and Technology College</option>
                        <option >IMPS College of Engineering and Technology</option>
                        <option >Indian Institute of Technology, Kharagpur</option>
                        <option >Institute of Engineering and Management</option>
                        <option >Institute of Jute Technology</option>
                        <option >Institute of Science and Technology</option>
                        <option>Institute of Technology and Marine Engineering</option>
                        <option>Jadavpur University</option>
                        <option>Jalpaiguri Government Engineering College</option>
                        <option>JIS College of Engineering</option>
                        <option >Kalyani Government Engineering College</option>
                        <option >M.B.C. Institute of Engineering &amp; Technology</option>
                        <option >Mallabhum Institute of Technology</option>
                        <option >Marine Enginnering and Research Institute</option>
                        <option >MCKV Institute of Engineering</option>
                        <option >Meghnad Saha Institute of Technology</option>
                        <option >Murshidabad College of Engineering and Technology</option>
                        <option >Narula Institute of Technology</option>
                        <option>National Institute of Technical Teachers Training And Research</option>
                        <option >National Institute of Technology</option>
                        <option>National Power Training Institute</option>
                        <option >Netaji Subhash Engineering College</option>
                        <option >North Calcutta Polytechnic</option>
                        <option>RCC Institute of Information Technology</option>
                        <option >Sanaka Educational Trusts Group of Institutions</option>
                        <option >Saroj Mohan Institute of Technology</option>
                        <option >Seacom Engineering College</option>
                        <option >Siliguri Institute of Technology</option>
                        <option >St. Thomas College of Engineering and Technology</option>
                        <option >Surendra Institute of Engineering And Management</option>
                        <option>Techno India College of Technology</option>
                        <option>University College of Science and Technology</option>
                        <option >University Institute of Techonology</option>
                        <option >University Instrumentation. Centre University of Kalyani Nadia,</option>
                        <option >West Bengal University of Animal and Fishery</option>
                        <option >West Bengal University of Technology</option>
                    </datalist>
                  </div>
                </div>
                <?php
                if(!isset($_SESSION["user_id"])){
                  echo '<div class="form-group">
                  <label for="email" class="col-sm-3 control-label"><i class="fa fa-envelope"></i> Email id</label>
                  <div class="col-sm-9">
                   <input type="email" class="form-control" id="email" name="email" placeholder="Your Email">
                  </div>
                </div>';
                }
                ?>

                <div class="form-group">
                  <label for="Phone" class="col-sm-3 control-label"><i class="fa fa-2x fa-mobile"></i> Phone Number</label>
                  <div class="col-sm-9">
                   <input type="tel" class="form-control" id="phone" name="phone" placeholder="Your contact number" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Submit-btn" class="col-sm-3 control-label" style="visibility:hidden;">Submit-btn</label>
                  <div class="col-sm-9">
                   <input type="submit" role="button" class="btn btn-primary  form-control" id="Submit-btn" name="Submit-btn" value="Submit your Order">
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="push"></div>
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
<script src="jquery-1.11.2.min.js"></script>
<script src="bootstrap.min.js"></script>
</body>
</html>
<?php
}
?>
