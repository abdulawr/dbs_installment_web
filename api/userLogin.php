<?php
include("include.php");
$response;
$email=$_POST["email"];
$pass=Encryption::Encrypt($_POST["pass"]);
$query=DBHelper::get("SELECT * from admin WHERE email='{$email}' and pass='{$pass}'");

$api_key = RandomString(150);

if($query->num_rows > 0){
    $array=$query->fetch_assoc();
    $date = date("Y-m-d");
    $pass=Encryption::Decrypt($array["pass"]);
    DBHelper::set("DELETE FROM `app_login` WHERE `access_id` = '{$array["id"]}' and `status` = 1;");
    DBHelper::set("INSERT INTO `app_login`(`api_key`, `status`, `access_id`,date) VALUES ('$api_key',1,'{$array["id"]}','$date')");
    $array["pass"]=$pass;
    $response=["status"=>1,"message"=>"Successfully Login","data"=>$array,'api_key'=>$api_key];
}
else{
    $response=["status"=>0,"message"=>"Invalid username or password"];
}

echo json_encode($response);
?>