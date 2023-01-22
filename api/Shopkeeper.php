<?php
include_once("include.php");


if(!isset($_REQUEST["api_key"])){
  echo json_encode(["status"=>0,"message"=>"Unauthorized access!"]);
  exit;
}

if(!isset($_REQUEST["company_id"])){
  echo json_encode(["status"=>0,"message"=>"Access without company details is not allowed!"]);
  exit;
}

$apk_key = $_REQUEST["api_key"];
$company_id = $_REQUEST["company_id"];

// get shopkeeper pending balance
if(isset($_POST["getshopkeeperbalance"]) && trim($_POST["getshopkeeperbalance"]) == "getshopkeeperbalance")
{
  $id = DBHelper::escape($_POST["ID"]);
  $access_pending_amount = DBHelper::get("SELECT SUM(amount) as total FROM `accessories_account` WHERE status = 0 and type = 0 and sellID = {$id} and company_id = $company_id");
  $amount = ($access_pending_amount->num_rows > 0) ? $access_pending_amount->fetch_assoc()["total"] : "0";
  
  if(!empty($amount) && $amount > 0){
      echo $amount;
  }
  else{
      echo "0";
  }

}

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

elseif (isset($_POST["getAccessordatabyID"]) && trim($_POST["getAccessordatabyID"]) == "getAccessordatabyID") {
 $id = DBHelper::escape($_POST["ID"]);
 $qry="select * from accessories where id = {$id} and quantity > 0 and company_id = $company_id";
 $stock=DBHelper::get($qry);
 if($stock->num_rows > 0){
    echo json_encode(["status"=>"1","message"=>"data found","data"=>$stock->fetch_assoc()]);
 }
 else{
     echo json_encode(["status"=>"0","message"=>"No data found"]);
 }
}

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

elseif (isset($_POST["generateAccessoryBill"]) && trim($_POST["generateAccessoryBill"]) == "generateAccessoryBill") {
  $date = date("Y-m-d");
  $sellID = $_POST["userID"];
  $stockID = $_POST["stockID"];
  $price = $_POST["price"];

  $prod = DBHelper::get("SELECT * FROM `accessories` WHERE id = {$stockID} and company_id = $company_id")->fetch_assoc();

  if(DBHelper::set("UPDATE accessories set quantity = quantity - 1  where id = {$stockID} and company_id = $company_id")){
    DBHelper::set("INSERT INTO `accessories_account`(`amount`, `date`, `accessID`, `status`, `sellID`, `type`,company_id) VALUES ({$price},'{$date}',{$stockID},0,{$sellID},0,$company_id)");
    DBHelper::set("INSERT INTO `accessories_transaction`(`date`, `sell_price`, `buy_price`, `accessID`, `quantity`,company_id) VALUES ('{$date}',{$price},{$prod["buying"]},{$stockID},1,$company_id)");
    echo json_encode(["status"=>1,"message"=>"Bill generate successfully"]);
   }
   else{
    echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
   }

}


// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

?>