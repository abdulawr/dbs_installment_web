<?php
include("include.php");
$response;
$email=$_POST["email"];
$pass=Encryption::Encrypt($_POST["pass"]);
$query=DBHelper::get("SELECT * from admin WHERE email='{$email}' and pass='{$pass}'");

$api_key = RandomString(50);

if($query->num_rows > 0){
    $array=$query->fetch_assoc();

    if($array["type"] == 1){
        $company=DBHelper::get("SELECT * from company_info WHERE id=1000")->fetch_assoc();
    }
    else{
        $company=DBHelper::get("SELECT * from company_info WHERE id='{$array["company_id"]}';")->fetch_assoc();
    }


    $date = date("Y-m-d");
    $pass=Encryption::Decrypt($array["pass"]);
    DBHelper::set("DELETE FROM `app_login` WHERE `access_id` = '{$array["id"]}' and `status` = 1;");
    DBHelper::set("INSERT INTO `app_login`(`api_key`, `status`, `access_id`,date) VALUES ('$api_key',1,'{$array["id"]}','$date')");
    $array["pass"]=$pass;
    $response=[
        "status"=>1,
        "message"=>"Successfully Login",
        "data"=>$array,
        'api_key'=>$api_key,
        'company_id' => $company["id"],
        "company_name" => $company["name"]
    ];
}
else{
    $response=["status"=>0,"message"=>"Invalid username or password"];
}

echo json_encode($response);
?>