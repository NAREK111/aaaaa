<?php
session_start();
include 'function/function.php';
if (!isset($_SESSION['user_id'])){
    header('location:logout.php');
}
$arr = json_array('register.json');

foreach ($arr as $key => $val){
    if ($key == $_SESSION['user_id']){

        $arr[$key]['images']['avatar']=$_GET['href'];

    }
}
array_json($arr,'register.json');
if (!copy($_GET['href'],'uplodes/img_golereya/'.$_GET['href'])) {
    echo "не удалось скопировать ...\n";
}
var_dump('uplodes/img_golereya/'.$_GET['href']);
var_dump($_GET['href']);
header("location:profil.php");