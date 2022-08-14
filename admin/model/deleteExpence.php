<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

$ID = DBHelper::escape($_GET["ID"]);
$expRec = DBHelper::get("SELECT * FROM `company_expense` WHERE id = {$ID} limit 1")->fetch_assoc();
$adminType = DBHelper::get("SELECT type FROM `admin` WHERE id = {$expRec["adminID"]}")->fetch_assoc();

$amount = $expRec["amount"];
// super admin
if($adminType["type"] == '1'){
  if($expRec["status"] == '0'){
      // dbs company
      DBHelper::set("UPDATE company_account SET amount = amount + {$amount}");
      DBHelper::set("DELETE FROM `admin_transaction` WHERE `date` = '{$expRec["date"]}' and `adminID` = {$expRec["adminID"]} and `exp_type` = 0 and `type` = 'expence';");
      DBHelper::set("DELETE FROM `company_expense` WHERE `id` = {$ID}");
  }
  else{
      // dbs shop
      DBHelper::set("UPDATE dbs_shop_account SET balance = balance + {$amount} WHERE `status` = 0 and id = 1");
      DBHelper::set("DELETE FROM `admin_transaction` WHERE `date` = '{$expRec["date"]}' and `adminID` = {$expRec["adminID"]} and `exp_type` = 1 and `type` = 'expence';");
      DBHelper::set("DELETE FROM `company_expense` WHERE `id` = {$ID}");
  }
}
else{

    if($expRec["status"] == '0'){
        // dbs company
        DBHelper::set("UPDATE `admin_account` SET amount= amount - {$amount} WHERE adminID = {$expRec["adminID"]}");
        DBHelper::set("DELETE FROM `admin_transaction` WHERE `date` = '{$expRec["date"]}' and `adminID` = {$expRec["adminID"]} and `exp_type` = 0 and `type` = 'expence';");
        DBHelper::set("DELETE FROM `company_expense` WHERE `id` = {$ID}");
    }
    else{
        // dbs shop
        DBHelper::set("UPDATE `admin_account` SET amount= amount - {$amount} WHERE adminID = {$expRec["adminID"]}");
        DBHelper::set("DELETE FROM `admin_transaction` WHERE `date` = '{$expRec["date"]}' and `adminID` = {$expRec["adminID"]} and `exp_type` = 1 and `type` = 'expence';");
        DBHelper::set("DELETE FROM `company_expense` WHERE `id` = {$ID}");
    }

}

?>
<script>
    alert('Expence deleted successfully!');
    location.replace("../ExpenceReport");
</script>
<?php

?>