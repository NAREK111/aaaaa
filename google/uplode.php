<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    die();
}
include '../function/function.php';
$arr = json_array('../register.json');
$mail_error = [
    'ardyunq' => 'такой email не существует',
];
foreach ($arr as $key => $value) {
    if ($key == $_SESSION['user_id']) {

        if (empty($arr[$key]['maps'])) {
            $arr[$key]['maps'] = [];
        }
        $gallery = $arr[$key]['maps'];
        if ( $gallery==null){
            $id ="0";
        }else {
            end($gallery);
            $id = key($gallery) + 1;
        }
        $arr[$key]['maps'][$id] = $_POST;
        $cod = json_encode($arr);
        file_put_contents("../register.json", $cod);

        echo json_encode( $arr[$key]);

    }
}






/*

$(function () {

    $('#email').on('blur',function () {
        var email = $(this).val();
        var data = {
            'a':email
        };
        $.ajax({
            url:'checkemail.php',
            method:'post',
            dataType:'json',
            data:data,
            success: function (response) {
            console.log(response);
            $("#aaa").remove()
                if (response['ardyunq']!=='ok'){
                    $('#email').after( "<div id='aaa' class='alert-danger' >"+response['ardyunq']+"</div>")
                }
            $('#aaa').addClass("alert");
            }
        })

    })*/