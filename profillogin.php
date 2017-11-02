<?php
session_start();
include 'function/function.php';
$arr = json_array('register.json');
foreach ($arr as $key => $value) {
    if ($value['email'] == $_POST["email"]) {
        if (password_verify($_POST['password'], $value['password'])) {
            $_SESSION['user_id'] = $key;
            header('location:profil.php');
        }
    }
}
