<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");
if(isset($_GET["type"])){
    DBHelper::set("DELETE FROM `item_type` WHERE id = {$_GET["id"]}");
    header("Location: ../add_item_type");
}
else{
    DBHelper::set("DELETE FROM `companies` WHERE id = {$_GET["id"]}");
    header("Location: ../add_company");
}
?>