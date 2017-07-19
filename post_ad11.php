<?php
include('files/config.php');
if(!isset($_SESSION["user_id"])){
    header("Location:confirm_seller");
}
else{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $form = true;
      if(isset($_POST['academic_form'])){
        $user_id = $_SESSION["user_id"];
        $post_category = test_input($_POST["post_a_category"]);
        $post_name = test_input($_POST["post_a_name"]);
        $post_author = test_input($_POST["post_a_author"]);
        $post_year = test_input($_POST["post_a_year"]);
        $post_department = test_input($_POST["post_a_department"]);
        $post_description = test_input($_POST["post_a_description"]);
        $post_price = test_input($_POST["post_a_price"]);
        $target_dir = "images/post_images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        }
        else if($_FILES["fileToUpload"]["size"] > 500000) {
          echo "Sorry, your image is too large.";
          $uploadOk = 0;
        }
        else {
          echo "File is not an image.";
          $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          $msg = "Sorry, there was an error uploading your file.";
          $form = true;
        }
        else {
          $form = false;
          $sql = "INSERT INTO post (user_id, post_category, post_name, post_author, post_year, post_department, post_description, post_price, image_path, image_upload) VALUES ('$user_id', '$post_category', '$post_name', '$post_author', '$post_year', '$post_department', '$post_description', '$post_price', '$target_file', 1)";
          if($result = mysqli_query($conn,$sql)){
            $last_post_id = $conn->insert_id;
            $_SESSION["last_post_id"]=$last_post_id;
            header('Location:dashboard?to=transactions');
          }
          else{
            $msg = "Sorry, your ad could not be posted successfully.<br>Please try again.";
            echo "Error error".$conn->error;
            $form = true;
          }
        }
      }
      else{//non-academic form process
        $user_id = $_SESSION["user_id"];
        $post_category = test_input($_POST["post_na_category"]);
        $post_name = test_input($_POST["post_na_name"]);
        $post_author = test_input($_POST["post_na_author"]);
        $post_genre = test_input($_POST["post_na_genre"]);
        $post_description = test_input($_POST["post_na_description"]);
        $post_price = test_input($_POST["post_na_price"]);
        $target_dir = "images/post_images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload_na"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["fileToUpload_na"]["tmp_name"]);
        if($check !== false) {
          echo "Yaha se File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } else {
          echo "File is not an image.";
          $uploadOk = 0;
        }
        if ($_FILES["fileToUpload_na"]["size"] > 500000) {
            echo "Sorry, your image is too large.";
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
        }
        if (!move_uploaded_file($_FILES["fileToUpload_na"]["tmp_name"], $target_file)) {
          $msg = "Sorry, there was an error uploading your file.";
          $form = true;
        }
        else {
          $form = false;
          $sql = "INSERT INTO post (user_id, post_category, post_name, post_author,post_genre, post_description, post_price, image_upload, image_path) VALUES ('$user_id', '$post_category', '$post_name', '$post_author', '$post_genre', '$post_description', '$post_price', 1, '$target_file')";
          if($result = mysqli_query($conn,$sql)){
            $last_post_id = $conn->insert_id;
            $_SESSION["last_post_id"]=$last_post_id;
            header('Location:dashboard?to=transactions');
          }
          else{
            $msg = "Sorry, your ad could not be posted successfully.<br>Please try again.";
            $form = true;
          }
        }
      }
    }
    else{
      $form = true;
    }
}
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
  <link rel="stylesheet" type="text/css" href="footer.css">

  <style type="text/css">
    label{
      font-weight: 100;
    }
      .tagline{
      font-family: 'Open Sans', sans-serif;
      }
    .form-group{
      margin-top: 20px;
    }
    #tab_content2{
      margin-top: 20px;
    }
  </style>
  <script src="jquery-1.11.2.min.js"></script>
  <script src="bootstrap.min.js"></script>
  <script>
  var loadFile = function(event) {
    document.getElementById('img_prev_a').innerHTML = "Image Preview";
    var output = document.getElementById('output_a');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
  var loadFile_na = function(event) {
    document.getElementById('img_prev_na').innerHTML = "Image Preview";
    var output = document.getElementById('output_na');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
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
      if($result190 = mysqli_query($conn,$sql190)){
        $_SESSION['no_of_unread_msg']= mysqli_num_rows($result190);
      }else{
        $_SESSION['no_of_unread_msg']= 0;
      }
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
<?php
if($form == true){
?>
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
      /*if($msg!=null){
      echo "<div class='error_msg alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>
      $msg</div>";
                  }*/
      ?>
      <ul class="nav nav-tabs nav-justified">
        <li class="active" onclick="set_b_category('Academic')"><a data-toggle="tab" href="#Academic"><strong>Academic</strong>&nbsp;<i class="fa fa-leanpub"></i></a></li>
        <li onclick="set_b_category('Non-academic')"><a data-toggle="tab" href="#Non_academic"><strong>Non-academic</strong>&nbsp;<i class="fa fa-book"></i></a></li>
      </ul>

      <div class="tab-content">
        <!--   Academic section starts here-->
          <div id="Academic" class="tab-pane fade in active">
              <form name="academic_form" role="form" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="POST" enctype="multipart/form-data">
                <input type="text" id="b_category" name="post_a_category" style="display:none;" value="Academic">
                <div class="row form-group">
          <div class="col-sm-6"><label for="book_title">Book Title</label>
          <input id="book_title" class="input-md form-control" type="text" name="post_a_name" list="title_list" required>
            <datalist id="title_list">
              <option>Organiser</option>
              <option>WBUT Study Guide</option>
            </datalist>
          </div>
          <div class="col-sm-6"><label for="book_author">Author or Publication</label>
            <input id="book_author" class="input-md form-control" type="text"  name="post_a_author">
          </div>
        </div>
        <div class="row form-group">
                  <div class="col-sm-6">
                    <label for="book_year">Year, Class or Semester</label>
                    <input type="text" class="input-md col-md-4 form-control" list="book_year" name="post_a_year">
                      <datalist id="book_year">
                        <option>Any Year</option>
                        <option>First Year</option>
                        <option>Second Year</option>
                        <option>Third Year</option>
                        <option>Fourth Year</option>
                        <option>Fifth Year</option>
                        <option>First Semester</option>
                        <option>Second Semester</option>
                        <option>Third Semester</option>
                        <option>Fourth Semester</option>
                        <option>Fifth Semester</option>
                        <option>Sixth Semester</option>
                        <option>Seventh Semester</option>
                        <option>Eighth Semester</option>
                      </datalist>
                  </div>
                  <div class="col-sm-6"><label for="book_department">Department or Subject</label>
                    <input class="input-md col-md-4 form-control" list="b_departments" type="text"  name="post_a_department">
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
<!--     </div>
 -->
    <div class="form-group">
      <label for="comment">Description of the book</label>
      <textarea class="form-control" rows="2" id="comment" name="post_a_description"></textarea>
    </div>
    <div class="row form-group">
      <div class="col-md-6">
        <label for="Price">Price</label>
        <input class="form-control" type="number" name="post_a_price" required>
      </div>
      <div class="col-md-6">
        <label>Choose an Image</label>
        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" onchange="loadFile(event)">
      </div>
    </div>
      <p>
        <span class="img_prev_a"></span><br>
        <img class="output_a" style="width:100px;height:100px;" />
      </p>
    <div class="centered">
      <button type="submit" class="btn btn-primary form-control" name="academic_form">Submit Your Book Post <i class="fa fa-arrow-right"></i></button>
    </div>
    <br>
  </form>
  </div>
  <!--non-academic starts here-->
  <div id="Non_academic" class="tab-pane fade">
    <form name="academic_form" role="form" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="post" enctype="multipart/form-data">
    <input type="text" id="b_category" name="post_na_category" style="display:none;" value="Novel">
    <div class="form-group"><label for="novel_title">Title</label>
      <input id="novel_title" class="input-md col-md-4 form-control" type="text" name="post_na_name" >
    </div>
        <div class="row form-group">
        <div class="col-sm-6"><label for="novel_author">Author</label>
                      <input id="novel_author" class="input-md form-control" type="text"  name="post_na_author" list="author_list">
                        <datalist id="author_list">
                          <option>Chetan Bhagat</option>
                          <option>Ravindar Singh</option>
                          <option>A P J Abdul Kalam</option>
                        </datalist>
        </div>
          <div class="col-sm-6">
            <label for="novel_genre">Genre or Category</label>
            <select class="form-control" list="novel_list" name="post_na_genre">
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
      </div>
      <div class="form-group">
      <label for="comment">Description of the book</label>
      <textarea class="form-control" rows="2" id="comment" name="post_na_description"></textarea>
    </div>
    <div class="row form-group">
      <div class="col-md-6">
        <label for="Price">Price</label>
      <input class="form-control" type="number" name="post_na_price">
      </div>
      <div class="col-md-6">
        <label>Choose an Image</label>
        <input type="file" name="fileToUpload_na" id="fileToUpload_na" accept="image/*" onchange="loadFile_na(event)">
      </div>
    </div>
    <p>
        <span id="img_prev_na"></span><br>
        <img id="output_na" style="width:100px;height:100px;" />
      </p>
    <div class="centered">
      <button type="submit" class="btn btn-primary form-control" value="Login">Submit Your Book Post <i class="fa fa-arrow-right"></i></button>
    </div>
    <br>
  </form>
      </div>
    <!--non-academic section ends-->
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
<?php
}
require('footer.php');
?>
</body>
</html>
