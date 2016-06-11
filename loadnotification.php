<?php
	include 'files/config.php';
	if (isset($_SESSION['user_id'])) {
		if (isset($_REQUEST['tag'])){
			$user_id=test_input($_SESSION['user_id']);
			$tag=test_input($_REQUEST['tag']);
			$sql10="SELECT * FROM notification WHERE user_id='$user_id' and tag='$tag'";
			$result10=mysqli_query($conn,$sql10);
			while($row10=mysqli_fetch_assoc($result10)){
			$notification=$row10['notification'];
   				$time = $row10["time"];
				$time = strtotime($time);
				$time = date("d M h:i a", $time);
   				if ($row10['tag']=="book_request") {
   					echo '
   					<div class="row notification_container">
   						<div class="col-md-1 col-icons">
   							<span class="icons"><i class="fa fa-comments-o fa-2x"></i></span>
   						</div>
   						<div class="col-md-11 col-content">
   							<h4><strong>You recieved a book request</strong></h4>
   							<p>
   								'.$notification.' <a href="messages.php">messages</a><br>
   								<span class="display_time"><i class="fa fa-clock-o"></i>'.$time.'</span>
   							</p>
   						</div>
   					</div>

   					';
   				}
   				
   				else
   				{
   					
   				}
            }
			}
		}
	else
	{
		header("location:index.php");
	}


?>