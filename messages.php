<?php
include 'files/config.php';
if(!isset($_SESSION["user_id"])){
    header('Location:login.php?from=messages&msg=notloggedin');
}
 //code for unread messages
 $one=1;
$user_id=$_SESSION["user_id"];
$sql190 = "SELECT * FROM chats WHERE (to_user='$user_id' and displayble='$one' and to_user_read=0) ";
$result190 = mysqli_query($conn,$sql190) or mysqli_error($conn);
$_SESSION['no_of_unread_msg']= mysqli_num_rows($result190);
$no_of_msg=$_SESSION['no_of_unread_msg'];

//end of code for unread messages
?>
<!DOCTYPE html>
<html>
<head>
<title>Handybooks: Messages</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap.min.css">
<link rel="stylesheet" href="styles/default_lp.css">
<link rel="stylesheet" type="text/css" href="footer.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<style type="text/css">
.navbar{
	margin-bottom:0px;
}
  #chat_content{
    height: 250px;
    width:100%;
    overflow-y: scroll;
    overflow-x:hidden;
    margin-right: 5px;
    margin-left: 5px;
}
	.threads:hover{
		background-color:#ECE9D8;
	}
</style>
<script src="jquery-1.11.2.min.js"></script>
<script src="bootstrap.min.js"></script>
<script>
var to_user = "";
var row;
function openChat(thread,row){
  var to_user = thread;
  $("td").css("background","transparent");
  $(row).parent().css("background-color","#C6C6C6");
  document.getElementById("chats").innerHTML = '<center><i class="fa fa-3x fa-spinner fa-pulse" style="position:absolute;top:50px;"></i></center>';
  var xmlhttp2 = new XMLHttpRequest();
  xmlhttp2.onreadystatechange = function(){
    if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200 ){
              document.getElementById("chats").innerHTML = xmlhttp2.responseText;
            }
  }  
  xmlhttp2.open('POST', 'logs.php?to_user='+to_user, true);
  xmlhttp2.send();
}
$('input').keydown(function(event) {
    if (event.which ==13 || event.keyCode == 13) {
      alert("hi");
        // $('#form').submit();
        sendChat();
    }
});
function sendChat(){
  if(chat.msg.value==""){
    alert("Please type something to send");
    return;
  }
  var to_user = chat.to_user.value;
  var msg = chat.msg.value;
  chat.msg.value = "";  
  var xmlhttp = new XMLHttpRequest();
    document.getElementById("chats").innerHTML = '<center><i class="fa fa-3x fa-spinner fa-pulse" style="position:absolute;top:50px;"></i></center>';

  xmlhttp.onreadystatechange = function(){
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
              document.getElementById("chats").innerHTML = xmlhttp.responseText;
            }
  }
            xmlhttp.open('POST', 'process_chat.php?to_user='+to_user+'&msg='+msg, true);
            xmlhttp.send();
}
if(to_user!=""){
  $(document).ready(function(e){
    $.ajaxSetup({cache:false});
      setInterval(function(){ $("#chats").load('logs.php?to_user='+to_user); }, 1000);
    });
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
            <a href="home" onmouseover = "document.getElementById('in').style.visibility='visible'" onmouseout = "document.getElementById('in').style.visibility='hidden'" class="logo_text"><strong>handybooks</strong><small id="in" style="visibility:hidden;">.in</small></a>
        </div>
    <div>
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
        <a href="post_ad1.php" class="btn btn-primary navbar-btn navbar-left" style="margin-right:5px;">Sell a Book</a>
        <li><a href="home"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><a href="messages"><i class="fa fa-comments"></i> Messages<?php if ($no_of_msg) {
          echo "<span class='badge'>".$no_of_msg."</span>";}?></a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i><span class="capitalize"> <?php echo $_SESSION["name"];?></span><span class="caret"></span></a>
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
    </div>
</nav>
<!-- Messages container -->
    <div class="container" id="main_content">
      <aside class="col-sm-3 menu" style="height:100%;border-right:1px solid #C6C6C6; padding-right:0px;border-left:1px solid #C6C6C6;padding-left:0px;">
        <h4 style="padding-left:10px;">Conversations</h4><hr>          
<?php
  $from_user=$_SESSION["user_id"];
  $one=1;
  $sql = "SELECT DISTINCT to_user,from_user FROM chats WHERE (to_user='$from_user')  ORDER BY time DESC";
  $result = mysqli_query($conn,$sql);
  echo '<div style="display:block;height:300px;overflow-y:auto;overflow-x:hidden;"><table class="table">';
  while($extract=mysqli_fetch_array($result)){
      $to_show_user = $extract['from_user'];
    $sql2 = "SELECT * FROM users WHERE user_id='$to_show_user'";
    $row2 = mysqli_query($conn,$sql2);
    $extract2 = mysqli_fetch_assoc($row2);
    if($extract2["name"]==""){
      $name = "User ".$extract2["user_id"];
    }else{
      $name = $extract2["name"];
    }
    echo '<tr><td class="threads" style="border-bottom:1px solid #C6C6C6"><a href="#" id="thread" style="text-decoration:none;color:#555555;display:block;padding:10px;" onclick="openChat('.$extract2["user_id"].',this)">'.$name.'</a></td></tr>';
  }
  echo '</table></div>';
?>
      </aside>
      <article class="col-sm-9" id="chats">
      <div class="row col-sm-10">
      <b></b>
      <div style="text-align:center;padding-top:50px;">No messages to display.</div><br>
      </div>
      <div class="row col-sm-10">
        
      </div>
      </article>
    </div><!-- End of Container -->
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
                        Handybooks on Google+
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
</body>
</html>