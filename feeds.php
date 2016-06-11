<?php 
include 'files/config.php';
if(isset($_SESSION[ 'user_id'])){
    $user_id=$_SESSION[ "user_id"];
    $sql53="SELECT * FROM users WHERE `user_id`='$user_id'" ;
    $row53=mysqli_query($conn,$sql53);
    $user_info=mysqli_fetch_assoc($row53);
    if(isset($_SESSION[ 'user_id'])){
        $one=1;$user_id=$_SESSION[ "user_id"];
        $sql190="SELECT * FROM chats WHERE (to_user='$user_id' and displayble='$one' and to_user_read=0) " ;
        $result190=mysqli_query($conn,$sql190)or mysqli_error($conn);
        $_SESSION[ 'no_of_unread_msg']=mysqli_num_rows($result190);
        $no_of_msg=$_SESSION[ 'no_of_unread_msg'];
        }
        else{
            $no_of_msg=0;
        }
    }
?>
<!DOCTYPE html>
<html lang=en>

<head>
    <title>Handybooks.in - Feeds</title>
    <meta charset=utf-8>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta property=og:url content=http://www.handybooks.in/ />
    <meta property=og:type content=website />
    <meta property=og:title content="The best place to exchange second hand books" />
    <meta property=og:description content="Buy, Sell, Donate and Exchange second hand easily in Handybooks.in. You can sell your old books or buy a second hand book easiy with handybooks.in " />
    <meta property=og:image content=http://handybooks.in/images/logo.png />
    <link rel=stylesheet href=bootstrap.min.css>
    <link rel=stylesheet href=styles/default_lp.css>
    <link rel=stylesheet href="footer.css">

    <link rel=stylesheet href=//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css>
    <style type=text/css>
        #request_div {
            display: block;
            height: auto;
            overflow-y: scroll;
            overflow-x: hidden
        }
        #rater_name {
            display: none
        }
        #hints{
            background-color: white;
            border: 1px #CCCCCC solid;
            border-radius: 5px;
            position: absolute;
            width: 100%;
            display: none;
            z-index: 999;
        }
        a .txt_decor_no hover {
            text-decoration: none
        }
    </style>
    <script src=jquery-1.11.2.min.js></script>
    <script src=bootstrap.min.js></script>
    <script>
        function save_user_info() {
            var b = edit_form.name.value;
            var d = edit_form.institution.value;
            var e = edit_form.city.value;
            var a = "feeds";
            var c = new XMLHttpRequest();
            c.onreadystatechange = function() {
                if (c.readyState == 4 && c.status == 200) {
                    document.getElementById("modal-body").innerHTML = c.responseText
                }
            };
            c.open("POST", "process_save_user_info.php?name=" + b + "&institution=" + d + "&city=" + e + "&from=" + a, true);
            c.send()
        }
    </script>
    <script type=text/javascript></script>
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
        <div class=container>
            <div class="navbar-header">
                <button type=button class=navbar-toggle data-toggle=collapse data-target=#myNavbar> <span class=icon-bar></span> <span class=icon-bar></span> <span class=icon-bar></span> </button>
                <a href=home onmouseover="document.getElementById('in').style.visibility='visible'" onmouseout="document.getElementById('in').style.visibility='hidden'" class=logo_text> <strong>handybooks</strong> <small id=in style=visibility:hidden>.in</small> </a>
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
            <div class="collapse navbar-collapse" id=myNavbar>
                <ul class="nav navbar-nav navbar-right">
                    <li class=active><a href=home><i class="fa fa-home"></i> Home </a>
                    </li>
                    <?php if(isset($_SESSION[ "user_id"])){echo '<li><a href="messages"><i class="fa fa-comments"></i> Messages';if($no_of_msg){echo "<span class='badge'>".$no_of_msg. "</span>";};echo '</a></li>        
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> '.$_SESSION[ "name"]. '<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="dashboard">Profile</a></li>
            <li><a href="dashboard?to=transactions">Transactions</a></li>
            <li><a href="dashboard?to=book_requests">Book Requests</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="auth.php">Logout</a></li>
          </ul>
        </li>';}
        else{echo '<li class="dropdown" id="signup_btn">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> Sign In<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">Existing User</li>
            <li><a href="login.php">Log In</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">New User</li>
            <li><a href="signup">Register</a></li>
          </ul>
        </li>';}?> </ul>
            </div>

        </div>
    </nav>
    <div class="container container1">
        <div class=row>
            <div class=col-md-9>
                <!-- <div class=row>
                    <div class="col-md-8 col-md-offset-2">
                        <form class="form-search" action="search_books" method="GET">
                            <div class="row">
                                <div class="input-group input-group-lg" id=search_box>
                                    <input type=text name=search_keyword placeholder="Search any second hand book here" onkeyup="showHint(this.value)" class="form-control" onfocus="show_hints()" required autocomplete="off"> <span class=input-group-btn> <button class="btn btn-default btn-lg btn-primary" type=submit> <i class="fa fa-search"></i> Search </button> </span> </div>
                            </div>
                            <div class=row id="hints"></div>
                        </form>
                    </div>
                </div> -->
                <div class=row>
                    <div class=col-md-11>
                        <br>
                        <h4> Latest Book Posts &nbsp; On Sale &nbsp; Wanted books</h4>
                        <hr>
                        <?php
                    //for pagination and displaying latest posts
                        $query = "SELECT * FROM post WHERE user_id<> '0' and deleted=false";
                        $total_pages = mysqli_num_rows(mysqli_query($conn,$query));
                        $targetpage = "feeds";
                        $limit = 7;
                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                            $start = ($page - 1) * $limit;
                        }   
                        else{
                            $page = 0;
                            $start = 0;
                        }

                        $sql = "SELECT * FROM post WHERE user_id<> '0' and deleted=false ORDER BY post_time DESC LIMIT $start, $limit";
                        $row = mysqli_query($conn,$sql);
                        while($posts = mysqli_fetch_assoc($row)){
                            $link='book_details?p_id='.$posts["post_id"];
                             if($posts["post_type"]=="donate"){
                                $price = "Free: On Donate";
                            }
                            elseif ($posts["post_type"]=="exchange") {
                                $price = "On Exchange";
                            }
                            else{
                                $price = "On sale for &nbsp;<i class='fa fa-inr'></i>' ".$posts["post_price"];
                            }

                            $time = $posts["post_time"];
                            $time = strtotime($time);
                            $time = " ".date("jS M", $time);

                            echo "<div style='display:block;' href='$link' class='latest_posts alert alert-default'>";
                            if ($posts['post_category']=="Academic" or $posts['post_category']=="uncategorized") {
                                echo '<div class="row"><div class="col-md-2"><i class="fa fa-5x fa-leanpub" style="color:#777777"></i></div>';
                            } 
                            elseif($posts['post_category']=="Novel"){
                                echo '<div class="row"><div class="col-md-2"><i class="fa fa-5x fa-book" style="color:#7C6F62;"></i></div>';
                            }
                            else{
                                echo '<div class="row"><div class="col-md-2"><i class="fa fa-5x fa-newspaper-o"></i></div>';
                            }
                            if($posts['post_author']!=""){
                                $author = "by ".$posts["post_author"];
                            }
                            else{
                                $author = "";
                            }
                            $user_id = $posts["user_id"];
                            if($user_id==1){
                                $hb = 1;
                                echo '<div class="col-md-10"><h4 style="text-transform:capitalize;"><a href='.$link.'>'.$posts['post_name']." ".$author.'</a> <a href="#" data-toggle="tooltip" title="Handybooks Verified Seller" data-placement="top"><span class="text-primary fa-stack" style="font-size:10px;"><i class="fa fa-certificate fa-stack-2x"></i><i class="fa fa-check fa-stack-1x fa-inverse "></i></span></a><a href="'.$link.'"role="button" class="pull-right btn btn-xs btn-default"style="font-size: 14px;">See more</a></h4>';
                                echo '<p><small >Sold by: <span class="text-success">Handybooks at 50% of MRP</span> &nbsp;<span class="pull-right"><i class="fa fa-clock-o"></i> '.$time.'</span><br></small></p>';
                            }
                            else{
                                $hb = 0;
                                $sql_user = "SELECT * FROM users WHERE user_id='$user_id'";
                                $row_user = mysqli_query($conn,$sql_user);
                                $extract_user=mysqli_fetch_assoc($row_user);
                                $user_institution = $extract_user["institution"];
                                $user_locality = $extract_user["city"];
                                if($user_institution!=""){
                                    $institution= " ".$user_institution;
                                }
                                else{
                                    $institution= "";
                                }
                                if($user_locality!=""){
                                    $user_locality= " ".$user_locality;
                                }
                                else{
                                    $user_locality= "";
                                }
                                echo '<div class="col-md-10"><h4 style="text-transform:capitalize;"><a href='.$link.'>'.$posts['post_name']." ".$author.'</a><a href="'.$link.'"role="button" class="pull-right btn btn-xs btn-default"style="font-size: 14px;">See more</a></h4>';
                                echo '<p><small ><span class="text-success">' . $price . '</span> &nbsp;<span class="pull-right"><i class="fa fa-clock-o"></i> '.$time.'</span><br><i class="fa fa-institution"></i> '.$institution.' &nbsp;&nbsp;<i class="fa fa-map-marker"></i> '.$user_locality.'</small></p>';
                            }
                            

                                //block for creating the tags string starts here
                                $tags = "";
                                if($posts['post_genre']!=""){
                                    $tags = $posts['post_genre'].", ";
                                }
                                if ($posts["post_subject"]!="") {
                                    $tags = $tags.$posts["post_subject"].", ";
                                }
                                if ($posts["post_department"]!="") {
                                    $tags = $tags.$posts["post_department"].", ";
                                }
                                if($posts['post_category']!=""){
                                    $tags = $tags.$posts["post_category"].", ";
                                }
                                if ($posts['post_class']!="") {
                                    $tags = $tags.$posts["post_class"].", ";
                                }
                                if($posts['post_subject']!=""){
                                    $tags = $tags.$posts["post_subject"].", ";
                                }
                                if($posts['post_year']!=""){
                                    $tags = $tags.$posts["post_year"].", ";
                                }
                                if($tags!=""){
                                    $tags = "<i class='fa fa-tags'></i> ".$tags;
                                }
                                //tags string creation ends here
                                echo $tags;
                                if($posts["post_description"]!=""){
                                    echo "<p>Description: ".$posts['post_description']."</p>";
                                }
                                echo "</div></div></div>";
                            }
                            echo '<ul class="pager">';
                            if ($page == 0) $page = 1;
                            $prev = $page - 1;
                            $next = $page + 1; 
                            $lastpage = ceil($total_pages/$limit);
                            $lpm1 = $lastpage - 1;
                            $pagination = "";
                            if($lastpage > 1)
                            { 
                                if($page>1){
                                    echo '<li class="previous"><a href="'.$targetpage.'?page='.$prev.'">Newer</a></li>';
                                }
                                else{
                                    echo '<li class="previous"><a role="button" class="btn btn-default "href="'.$targetpage.'?page='.$prev.'" disabled="disabled">Newer</a></li>';
                                }
                                if ($page < $lastpage){
                                    echo '<li class="next"><a href="'.$targetpage.'?page='.$next.'">Older</a></li>';
                                }
                                else{
                                    echo '<li class="next"><a href="'.$targetpage.'?page='.$next.'" role="button" class="btn btn-default"disabled="disabled">Older</a></li>';
                                }
                            }
                            echo '</ul>';
                    ?> </div>
                </div>
            </div>
            <div class=col-md-3>
                <?php if(isset($_SESSION[ 'user_id'])){$user_id_pc=$_SESSION[ "user_id"];$sql_pc="SELECT * FROM users WHERE user_id='$user_id_pc'" ;$row_pc=mysqli_query($conn,$sql_pc);$extract_pc=mysqli_fetch_assoc($row_pc);if($extract_pc[ "name"]=="" &&$extract_pc[ "city"]=="" &&$extract_pc[ "institution"]=="" ){echo '
            <div id="profile completeness" class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your Profile completeness:<br><br>
                <div class="progress">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:25%;color:black;">25% Complete
                    </div>
                </div>
                <a role="button" class="btn btn-xs btn-default " href="#" data-toggle="modal" data-target="#edit_modal">Complete now</a>
            </div>';}elseif(($extract_pc[ "name"]=="" and $extract_pc[ "city"]=="" )or($extract_pc[ "name"]=="" and $extract_pc[ "institution"]=="" )or($extract_pc[ "city"]=="" and $extract_pc[ "institution"]=="" )){echo '
            <div id="profile completeness" class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your Profile Completeness:<br><br>
                <div class="progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;color:black;">50% Complete
                    </div>
                </div>
                <a role="button" class="btn btn-xs btn-default " href="#" data-toggle="modal" data-target="#edit_modal">Complete now</a>
            </div>';}elseif($extract_pc[ "name"]=="" or $extract_pc[ "city"]==="" or $extract_pc[ "institution"]=="" ){echo '
            <div id="profile completeness" class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your Profile Completeness:<br><br>
                <div class="progress">
                    <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%;color:black;">75% Complete
                    </div>
                </div>
                <a role="button" class="btn btn-xs btn-default " href="#" data-toggle="modal" data-target="#edit_modal">Complete now</a>
            </div>';}}?>
                <h3 style=display:none>Book Requests</h3>
                <div style=display:none id=request_div>
                    <?php $sql52="SELECT * FROM requests LIMIT 6" ;$row52=mysqli_query($conn,$sql52);while($extract52=mysqli_fetch_assoc($row52)){echo '<div class="requests" style="display: block;
    border-bottom: 1px solid #EEEEEE; margin-bottom:5px; padding-bottom:3px;"><strong>'.$extract52[ "req_name"]. '</strong><br>'.$extract52[ "req_description"]. '</div>';}?> </div>
                <br> 
                <!-- <a role=button href=post_a_book class="btn btn-success btn-xs btn-block"><h4>Post a Free Ad for your book</h4></a> -->
                <div style="margin-top:10px;padding:10px;border:1px #eee solid;border-radius:3px;height:auto;width:100%">
                    <h3 class="text-success">What keeps you waiting?</h3>
                    <ul id=to_do_div style=list-style:none;padding-left:0>
                        <li> <i class="fa fa-check-circle fa-2x"></i><a class=txt_decor_no href="post_a_book">&nbsp;&nbsp;<span style=font-size:18px>Sell Your Used Books</span> </a> </li>
                        <br>
                        <li> <i class="fa fa-check-circle fa-2x"></i>
                            <a class=txt_decor_no href="book_request">&nbsp;&nbsp;<span style=font-size:18px>Request some old books</span>
                            </a>
                        </li>
                        <br>
                        <!-- <li> <i class="fa fa-check-circle fa-2x"></i>
                            <a class=txt_decor_no href="book_request">&nbsp;&nbsp;<span style=font-size:18px>Sell Your Used Books</span>
                            </a>
                        </li> -->
                    </ul>
                </div>
                <div id=rating_div style="margin-top:10px;padding:10px;border:1px #eee solid;border-radius:3px;height:auto;width:100%">
                    <h4>Like handybooks facebook page</h4>
                    <div class="fb-page" data-href="https://www.facebook.com/handybooks.in" data-height="220" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/handybooks.in"><a href="https://www.facebook.com/handybooks.in">handybooks.in</a></blockquote></div></div>
                    <?php if(isset($rating)){echo '<h4>Rate handybooks</h4>';echo '
                        <a href="#" onclick="rating(1)"><i class="fa fa-star"></i></a>
                        <a href="#" onclick="rating(2)"><i class="fa fa-star"></i></a>
                        <a href="#" onclick="rating(3)"><i class="fa fa-star"></i></a>
                        <a href="#" onclick="rating(4)"><i class="fa fa-star"></i></a>
                        <a href="#" onclick="rating(5)"><i class="fa fa-star"></i></a>';}?>
                    <div id=rater_name>
                        <form name=rating_form>
                            <input>
                            <div class=input-group>
                                <input name=name class=form-control placeholder="Tell us your name" autofocus> <span class=input-group-btn><a role=button class="btn btn-primary">save</a></span> </div>
                        </form>
                    </div>
                </div>
                <br>
                <div id=edit_modal class="modal fade" role=dialog>
                    <div class="modal-dialog modal-md">
                        <div class=modal-content>
                            <div class=modal-header>
                                <button type=button class=close data-dismiss=modal>&times;</button>
                                <h4 class=modal-title>Edit your profile info</h4> </div>
                            <div class=modal-body id=modal-body>
                                <form role=form name=edit_form>
                                    <div class=form-group>
                                        <label for=name>Your name</label>
                                        <input type=text name=name class="input-md form-control" value=<?php echo $_SESSION[ "name"];?>> </div>
                                    <div class=form-group>
                                        <label for=institution>Your school/college</label>
                                        <input id=institution list=institutions name=institution class=form-control value=<?php echo $user_info[ "institution"];?>>
                                        <datalist id=institutions>
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
                                    </div>
                                    <div class=form-group>
                                        <label for=city>Your city</label>
                                        <input name=city id=city class=form-control list=cities value=<?php echo $user_info[ "city"];?>>
                                        <datalist id=cities>
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
                                            <option>Coopers Camp N</option>
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
                                    </div> <a href=# class="btn btn-primary pull-right" onclick=save_user_info()>Save <i class="fa fa-arrow-right"></i></a> </form>
                            </div>
                            <div class=modal-footer> </div>
                        </div>
                    </div>
                </div>
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
                <a href="home" onmouseover="document.getElementsByClassName(" in ").style.visibility='visible'" onmouseout="document.getElementsByClassName(" in ").style.visibility='hidden'" class="logo_text">
                    <strong>handybooks</strong>
                    <small class="in">.in</small>
                </a>
                <i>Happy Reading...</i>
            </div>
        </div>
    </div>
<script src="js/show_hints.js"></script>

</body>

</html>