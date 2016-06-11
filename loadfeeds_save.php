<?php
include 'files/config.php';
if (isset($_GET['category'])) {
    $post_department= $_GET['category'];
    $query = "SELECT * FROM post WHERE user_id<> '0' and (post_department='$post_department' or post_department='Any Branch') and deleted=false";
    $total_pages = mysqli_num_rows(mysqli_query($conn,$query));
    $targetpage = "home";
    $limit = 5;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        $start = ($page - 1) * $limit;
    }   
    else{
        $page = 0;
        $start = 0;
    }
    $sql= "SELECT * FROM post WHERE user_id<> '0' and (post_department='$post_department' or post_department='Any Branch') and deleted=false ORDER BY post_time DESC LIMIT $start, $limit";
}
else{
    $query = "SELECT * FROM post WHERE user_id<> '0' and deleted=false";
    $total_pages = mysqli_num_rows(mysqli_query($conn,$query));
    $targetpage = "home";
    $limit = 5;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        $start = ($page - 1) * $limit;
    }   
    else{
        $page = 0;
        $start = 0;
    }
    $sql= "SELECT * FROM post WHERE user_id<> '0' and deleted=false ORDER BY post_time DESC LIMIT $start, $limit";
}
$row = mysqli_query($conn, $sql);
echo '<p>Category: '.$post_department.'</p>';
while ($posts = mysqli_fetch_assoc($row)) {
    $link = 'book_details?p_id=' . $posts["post_id"];
    if ($posts["post_type"] == "donate") {
        $price = "Free: On Donate";
    } elseif ($posts["post_type"] == "exchange") {
        $price = "On Exchange";
    } else {
        $price = "On sale for Rs. " . $posts["post_price"];
    }
    $author="";
    $time = $posts["post_time"];
    $time = strtotime($time);
    $time = "Posted on ".date("jS M", $time);
    echo "<div style='display:block;' href='$link' class='latest_posts alert alert-default'>";
    if ($posts['post_category'] == "Academic" or $posts['post_category'] == "uncategorized") {
        echo '<div class="row"><div class="col-md-2"><i class="fa fa-5x fa-leanpub" style="color:#777777"></i></div>';
    } elseif ($posts['post_category'] == "Novel") {
        echo '<div class="row"><div class="col-md-2"><i class="fa fa-5x fa-book" style="color:#7C6F62;"></i></div>';
    } else {
        echo '<div class="row"><div class="col-md-2"><i class="fa fa-5x fa-newspaper-o"></i></div>';
    }
    if ($posts['post_author'] != "") {
        $author = "by " . $posts["post_author"];
    }
    echo '<div class="col-md-10"><p><h4 class="capitalize"><a href=' . $link . '>' . $posts['post_name'] . " " . $author . '</a><a href="' . $link . '"role="button" class="pull-right btn btn-xs btn-default"style="font-size: 14px;">See more</a></h4><p>';
    echo '<p><small class="text-success">' . $price . '<span class="pull-right"><i class="fa fa-clock-o"></i> '.$time.'</span></small></p>';
    
    //block for creating the tags string starts here
    $tags = "";
    if ($posts['post_genre'] != "") {
        $tags = $posts['post_genre'] . ", ";
    }
    if ($posts["post_subject"] != "") {
        $tags = $tags . $posts["post_subject"] . ", ";
    }
    if ($posts["post_department"] != "") {
        $tags = $tags . $posts["post_department"] . ", ";
    }
    if ($posts['post_category'] != "") {
        $tags = $tags . $posts["post_category"] . ", ";
    }
    if ($posts['post_class'] != "") {
        $tags = $tags . $posts["post_class"] . ", ";
    }
    if ($posts['post_subject'] != "") {
        $tags = $tags . $posts["post_subject"] . ", ";
    }
    if ($posts['post_year'] != "") {
        $tags = $tags . $posts["post_year"] . ", ";
    }
    //tags string creation ends here
    echo "<small style='color: #7d7d7d'>Tags: </small>" . $tags;
    if ($posts["post_description"] != "") {
        echo "<br><small style='color: #7d7d7d'>Description:</small> " . $posts["post_description"] . "<br>";
    }
    // echo "<div class='pull-right text-success'>".$price."</div>";
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
    if ($page < $lastpage) 
        echo '<li class="next"><a href="'.$targetpage.'?page='.$next.'">Older</a></li>';
    else
        echo '<li class="next"><a href="'.$targetpage.'?page='.$next.'" role="button" class="btn btn-default"disabled="disabled">Older</a></li>';
}
    echo '</ul>';
?>