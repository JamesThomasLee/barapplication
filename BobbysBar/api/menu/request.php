<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once ('../../src/model/DBContext.php');
include_once ('../../src/model/Menu_item.php');

$db = new DBContext();
$results = $db->apiCall();

if($results){
    $code = 200;
    echo returnJSON($results, $code);
}else{
    //404 - not found
    http_response_code(404);

    echo json_encode(
        array("message" => "No products found.")
    );
}

function returnJSON($result, $code){
    header_remove();
    http_response_code($code);
    header('Content-Type: application/json');
    header('Status: '.$code);
    return json_encode(array('status' => $code, 'message' => $result));
}
?>