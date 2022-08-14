<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

$ID = $_GET["ID"];

if(DBHelper::set("DELETE FROM `db_shop_buy_request` WHERE id = {$ID}")){
    ?>
    <script>
        alert("Successfully deleted");
        location.href = "../PendingRequest";
    </script>
    <?php
}
else{
    ?>
    <script>
        alert("Something went wrong try again");
        location.href = "../PendingRequest";
    </script>
    <?php  
}

?>