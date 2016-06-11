<?php
	include ('files/config.php');
	            		if (isset($_GET["search_keyword"])){
	    					$search_keyword = test_input($_GET["search_keyword"]);
	    					if (isset($_GET["filterYear"])||(isset($_GET["filterDepartment"]))) {
	    						$opts = $_GET["filterYear"];
$opts1=$_GET["filterDepartment"];
if ($opts=="" && $opts1=="") {
    $where = " WHERE TRUE";
} 
else 
{
    $where = " WHERE";
    if ($opts1=="") {
        $where .= " post_year = '$opts'";
    } 
    else if ($opts==""){
        $where .= "  post_department = '$opts1'";
    }
    else
    {
         $where .= " post_year = '$opts'";
         $where .= " AND post_department = '$opts1'";
    }
    
}
//$where.=" AND post_name LIKE '%".$search_keyword."%' AND deleted=false";
$query = "SELECT * FROM post $where";
	    					} else {
	    						$query = "SELECT * FROM post WHERE user_id<> '0' and deleted=false AND post_name LIKE '%" . $search_keyword . "%'";
	    					}
	    					
	    						
	                        $total_pages = mysqli_num_rows(mysqli_query($conn,$query));
	                        if ($total_pages == 0){
								echo "<hr><h4>Sorry, there isn't any book post matching your search.<br /> You can <a href='book_request'>post a request</a> for this book and we will notify you once we have it in handybooks.</h4>";
							}
							else{
								if (isset($_GET["filterYear"])||(isset($_GET["filterDepartment"]))) {
									$targetpage = "search_books?filterYear=".$opts."&filterDepartment".$opts1;
								} else {
									$targetpage = "search_books?search_keyword=".$search_keyword;
								}
								
							    
	                        	$limit = 15;
		                        if(isset($_GET['page'])){
		                            $page = $_GET['page'];
		                            $start = ($page - 1) * $limit;
		                        }   
		                        else{
		                            $page = 0;
		                            $start = 0;
		                        }
		                        if (isset($_GET["filterYear"])||(isset($_GET["filterDepartment"]))) {
		                        	$sql = "SELECT * FROM post $where ORDER BY post_time DESC LIMIT $start, $limit";
		                        } else {
		                        	$sql = "SELECT * FROM post WHERE user_id<> '0' and deleted=false AND post_name LIKE '%" . $search_keyword . "%' ORDER BY post_time DESC LIMIT $start, $limit";
		                        }
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
	                            if ($posts["image_path"] != ""){
                                echo '<div class="row"><div class="col-md-2"><img src="' . $posts["image_path"] . '" width="100px" height="100px"></div>';
                            	}
                              else{
                                    echo '<div class="row"><div class="col-md-2"><i class="fa fa-book fa-5x"></i></div>';
                                }
	                            if($posts['post_author']!=""){
	                                $author = "by ".$posts["post_author"];
	                            }
	                            else{
	                                $author = "";
	                            }
	                            $user_id = $posts["user_id"];
	                            $sql_user = "SELECT * FROM users WHERE user_id='$user_id'";
	                            $row_user = mysqli_query($conn,$sql_user);
	                            $extract_user=mysqli_fetch_assoc($row_user);
	                            $user_institution = $extract_user["institution"];
	                            $user_locality = $extract_user["city"];
	                            $user_name = $extract_user["name"];
                                if($user_name!=""){
                                    $user_name = '<i class="fa fa-user"></i> Posted by: '.$user_name;
                                }
                                if($user_institution!=""){
                                    $institution= '&nbsp;&nbsp;&nbsp;<i class="fa fa-institution"></i> '.$user_institution;
                                }
                                else{
                                    $institution= "";
                                }
                                if($user_locality!=""){
                                    $user_locality= '&nbsp;&nbsp;<i class="fa fa-map-marker"></i> '.$user_locality;
                                }
                                else{
                                    $user_locality= "";
                                }
                                echo '<div class="col-md-10"><h4 style="text-transform:capitalize;"><a href='.$link.'>'.$posts['post_name']." ".$author.'</a><a href="'.$link.'"role="button" class="pull-right btn btn-xs btn-default"style="font-size: 14px;">See more</a></h4>';
                                echo '<p><small ><span class="text-success">' . $price . '</span> &nbsp;<span class="pull-right"><i class="fa fa-clock-o"></i> '.$time.'</span><br>'.$user_name.' '.$institution.' '.$user_locality.'</small></p>';

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
	                                    echo '<li class="previous"><a href="'.$targetpage.'&page='.$prev.'">Newer</a></li>';
	                                }
	                                else{
	                                    echo '<li class="previous"><a role="button" class="btn btn-default "href="'.$targetpage.'&page='.$prev.'" disabled="disabled">Newer</a></li>';
	                                }
	                                if ($page < $lastpage){
	                                    echo '<li class="next"><a href="'.$targetpage.'&page='.$next.'">Older</a></li>';
	                                }
	                                else{
	                                    echo '<li class="next"><a href="'.$targetpage.'&page='.$next.'" role="button" class="btn btn-default"disabled="disabled">Older</a></li>';
	                                }
	                            }
	                            echo '</ul>';
	    				}
	    				}
	  					else{
	    					$search_keyword = "";
	    				}
	            	?>