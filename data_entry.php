<?php
include 'files/config.php';
$form=true;
  //checking if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  //initialize and sanitize input variables here
  $user_id = 1;
  $b_category = "Academic";
  $b_title = test_input($_POST["b_title"]);
  $b_author = test_input($_POST["b_author"]);
  $b_year = test_input($_POST["b_year"]);
  $b_department = test_input($_POST["b_department"]);
  $b_description = ($_POST["b_description"]);
  $b_price = test_input($_POST["b_price"]);
  $b_class = test_input($_POST["b_class"]);
  $b_subject = test_input($_POST["b_subject"]);
  $deleted=true;
  $optradio="sell";
  $sql = "INSERT INTO post (user_id, post_category, post_name, post_author, post_year, post_department, post_description, post_price, post_class, post_subject, post_type,deleted) VALUES ('$user_id', '$b_category', '$b_title', '$b_author', '$b_year', '$b_department', '$b_description', '$b_price', '$b_class', '$b_subject', '$optradio', '$deleted')";
  if($conn->query($sql)=== TRUE)
  {
    $form = false;
  	header('Location:data_entry.php');
  }
  else 
  {
    $form = true;
    echo "Something went wrong. Data could not be inserted properly" . $conn->error;
  }
}
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
  <script src="jquery-1.11.2.min.js"></script>
  <script src="bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading"><h3 class="tagline"><strong><center>Post Ad for Your   Book</center></strong></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                  <form role="form" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="post"><br>
                    <div class="row form-group">
                      <div class="col-sm-6"><label for="book_title">Title</label>
                        <input id="book_title" class="input-md form-control" type="text" name="b_title" autofocus>
                      </div>
                      <div class="col-sm-6"><label for="book_author">Author</label>
                        <input id="book_author" class="input-md form-control" type="text"  name="b_author">
                      </div>
                    </div> 
                    <div class="form-group">
                      <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#college">College&nbsp;</a></li>
                        
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
                    </div><!--Ending tab content div-->
                    <div class="form-group">
                      <label for="comment">Description</label>
                      <textarea class="form-control" rows="2" id="comment" name="b_description"></textarea>
                    </div>
                    <div class="row form-group">
                    <div class="col-md-4">
                    <div class="col-md-4"> 
                    </div>                      
                    <div class="col-md-4"><div class="input-group"><span class="input-group-addon">
                      <input type="radio" name="optradio" value="Sell" checked> Sell &#x20b9;</span>
                      <input type="number" min="0" max="2000" step="10" class="form-control" name="b_price">
                    </div>
                  </form>
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
  </body>
</html>
<?php
   }
?>