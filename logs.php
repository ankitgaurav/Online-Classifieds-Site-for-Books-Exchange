<?php
include 'files/config.php';
$from_user_id = test_input($_SESSION["user_id"]);
$to_user_id = test_input($_REQUEST["to_user"]);
$_SESSION["to_user_id"] = $to_user_id;
$one=1;
$sql50 = "UPDATE chats SET to_user_read=1 WHERE from_user='$to_user_id'  and to_user='$from_user_id' and to_user_read=0";
$result50= mysqli_query($conn,$sql50) or mysqli_error($conn);
$sql1 = "SELECT * FROM chats WHERE (from_user='$from_user_id' AND to_user='$to_user_id' and displayble='$one') OR (from_user='$to_user_id' AND to_user='$from_user_id' and displayble='$one') ORDER BY id DESC LIMIT 20";
$result1 = mysqli_query($conn,$sql1) or mysqli_error($conn);
//getting names of message senders
$sql5 = "SELECT name FROM users WHERE user_id='$to_user_id'";
$result5 = mysqli_query($conn,$sql5);
$extract5 = mysqli_fetch_assoc($result5);
$to_user_name=$extract5["name"];
?>

<div class="row col-sm-10">
      <h4><?php echo $to_user_name;?></h4>
        <hr>
      <div id="chat_content">
      	<?php
      	while($extract1= mysqli_fetch_assoc($result1)){
      		//code0 to fetch names of users table from user_ids of chats table
      		$from_user_id = $extract1["from_user"];
          $sql0 = "SELECT name FROM users WHERE user_id='$from_user_id'";
      		$result0 = mysqli_query($conn,$sql0);
      		$extract0 = mysqli_fetch_assoc($result0);
      		$from_user_name=$extract0["name"];
      		//code0 ends
      		//code1 to fetch time of chats and formatting
    			$time = $extract1["time"];
    			$time = strtotime($time);
    			$time = date("d M h:i a", $time);
          //code1 ends
          echo '<div class="row">';
          if($from_user_name==$_SESSION['name']){
            echo "<div class='alert alert-success col-md-9 pull-right' style='margin-right:20px;'><b>Me</b><br><span style='color:black;'>".$extract1["msg"]."<span class='pull-right'><small>".$time."</small></span></span></div><br>";
          }
          else{
            echo "<div class='alert alert-info col-md-9 pull-left' style='margin-left:20px;'><b>".$from_user_name."</b><br><span style='color:black;'>".$extract1["msg"]." <span class='pull-right'><small>".$time."</small></span></span></div><br>";
          }
          echo '</div>';
  			
  		}
      	?>
      </div><hr>
      <form role="form" name="chat">
		<div class="form-group" style="display:none;">
        <input type="text" name="to_user" value=<?php echo $_SESSION['to_user_id'];?>>
        </div>
        <div class="form-group">
        <label for="msg">Type your message here:</label>
                <textarea class="form-control"  id="msg" name="msg"></textarea> 

<!--         <textarea class="form-control" rows=3 id="msg" name="msg"></textarea>
 -->        </div>
        <a class="btn btn-primary pull-right" href="#" onclick="sendChat()">Submit</a><br><br>
        </form>
 </div>