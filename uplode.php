<?php
session_start();
include 'function/function.php';

//echo "<pre>";

//var_dump($_FILES);
$target_dir = "uplodes/img_golereya/";
$target_file = $target_dir .uniqid(). basename($_FILES["images"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

if(isset($_POST["submit"])) {
    //var_dump($_FILES["images"]);
    if ($_FILES["images"]["size"] == 0){

        }

    $check = getimagesize($_FILES["images"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";

        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["images"]["size"] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

    // die($_FILES["images"]["tmp_name"]);
    if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
$arr = json_array("register.json");
        foreach ($arr as $key => $value){
            if ($key == $_SESSION['user_id']){
                if(!empty($arr[$key]['images']['avatar'])){
                    unlink($arr[$key]['images']['avatar']);
                }
                $arr[$key]['images']['avatar']=$target_file;
                $cod = json_encode($arr);
                file_put_contents("register.json", $cod);
                header('location:profil.php');
            }
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
