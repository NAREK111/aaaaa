<?php
session_start();
include 'function/function.php';
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');die();
}
$arr = json_array('register.json');

if(file_exists($_GET['href'])){
    $gallery = $arr[$_SESSION['user_id']]['images']['gallery'];
  //  var_dump($gallery);
foreach ($gallery as $key=> $val){
    if ($val==$_GET['href']){
        unset($arr[$_SESSION['user_id']]['images']['gallery'][$key]);
        array_json($arr,'register.json');
    }
}
    unlink($_GET['href']);
    header('location:gallery.php');die();

}