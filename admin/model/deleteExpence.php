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
$company_id = $_SESSION["company_id"];

// super admin
if($adminType["type"] == '1'){
  if($expRec["status"] == '0'){
      // dbs company
      DBHelper::set("UPDATE company_account SET amount = amount + {$amount} where company_id = $company_id");
      DBHelper::set("DELETE FROM `admin_transaction` WHERE `date` = '{$expRec["date"]}' and `adminID` = {$expRec["adminID"]} and `exp_type` = 0 and `type` = 'expence';");
      DBHelper::set("DELETE FROM `company_expense` WHERE `id` = {$ID}");
  }
  else{
      // dbs shop
      DBHelper::set("UPDATE dbs_shop_account SET balance = balance + {$amount} WHERE `status` = 0 and id = 1 and company_id = $company_id");
      DBHelper::set("DELETE FROM `admin_transaction` WHERE `date` = '{$expRec["date"]}' and `adminID` = {$expRec["adminID"]} and `exp_type` = 1 and `type` = 'expence';");
      DBHelper::set("DELETE FROM `company_expense` WHERE `id` = {$ID}");
  }
}
else{

    if($expRec["status"] == '0'){
        // dbs company
        $check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = {$adminID} and company_id = $company_id");
        if($check_admin_account->num_rows <= 0){
         DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`,company_id) VALUES ($amount,'{$expRec["adminID"]}',$company_id)");
        }else{
            DBHelper::set("UPDATE `admin_account` SET amount= amount - {$amount} WHERE adminID = '{$expRec["adminID"]}' and company_id = $company_id");
        }

        DBHelper::set("DELETE FROM `admin_transaction` WHERE `date` = '{$expRec["date"]}' and `adminID` = {$expRec["adminID"]} and `exp_type` = 0 and `type` = 'expence';");
        DBHelper::set("DELETE FROM `company_expense` WHERE `id` = {$ID}");
    }
    else{
        // dbs shop

        $check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = '{$expRec["adminID"]}' and company_id = $company_id");
        if($check_admin_account->num_rows <= 0){
         DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`,company_id) VALUES ($amount,'{$expRec["adminID"]}',$company_id)");
        }else{
            DBHelper::set("UPDATE `admin_account` SET amount= amount - {$amount} WHERE adminID = {$expRec["adminID"]} and company_id = $company_id");
        }
        
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