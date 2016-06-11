<?php
include ('files/config.php');
$from_user = test_input($_SESSION['user_id']);
$msg = test_input($_REQUEST['msg']);
$to_user = test_input($_REQUEST['to_user']);

$sql1 = "INSERT INTO chats(from_user , msg, to_user, from_user_read) VALUES ('$from_user','$msg', '$to_user', 1)";
$row1 = mysqli_query($conn,$sql1);
$one=1;
$sql2 = "SELECT * FROM chats WHERE (from_user='$from_user' AND to_user='$to_user' and displayble='$one') OR (from_user='$to_user' AND to_user='$from_user' and displayble='$one') ORDER BY id DESC LIMIT 20";
$row2 = mysqli_query($conn,$sql2);
?>

<?php
      		$sql5 = "SELECT name FROM users WHERE user_id='$to_user'";
          $result5 = mysqli_query($conn,$sql5);
      		$extract5 = mysqli_fetch_assoc($result5);
      		$to_user_name=$extract5["name"];
?>

<div class="row col-sm-10">
      <h4><?php echo $to_user_name;?></h4>
        <hr>
      <div id="chat_content">
      	<?php
      	while($extract2 = mysqli_fetch_array($row2)){
      		//code0 to fetch names of users from user_ids of chats
      		$from_user_id = $extract2["from_user"];
          $sql0 = "SELECT name FROM users WHERE user_id='$from_user_id'";
      		$result0 = mysqli_query($conn,$sql0);
      		$extract0 = mysqli_fetch_assoc($result0);
      		$from_user_name=$extract0["name"];
      		//code0 ends
      		//code1 to fetch time of chats and formatting
			$time = $extract2["time"];
			$time = strtotime($time);
			$time = date("d M h:i a", $time);
			//code1 ends
      echo '<div class="row">';
      if($from_user_name==$_SESSION['name']){
            echo "<div class='alert alert-success col-md-9 pull-right' style='margin-right:20px;'><b>Me</b><br><span style='color:black;'>".$extract2["msg"]."<span class='pull-right'><small>".$time."</small></span></span></div><br>";
          }
          else{
            echo "<div class='alert alert-info col-md-9 pull-left' style='margin-left:20px;'><b>".$from_user_name."</b><br><span style='color:black;'>".$extract2["msg"]." <span class='pull-right'><small>".$time."</small></span></span></div><br>";
          }
          echo '</div>';
  		}
      	?>
      </div><hr>
      <form role="form" id="form" name="chat">
		<div class="form-group" style="display:none;">
        <input type="text" name="to_user" id="to_user" value=<?php echo $to_user;?>>
        </div>
        <div class="form-group">
        <label for="msg">Type your message here:</label>
        <textarea class="form-control"  id="msg" name="msg" ></textarea>
        </div>
        <a class="btn btn-primary pull-right" href="#" onclick="sendChat()">Submit</a><br><br>
        </form>
 </div>