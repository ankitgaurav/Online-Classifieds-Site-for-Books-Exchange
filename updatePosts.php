<?php
include ('files/config.php');
// if (isset($_GET["filter"])){
// 	var_dump($_GET["filter"]);
// }
$opts = $_GET["filter"];
$opts = explode(",",$opts);
// print_r($opts);

if(in_array("", $opts)){
	$where = " WHERE TRUE";
}
else{
	$where = " WHERE FALSE";
	if(in_array("First Year", $opts)){
		$where .= " OR post_year = 'First Year'";
	}
	if(in_array("Second Year", $opts)){
		$where .= " OR post_year = 'Second Year'";
	}
	if(in_array("Third Year", $opts)){
		$where .= " OR post_year = 'Third Year'";
	}
	if(in_array("Fourth Year", $opts)){
		$where .= " OR post_year = 'Fourth Year'";
	}
	if(in_array("Fifth Year", $opts)){
		$where .= " OR post_year = 'Fifth Year'";
	}
}

$query = "SELECT * FROM post $where AND user_id<> '0' AND deleted=false";
$total_pages = mysqli_num_rows(mysqli_query($conn,$query));
                        $targetpage = "home";
                        $limit = 7;
                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                            $start = ($page - 1) * $limit;
                        }   
                        else{
                            $page = 0;
                            $start = 0;
                        }

                        $sql = "SELECT * FROM post $where AND user_id<> '0' AND deleted=false limit 6";
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
?>