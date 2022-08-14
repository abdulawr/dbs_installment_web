<?php
include("include.php");
$response;
$email=$_POST["email"];
$pass=Encryption::Encrypt($_POST["pass"]);
$query=DBHelper::get("SELECT * from admin WHERE email='{$email}' and pass='{$pass}'");
if($query->num_rows > 0){
    $array=$query->fetch_assoc();
    $pass=Encryption::Decrypt($array["pass"]);
    $array["pass"]=$pass;
    $response=["status"=>1,"message"=>"Successfully Login","data"=>$array];
}
else{
    $response=["status"=>0,"message"=>"Invalid username or password"];
}
echo json_encode($response);
?>