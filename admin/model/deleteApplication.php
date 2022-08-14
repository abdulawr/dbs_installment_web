<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");
$ID = $_GET["ID"];
DBHelper::set("DELETE FROM `application_mobile_number` WHERE appID = {$ID}");
DBHelper::set("DELETE FROM `application_proof_person` WHERE `appID` = {$ID}");
if(DBHelper::set("DELETE FROM `application` WHERE id = {$ID}")){
    ?>
    <script>
        alert("Successfully deleted");
        location.href = "../Application";
    </script>
    <?php
}
else{
    ?>
    <script>
        alert("Something went wrong try again");
    </script>
    <?php
    exit;
}
?>