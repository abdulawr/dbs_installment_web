<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");
$id = $_GET["id"];
$name = $_POST["name"];

if (isset($_GET["type"])) {
    DBHelper::set("UPDATE `item_type` SET `name`='{$name}' WHERE id = {$id}");
    header("Location: ../add_item_type");
}
else{
    DBHelper::set("UPDATE `companies` SET `name`='{$name}' WHERE id = {$id}");
    header("Location: ../add_company");
}
?>