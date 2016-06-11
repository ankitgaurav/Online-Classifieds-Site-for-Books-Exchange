<?php
include 'files/config.php';
  //checking if form has been submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //initialize and sanitize input variables here
    $user_id = test_input($_POST["u_id"]);
    $b_category = test_input($_POST["b_category"]);
    $b_title = test_input($_POST["b_title"]);
    $m_title = test_input($_POST["m_title"]);
    $n_title = test_input($_POST["n_title"]);
    $b_author = test_input($_POST["b_author"]);
    $n_author = test_input($_POST["n_author"]);
    $b_year = test_input($_POST["b_year"]);
    $b_department = test_input($_POST["b_department"]);
    $b_description = ($_POST["b_description"]);
    $n_genre = test_input($_POST["n_genre"]);
    $m_genre = test_input($_POST["m_genre"]);
    $b_price = test_input($_POST["b_price"]);
    $b_issue = test_input($_POST["b_issue"]);
    $b_class = test_input($_POST["b_class"]);
    $b_subject = test_input($_POST["b_subject"]);
    $optradio = test_input($_POST["optradio"]);
    if($b_title!="" or $m_title!="" or $n_title!=""){

    if($b_title!=""){
      $b_title = $b_title;
    }
    elseif ($m_title!="") {
      $b_title = $m_title;
    }
    elseif ($n_title!="") {
      $b_title = $n_title;
    }
    if($b_author!=""){
      $b_author = $b_author;
    }
    elseif ($n_author!="") {
      $b_author = $n_author;
    }
    if($n_genre!=""){
      $b_genre = $n_genre;
    }
    elseif ($m_genre!="") {
      $b_genre = $m_genre;
    }
    //data insert here
    $sql = "INSERT INTO post (user_id, post_category, post_name, post_author, post_year, post_department, post_description, post_genre, post_price, post_issue, post_class, post_subject, post_type) VALUES ('$user_id', '$b_category', '$b_title', '$b_author', '$b_year', '$b_department', '$b_description', '$b_genre', '$b_price', '$b_issue', '$b_class', '$b_subject', '$optradio')";
    if($conn->query($sql)=== TRUE){
                    $form = false;
                    $last_post_id = $conn->insert_id;
                    $_SESSION["last_post_id"]=$last_post_id;
                    // header('Location:dashboard?to=transactions&b_id='.$last_post_id);
                    header('Location:confirm_seller');
                }
                else 
                {
                    $form = true;
                    echo "Something went wrong. Data could not be inserted properly" . $conn->error;
                }
    }
    else{
      $msg = "You can't post an ad of a book without a name.";
      $form = true;
    } 
  }
  else{
    $msg = null;
    $form = true;
  } 
