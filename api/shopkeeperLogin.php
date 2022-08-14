<?php
include_once("include.php");
$mobile = validateInput($_POST["mobile"]);
$pass = Encryption::Encrypt($_POST["pass"]);
$data = DBHelper::get("SELECT * FROM `shopkeeper` WHERE mobile = '{$mobile}' and pass = '{$pass}' LIMIT 1");
$response = [];
if($data->num_rows > 0){
$response = ["status"=>1,"message"=>"Login successfull","data"=>$data->fetch_assoc()];

}else{
    $response = ["status"=>0,"message"=>"Invalid mobile or password record"];
}

echo json_encode($response);

?>