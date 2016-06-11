<?php include("files/config.php");
if(isset($_POST["name"])&&$_POST['name']!=""){$name=test_input($_POST["name"]);$city=test_input($_POST["city"]);$phone=test_input($_POST["phone"]);$institution=test_input($_POST["institution"]);$user=$_SESSION["user_id"];$sql11="UPDATE users SET name='$name', city='$city', institution='$institution', phone='$phone' WHERE user_id='$user'";$result11=mysqli_query($conn,$sql11)or die(mysqli_error($conn));header('Location:dashboard.php?msg=ad_posted&p_id='.$_SESSION["last_post_id"].'&to=transactions');}elseif(isset($_POST["email"])){if($_POST["email"]!="" or $_POST["password"]!=""){$email=test_input($_POST["email"]);$password=test_input($_POST["password"]);$sql20="SELECT * FROM users WHERE email='$email'";$row20=mysqli_query($conn,$sql20);if(mysqli_num_rows($row20)!=0){$extract20=mysqli_fetch_assoc($row20);if(password_verify($password,$extract20["hash"])){$sql50="SELECT * FROM users WHERE email='$email'";$row50=mysqli_query($conn,$sql50);$extract50=mysqli_fetch_assoc($row50);$_SESSION["name"]=$extract50["name"];$_SESSION["user_id"]=$extract50["user_id"];$_SESSION["email"]=$extract50["email"];$user_id=$_SESSION['user_id'];$last_post_id=$_SESSION['last_post_id'];$sql60="UPDATE post SET user_id = '$user_id' WHERE post_id = '$last_post_id'";$row60=mysqli_query($conn,$sql60);header('Location:dashboard.php?to=transactions&msg=ad_posted&last_p_id='.$last_post_id);}else{echo "Email has been registered with different password.<br>Please enter correct password or login with another email.";}}else{$password=password_hash($password,PASSWORD_DEFAULT);$sql30="INSERT INTO users(email, hash) VALUES ('$email','$password')";$result30=mysqli_query($conn,$sql30);$sql40="SELECT * FROM users WHERE email='$email'";$row40=mysqli_query($conn,$sql40);$extract40=mysqli_fetch_assoc($row40);$_SESSION["name"]=$extract40["name"];$_SESSION["user_id"]=$extract40["user_id"];$_SESSION["email"]=$extract40["email"];$user_id=$_SESSION['user_id'];$last_post_id=$_SESSION['last_post_id'];$sql70="UPDATE post SET user_id = '$user_id' WHERE post_id = '$last_post_id'";$row70=mysqli_query($conn,$sql70);header('Location:dashboard.php?to=transactions&msg=ad_posted');}}else{echo "both email and password are required";}}?> <!DOCTYPE html> <html lang=en> <head> <title>Post ad step 2</title> <meta charset=utf-8> <meta name=viewport content="width=device-width, initial-scale=1"> <link rel=stylesheet href=bootstrap.min.css> <link rel=stylesheet href=styles/default_lp.css><link rel=stylesheet href=//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css> <script src=jquery-1.11.2.min.js></script> <script src=bootstrap.min.js></script> <script>function on_m_dn(){document.getElementById("password").type="text"}function on_m_up(){document.getElementById("password").type="password"};</script> </head> <body> <nav class="navbar navbar-default"> <div class=container> <div class=navbar-header> <a href=index.php onmouseover="document.getElementById('in').style.visibility='visible'" onmouseout="document.getElementById('in').style.visibility='hidden'" class=logo_text><strong>handybooks</strong><small id=in style=visibility:hidden>.in</small></a> </div> <div> <ul class="nav navbar-nav navbar-right"> <li><a href=index.php><i class="fa fa-home"></i> Home</a></li> </ul> </div> </div> </nav> <div class=container> <div class=row> <div class="col-sm-6 col-sm-offset-3"> <div class="panel panel-success"> <div class=panel-heading><h3><strong>Just one more step</strong></h3></div> <div class=panel-body> <div class=row> <div class="col-sm-8 col-sm-offset-2"> <?php if(isset($_SESSION["user_id"])){$sql10="SELECT * FROM users WHERE user_id='$_SESSION[user_id]'";$row10=mysqli_query($conn,$sql10);$extract10=mysqli_fetch_assoc($row10);$user_name=$extract10["name"];$user_institution=$extract10["institution"];$user_city=$extract10["city"];echo '<form role="form" action='.htmlspecialchars($_SERVER["PHP_SELF"]).' method="post">
                <div class="form-group"><label for="name">Your Name</label>                
                    <input id="name" class="input-md col-lg-2 form-control" type="text" placeholder="Name" name="name" required value="'.$user_name.'">
                </div>
                <div class="form-group"><label for="institution">Your Institution</label><input id="institution" class="input-md col-lg-2 form-control" type="text" placeholder="institution" name="institution" value="'.$user_institution.'">
                </div>
                <div class="form-group"><label for="city">Your Locality</label>
                    <input id="city" class="input-md col-lg-2 form-control" type="text" placeholder="City" name="city"  value="'.$user_city.'">
                </div>
                <div class="form-group"><label for="phone">Your Phone Number</label>
                    <input id="phone" class="input-md col-lg-2 form-control" type="text" placeholder="Phone (Optional)" name="phone"  value="'.$user_phone.'">
                </div><br><br>
                <div class="form-group">
                <button type="submit" class="btn btn-info btn-md" value="Signup">Post ad &nbsp;<i class="fa fa-arrow-right"></i></button>
            </form>';}else{echo '<form role="form" action='.htmlspecialchars($_SERVER["PHP_SELF"]).' method="post">
                <div class="form-group"><label for="name">Your email</label>                
                    <input id="email" class="input-md col-lg-2 form-control" type="email" placeholder="Email" name="email" autofocus required>
                </div>
                <div class="form-group"><label for="institution">Choose a password</label>
                <div class="input-group"><input id="password" class="input-md col-lg-2 form-control" type="password" placeholder="password" name="password"><span class="input-group-btn"><button onmouseup="on_m_up()" onmousedown="on_m_dn()" class="btn btn-default" id="show_password" type="button"><small>show</small></button></span>
                    </div>
                </div>
                <div class="form-group">
                <button type="submit" class="btn btn-info btn-md" value="Signup & post ad">Post ad &nbsp;<i class="fa fa-arrow-right"></i></button>
            </form>';}?> </div> </div> </div> </div></div> </div></div></div>
            <div id="footer">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12" id="footer-main" style="width:100%">
                <ul> 
                    <li>
                        <a href=<?php echo htmlspecialchars('about_us');?>>:: About Us ::</a>
                    </li> 
                    <li>
                        <a href=<?php echo htmlspecialchars('about_us');?>>The Story ::</a></li> 
                    <li>
                        <a href=<?php echo htmlspecialchars('terms');?>>Terms ::</a>
                    </li> 
                    <li>
                        <a href=<?php echo htmlspecialchars('terms');?>>Privacy Policy ::</a>
                    </li> 
                    <li>
                        <a href="https://www.facebook.com/handybooks"><i class="fa fa-1x fa-facebook"></i>
                    </li>
                </ul> 
                
            
            </div>
        </div>
             </body> </html>