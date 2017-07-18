<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$db = "handybooks";
$home = "http://www.handybooks.in";
$conn = new mysqli($servername, $username, $password, $db);

//connect database here
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}
//function for sanitization of inputs
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlentities($data);
    return $data;
}
if(isset($_SESSION["user_id"])){
    $usr_id = $_SESSION["user_id"];
    $sql_ban_check = "SELECT deleted FROM users WHERE user_id=$usr_id";
    $row_ban_check = mysqli_query($conn, $sql_ban_check);
    if($extract_ban_check = mysqli_fetch_assoc($row_ban_check)){
        if($extract_ban_check["deleted"]==1){
            header("Location:auth.php");
        }
    }
}

?>
