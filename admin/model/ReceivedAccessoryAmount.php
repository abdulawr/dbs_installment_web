<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

$userID = DBHelper::escape($_GET["userID"]);
$hisID = DBHelper::escape($_GET["id"]);
$balance = DBHelper::get("SELECT amount,type FROM accessories_account WHERE id = {$hisID} and sellID = {$userID}")->fetch_assoc();
$price = $balance["amount"];
$page = (trim($balance["type"]) == "0") ? "ShopkeeperProfile" : "adminProfile";
$page .= "?ID=".$userID;

if(DBHelper::set("UPDATE accessories_account SET status = 1 WHERE id = {$hisID} and sellID = {$userID}")){
    DBHelper::set("UPDATE dbs_shop_account set balance=balance + {$price} where status = 0");
    DBHelper::set("UPDATE dbs_shop_account set balance=balance - {$price} where status = 1");
   ?>
    <script>
        alert("Action perform successuflly");
        location.href = "../<?php echo $page;?>";
    </script>
    <?php
}
else{
    ?>
    <script>
        alert("Something went wrong try again");
        location.href = "../<?php echo $page;?>";
    </script>
    <?php  
}

?>