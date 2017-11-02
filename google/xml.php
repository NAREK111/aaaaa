<?php
session_start();
include '../function/function.php';
$arr = json_array('../register.json');
$xml = $arr[$_SESSION['user_id']]['maps'];


// Start XML file, echo parent node
echo '<markers>';
foreach($xml as $val ){

// Iterate through the rows, printing XML nodes for each
    // Add to XML document node
    echo '<marker ';
    echo 'name="' . parseToXML($val['name']) . '" ';
    echo 'address="' . parseToXML($val['address']) . '" ';
    echo 'lat="' .$val['lat'] . '" ';
    echo 'lng="' . $val['log'] . '" ';
    echo 'type="aaaaaaaaaa" ';
    echo '/>';
}

// End XML file
echo '</markers>';