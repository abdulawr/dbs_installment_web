<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

if(isset($_SESSION["company_id"])){
  $amount = $_POST["amount"];
  $desc = $_POST["desc"];
  $type = $_POST["type"];
  $ID = $_POST["ID"];

  $balance = $_POST["balance"];
  $balance = abs($balance);
  
  if($type == 1){
     $balance = $balance - $amount;
  }
  elseif($type == 2 && $amount > $balance){
    $balance = $amount - $balance;
  }
  elseif($type == 2 && $amount <= $balance){
    $balance = $balance + $amount;
  }

  $qr = "SELECT * FROM `dg_user_account` WHERE `user_id` = '$ID'";
  $user_account = DBHelper::get($qr);
  if($user_account->num_rows > 0){
     DBHelper::set("UPDATE dg_user_account set balance = '$balance' WHERE user_id = '$ID'");
  }
  else{
    DBHelper::set("INSERT INTO `dg_user_account`(`balance`, `user_id`) VALUES ('$balance','$ID')");
  }

  $query = "INSERT INTO `dg_user_transaction`(`amount`, `user_id`, `type`, `balance`, `desc`) 
            VALUES ('$amount','$ID','$type','$balance','$desc')";
   if(DBHelper::set($query)){
     header("Location: ../db_user_profile?ID=".$ID."&status=success");
   }
   else{
     header("Location: ../db_user_profile?ID=".$ID."&status=error");
   }
}
else{
    header("Location: ../index.php?error=invalid");
}

?>