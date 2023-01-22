<?php
include_once("include.php");
$mobile = validateInput($_POST["mobile"]);
$pass = Encryption::Encrypt($_POST["pass"]);
$data = DBHelper::get("SELECT * FROM `shopkeeper` WHERE mobile = '{$mobile}' and pass = '{$pass}' LIMIT 1");
$response = [];
$api_key = RandomString(50);
$date = date("Y-m-d");

if($data->num_rows > 0){
$data = $data->fetch_assoc();
$company=DBHelper::get("SELECT * from company_info WHERE id='{$data["company_id"]}'")->fetch_assoc();

DBHelper::set("DELETE FROM `app_login` WHERE `access_id` = '{$data["id"]}' and `status` = 2;");
DBHelper::set("INSERT INTO `app_login`(`api_key`, `status`, `access_id`,date) VALUES ('$api_key',2,'{$data["id"]}','$date')");

$response = [
    "status"=>1,
    "message"=>"Login successfull",
    "data"=>$data,
    'api_key'=>$api_key,
    'company_id' => $company["id"],
    "company_name" => $company["name"]
];

}else{
    $response = ["status"=>0,"message"=>"Invalid mobile or password record"];
}

echo json_encode($response);

?>