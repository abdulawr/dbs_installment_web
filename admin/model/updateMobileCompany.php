<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

if(isset($_GET["typ"]) && $_GET["typ"] == "up"){
    $id = $_GET["id"];
    $name = $_POST["name"];
    DBHelper::set("UPDATE `mobile_company_dbs` SET `name`='{$name}' WHERE id = {$id}");
    header("Location: ../mobileCompany"); 
}
else{
    DBHelper::set("delete from mobile_company_dbs where id = {$_GET["id"]}");
    header("Location: ../mobileCompany");
 
}
    
?>