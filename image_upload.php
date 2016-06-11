<?php
include ('files/config.php');
?>
<?php
$target_dir = "images/image_uploads/";
$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_FILES["userfile"])) {
    $check = getimagesize($_FILES["userfile"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] .".<br> ";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }
	
// Check if file already exists
//if (file_exists($target_file)) {
  //  echo "Sorry, file already exists.";
   // $uploadOk = 0;
//}
// Check file size
if ($_FILES["userfile"]["size"] > 1500000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// Allowing certain file formats
if($imageFileType != "JPG" && $imageFileType != "jpg" && $imageFileType != "PNG" && $imageFileType != "png" && $imageFileType != "JPEG" && $imageFileType != "jpeg]" && $imageFileType != "GIF" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["userfile"]["name"]). " has been uploaded.<br>";
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}
}
else {
?> 
<!DOCTYPE html>
<html>
<head>
<title>Image upload form</title>
<script>

</script>
</head>
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="1500000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="submit" />
</form>
</html>
<?php
}?>