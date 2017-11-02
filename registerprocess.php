<?php
session_start();
include 'function/function.php';
$error = 0;
if (isset($_POST["submit"])) {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $arr = json_array("register.json");
            if ($arr != null) {
                foreach ($arr as $value) {
                    if ($value['email'] == $_POST['email']) {
                        $_SESSION['error_mail1_repeat']="this email has already been used";
                        $error++;
                    } else {
                        unset( $_SESSION['error_mail1_repeat']);
                        unset( $_SESSION['error_mail1_valid']);
                        unset( $_SESSION['error_mail']);
                        $_SESSION['email'] = $_POST['email'];
                    }
                }
            }
        } else {
            $_SESSION['error_mail1_valid']="not a valid";
            $error++;
        }
    } else {
        $_SESSION['error_mail']= "This field is required";
        $error++;
    }

    if (isset($_POST['first_name']) && !empty($_POST['first_name'])) {
        unset($_SESSION['error_first_name']);
        $_SESSION['firstname'] = $_POST['first_name'];
    } else {
        unset($_SESSION['firstname']);
        $_SESSION['error_first_name'] = "This field is required";
        $error++;
    }


    if (isset($_POST['last_name']) && !empty($_POST['last_name'])) {
        unset($_SESSION['error_last_name']);
        $_SESSION['lastname'] = $_POST['last_name'];
    } else {
        unset($_SESSION['lastname']);
        $_SESSION['error_last_name'] = "This field is required";
        $error++;
    }

    if (isset($_POST['password']) && !empty($_POST['password'])) {

        if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
            if ($_POST['confirm_password'] != $_POST['password']) {
                $_SESSION['error_nou_repeat_password']="passvordner@ chen hamnknum";
                $error++;
            }else{
                unset( $_SESSION['error_nou_repeat_password']);
                unset( $_SESSION['error_confirm_password']);
                unset(  $_SESSION['error_password']);
            }
        } else {
            $_SESSION['error_confirm_password']="This field is required";
            $error++;
        }

    } else {
        $_SESSION['error_password'] = "This field is required";
        $error++;
    }


    if (isset($_POST['gender']) && !empty($_POST['gender'])) {
        unset($_SESSION['error_gender']);
        $_SESSION['gender']=$_POST['gender'];
    } else {
        $_SESSION['error_gender'] = "Be sure to note";
        $error++;
    }
    if ($error != 0) {
        header('location:register.php');
        die();
    } else {
        register($_POST);
        header('location:login.php');
        die();
    }
}
