<?php
include "files/config.php";
$text=$_GET["search_text"];
$text = trim($text);
$text = stripslashes($text);
$text = htmlspecialchars($text);

if($text!=""){
	echo "<table class='table'>";
echo "<style>td a:hover{background-color:#F8F8F8;text-decoration:none;}</style>";
$query = "SELECT * FROM post WHERE `user_id`<>0 AND `deleted`=0  AND `post_name` LIKE '%$text%' OR `post_author` LIKE '%$text%' LIMIT 5";
$results=mysqli_query($conn, $query) or die('no connection');
while($rows=mysqli_fetch_assoc($results)){
		$link_key = $rows['post_name'];
		$link= "search_books?search_keyword=$link_key";
		$result_string = $rows["post_name"];
		if($rows["post_author"]!=""){
			$result_string .= " by ".$rows["post_author"]; 
		}
	echo "<tr><td><a href= '$link' style='display:block; padding:5px;'>".$result_string."</a></td></tr>";
}
    echo "<table/>";
}

?>