// }
if($form == true){
?>
<!DOCTYPE html>
<html>
  <head>
  <title>Handybooks: A place to buy and sell used books easily</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="styles/default_lp.css">
  <style type="text/css">
      .tagline{
      font-family: 'Open Sans', sans-serif;
      }
  </style>
  <script src="jquery-1.11.2.min.js"></script>
  <script src="bootstrap.min.js"></script>
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
if(isset($_SESSION["user_id"])){ 
$one=1;
$user_id=$_SESSION["user_id"];
//code for unread messages
$sql190 = "SELECT * FROM chats WHERE (to_user='$user_id' and displayble='$one' and to_user_read=0) ";
$result190 = mysqli_query($conn,$sql190) or mysqli_error($conn);
$_SESSION['no_of_unread_msg']= mysqli_num_rows($result190);
$no_of_msg=$_SESSION['no_of_unread_msg'];
//end of code for unread messages




echo '
        <li><a href="home"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="messages"><i class="fa fa-comments"></i> Messages';
             if ($no_of_msg) {
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
        </li>'
        ;}
        else{
          echo '<li><a href="home"><i class="fa fa-home"></i> Home</a></li>';
        }
        ?>
        </ul>
    </div>
      </div>
      </nav>
          <div class="container">
              <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
          <div class="panel panel-default">
        <div class="panel-heading"><h3 class="tagline"><strong><center>Post Ad for Your Book</center></strong></h3></div>
        <div class="panel-body">
            <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
<!--show message here-->
<?php
if($msg!=null){
echo "<div class='error_msg alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>
$msg</div>";
            }
?>
<!-- End of message-->
<!-- <div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <button type="button" onclick="one()" class="btn btn-default active">Textbook</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" onclick="two()" class="btn btn-default">Novel</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" onclick="three()" class="btn btn-default">Magazine</button>
  </div>
</div>-->
<form role="form" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="post"><br>
  <ul class="nav nav-pills nav-justified">
    <li class="active" onclick="set_b_category('Academic')"><a data-toggle="pill" href="#Book"><strong>Academic</strong>&nbsp;<i class="fa fa-leanpub"></i></a></li>
    <li onclick="set_b_category('Novel')"><a data-toggle="pill" href="#Novel"><strong>Novel</strong>&nbsp;<i class="fa fa-book"></i></a></li>
    <li onclick="set_b_category('Magazine')"><a data-toggle="pill" href="#Magazine"><strong>Magazine</strong>&nbsp;<i class="fa fa-newspaper-o"></i></a></li>
  </ul>
  <input type="text" id="b_category" name="b_category" style="display:none;" value="Academic">
  <div class="tab-content"><br>      
<!--   Academic section starts here-->    
<div id="Book" class="tab-pane fade in active">
    <div class="row form-group">
      <div class="col-sm-6"><label for="book_title">Title</label>
      <input id="book_title" class="input-md form-control" type="text" name="b_title">
      </div>
      <div class="col-sm-6"><label for="book_author">Author</label>
      <input id="book_author" class="input-md form-control" type="text"  name="b_author">
      </div>
    </div> 
    <div class="form-group"><!-- <label for="level_of_education">Level of Eductaion</label> -->
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#college">College&nbsp;</strong></a></li>
          <li><a data-toggle="tab" href="#school">School&nbsp;</strong></a></li>
          <li><a data-toggle="tab" href="#other">Other&nbsp;</strong></a></li>
        </ul>
    </div>
      <div class="tab-content">
        <div id="college" class="tab-pane fade in active">
            <div class="row">
              <div class="col-sm-6">
                <label for="book_year">Year</label>
                <select class="form-control" id="book_year" name="b_year">
                  <option></option>
                  <option>First Year</option>
                  <option>Second Year</option>
                  <option>Third Year</option>
                  <option>Fourth Year</option>
                    <option>Fifth Year</option>
                </select>
              </div>        
              <div class="col-sm-6"><label for="book_department">Department</label>
                            <input class="input-md col-md-4 form-control" list="b_departments" type="text"  name="b_department" >
              <datalist id="b_departments">
                  <option>Any Branch</option>
                  <option>Architecture & Design</option>
                  <option>Arts & Humanities</option>
                  <option>Banking, Finance & Commerce</option>
                  <option>Business & Professional</option>
                  <option>Computers & IT Training</option>
                  <option>Engineering</option>
                  <option>Engineering</option>
                  <option>Computer Scinece Engineering</option><option>Electrical Engineering</option><option>Electronics and Communication Engineering</option><option>Information Technology Engineering</option><option>Automobile Engineering</option><option>Civil Engineering</option><option>Mechanical Engineering</option>
                  <option>Environment Science & Technology</option>
                  <option>Fine Arts & Crafts</option>
                  <option>Health, Wellness & Fitness</option>
                  <option>Law</option>
                  <option>Management</option>
                  <option>Media & Mass Communication</option>
                  <option>Medical</option>
                  <option>Performing Arts</option>
                  <option>Public Administration</option>
                  <option>Science</option>
                  <option>Social Science</option>
                  <option>Social Work</option>
                  <option>Teacher Education & Teacher Training</option>
                  <option>Transportation</option>
                  <option>Travel & Tourism</option>
              </datalist>
              </div>
            </div>
        </div>
        <div id="school" class="tab-pane fade in">
          <div class="row">
            <div class="col-sm-6">
              <label for="book_class">Class</label>
              <select class="form-control" id="book_class" name="b_class">
                <option></option>
                <option>Nursery/ Prep</option>
                <option>One</option>
                <option>Two</option>
                <option>Three</option>
                <option>Four</option>
                <option>Five</option>
                <option>Six</option>
                <option>Seven</option>
                <option>Eight</option>
                <option>Nine</option>
                <option>Ten</option>
                <option>Eleven</option>
                <option>Twelve</option>
              </select>
            </div>        
            <div class="col-sm-6"><label for="book_subject">Subject</label>
                        <input class="input-md col-md-4 form-control" type="text"  name="b_subject" >
            </div>
          </div>
        </div>
        <div id="other" class="tab-pane fade in"></div>
      </div>
</div><!--academic section ends-->
<!--       novel section starts
 -->
<div id="Novel" class="tab-pane fade">
          <div class="form-group"><label for="novel_title">Title</label>
      <input id="novel_title" class="input-md col-md-4 form-control" type="text" name="n_title" >
        </div>
        <div class="row form-group">
        <div class="col-sm-6"><label for="novel_author">Author</label>
                      <input id="novel_author" class="input-md form-control" type="text"  name="n_author" >
        </div>
          <div class="col-sm-6"><label for="novel_genre">Genre</label>
<select class="form-control" id="sel1" name="n_genre">
      <option></option>
      <option>Art</option>
      <option>Biography</option>
      <option>Children</option>
      <option>Classics</option>
      <option>Comics</option>
      <option>Cookbooks</option>
      <option>Fantasy</option>
      <option>Fiction</option>
      <option>History</option>
      <option>Humor And Comedy</option>
      <option>Music</option>
      <option>Non Fiction</option>
      <option>Philosophy</option>
      <option>Poetry</option>
      <option>Psychology</option>
      <option>Religious</option>
      <option>Romance</option>
      <option>Science</option>
      <option>Self Help</option>
      <option>Sports</option>
      <option>Travel</option>
    </select>

      </div>
      </div><!--div end for id novel-->
      </div>
<!-- novel section ends
 -->
<!--  magazine section starts
 -->      <div id="Magazine" class="tab-pane fade">
      <div class="form-group "><label for="mag_title">Title</label>
      <input id= "mag_title" class="input-md col-md-4 form-control" type="text"  name="m_title" >
        </div>
        <div class="row form-group">
          <div class="col-sm-6"><label for="sel3">Issue</label>
    <select class="form-control" id="sel3" name="b_issue">
      <option></option>
      <option>Jan</option>
      <option>Feb</option>
      <option>March</option>
      <option>April</option>
        <option>May</option>
      <option>June</option>
      <option>July</option>
        <option>August</option>
      <option>September</option>
      <option>October</option>
      <option>November</option>
        <option>December</option>
    </select>
  </div>
          <div class="col-sm-6"><label for="sel1">Genre</label>
    <select class="form-control" id="sel1" name="m_genre">
      <option></option>
      <option>Art</option>
      <option>Biography</option>
      <option>Childrens</option>
      <option>Womens</option>      
      <option>Men</option>
      <option>Classics</option>
      <option>Comics</option>
      <option>Cookbooks</option>
      <option>Fantasy</option>
      <option>Fiction</option>
      <option>History</option>
      <option>Humor And Comedy</option>
      <option>Music</option>
      <option>Non&nbsp;Fiction</option>
      <option>Philosophy</option>
      <option>Poetry</option>
      <option>Psychology</option>
      <option>Religious</option>
      <option>Romance</option>
      <option>Science</option>
      <option>Self Help</option>
      <option>Sports</option>
      <option>Travel</option>
    </select>
    </div>
    </div>       
    </div><!--div end for magazine-->
  </div><!--Ending tab content div-->
    <div class="form-group">
      <label for="comment">Description</label>
      <textarea class="form-control" rows="2" id="comment" name="b_description"></textarea>
    </div>
    <div class="row form-group">
    <div class="col-md-4">
    <label class="radio-inline"><input type="radio" name="optradio" value="Exchange">Exchange</label>
    </div>
    <div class="col-md-4"> 
    <label class="radio-inline"><input type="radio" name="optradio" value="Donate">Donate</label>
    </div>                      
    <div class="col-md-4"><div class="input-group"><span class="input-group-addon">
    <input type="radio" name="optradio" value="Sell" checked> Sell &#x20b9;</span>
    <input type="number" min="0" max="2000" step="10" class="form-control" name="b_price">
    </div>
    </div></div>
      <div class="form-group">
      <?php
        if(isset($_SESSION['user_id'])){
          echo '<input id="u_id" style="display:none;" class="input-md col-md-4 form-control" type="text"  name="u_id" value='.$_SESSION["user_id"].'>';
}
else{
  echo '<input id="u_id" style="display:none;" class="input-md col-md-4 form-control" type="text"  name="u_id" value="0">';
}
?>
      </div>
      <div class="centered">
                  <button type="submit" class="btn btn-primary form-control" value="Login">Proceed&nbsp;<i class="fa fa-arrow-right"></i></button>
      </div><br>
              </form>
            </div>
            </div>
               </div>
      </div>              
          </div>
          </div>              
              </div>
              <div id="footer">
 		<div id="footer-main" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
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
                        <a href="https://www.facebook.com/handybooks"><i class="fa fa-facebook-original"></i>
                    </li>
                </ul> 
                
            
            </div>
        </div>
<script type="text/javascript">
var val;
  function set_b_category(val){
    document.getElementById("b_category").value = val;
  }
</script>

  </body>
</html>
<?php
   }
?>