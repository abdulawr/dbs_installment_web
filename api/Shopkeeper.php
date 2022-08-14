<?php
include_once("include.php");

// get shopkeeper pending balance
if(isset($_POST["getshopkeeperbalance"]) && trim($_POST["getshopkeeperbalance"]) == "getshopkeeperbalance")
{
  $id = DBHelper::escape($_POST["ID"]);
  $access_pending_amount = DBHelper::get("SELECT SUM(amount) as total FROM `accessories_account` WHERE status = 0 and type = 0 and sellID = {$id}");
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
 $qry="select * from accessories where id = {$id} and quantity > 0";
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

  $prod = DBHelper::get("SELECT * FROM `accessories` WHERE id = {$stockID}")->fetch_assoc();

  if(DBHelper::set("UPDATE accessories set quantity = quantity - 1  where id = {$stockID}")){
    DBHelper::set("INSERT INTO `accessories_account`(`amount`, `date`, `accessID`, `status`, `sellID`, `type`) VALUES ({$price},'{$date}',{$stockID},0,{$sellID},0)");
    DBHelper::set("INSERT INTO `accessories_transaction`(`date`, `sell_price`, `buy_price`, `accessID`, `quantity`) VALUES ('{$date}',{$price},{$prod["buying"]},{$stockID},1)");
    echo json_encode(["status"=>1,"message"=>"Bill generate successfully"]);
   }
   else{
    echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
   }

}


// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

?>