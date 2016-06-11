<?php
include ('files/config.php');
if(isset($_POST["rating"], $_POST["feedback"])){
  $rating = test_input($_POST["rating"]);
  $feedback = test_input($_POST["feedback"]);
  $sql = "INSERT INTO feedback(rating, feedback) VALUES ('$rating', '$feedback')";
  if($result = mysqli_query($conn,$sql)){
    $form= false;
    $msg = "Thanks for your feedback.<br>We hope you enjoy using handybooks as much do maintaining it.";
  }
  else{
    $msg  = "Sorry. An error occured while submitting your feedback.<br> PLease try again in a while.";
    $form = true;
  }
}
else{
  $form = true;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Handybooks: Feedback</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="styles/default_lp.css">
  <link rel="stylesheet" type="text/css" href="footer.css">
<style type="text/css">
  #rating a:hover {
    color:red;
  }
</style>
  <script src="jquery-1.11.2.min.js"></script>
  <script src="bootstrap.min.js"></script>
</head>
<body>
    <div id=fb-root></div>
    <script>
        (function(e, a, f) {
            var c, b = e.getElementsByTagName(a)[0];
            if (e.getElementById(f)) {
                return
            }
            c = e.createElement(a);
            c.id = f;
            c.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1075301472498825";
            b.parentNode.insertBefore(c, b)
        }(document, "script", "facebook-jssdk"));
    </script>
  <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
            <a href="home" onmouseover = "document.getElementById('in').style.visibility='visible'" onmouseout = "document.getElementById('in').style.visibility='hidden'" class="logo_text"><strong>handybooks</strong><small id="in" style="visibility:hidden;">.in</small></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="home"><i class="fa fa-home"></i> Home</a></li>          </ul>
        </div>
      </div>
  </nav>
  <div class="container" id="main_content">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
<?php
if($form==true){
?>
        <div class="jumbotron" style="border:1px solid black">
        <!--show message here-->
<!-- End of message-->
        <h2 class="text-success">Feedback <i class="fa fa-thumbs-up"----></i></h2>
        <hr>
        <h4>Please do spare your valuable 1 minute and share your experience with Handybooks.</h4>
          <div>
            <div> 
              <form class="form-horizontal" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <div class="form-group">
                  <label for="rating" class="col-sm-3 control-label">Your Rating: <i class="fa fa-star"></i></label>
                  <div class="col-sm-9">
                    <input type="radio" id="rating1" name="rating" value="1"> <label for="rating1"> Awesome</label><br>
                    <input type="radio" id="rating2" name="rating" value="2"> <label for="rating2"> Good</label><br>
                    <input type="radio" id="rating3" name="rating" value="3"> <label for="rating3"> Above Average</label><br>
                    <input type="radio" id="rating4" name="rating" value="4"> <label for="rating4">  Needs Improvement</label><br>
                    <input type="radio" id="rating5" name="rating" value="5"> <label for="rating5"> Not Satisfactory</label><br>
                  </div>
                </div>
                <div class="form-group">
                  <label for="description" class="col-sm-3 control-label">Your Feedback <i class="fa fa-pencil"></i></label>
                  <div class="col-sm-9">
                   <textarea class="form-control"  id="description" name="feedback" placeholder="Say something. Suggest a feature or some modifications etc."required></textarea>
                  </div>
                </div>
                 
                <div class="form-group">
                  <label for="Submit-btn" class="col-sm-3 control-label" style="visibility:hidden;">Submit-btn</label>
                  <div class="col-sm-9">
                   <input type="submit" role="button" class="btn btn-primary  form-control" id="Submit-btn" name="Submit-btn" value="Submit your Feedback">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
<?php
}
else{
  echo '<div class="jumbotron">
          <h2 class="text-danger">'.$msg.'</h2>
          <h3>Like handybooks facebook page</h3>
          <div class=fb-like data-href=https://facebook.com/handybooks data-width=50 data-layout=standard data-action=like data-show-faces=true data-share=true></div>
        </div>';
}
?>
      </div>
    </div>
  </div>
              <div id="footer">
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
  function starHover(x){
    var x = x.value;
    document.alert(x);
  }
</script>
</body>
</html>
