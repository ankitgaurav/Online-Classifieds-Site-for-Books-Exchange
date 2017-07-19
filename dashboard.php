<?php
include ("files/config.php");
if(isset($_GET["msg"])){
    if ($_GET["msg"]=="greetings"){
        $msg = "Greetings ".$_SESSION['name']."! You have just created an account in Handybooks.in";
    }
    elseif($_GET["msg"]=="ad_posted"){
        $msg = 'You just posted an ad for your book. <a href="book_details.php?p_id='.$_SESSION['last_post_id'].'">Review</a>';
        unset($_SESSION['last_post_id']);
    }
    elseif($_GET["msg"]=="deleted_post"){
        $msg = 'Your post deleted successfully.';
    }
    else{
        $msg=null;
}
}
else{
    $msg=null;
}
if(!isset($_SESSION["email"])){
    header('Location:login?msg=notloggedin&from=dashboard');
}
else{
 //code for unread messages
 $one=1;
$user_id=$_SESSION["user_id"];
$sql190 = "SELECT * FROM chats WHERE (to_user='$user_id' and displayble='$one' and to_user_read=0) ";
if($result190 = mysqli_query($conn,$sql190)){
  $_SESSION['no_of_unread_msg']= mysqli_num_rows($result190);
}else{
  $_SESSION['no_of_unread_msg']=0;
}

$no_of_msg=$_SESSION['no_of_unread_msg'];
//end of code for unread messages
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Index</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="jquery-1.11.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script type="text/javascript">
        function show_confirm_delete(data){
            document.getElementById(data).style.display = "block";
            // document.getElementById('confirm_box').innerHTML = '<hr><div class="alert alert-warning text-center" style="background-color:white;">Do you really want to delete this post?<br><a href="#" role="button" class="btn btn-sm btn-primary">Yes</a>&nbsp;<a href="#" onclick="hide_confirm_delete()" role="button" class="btn btn-sm btn-default">No</a></div>';
        }
        function hide_confirm_delete(data){
            document.getElementById(data).style.display = 'none';
        }
        function delete_post(data){
            var post_id = data;
           // alert(post_id);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.body.innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "process_delete_post.php?post_id=" + post_id, true);
            xmlhttp.send();
        }
    </script>
<style type="text/css">
.profile_labels{
    font-weight: 300;
    font-size: 1.1em;
    line-height: 1.5em;
}
.profile_values{
    font-weight: 500;
    font-size: 1.2em;
        line-height: 1.5em;

}
</style>
<script>
        function save_user_info(){
                var name = edit_form.name.value;
                var institution = edit_form.institution.value;
                var city = edit_form.city.value;
                var dashboard = "dashboard";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                        document.getElementById("modal-body").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('POST', 'process_save_user_info.php?name='+name+'&institution='+institution+'&city='+city+'&from='+dashboard, true);
                xmlhttp.send();
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
        <a href="post_a_book" class="btn btn-primary navbar-btn navbar-left" style="margin-right:5px;">Sell a Book</a>
        <li><a href="home"><i class="fa fa-home"></i> Home </a></li>
        <li><a href="messages"><i class="fa fa-comments"></i> Messages <?php if ($no_of_msg) {
          echo "<span class='badge'>".$no_of_msg."</span>";}?></a></li>
        <li class="dropdown active">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> <?php echo $_SESSION["name"];?><span class="caret"></span></a>
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
<!-- Dashbaord container -->
    <div class="container container1" id="main_content">
        <aside class="col-sm-3">

<div class="btn-group-vertical btn-block" role="group" aria-label="...">
<?php
                    $user_id=$_SESSION["user_id"];
                            $sql53 = "SELECT * FROM users WHERE `user_id`='$user_id'";
                            $row53 = mysqli_query($conn,$sql53);
                            $user_info = mysqli_fetch_assoc($row53);

                    if(isset($_REQUEST["to"])){
                        if($_REQUEST["to"]=="transactions"){
                            echo '<a href="dashboard" role="button" type="button" class="btn btn-default">My Profile</a>
                            <a href="dashboard?to=transactions" role="button" type="button" class="btn btn-default active">My Posts</a>
                            <a href="dashboard?to=book_requests" role="button" type="button" class="btn btn-default">My Book Requests</a>
                            ';
                            }
                        elseif($_REQUEST["to"]=="book_requests"){
                            echo '<a href="dashboard" role="button" type="button" class="btn btn-default">My Profile</a>
                            <a href="dashboard?to=transactions" role="button" type="button" class="btn btn-default">My Posts</a>
                            <a href="dashboard?to=book_requests" role="button" type="button" class="btn btn-default active">My Book Requests</a>';
                        }}
                        else{
                            echo '<a href="dashboard" role="button" type="button" class="btn btn-default active">My Profile</a>
                            <a href="dashboard?to=transactions" role="button" type="button" class="btn btn-default">My Posts</a>
                            <a href="dashboard?to=book_requests" role="button" type="button" class="btn btn-default">My Book Requests</a>';
                        }
?>
</div>
<br>
<br>
<?php
                $user_id_pc = $_SESSION["user_id"];
    $sql_pc = "SELECT * FROM users WHERE user_id='$user_id_pc'";
    $row_pc = mysqli_query($conn,$sql_pc);
    $extract_pc = mysqli_fetch_assoc($row_pc);
    if($extract_pc["name"]=="" && $extract_pc["city"]=="" && $extract_pc["institution"]==""){
        //25%
        echo '
            <div id="profile completeness" class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your Profile Completeness <br>
                <div class="progress">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:25%;color:black;">25% Complete
                    </div>
                </div>
                <a role="button" class="btn btn-xs btn-default " href="#" data-toggle="modal" data-target="#edit_modal">Complete now</a>
            </div>';
            }
    elseif(($extract_pc["name"]=="" and $extract_pc["city"]=="") or ($extract_pc["name"]=="" and $extract_pc["institution"]=="") or ($extract_pc["city"]=="" and $extract_pc["institution"]=="") ){
        //50%
        echo '
            <div id="profile completeness" class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your Profile Completeness<br>
                <div class="progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;color:black;">50% Complete
                    </div>
                </div>
                <a role="button" class="btn btn-xs btn-default " href="#" data-toggle="modal" data-target="#edit_modal">Complete now</a>
            </div>';
    }
    elseif($extract_pc["name"]=="" or $extract_pc["city"]==="" or $extract_pc["institution"]==""){
        //75%
        echo '
            <div id="profile completeness" class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your Profile Completeness<br>
                <div class="progress">
                    <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%;color:black;">75% Complete
                    </div>
                </div>
                <a role="button" class="btn btn-xs btn-default " href="#" data-toggle="modal" data-target="#edit_modal">Complete now</a>
            </div>';
    }
?>

        </aside>
        <article class="col-sm-9">
            <div id="container">
                <div id="jumbotron">
<!--show message here-->
<?php
if($msg!=null){
echo "<div class='error_msg alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>".$msg."</div>";
            }
?>
<!-- End of message-->
                <div id="content">
                    <?php
                    if(isset($_REQUEST["to"])){
                        if($_REQUEST["to"]=="transactions"){
                            $user_id=$_SESSION["user_id"];
                            $sql = "SELECT * FROM post WHERE `user_id`='$user_id' AND deleted='false' ORDER BY post_time DESC";
                            $row = mysqli_query($conn,$sql);
                            $posts_count = mysqli_num_rows($row);
                            echo '<span style="font-size:20px;">Books Posted by Me</span><hr>';
                            echo 'Total number of posts: '.$posts_count.'<br>';
//Displaying books posted by user here
                        if(isset($_REQUEST["b_id"])){
                            if($_REQUEST["b_id"]!=""){
                                $b_id=$_REQUEST["b_id"];
                                $sql0 = "SELECT * FROM post WHERE post_id='$b_id'";
                                $row0=mysqli_query($conn,$sql0);
                                echo "hi";
                                $extract0 = mysqli_fetch_assoc($row0);
                                echo "You just posted this book.";
                            }
                        }
                            echo '<div id="chk"></div>';
                            echo '<div style="display:block;height:400px;overflow:scroll;"><table class="table table-striped well">';
                            while($posts = mysqli_fetch_assoc($row)){
                                    $time = $posts["post_time"];
                                    $time=strtotime($time);
                                    $time=date("dS F", $time);
                                    if($posts["post_name"]==""){
                                        $posts["post_name"] = "Unnamed book";
                                    }
                                    echo '<tr><td><h5><span style="text-transform:capitalize;font-weight:bolder;" class="text-success">'
                                    .$posts['post_name'].
                                    "</span></h5> for <span class='text-success'>Rs.".$posts['post_price']."</span> posted on "
                                    .$time.
                                    "<a onclick = 'show_confirm_delete(".$posts['post_id'].")' href='#' role='button' class='btn btn-sm btn-default btn-danger' style='margin-right:5px;margin-left:5px; float:right;'>Delete</a>&nbsp;
                                    <a href='book_details.php?p_id=".$posts['post_id']."' role='button'style='margin-right:5px;margin-left:5px;float:right;' class='btn btn-sm btn-default '>See Post</a>&nbsp;
                                    <div name='confirm_box' id=".$posts['post_id']." style='display:none;'><hr>
                                    <div class='alert alert-warning text-center' style='background-color:white;'>

                                    Do you really want to delete this post?<br><a onclick='delete_post(".$posts['post_id'].")' href='#' role='' class='btn btn-sm btn-primary'>Yes</a>&nbsp;<a href='#' onclick='hide_confirm_delete(".$posts['post_id'].")' role='button' class='btn btn-sm btn-default'>No</a>
                                    </div>
                                    </div>
                                    </td></tr>";
                            }
                            echo '</table></div>';

                        }
//showing Book Requests here
                        elseif($_REQUEST["to"]=="book_requests"){
                    ?>
                            <span style="font-size:20px;">Books Requested by Me</span><hr>
                    <?php
                            echo "No requests yet.";
                        }
                    }
                                            else{
//showing Profile here
                    ?>
                            <span style="font-size:20px;">My Profile</span><span style="padding-left:10px;"><a href="#" class="" id="reply_btn"  data-toggle="modal" data-target="#edit_modal"> <i class="fa fa-edit"></i> Edit</a></span><hr>
                    <?php

                            echo "<div class='well'><span class='profile_labels'>Name: </span><span class='profile_values'>"
                            .$user_info["name"].
                                "</span><hr><span class='profile_labels'>Email: </span><span class='profile_values'>"
                            .$user_info["email"].
                                "</span><hr><span class='profile_labels'>Institution: </span><span class='profile_values'>"
                            .$user_info["institution"].
                                "</span><hr><span class='profile_labels'>Address: </span><span class='profile_values'>"
                            .$user_info["city"].
                                "</span></div>";
                        }
                    ?>
                </div>
                </div>
                </div>
            </div>
                        <!-- Reply Modal Starts Here -->
            <div id="edit_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit your profile info</h4>
      </div>
      <div class="modal-body" id="modal-body">
        <form role="form" name="edit_form">
            <div class="form-group"><label for="name">Your name</label>
                <input type="text" name="name" class="input-md form-control" value="<?php echo $_SESSION["name"];?>">
                </div>
            <div class="form-group"><label for="institution">Your school/college</label>
            <input id="institution" list="institutions" name="institution" class="form-control" value="<?php echo $user_info["institution"];?>">
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
            <div class="form-group"><label for="city">Your city</label>
            <input  name="city" id="city" class="form-control" list="cities" value="<?php echo $user_info["city"];?>">
                    <datalist id="cities">
                        <option>Select City</option>
                        <option>Abohar</option>
                        <option>Achalpur</option>
                        <option>Adilabad</option>
                        <option>Adipur</option>
                        <option>Adityapur</option>
                        <option>Adoni</option>
                        <option>Agartala</option>
                        <option>Agra</option>
                        <option>Agra Cantonment</option>
                        <option>Ahmedabad</option>
                        <option>Ahmednagar</option>
                        <option>Aizawl</option>
                        <option>Ajmer</option>
                        <option>Akola</option>
                        <option>Akot</option>
                        <option>Alandur</option>
                        <option>Alappuzha</option>
                        <option>Aoptiongarh</option>
                        <option>Aoptionpurduar</option>
                        <option>Allahabad</option>
                        <option>Along</option>
                        <option>Alwal</option>
                        <option>Alwar</option>
                        <option>Amalapuram</option>
                        <option>Amalner</option>
                        <option>Ambajogai</option>
                        <option>Ambala</option>
                        <option>Ambala Cantonme</option>
                        <option>Ambala Sadar</option>
                        <option>Ambarnath</option>
                        <option>Ambasamudram</option>
                        <option>Ambattur</option>
                        <option>Ambikapur</option>
                        <option>Ambur</option>
                        <option>Amravati</option>
                        <option>Amreoption</option>
                        <option>Amritsar</option>
                        <option>Amroha</option>
                        <option>Anakapalle</option>
                        <option>Anand</option>
                        <option>Anantapur</option>
                        <option>Anantnag</option>
                        <option>Anjangaon</option>
                        <option>Anjar</option>
                        <option>Ankleshwar</option>
                        <option>Ara</option>
                        <option>Arakkonam</option>
                        <option>Arambagh</option>
                        <option>Arani</option>
                        <option>Araria</option>
                        <option>Arcot</option>
                        <option>Aruppukkottai</option>
                        <option>Asansol MC</option>
                        <option>Ashokenagar-Kal</option>
                        <option>Ashoknagar</option>
                        <option>Ashoknagar</option>
                        <option>Attur</option>
                        <option>Auraiya</option>
                        <option>Aurangabad</option>
                        <option>Aurangabad</option>
                        <option>Avadi</option>
                        <option>Avaniapuram</option>
                        <option>Azamgarh</option>
                        <option>Badlapur</option>
                        <option>Baduna</option>
                        <option>Bagaha</option>
                        <option>Bagalkot</option>
                        <option>Bagbera</option>
                        <option>Bahadurgarh</option>
                        <option>Baharampore</option>
                        <option>Baheri</option>
                        <option>Bahraich</option>
                        <option>Baidyabati</option>
                        <option>Balaghat</option>
                        <option>Balaghat</option>
                        <option>Balangir</option>
                        <option>Baleshwar</option>
                        <option>Ballarpur</option>
                        <option>Baloptiona</option>
                        <option>Bally</option>
                        <option>Balotra</option>
                        <option>Balrampur</option>
                        <option>Balurghat</option>
                        <option>Banda</option>
                        <option>Bangalore</option>
                        <option>Bankura</option>
                        <option>Bansberia</option>
                        <option>Banswara</option>
                        <option>Bapatla</option>
                        <option>Baramati</option>
                        <option>Baramula</option>
                        <option>Baran</option>
                        <option>Baranagar</option>
                        <option>Barasat</option>
                        <option>Baraut</option>
                        <option>Barbil</option>
                        <option>Bardhaman</option>
                        <option>Bardooption</option>
                        <option>Bareilly</option>
                        <option>Bargarh</option>
                        <option>Bari</option>
                        <option>Baripada</option>
                        <option>Barmer</option>
                        <option>Barnala</option>
                        <option>Barrackpore</option>
                        <option>Barsi</option>
                        <option>Baruipur</option>
                        <option>Basavakalyan</option>
                        <option>Basirhat</option>
                        <option>Basmat</option>
                        <option>Basoda</option>
                        <option>Basoda</option>
                        <option>Basti</option>
                        <option>Batala</option>
                        <option>Bathinda</option>
                        <option>Beawar</option>
                        <option>Begusarai</option>
                        <option>Behta Hazipur</option>
                        <option>Bela Pratapgarh</option>
                        <option>Beldanga</option>
                        <option>Belgaum</option>
                        <option>Bellampalle</option>
                        <option>Bellary</option>
                        <option>Berhmapur</option>
                        <option>Bettiah</option>
                        <option>Betul</option>
                        <option>Betul</option>
                        <option>Beypore</option>
                        <option>Bhadohi</option>
                        <option>Bhadrak</option>
                        <option>Bhadravati</option>
                        <option>Bhadravati</option>
                        <option>Bhadreswar</option>
                        <option>Bhagalpur</option>
                        <option>Bhandara</option>
                        <option>Bharatpur</option>
                        <option>Bharuch</option>
                        <option>Bhatapara</option>
                        <option>Bhatpara</option>
                        <option>Bhavani</option>
                        <option>Bhavnagar</option>
                        <option>Bhawanipatna</option>
                        <option>Bhilai</option>
                        <option>Bhilai Charoda</option>
                        <option>Bhilwara</option>
                        <option>Bhimavaram</option>
                        <option>Bhind</option>
                        <option>Bhind</option>
                        <option>Bhiwandi</option>
                        <option>Bhiwani</option>
                        <option>Bhopal</option>
                        <option>Bhubaneswar</option>
                        <option>Bhuj</option>
                        <option>Bhuoption</option>
                        <option>Bhusawal</option>
                        <option>Bid</option>
                        <option>Bidar</option>
                        <option>Bidhannagar</option>
                        <option>Bihar</option>
                        <option>Bijapur</option>
                        <option>Bijnor</option>
                        <option>Bikaner</option>
                        <option>Bilaspur</option>
                        <option>Bioptionmora</option>
                        <option>Bina-Etawa</option>
                        <option>Bina-Etawa</option>
                        <option>Birnagar</option>
                        <option>Bisalpur</option>
                        <option>Bishnupur</option>
                        <option>Bobbioption</option>
                        <option>Bodhan</option>
                        <option>Bodinayakanur</option>
                        <option>Bokaro Steel Ci</option>
                        <option>Bolpur</option>
                        <option>Bommanahaloption</option>
                        <option>Bongaigaon</option>
                        <option>Bongaon</option>
                        <option>Borsad</option>
                        <option>Botad</option>
                        <option>Brajarajnagar</option>
                        <option>Budaun</option>
                        <option>Budge-Budge</option>
                        <option>Bulandshahr</option>
                        <option>Buldana</option>
                        <option>Bundi</option>
                        <option>Burhanpur</option>
                        <option>Burhanpur</option>
                        <option>Burhar-Dhanpuri</option>
                        <option>Burhar-Dhanpuri</option>
                        <option>Buxar</option>
                        <option>Byatarayanapura</option>
                        <option>Chaibasa</option>
                        <option>Chakdah</option>
                        <option>Chakradharpur</option>
                        <option>Chaoptionsgaon</option>
                        <option>Champdani</option>
                        <option>Chamrajnagar</option>
                        <option>Chandannagar M.</option>
                        <option>Chandausi</option>
                        <option>Chandigarh</option>
                        <option>Chandlodiya</option>
                        <option>Chandpur</option>
                        <option>Chandrapur</option>
                        <option>Chandrokona</option>
                        <option>Changanacheri</option>
                        <option>Channapatna</option>
                        <option>Chapra</option>
                        <option>Chas</option>
                        <option>Chengalpattu</option>
                        <option>Chennai</option>
                        <option>Cherthala</option>
                        <option>Cheruvannur</option>
                        <option>Chhatarpur</option>
                        <option>Chhatarpur</option>
                        <option>Chhibramau</option>
                        <option>Chhindwara</option>
                        <option>Chhindwara</option>
                        <option>Chidambaram</option>
                        <option>Chikballapur</option>
                        <option>Chikmagalur</option>
                        <option>Chilakalurupet</option>
                        <option>Chinnachowk</option>
                        <option>Chintamani</option>
                        <option>Chirala</option>
                        <option>Chirkunda</option>
                        <option>Chirmiri</option>
                        <option>Chitradurga</option>
                        <option>Chittoor</option>
                        <option>Chittorgarh</option>
                        <option>Chittur</option>
                        <option>Chomun</option>
                        <option>Chopda</option>
                        <option>Churachandpur</option>
                        <option>Churu</option>
                        <option>Civil Township</option>
                        <option>Coimbatore</option>
                        <option>Contai</option>
                        <option>Cooch Behar</option>
                        <option>Coonoor</option>
                        <option>Coopers' Camp N</option>
                        <option>Cuddalore</option>
                        <option>Cuddapah</option>
                        <option>Cumbum</option>
                        <option>Cuttack</option>
                        <option>Dabhoi</option>
                        <option>Dabra</option>
                        <option>Dabra</option>
                        <option>Dadra</option>
                        <option>Dadri</option>
                        <option>Dahod</option>
                        <option>Dainhata</option>
                        <option>Dalkhola</option>
                        <option>Daloption-Rajhara</option>
                        <option>Daltonganj</option>
                        <option>Daman</option>
                        <option>Damoh</option>
                        <option>Damoh</option>
                        <option>Dandeoption</option>
                        <option>Darbhanga</option>
                        <option>Darjeeoptionng</option>
                        <option>Dasarahaloption</option>
                        <option>Datia</option>
                        <option>Datia</option>
                        <option>Dausa</option>
                        <option>Davangere</option>
                        <option>Deesa</option>
                        <option>Dehradun</option>
                        <option>Dehri</option>
                        <option>Delhi</option>
                        <option>Deoband</option>
                        <option>Deoghar</option>
                        <option>Deolaoption</option>
                        <option>Deoria</option>
                        <option>Devarshola</option>
                        <option>Dewas</option>
                        <option>Dewas</option>
                        <option>Dhamtari</option>
                        <option>Dhanbad</option>
                        <option>Dhar</option>
                        <option>Dhar</option>
                        <option>Dharapuram</option>
                        <option>Dharmapuri</option>
                        <option>Dharmavaram</option>
                        <option>Dharwad </option>
                        <option>Dhaulpur</option>
                        <option>Dhenkanal</option>
                        <option>Dholka</option>
                        <option>Dhoraji</option>
                        <option>Dhrangadhra</option>
                        <option>Dhubri</option>
                        <option>Dhule</option>
                        <option>Dhuoptionan</option>
                        <option>Dhupguri</option>
                        <option>Diamond Harbour</option>
                        <option>Dibrugarh</option>
                        <option>Digoptionpur</option>
                        <option>Dimapur</option>
                        <option>Dinapur Nizamat</option>
                        <option>Dindigul</option>
                        <option>Diphu</option>
                        <option>Dispur</option>
                        <option>Diu</option>
                        <option>Dmhata</option>
                        <option>Dod Ballapur</option>
                        <option>Dombivaoption</option>
                        <option>Dubrajpur</option>
                        <option>Dum Dum</option>
                        <option>Durg-Bhilainaga</option>
                        <option>Durgapur MC</option>
                        <option>Edathala</option>
                        <option>Egra</option>
                        <option>Eluru</option>
                        <option>Engoptionsh Bazar</option>
                        <option>Erode</option>
                        <option>Etah</option>
                        <option>Etawah</option>
                        <option>Faizabad</option>
                        <option>Faridabad (New </option>
                        <option>Faridkot</option>
                        <option>Faridpur</option>
                        <option>Farrukhabad</option>
                        <option>Fatehabad</option>
                        <option>Fatehpur</option>
                        <option>Fatehpur</option>
                        <option>Fazilka</option>
                        <option>Firozabad</option>
                        <option>Firozepur</option>
                        <option>Firozpur Canton</option>
                        <option>Gadag</option>
                        <option>Gaddiannaram</option>
                        <option>Gadwal</option>
                        <option>Gajuwaka</option>
                        <option>Gandhidham</option>
                        <option>Gandhinagar</option>
                        <option>Gangaghat</option>
                        <option>Gangapur</option>
                        <option>Gangarampore</option>
                        <option>Gangavati</option>
                        <option>Gangoh</option>
                        <option>Gangtok</option>
                        <option>Garuoptiona</option>
                        <option>Gaya</option>
                        <option>Gayeshpur</option>
                        <option>Geyzing</option>
                        <option>Ghatal</option>
                        <option>Ghatlodiya</option>
                        <option>Ghaziabad</option>
                        <option>Ghazipur</option>
                        <option>Giridih</option>
                        <option>Gobardanga</option>
                        <option>Gobichettipalay</option>
                        <option>Gobindgarh</option>
                        <option>Godhra</option>
                        <option>Gokak</option>
                        <option>Gola Gokarannat</option>
                        <option>Gonda</option>
                        <option>Gondal</option>
                        <option>Gondia</option>
                        <option>Gopalganj</option>
                        <option>Gorakhpur</option>
                        <option>Gudivada</option>
                        <option>Gudiyatham</option>
                        <option>Gudur</option>
                        <option>Gulbarga</option>
                        <option>Guna</option>
                        <option>Guna</option>
                        <option>Guntakal</option>
                        <option>Guntur</option>
                        <option>Gurdaspur</option>
                        <option>Gurgaon</option>
                        <option>Guruvayur</option>
                        <option>Gushkara</option>
                        <option>Guwahati</option>
                        <option>Gwaoptionor</option>
                        <option>Gwaoptionor</option>
                        <option>Habra</option>
                        <option>Hajipur</option>
                        <option>Haldia</option>
                        <option>Haldibari</option>
                        <option>Haldwani</option>
                        <option>Haoptionsahar</option>
                        <option>Hansi</option>
                        <option>Hanumangarh</option>
                        <option>Hapur</option>
                        <option>Harda</option>
                        <option>Harda</option>
                        <option>Hardoi</option>
                        <option>Haridwar</option>
                        <option>Harihar</option>
                        <option>Hasanpur</option>
                        <option>Hassan</option>
                        <option>Hathras</option>
                        <option>Haveri</option>
                        <option>Hazaribagh</option>
                        <option>Himatnagar</option>
                        <option>Hindon</option>
                        <option>Hindupur</option>
                        <option>Hinganghat</option>
                        <option>Hingooption</option>
                        <option>Hissar</option>
                        <option>Hooghly-Chinsur</option>
                        <option>Hoshangabad</option>
                        <option>Hoshangabad</option>
                        <option>Hoshiarpur</option>
                        <option>Hospet</option>
                        <option>Hosur</option>
                        <option>Howrah</option>
                        <option>Huboption</option>
                        <option>Hyderabad</option>
                        <option>Ichalkaranji</option>
                        <option>Ilkal</option>
                        <option>Imphal</option>
                        <option>Indore</option>
                        <option>Indore</option>
                        <option>Islampur</option>
                        <option>Itanagar</option>
                        <option>Itarsi</option>
                        <option>Itarsi</option>
                        <option>Jabalpur</option>
                        <option>Jabalpur</option>
                        <option>Jabalpur Canton</option>
                        <option>Jabalpur Canton</option>
                        <option>Jagadhri</option>
                        <option>Jagdalpur</option>
                        <option>Jagraon</option>
                        <option>Jagtial</option>
                        <option>Jahangirabad</option>
                        <option>Jainagar-Mazilp</option>
                        <option>Jaipur</option>
                        <option>Jaisalmer</option>
                        <option>Jalandhar</option>
                        <option>Jalaun</option>
                        <option>Jalgaon</option>
                        <option>Jalna</option>
                        <option>Jalpaiguri</option>
                        <option>Jalpaiguri</option>
                        <option>Jamalpur</option>
                        <option>Jamkhandi</option>
                        <option>Jammu</option>
                        <option>Jamnagar</option>
                        <option>Jamshedpur</option>
                        <option>Jamui</option>
                        <option>Jamuria</option>
                        <option>Jangipore</option>
                        <option>Jaora</option>
                        <option>Jaora</option>
                        <option>Jatani</option>
                        <option>Jaunpur</option>
                        <option>Jaypore</option>
                        <option>Jehanabad</option>
                        <option>Jetalpur</option>
                        <option>Jetpur</option>
                        <option>Jhaldah</option>
                        <option>Jhansi</option>
                        <option>Jhargram</option>
                        <option>Jharia</option>
                        <option>Jharsuguda</option>
                        <option>Jhunjhunun</option>
                        <option>Jiaganj-Azimgan</option>
                        <option>Jind</option>
                        <option>Jodhpur</option>
                        <option>Jorapokhar</option>
                        <option>Jorhat</option>
                        <option>Jumri Tilaiya</option>
                        <option>Junagadh</option>
                        <option>Kadayanallur</option>
                        <option>Kadi</option>
                        <option>Kadiri</option>
                        <option>Kagaznagar</option>
                        <option>Kairana</option>
                        <option>Kaithal</option>
                        <option>Kakinada</option>
                        <option>Kalamassery</option>
                        <option>Kaoptionaganj</option>
                        <option>Kaoptionmpong</option>
                        <option>Kallur</option>
                        <option>Kalna</option>
                        <option>Kalol</option>
                        <option>Kalyan</option>
                        <option>Kalyani</option>
                        <option>Kamareddy</option>
                        <option>Kamarhati</option>
                        <option>Kamthi</option>
                        <option>Kanchipuram</option>
                        <option>Kanchrapara</option>
                        <option>Kandi</option>
                        <option>Kandukur</option>
                        <option>Kanhangad</option>
                        <option>Kannauj</option>
                        <option>Kannur</option>
                        <option>Kanpur</option>
                        <option>Kanpur Cantonme</option>
                        <option>Kapra</option>
                        <option>Kapurthala</option>
                        <option>Karad</option>
                        <option>Karaikal</option>
                        <option>Karaikkudi</option>
                        <option>Karanja</option>
                        <option>Karauoption</option>
                        <option>Karimganj</option>
                        <option>Karimnagar</option>
                        <option>Karnal</option>
                        <option>Karur</option>
                        <option>Karwar</option>
                        <option>Kasaragod</option>
                        <option>Kasganj</option>
                        <option>Kashipur</option>
                        <option>Kasipalayam</option>
                        <option>Kathua</option>
                        <option>Katihar</option>
                        <option>Katras</option>
                        <option>Kattankulathur</option>
                        <option>Katwa</option>
                        <option>Kavaoption</option>
                        <option>Kavaratti</option>
                        <option>Kayamkulam</option>
                        <option>Kendujhar</option>
                        <option>Keshod</option>
                        <option>Khadki</option>
                        <option>Khambhat</option>
                        <option>Khamgaon</option>
                        <option>Khamman</option>
                        <option>Khandwa</option>
                        <option>Khandwa</option>
                        <option>Khanna</option>
                        <option>Kharagpur</option>
                        <option>Kharar</option>
                        <option>Khardah</option>
                        <option>Khargone</option>
                        <option>Khargone</option>
                        <option>Khatauoption</option>
                        <option>Kheda</option>
                        <option>Khirpai</option>
                        <option>Khopooption</option>
                        <option>Khurja</option>
                        <option>Kiratpur</option>
                        <option>Kishanganj</option>
                        <option>Kishangarh</option>
                        <option>Kochi</option>
                        <option>Kodungallur</option>
                        <option>Kohima</option>
                        <option>Kolar</option>
                        <option>Kolhapur</option>
                        <option>Kolkata</option>
                        <option>Kollam</option>
                        <option>Kollegal</option>
                        <option>Komarapalayam</option>
                        <option>Konch</option>
                        <option>Konnagar</option>
                        <option>Kopargaon</option>
                        <option>Koppal</option>
                        <option>Koratla</option>
                        <option>Korba</option>
                        <option>Kota</option>
                        <option>Kotkapura</option>
                        <option>Kottagudem</option>
                        <option>Kottayam</option>
                        <option>Kovilpatti</option>
                        <option>Kozhikode</option>
                        <option>Krishnagiri</option>
                        <option>Krishnanagar</option>
                        <option>Krishnarajapura</option>
                        <option>Kuchaman City</option>
                        <option>Kukatpalle</option>
                        <option>Kulti</option>
                        <option>Kumbakonam</option>
                        <option>Kuniyamuthur</option>
                        <option>Kunnamkulam</option>
                        <option>Kurichi</option>
                        <option>Kurnool</option>
                        <option>Kurseong</option>
                        <option>Kurukshetra</option>
                        <option>Ladnun</option>
                        <option>Laharpur</option>
                        <option>Lakhimpur</option>
                        <option>Lakhisarai</option>
                        <option>Lalbahadur Naga</option>
                        <option>Laoptiontpur</option>
                        <option>Lasalgaon</option>
                        <option>Latur</option>
                        <option>optionmbdi</option>
                        <option>Lonavale</option>
                        <option>Loni</option>
                        <option>Lucknow</option>
                        <option>Lucknow Cantonm</option>
                        <option>Ludhiana</option>
                        <option>Lumding</option>
                        <option>Lunglei</option>
                        <option>Machioptionpatnam</option>
                        <option>Madanapalle</option>
                        <option>Madavaram</option>
                        <option>Madgaon</option>
                        <option>Madhubani</option>
                        <option>Madhyamgram</option>
                        <option>Madurai</option>
                        <option>Mahadevapura</option>
                        <option>Mahbubnagar</option>
                        <option>Mahesana</option>
                        <option>Maheshtala</option>
                        <option>Mahoba</option>
                        <option>Mahuva</option>
                        <option>Mainpuri</option>
                        <option>Makrana</option>
                        <option>Mal</option>
                        <option>Malappuram</option>
                        <option>Malegaon</option>
                        <option>Maler Kotla</option>
                        <option>Malkajgiri</option>
                        <option>Malkapur</option>
                        <option>Malout</option>
                        <option>Mancherial</option>
                        <option>Mandamarri</option>
                        <option>Mandi</option>
                        <option>Mandi Dabwaoption</option>
                        <option>Mandla</option>
                        <option>Mandla</option>
                        <option>Mandsaur</option>
                        <option>Mandsaur</option>
                        <option>Mandvi</option>
                        <option>Mandya</option>
                        <option>Mangalagiri</option>
                        <option>Mangalore</option>
                        <option>Mango</option>
                        <option>Mangrol</option>
                        <option>Manjeri</option>
                        <option>Manmad</option>
                        <option>Mannargudi</option>
                        <option>Mansa</option>
                        <option>Markapur</option>
                        <option>Mathabhanga</option>
                        <option>Mathura</option>
                        <option>Mau Ranipur</option>
                        <option>Maunath Bhanjan</option>
                        <option>Mawana</option>
                        <option>Mayiladuthurai</option>
                        <option>Medinipur</option>
                        <option>Meerut</option>
                        <option>Meerut Cantonme</option>
                        <option>Mekoptionganj</option>
                        <option>Memari</option>
                        <option>Mettupalayam</option>
                        <option>Mettur</option>
                        <option>Mhow</option>
                        <option>Mhow</option>
                        <option>Mira Bhayandar</option>
                        <option>Miraj</option>
                        <option>Mirik N.A.A.</option>
                        <option>Miryalguda</option>
                        <option>Mirzapur</option>
                        <option>Modasa</option>
                        <option>Modinagar</option>
                        <option>Moga</option>
                        <option>Mohaoption</option>
                        <option>Mokama</option>
                        <option>Moradabad</option>
                        <option>Morbi</option>
                        <option>Morena</option>
                        <option>Morena</option>
                        <option>Mormugao</option>
                        <option>Motihari</option>
                        <option>Mubarakpur</option>
                        <option>Mughalsarai</option>
                        <option>Mumbai</option>
                        <option>Munger</option>
                        <option>Muradnagar</option>
                        <option>Murshidabad</option>
                        <option>Murwara</option>
                        <option>Murwara</option>
                        <option>Muzaffarnagar</option>
                        <option>Muzaffarpur</option>
                        <option>Mysore</option>
                        <option>Nabadwip</option>
                        <option>Nabha</option>
                        <option>Nadiad</option>
                        <option>Nagaon</option>
                        <option>Nagapattinam</option>
                        <option>Nagaur</option>
                        <option>Nagda</option>
                        <option>Nagda</option>
                        <option>Nagercoil</option>
                        <option>Nagina</option>
                        <option>Nagpur</option>
                        <option>Naihati</option>
                        <option>Najibabad</option>
                        <option>Nalasopara</option>
                        <option>Nalgonda</option>
                        <option>Nalhati</option>
                        <option>Namakkal</option>
                        <option>Nanded</option>
                        <option>Nandurbar</option>
                        <option>Nandyal</option>
                        <option>Narasaraopet</option>
                        <option>Narnaul</option>
                        <option>Narsapur</option>
                        <option>Narsimhapur</option>
                        <option>Narsimhapur</option>
                        <option>Narwana</option>
                        <option>Nashik</option>
                        <option>Navghar-Manikpu</option>
                        <option>Navsari</option>
                        <option>Nawabganj</option>
                        <option>Nawada</option>
                        <option>Nawalgarh</option>
                        <option>Nedumangad</option>
                        <option>Nellore</option>
                        <option>New Barrackpore</option>
                        <option>Neyveoption</option>
                        <option>Neyyattinkara</option>
                        <option>Nimach</option>
                        <option>Nimach</option>
                        <option>Nimbahera</option>
                        <option>Nipani</option>
                        <option>Nirmal</option>
                        <option>Nizamabad</option>
                        <option>Noida</option>
                        <option>North Barrackpo</option>
                        <option>North Dum Dum</option>
                        <option>North Lakhimpur</option>
                        <option>Nuzvid</option>
                        <option>Obra</option>
                        <option>Old Malda</option>
                        <option>Ongole</option>
                        <option>Ooty</option>
                        <option>Orai</option>
                        <option>Osmanabad</option>
                        <option>Oulgaret</option>
                        <option>Palacole</option>
                        <option>Palakkad</option>
                        <option>Palani</option>
                        <option>Palanpur</option>
                        <option>Palghar</option>
                        <option>Paoption</option>
                        <option>Paoptiontana</option>
                        <option>Pallavaram</option>
                        <option>Palwal</option>
                        <option>Palwancha</option>
                        <option>Panaji</option>
                        <option>Panchkula</option>
                        <option>Panchmahal</option>
                        <option>Pandharpur</option>
                        <option>Panihati</option>
                        <option>Panipat</option>
                        <option>Panna</option>
                        <option>Panna</option>
                        <option>Panruti</option>
                        <option>Panskura</option>
                        <option>Panvel</option>
                        <option>Paradip</option>
                        <option>Paramakudi</option>
                        <option>Parasia</option>
                        <option>Parasia</option>
                        <option>Parbhani</option>
                        <option>Paroption</option>
                        <option>Patan</option>
                        <option>Pathankot</option>
                        <option>Patiala</option>
                        <option>Patna</option>
                        <option>Pattanagere</option>
                        <option>Pattukkottai</option>
                        <option>Payyannur</option>
                        <option>Petlad</option>
                        <option>Phagwara</option>
                        <option>Phaltan</option>
                        <option>Phulwari Sharif</option>
                        <option>Phusro</option>
                        <option>Pioptionbhit</option>
                        <option>Pilkhuwa</option>
                        <option>Pimpri-Chinchwa</option>
                        <option>Pitapuram</option>
                        <option>Pithampur</option>
                        <option>Pithampur</option>
                        <option>Pollachi</option>
                        <option>Ponnani</option>
                        <option>Ponnur</option>
                        <option>Porbandar</option>
                        <option>Port Blair</option>
                        <option>Proddatur</option>
                        <option>Puducherry</option>
                        <option>Pudukkottai</option>
                        <option>Pujaoption</option>
                        <option>Puoptionyankudi</option>
                        <option>Pune</option>
                        <option>Pune Cantonment</option>
                        <option>Purba Medinipur</option>
                        <option>Puri</option>
                        <option>Purnia</option>
                        <option>Puruoptiona</option>
                        <option>Pusad</option>
                        <option>Quilandi</option>
                        <option>Qutubullapur</option>
                        <option>Rabkavi Banhatt</option>
                        <option>Raebareoption</option>
                        <option>Raghunathpu</option>
                        <option>Raichur</option>
                        <option>Raiganj</option>
                        <option>Raigarh</option>
                        <option>Raipur</option>
                        <option>Rajahmundry</option>
                        <option>Rajapalayam</option>
                        <option>Rajarhat-Gopalp</option>
                        <option>Rajendranagar</option>
                        <option>Rajgarh</option>
                        <option>Rajkot</option>
                        <option>Rajnandgaon</option>
                        <option>Rajpur Sonarpor</option>
                        <option>Rajpura</option>
                        <option>Rajsamand</option>
                        <option>Ramachandrapura</option>
                        <option>Ramagundam</option>
                        <option>Ramanagaram</option>
                        <option>Ramanathapuram</option>
                        <option>Ramgarh</option>
                        <option>Ramjibanpore</option>
                        <option>Rampur</option>
                        <option>Rampurhat</option>
                        <option>Ranaghat</option>
                        <option>Ranchi</option>
                        <option>Ranibennur</option>
                        <option>Raniganj</option>
                        <option>Ranip</option>
                        <option>Ratangarh</option>
                        <option>Rath</option>
                        <option>Ratlam</option>
                        <option>Ratlam</option>
                        <option>Ratnagiri</option>
                        <option>Raurkela</option>
                        <option>Rayachoti</option>
                        <option>Rayadurg</option>
                        <option>Rayagada</option>
                        <option>Renukoot</option>
                        <option>Rewa</option>
                        <option>Rewa</option>
                        <option>Rewari</option>
                        <option>Rishikesh</option>
                        <option>Rishra</option>
                        <option>Robertson Pet</option>
                        <option>Rohtak</option>
                        <option>Roorkee</option>
                        <option>Rudrapur</option>
                        <option>S.A.S. Nagar</option>
                        <option>Sabarkantha</option>
                        <option>Saharanpur</option>
                        <option>Saharsa</option>
                        <option>Sahaswan</option>
                        <option>Sahibganj</option>
                        <option>Sainthia</option>
                        <option>Salem</option>
                        <option>Samalkota</option>
                        <option>Samastipur</option>
                        <option>Sambalpur</option>
                        <option>Sambhal</option>
                        <option>Sangamner</option>
                        <option>Sangareddy</option>
                        <option>Sangoption (-Miraj)</option>
                        <option>Sangrur</option>
                        <option>Sankarankoil</option>
                        <option>Santipur</option>
                        <option>Santirbazar</option>
                        <option>Sardarshahar</option>
                        <option>Sarni</option>
                        <option>Sarni</option>
                        <option>Sasaram</option>
                        <option>Satara</option>
                        <option>Satna</option>
                        <option>Satna</option>
                        <option>Sattenapalle</option>
                        <option>Saunda</option>
                        <option>Savarkundla</option>
                        <option>Sawai Madhopur</option>
                        <option>Secunderabad</option>
                        <option>Sehore</option>
                        <option>Sehore</option>
                        <option>Seoni</option>
                        <option>Seoni</option>
                        <option>Serampore</option>
                        <option>Serchhip</option>
                        <option>Serioptionngampalle</option>
                        <option>Shahabad</option>
                        <option>Shahabad</option>
                        <option>Shahdol</option>
                        <option>Shahdol</option>
                        <option>Shahjahanpur</option>
                        <option>Shajapur</option>
                        <option>Shajapur</option>
                        <option>Shamoption</option>
                        <option>Shegaon</option>
                        <option>Sheopur</option>
                        <option>Sheopur</option>
                        <option>Sherkot</option>
                        <option>Shikohabad</option>
                        <option>Shillong</option>
                        <option>Shimla</option>
                        <option>Shimoga</option>
                        <option>Shirpur</option>
                        <option>Shivpuri</option>
                        <option>Shivpuri</option>
                        <option>Shrirampur</option>
                        <option>Sibsagar</option>
                        <option>Siddipet</option>
                        <option>Sidhpur</option>
                        <option>Sikandrabad</option>
                        <option>Sikar</option>
                        <option>Silchar</option>
                        <option>Sioptionguri</option>
                        <option>Silvassa</option>
                        <option>Sindhnur</option>
                        <option>Sindri</option>
                        <option>Singrauoption</option>
                        <option>Singrauoption</option>
                        <option>Sira</option>
                        <option>Sirhind</option>
                        <option>Sirsa</option>
                        <option>Sirsi</option>
                        <option>Sirsilla</option>
                        <option>Sitamarhi</option>
                        <option>Sitapur</option>
                        <option>Sivakasi</option>
                        <option>Siwan</option>
                        <option>Solan</option>
                        <option>Solapur</option>
                        <option>Sonamukhi</option>
                        <option>Sonepat</option>
                        <option>Sopore</option>
                        <option>South Dum Dum</option>
                        <option>Sri Ganganagar</option>
                        <option>Sri Muktsar Sah</option>
                        <option>Srikakulam</option>
                        <option>Srikalahasti</option>
                        <option>Srinagar</option>
                        <option>Sriviloptionputhur</option>
                        <option>Sujangarh</option>
                        <option>Sultanpur</option>
                        <option>Sunabeda</option>
                        <option>Sunam</option>
                        <option>Supaul</option>
                        <option>Surat</option>
                        <option>Suratgarh</option>
                        <option>Surendranagar</option>
                        <option>Suri</option>
                        <option>Suryapet</option>
                        <option>Tadepaloptiongudem</option>
                        <option>Tadpatri</option>
                        <option>Taherpur N.A.A</option>
                        <option>Taki</option>
                        <option>Taoptionparamba</option>
                        <option>Tambaram</option>
                        <option>Tamluk</option>
                        <option>Tanda</option>
                        <option>Tandur</option>
                        <option>Tanuku</option>
                        <option>Tarakeswar</option>
                        <option>Tarn Taran</option>
                        <option>Teoptionamura</option>
                        <option>Tenaoption</option>
                        <option>Tenkasi</option>
                        <option>Tezpur</option>
                        <option>Thalassery</option>
                        <option>Thane</option>
                        <option>Thanesar</option>
                        <option>Thanjavur</option>
                        <option>Theni</option>
                        <option>Thiruvananthapu</option>
                        <option>Thiruvarur</option>
                        <option>Thrippunithura</option>
                        <option>Thrissur</option>
                        <option>Tikamgarh</option>
                        <option>Tikamgarh</option>
                        <option>Tilhar</option>
                        <option>Tindivanam</option>
                        <option>Tinsukia</option>
                        <option>Tiptur</option>
                        <option>Tiruchendur</option>
                        <option>Tiruchengode</option>
                        <option>Tiruchirappaloption</option>
                        <option>Tirunelveoption</option>
                        <option>Tirupathur</option>
                        <option>Tirupati</option>
                        <option>Tiruppur</option>
                        <option>Tirur</option>
                        <option>Tiruvalla</option>
                        <option>Tiruvannamalai</option>
                        <option>Tiruvottiyur</option>
                        <option>Tisra</option>
                        <option>Titagarh</option>
                        <option>Tohana</option>
                        <option>Tonk</option>
                        <option>Tufanganj</option>
                        <option>Tumkur</option>
                        <option>Tundla</option>
                        <option>Tuni</option>
                        <option>Tura</option>
                        <option>Tuticorin</option>
                        <option>Udaipur</option>
                        <option>Udgir</option>
                        <option>Udhampur</option>
                        <option>Udumalpet</option>
                        <option>Udupi</option>
                        <option>Ujhani</option>
                        <option>Ujjain</option>
                        <option>Ujjain</option>
                        <option>Ukhrul</option>
                        <option>Ulhasnagar</option>
                        <option>Uluberia</option>
                        <option>Una</option>
                        <option>Unjha</option>
                        <option>Unnao</option>
                        <option>Upleta</option>
                        <option>Uppal Kalan</option>
                        <option>Uran-Islampur</option>
                        <option>Uttarpara Kotru</option>
                        <option>Vadakara</option>
                        <option>Vadodara</option>
                        <option>Vallabh Vidyanagar</option>
                        <option>Valparai</option>
                        <option>Valsad</option>
                        <option>Vaniyambadi</option>
                        <option>Vapi</option>
                        <option>Varanasi</option>
                        <option>Vasad</option>
                        <option>Vasai</option>
                        <option>Veerappanchatra</option>
                        <option>Vejalpur</option>
                        <option>Vellore</option>
                        <option>Veraval</option>
                        <option>Vidisha</option>
                        <option>Vidisha</option>
                        <option>Vijalpor</option>
                        <option>Vijayawada</option>
                        <option>Viluppuram</option>
                        <option>Vinukonda</option>
                        <option>Viramgam</option>
                        <option>Virar</option>
                        <option>Virudhachalam</option>
                        <option>Virudhunagar</option>
                        <option>Visakhapatnam</option>
                        <option>Visnagar</option>
                        <option>Vizianagaram</option>
                        <option>Vrindavan</option>
                        <option>Wadhwan</option>
                        <option>Wanaparthi</option>
                        <option>Wani</option>
                        <option>Warangal</option>
                        <option>Wardha</option>
                        <option>Washim</option>
                        <option>Yadgir</option>
                        <option>Yamuna Nagar</option>
                        <option>Yavatmal</option>
                        <option>Yelahanka</option>
                        <option>Yemmiganur</option>
                        <option>pilani</option>
            </datalist>
            </div>
            <!-- <div class="form-group"><label for="name">Your password</label>
            <input type="text" name="name" class="input-md form-control" value="<?php echo $_SESSION["name"];?>">
            </div> -->
            <!-- <div class="form-group">
            <input type="text" name="poster_id" style="display:none;" class="input-md form-control" readonly value="<?php echo $poster_id;?>">
            </div> -->
            <a href="#" class="btn btn-primary pull-right" onclick="save_user_info()">Save <i class="fa fa-arrow-right"></i></a>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div><!-- Reply Modal Ends Here -->

        </article>
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
    </body>
</html>
