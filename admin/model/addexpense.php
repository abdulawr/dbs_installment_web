<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

$amount = abs($_POST["amount"]);
$comment = $_POST["comment"];
$adminID = $_SESSION["isAdmin"];
$adminType = $_SESSION["type"];
$exp_type = $_POST["exp_type"];
$date = date("Y-m-d");

$company_id = $_SESSION["company_id"];


$check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = {$adminID} and company_id = $company_id");
if($check_admin_account->num_rows <= 0){
 DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`,company_id) VALUES (0,{$adminID},$company_id)");
}

if(DBHelper::set("INSERT INTO `company_expense`(`amount`, `date`, `comment`, `adminID`,status,company_id) VALUES ($amount,'{$date}','{$comment}',$adminID,$exp_type,'{$_SESSION["company_id"]}')")){
   
    if($adminType == 2){
        DBHelper::set("UPDATE admin_account set amount = amount + {$amount} WHERE adminID = {$adminID} and company_id = $company_id");
      } 
      else{
        if($exp_type == 1){
            DBHelper::set("UPDATE dbs_shop_account set balance = balance - {$amount} WHERE status = 0 and company_id = '{$_SESSION["company_id"]}'");
        }
        else{
            DBHelper::set("UPDATE company_account set amount=amount - {$amount} where id = '{$_SESSION["company_id"]}'");
        }
      }

      DBHelper::set("INSERT INTO `admin_transaction`(`amount`, `date`, `status`, `type`, `adminID`,exp_type,company_id) VALUES ($amount,'{$date}',3,'expence',$adminID,$exp_type,$company_id)");

      ?>
      <script>
          alert("Action perform successfull");
          location.href = "../addExp";
      </script>
      <?php

}
else{
    ?>
    <script>
        alert("Something went wrong try again later");
        location.href = "../addExp";
    </script>
    <?php
}

?>