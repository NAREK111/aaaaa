<?php
session_start();
include 'function/function.php';

//echo "<pre>";


$target_dir = "uplodes/gallery/";
$target_file_img = uniqid() . basename($_FILES["img_gallery"]["name"]);
$target_file = $target_dir .$target_file_img;

$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if (isset($_POST["submit_gallery"])) {
    $check = getimagesize($_FILES["img_gallery"]["tmp_name"]);
    if ($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";

        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["img_gallery"]["size"] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

    // die($_FILES["images"]["tmp_name"]);
    if (move_uploaded_file($_FILES["img_gallery"]["tmp_name"], $target_file)) {
        $arr = json_array("register.json");


        foreach ($arr as $key => $value) {
            if ($key == $_SESSION['user_id']) {

                if (empty($arr[$key]['images']['gallery'])) {
                    $arr[$key]['images']['gallery'] = [];
                }
                $gallery = $arr[$key]['images']['gallery'];

              //  array_push($gallery ,$target_file);
       /*         echo '<pre>';
var_dump($gallery);*/
                if ( $gallery==null){
                    $id ="0";
                }else {
                    end($gallery);
                    $id = key($gallery) + 1;
                }
                $arr[$key]['images']['gallery'][$id] = $target_file_img;
                $cod = json_encode($arr);
                file_put_contents("register.json", $cod);
                header('location:gallery.php');
            }
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
