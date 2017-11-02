<?php


/* register  */
function register($_post)
{
    $json = file_get_contents('register.json');
    $decode = json_decode($json, true);
    if ($decode==null){
        $id ="0";

    }else {
        end($decode);
        $id = key($decode) + 1;
    }
    $arrayApi = array(

            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            "password" => crypt($_POST['password']),
            "gender" => $_POST['gender'],

    );
    $decode[$id] = $arrayApi;
    $cod = json_encode($decode);
    file_put_contents("register.json", $cod);
}



 /*json transform array*/
function json_array($file_json){
    $json = file_get_contents($file_json);
    $decode = json_decode($json, true);
    return $decode;
}


/*array transform json*/
function array_json($array , $file_json){
    $cod = json_encode($array);
    return file_put_contents($file_json, $cod);
}


function search($json_file , $user_id){
    $json = file_get_contents($json_file);
    $decode = json_decode($json, true);
   foreach ($decode as $key => $value){
       if ($key==$user_id){
           return $decode[$key];
       }
   }
    $cod = json_encode($decode);
    file_put_contents($json_file, $cod);
}