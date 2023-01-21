<?php
include("include.php");

if(!isset($_POST["type"])){
  echo json_encode(["status"=>0,"message"=>"Invalid access!"]);
  exit;
}

if(!isset($_POST["adminID"])){
  echo json_encode(["status"=>0,"message"=>"Invalid access!"]);
  exit;
}

if(!isset($_POST["api_key"])){
  echo json_encode(["status"=>0,"message"=>"Unauthorized access!"]);
  exit;
}

$type = validateInput($_POST["type"]);
$adminID = validateInput($_POST["adminID"]);
$apk_key = $_POST["api_key"];


if(!empty($apk_key) && !empty($type) && isAdmin($apk_key)){
// to verify admin

 // --------------------- Get admin profile start --------------------------
   if(trim($type) == "getAdminProfile"){
       $data = DBHelper::get("select * from admin where id = {$adminID}");
       if($data->num_rows > 0){
         $data = $data->fetch_assoc();
         $pass = Encryption::Decrypt($data["pass"]);
         $data["pass"] = $pass;
         echo json_encode(["status"=>1,"message"=>"Data found successfully","data"=>$data]);
       }
       else{
           echo json_encode(["status"=>0,"message"=>"Data not found in the database"]);
       }
   }
 // --------------------- Get admin profile End --------------------------



 // --------------------- Update admin profile start --------------------------
   elseif(trim($type) == "updateAdminProfile"){

     $name = validateInput($_POST["name"]);
     $email = validateInput($_POST["email"]);
     $mobile = validateInput($_POST["mobile"]);
     $cnic = validateInput($_POST["cnic"]);
     $address = validateInput($_POST["address"]);
     $password = Encryption::Encrypt($_POST["password"]);

     $qry = "UPDATE admin SET
     name = '{$name}',
     mobile = '{$mobile}',
     email = '{$email}',
     pass = '{$password}',
     cnic = '{$cnic}',
     address = '{$address}'
            WHERE id = {$adminID}";

     if(DBHelper::set($qry)){
        $data = DBHelper::get("select * from admin where id = {$adminID}");
        $data = $data->fetch_assoc();
        $pass = Encryption::Decrypt($data["pass"]);
        $data["pass"] = $pass;
        echo json_encode(["status"=>1,"message"=>"Profile updated successfully!","data"=>$data]);
     }
     else{
         echo json_encode(["status"=>0,"message"=>"Unable to update admin profile!"]);
     }

   }
 // --------------------- Update admin profile End --------------------------



 // --------------------- Get company information start --------------------------
  elseif(trim($type) == "getCompanyInfo"){
    $data = DBHelper::get("SELECT * FROM `company_info`");
    if($data->num_rows > 0){
        echo json_encode(["status"=>1,"message"=>"Successfull","data"=>$data->fetch_assoc()]);
    }
    else{
        echo json_encode(["status"=>0,"message"=>"Unable to get company data"]);
    }
  }
 // --------------------- Get company information End --------------------------



  // --------------------- Update company info start --------------------------
   elseif(trim($type) == "updateCompanyInfo"){
       $name = validateInput($_POST["name"]);
       $mobile = validateInput($_POST["mobile"]);
       $email = validateInput($_POST["email"]);
       $address = validateInput($_POST["address"]);
       $facebook = validateInput($_POST["facebook"]);
       $whatapp = validateInput($_POST["whatapp"]);

      $qry = "UPDATE company_info SET
                 name = '{$name}',
                 mobile = '{$mobile}',
                 email = '{$email}',
                 address = '{$address}',
                 facebook = '{$facebook}',
                 whatsapp = '{$whatapp}' ;"; 
        if(DBHelper::set($qry)){
            echo json_encode(["status"=>1,"message"=>"Company info updated successfully"]);
        }
        else{
            echo json_encode(["status"=>0,"message"=>"Unable to update company info"]);
        }
   }
 // --------------------- Update company info End --------------------------



 // --------------------- Add new customer start --------------------------
 elseif(trim($type) == "AddnewCustomer"){
  $image = $_POST["image"];
  $name = validateInput($_POST["name"]);
  $mobile = validateInput($_POST["mobile"]);
  $cnic = validateInput($_POST["cnic"]);
  $father = validateInput($_POST["father"]);
  $address = validateInput($_POST["address"]);
  $response = [];
  if(!customerCheck($mobile,$cnic)){
    $filename = "customer_".$mobile."_".$cnic."_".RandomString(15).".jpeg";
    $image = base64_decode($image);
    if(file_put_contents("../images/customer/".$filename,$image)){
       $qry = "INSERT INTO customer 
       (name,cnic,mobile,address,image,fname) VALUES(
       '{$name}',
       '{$cnic}',
       '{$mobile}',
       '{$address}',
       '{$filename}',
       '{$father}')";

       if(DBHelper::set($qry)){
        $response = ["status"=>1,"message"=>"Customer account created successfully"];
       }
       else{
        $response = ["status"=>0,"message"=>"Error occured while inserting data into db"];
       }
    }
    else{
      $response = ["status"=>0,"message"=>"Error occurred in customer image uploading"];
    }
  }
  else{
    $response = ["status"=>0,"message"=>"Customer already exist"];
  }

  echo json_encode($response);

 }
 // --------------------- Add new customer End --------------------------



 // --------------------- Add new investor start --------------------------
 elseif(trim($type) == "AddnewInvest"){
  $image = $_POST["image"];
  $name = validateInput($_POST["name"]);
  $mobile = validateInput($_POST["mobile"]);
  $cnic = validateInput($_POST["cnic"]);
  $address = validateInput($_POST["address"]);
  $response = [];
  if(!investorCheck($mobile,$cnic)){
    $filename = "customer_".$mobile."_".$cnic."_".RandomString(15).".jpeg";
    $image = base64_decode($image);
    if(file_put_contents("../images/investor/".$filename,$image)){
       $qry = "INSERT INTO investor 
       (name,cnic,mobile,address,image) VALUES(
       '{$name}',
       '{$cnic}',
       '{$mobile}',
       '{$address}',
       '{$filename}')";

       if(DBHelper::set($qry)){
        $response = ["status"=>1,"message"=>"Investor account created successfully"];
       }
       else{
        $response = ["status"=>0,"message"=>"Error occured while inserting data into db"];
       }
    }
    else{
      $response = ["status"=>0,"message"=>"Error occurred in customer image uploading"];
    }
  }
  else{
    $response = ["status"=>0,"message"=>"Investor already exist"];
  }

  echo json_encode($response);

 }
 // --------------------- Add new investor End --------------------------



 // --------------------- Get Home Page Data start --------------------------
 elseif(trim($type) == "getHomeScreenData"){
   $response=[];
    $cmp = DBHelper::get("SELECT * FROM `company_info`")->fetch_assoc();
    $response["companyinfo"] = $cmp;

    $access_pending_amount = DBHelper::get("SELECT SUM(amount) as total FROM `accessories_account` WHERE status = 0 and type = 1 and sellID = {$adminID}");
    $amount = ($access_pending_amount->num_rows > 0) ? $access_pending_amount->fetch_assoc()["total"] : "0";
    $adminAmount = DBHelper::get("SELECT amount FROM `admin_account` WHERE `adminID` = {$adminID}")->fetch_assoc()["amount"];

    $amount += $adminAmount;
    $response["adminBalance"] = $amount;

    //DBS Company
    $account = DBHelper::get("SELECT * FROM `company_account` ")->fetch_assoc();
    $pending_account = DBHelper::get("SELECT SUM(amount) as 'sum' from admin_account")->fetch_assoc();

    $response["dbs_cmp_balance"] = $account["amount"];
    $response["dbs_cmp_pending"] = $pending_account["sum"];

    $pendingPayment = DBHelper::get("SELECT SUM(payable) as tot from application_investor_pending_payment WHERE `payable` > 0;");
    $response["investor_pending"] = $pendingPayment->fetch_assoc()["tot"];

    $customerPayment = DBHelper::get("SELECT id,`total_price` FROM application WHERE status = 3;");
    $totalPPCUS = 0;
     while($row = $customerPayment->fetch_assoc()){
      $pp = DBHelper::get("SELECT SUM(amount) as tot from application_installment WHERE appID = {$row["id"]};");
      if($pp->num_rows > 0){
        $pps = (int) $pp->fetch_assoc()["tot"];
        $totalPPCUS += ceil(abs((int) $row["total_price"] - $pps));
      }
      else{
        $totalPPCUS += (int) $row["total_price"];
      }

     }

     $response["customer_pending"] = $totalPPCUS;
     $response["avail_balance"] =  $available = abs($account["amount"] - $totalPPCUS);;

    // DBS Shop
    $dbs_account = DBHelper::get("SELECT * FROM `dbs_shop_account` WHERE `status` = 0")->fetch_assoc();
    $dbs_stock = DBHelper::get("SELECT * FROM `dbs_shop_account` WHERE `status` = 1")->fetch_assoc();
    $response["dbs_shop_balance"] = $dbs_account["balance"];
    $response["dbs_shop_stock"] = $dbs_stock["balance"];

   echo json_encode($response);
 }
 // --------------------- Get Home Page Data End --------------------------



 // --------------------- Get admin list start --------------------------
 elseif(trim($type) == "getAdminList"){
   $response = [];
   $data = DBHelper::get("SELECT admin.*,amount FROM admin left JOIN admin_account on adminID = admin.id;");
   while($row = $data->fetch_assoc()){
    $access_pending_amount = DBHelper::get("SELECT SUM(amount) as total FROM `accessories_account` WHERE status = 0 and type = 1 and sellID = {$row["id"]}");
    $amount = ($access_pending_amount->num_rows > 0) ? $access_pending_amount->fetch_assoc()["total"] : "0";
    $row["accessBalance"] = $amount;
    array_push($response,$row);
   }
   echo json_encode($response);
 }
 // --------------------- Get admin list End --------------------------



 // --------------------- Blocked or Allowed Admin Account start --------------------------
 elseif(trim($type) == "ChangeAdminAccountStatus"){
   $response = [];
  $status = validateInput($_POST["status"]);
  if(DBHelper::set("UPDATE admin SET account_status ={$status} WHERE id = {$adminID}")){
    $response = ["status"=>1,"message"=>"Account status changed successfuly","st"=>$status];
  }
  else{
    $response = ["status"=>0,"message"=>"Error occured while inserting data in DB"];
  }
  echo json_encode($response);
}
 // --------------------- Blocked or Allowed Admin Account End --------------------------




  // --------------------- Get Admin Pending Transaction start --------------------------
  elseif(trim($type) == "getAdminPendingTransaction"){
    $data = DBHelper::get("SELECT * from admin_transaction WHERE 
    adminID = {$adminID} and paymentStatus = 0 order by id desc");
    $response = [];
    while($row = $data->fetch_assoc()){
      array_push($response,$row);
    }
    echo json_encode($response);
  }
 // --------------------- Get Admin Pending Transaction End --------------------------



 // --------------------- Change Pending Transaction Type start --------------------------
 elseif(trim($type) == "changePendingTransactionType"){
   $tranID = $_POST["ID"];
   $adminID = $_POST["ADMID"];
   
    $tran_data = DBHelper::get("SELECT * FROM `admin_transaction` WHERE id = {$tranID} and adminID = {$adminID}");
  $adminAccount = DBHelper::get("SELECT amount FROM `admin_account` WHERE `adminID` = {$adminID}")->fetch_assoc();
  $adminAccount = $adminAccount["amount"];

    if($adminAccount > 0){
    if($tran_data->num_rows > 0){
    $tran_data = $tran_data->fetch_assoc();
    $check = false;
    $amount = $tran_data["amount"];
   
    if($tran_data["type"] == "investor"){
       if($tran_data["status"] == 0){
           DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]}");
           DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID}");
           DBHelper::set("UPDATE company_account SET amount = amount + {$amount};");
           $check = true;
       }
       elseif($tran_data["status"] == 1){
           DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]}");
           DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID}");
           DBHelper::set("UPDATE company_account SET amount = amount - {$amount};");
           $check = true;
       }
       else{
           $check = false;
       }
       
    }
   
    elseif($tran_data["type"] == "dbs_shop"){
       DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]}");
       DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID}");
       DBHelper::set("UPDATE dbs_shop_account SET balance = balance + {$amount} where status = 0");
       $check = true;
    }
   
    elseif($tran_data["type"] == "customer"){
       DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]}");
       DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID}");
       DBHelper::set("UPDATE company_account SET amount = amount + {$amount};");
       $check = true;
    }
    elseif($tran_data["type"] == "expence"){
      DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]}");
      DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID}");
    
      if($tran_data["exp_type"] == 0){
         DBHelper::set("UPDATE company_account SET amount = amount - {$amount};");
      }
      else{
         DBHelper::set("UPDATE dbs_shop_account SET balance = balance - {$amount} WHERE status = 0");
      }
   
      $check = true;
    }
    else{
        $check = false;
    }
   
    if($check){
      echo json_encode(["status"=>1,"message"=>"Action perform successfully"]);
    }
    else{
      echo json_encode(["status"=>0,"message"=>"Invalid transaction type"]);
    }
    }
    else{
      echo json_encode(["status"=>0,"message"=>"No transaction exist with id"]); 
    }
  }
  else{
      echo json_encode(["status"=>0,"message"=>"Admin account is zero, Nothing to minues"]); 
  }
 }
 // --------------------- Change Pending Transaction Type End --------------------------



 // --------------------- Get accessories pending payments start --------------------------
 elseif(trim($type) == "getAccessoryPendingpayment"){
   $response = [];
   if(isset($_POST["ID"]))
   {
     $adminID = $_POST["ID"];
     $type = 0;
   }
   else{
    $type = 1;
   }

   $data = DBHelper::get("SELECT * FROM `accessories_account` WHERE status = 0 and type = {$type} and sellID = {$adminID}");
   while($row = $data->fetch_assoc()){
     array_push($response,$row);
   }
   echo json_encode($response);
 }
 // --------------------- Get accessories pending payments End --------------------------




  // --------------------- Change Accessory tran status start --------------------------
elseif(trim($type) == "changePending_Accessory_TransactionType"){
$userID = DBHelper::escape($_POST["ADMID"]);
$hisID = DBHelper::escape($_POST["ID"]);
$balance = DBHelper::get("SELECT amount,type FROM accessories_account WHERE id = {$hisID} and sellID = {$userID}")->fetch_assoc();
$price = $balance["amount"];
$page = (trim($balance["type"]) == "0") ? "ShopkeeperProfile" : "adminProfile";
$page .= "?ID=".$userID;

if(DBHelper::set("UPDATE accessories_account SET status = 1 WHERE id = {$hisID} and sellID = {$userID}")){
    DBHelper::set("UPDATE dbs_shop_account set balance=balance + {$price} where status = 0");
    DBHelper::set("UPDATE dbs_shop_account set balance=balance - {$price} where status = 1");
    echo json_encode(["status"=>1,"message"=>"Action perform successuflly"]); 
}
else{
  echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]); 
}
  }
 // --------------------- Change Accessory tran status End --------------------------



 // --------------------- Get shopkeeper list start --------------------------
 elseif(trim($type) == "getShopkeeperList")
{
   $response = [];
   $data = DBHelper::get("SELECT * FROM `shopkeeper`");
   while($row = $data->fetch_assoc()){
    $access_pending_amount = DBHelper::get("SELECT SUM(amount) as total FROM `accessories_account` WHERE status = 0 and type = 0 and sellID = {$row["id"]}");
    $access_pending_amount = $access_pending_amount->fetch_assoc()["total"];
    $amount = (!empty($access_pending_amount)) ? $access_pending_amount : "0";
    $row["balance"] = $amount;
    array_push($response,$row);
   }
   echo json_encode($response);
}
 // --------------------- Get shopkeeper list End --------------------------



 // --------------------- Change shopkeeper account status start --------------------------
 elseif(trim($type) == "changeShopkeeperAccountStatus"){
  $response = [];
  $status = validateInput($_POST["status"]);
  $ID = validateInput($_POST["ID"]);
  if(DBHelper::set("UPDATE shopkeeper SET status = {$status} WHERE id = {$ID}")){
   $response = ["status"=>1,"message"=>"Account status changed successfuly","st"=>$status];
  }
 else{
   $response = ["status"=>0,"message"=>"Error occured while inserting data in DB"];
 }
 echo json_encode($response);
}
 // --------------------- Change shopkeeper account status End --------------------------





  // --------------------- Change shopkeeper transaction type start --------------------------
elseif(trim($type) == "Change_shopkeeper_PendingBalance"){
    $hisID = $_POST["ID"];
    $userID = $_POST["ADMID"];
$response = [];

$balance = DBHelper::get("SELECT amount,type FROM accessories_account WHERE id = {$hisID} and sellID = {$userID}")->fetch_assoc();
$price = $balance["amount"];
$page = (trim($balance["type"]) == "0") ? "ShopkeeperProfile" : "adminProfile";
$page .= "?ID=".$userID;

if(DBHelper::set("UPDATE accessories_account SET status = 1 WHERE id = {$hisID} and sellID = {$userID}")){
    DBHelper::set("UPDATE dbs_shop_account set balance=balance + {$price} where status = 0");
    DBHelper::set("UPDATE dbs_shop_account set balance=balance - {$price} where status = 1");
    $response = ["status"=>1,"message"=>"Action perform successuflly"];
}
else{
  $response = ["status"=>0,"message"=>"Something went wrong try again"];
}

echo json_encode($response);

  }
 // --------------------- Change shopkeeper transaction type End --------------------------



 // --------------------- Get Application List start --------------------------
 elseif(trim($type) == "getApplicationList"){
   $response = [];

   if(isset($_POST["status"])){
    $type = $_POST["status"];
     $search = "status = ".$type;
   }
   elseif(isset($_POST["appID"])){
    $search = "application.id = ".$_POST["appID"];
   }
   elseif(isset($_POST["searchQuery"])){
    $search = $_POST["searchQuery"];
   }


   $data=DBHelper::get("SELECT customer.id AS 'cusID',customer.name,customer.mobile,companies.name 
   as 'comp',item_type.name as 'item',application.* from application INNER JOIN 
   customer on customer.id = cusID INNER JOIN companies on companies.id = companyID 
   INNER JOIN item_type on item_type.id = item_type_id where {$search};");
   while($row = $data->fetch_assoc()){
     array_push($response,$row);
   }
   echo json_encode($response);
 }
 // --------------------- Get Application List End --------------------------


  // --------------------- Submit Discount start --------------------------
elseif(trim($type) == "submitApplicationDiscount"){

$appID = $_POST["AppID"];
$discount_amount = $_POST["amount"];
$investor_amount = ceil($discount_amount / 100) * 75;
$company_amount = ceil($discount_amount / 100) * 25;

$details = DBHelper::get("SELECT * FROM `application` WHERE id = {$appID}")->fetch_assoc();
if(DBHelper::set("UPDATE application set `total_price`= total_price - {$discount_amount},discount_amount={$discount_amount} WHERE id = {$appID}")){
 DBHelper::set("UPDATE `company_account` SET `amount`= amount - {$company_amount}");
 DBHelper::set("UPDATE investor_account SET balance = balance - {$investor_amount} WHERE investorID = {$details["investorID"]}");

 echo json_encode(["status"=>1,"message"=>"Action perform successfully"]);
}
else{
   echo json_encode(["status"=>0,"message"=>"Error occured while inserting data into DB"]);
}

  }
 // --------------------- Submit Discount End --------------------------



 // --------------------- Get application details start --------------------------
 elseif(trim($type) == "getApplicationDetails_View"){
   $appID = validateInput($_POST["appID"]);
   $response = [];
   $application = DBHelper::get("SELECT * FROM application WHERE id = {$appID}")->fetch_assoc();
   $customer = DBHelper::get("SELECT * FROM `customer` WHERE id = {$application['cusID']}")->fetch_assoc();
   $response["customer"] = $customer;

   if($application["status"] == '3' || $application["status"] == '4'){
    $investor = DBHelper::get("SELECT * FROM `investor` WHERE id = {$application['investorID']}")->fetch_assoc();
    $response["investor"] = $investor; 

    $trans = [];
    $Trandata = DBHelper::get("SELECT * FROM `application_installment` WHERE appID = {$application["id"]}");
    while($row = $Trandata->fetch_assoc()){
      array_push($trans,$row);
    }
    $response["transaction"] = $trans;
  }
  else{
    $response["investor"] = 'null';
    $response["transaction"] = 'null';
  }

  $installment = DBHelper::get("SELECT  (
    SELECT COUNT(id)
    FROM   application_installment WHERE appID = {$application["id"]}
) AS count,
(
    SELECT sum(amount)
    FROM   application_installment WHERE appID = {$application["id"]}
) AS total")->fetch_assoc();

  $response["total_paid_amount"] = $installment["total"];
  $response["num_of_installment"] = $installment["count"];
  $response["remaining_amount"] = ceil($application["total_price"] - $installment["total"]);

  echo json_encode($response);
 }
 // --------------------- Get application details End --------------------------



 // --------------------- Add application installment start --------------------------
 elseif(trim($type) == "addApplicationInstallement"){
   $amount = validateInput($_POST["amount"]);
   $appID = validateInput($_POST["appID"]);
   $adminType = validateInput($_POST["adminType"]);
   $adminID = $adminID;
   $date = date("Y-m-d");
  
   $check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = {$adminID}");
   if($check_admin_account->num_rows <= 0){
    DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`) VALUES (0,{$adminID})");
   }
 
   if(DBHelper::set("INSERT INTO `application_installment`(`appID`, `date`, `amount`, `type`) VALUES ($appID,'{$date}',$amount,'I')")){
     if($adminType == 2){
         DBHelper::set("UPDATE admin_account set amount = amount + {$amount} WHERE adminID = {$adminID}");
       }
       else{
         DBHelper::set("UPDATE company_account set amount=amount+ {$amount}");
       }
     
       DBHelper::set("INSERT INTO `admin_transaction`(`amount`, `date`, `status`, `type`, `adminID`,appID) VALUES ($amount,'{$date}',2,'customer',$adminID,$appID)");
     
       echo json_encode(["status"=>1,"message"=>"Monthly installment is successfully added"]);
   }
   else{
     echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
   }

 }
 // --------------------- Add application installment End --------------------------




  // --------------------- Complete Application start --------------------------
  elseif(trim($type) == "addApplicationInstallement"){
    $appID = validateInput($_POST["appID"]);
    if(DBHelper::set("UPDATE application SET status = 4 WHERE id = {$appID}")){
      echo json_encode(["status"=>1,"message"=>"Application complete successfully"]);
    }
    else{
      echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
    }
  }
 // --------------------- Complete Application End --------------------------



 // --------------------- Delete Application start --------------------------
 elseif(trim($type) == "deleteApplication"){
   $appID = validateInput($_POST["appID"]);
   DBHelper::set("DELETE FROM `application_mobile_number` WHERE appID = {$appID}");
   DBHelper::set("DELETE FROM `application_proof_person` WHERE `appID` = {$appID}");
if(DBHelper::set("DELETE FROM `application` WHERE id = {$appID}")){
  echo json_encode(["status"=>1,"message"=>"Application deleted successfully"]);
}
else{
  echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
}
}
 // --------------------- Delete Application End --------------------------



 // --------------------- Reject Application start --------------------------
 elseif(trim($type) == "rejectApplicationWithReasion"){
   $ID = validateInput($_POST["appID"]);
   $des = validateInput($_POST["comment"]);

if(DBHelper::set("UPDATE application SET status = 5,rej_des='{$des}' WHERE id = {$ID}")){
  echo json_encode(["status"=>1,"message"=>"Application rejected successfully"]);
}
else{
  echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
}
 }
 // --------------------- Reject Application End --------------------------



  // --------------------- Get admin profile start --------------------------
  elseif(trim($type) == "acceptApplicationWithadvance"){
    $ID = DBHelper::escape($_POST["appID"]);
    $amount = $_POST['amount'];
    $app = DBHelper::get("select * from application where id = {$ID}")->fetch_assoc();
    $date = date('Y-m-d');
    if($app["advance_payment"] == $amount){
    $advanceStatus = 1;
    }
    else{
        $advanceStatus = 0;
    }
    if(DBHelper::set("UPDATE application SET status = 1,advance_payment_status={$advanceStatus},advance_payment_paid={$amount},active_date='{$date}' WHERE id = {$ID}")){
      echo json_encode(["status"=>1,"message"=>"Action performed successfully!"]);
    }
    else{
      echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
    }
  }
 // --------------------- Get admin profile End --------------------------




  // --------------------- Get admin profile start --------------------------
  elseif(trim($type) == "FullyPaidAdvancePayment"){
    $ID = DBHelper::escape($_POST["appID"]);
    $app = DBHelper::get("select * from application where id = {$ID}")->fetch_assoc();

    if(DBHelper::set("UPDATE application SET advance_payment_status=1,advance_payment_paid={$app["advance_payment"]} WHERE id = {$ID}")){
      echo json_encode(["status"=>1,"message"=>"Action perform successfully"]);
    }
    else{
      echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
    }
  }
 // --------------------- Get admin profile End --------------------------



 // --------------------- Get investor list for deliver application start --------------------------
 elseif(trim($type) == "getDeliverApplicationInvestorLIst"){
  $id = validateInput($_POST["appID"]);
  $app = DBHelper::get("SELECT companies.name as 'comp',item_type.name as 'item',application.* from application INNER JOIN companies on companies.id = companyID INNER JOIN item_type on item_type.id = item_type_id WHERE application.id = {$id}")->fetch_assoc();
  $investorList = DBHelper::get("SELECT investor.*,investor_account.balance FROM investor INNER JOIN investor_account on investorID = investor.id WHERE balance >= {$app["product_orginal_price"]};");
  $response = [];
  while($row = $investorList->fetch_assoc()) {
    array_push($response,$row);
  }
  echo json_encode($response);
}
 // --------------------- Get investor list for deliver application End --------------------------



 // --------------------- Deliver Application start --------------------------
 elseif(trim($type) == "submitDeliverApplicationForom"){
   $image = $_POST["image"];
   $appID = validateInput($_POST["appID"]);
   $invesID = validateInput($_POST["investorID"]);

   $app = DBHelper::get("SELECT companies.name as 'comp',item_type.name as 'item',application.* from application INNER JOIN companies on companies.id = companyID INNER JOIN item_type on item_type.id = item_type_id WHERE application.id = {$appID}")->fetch_assoc();
   $customer = DBHelper::get("SELECT * FROM `customer` WHERE id = {$app["cusID"]}")->fetch_assoc();
   $investor = DBHelper::get("SELECT * FROM `investor` WHERE id = {$invesID}")->fetch_assoc();

   $profit = ($app["product_orginal_price"] / 100) * $app["percentage_on_prod"];
   $profit = ceil($profit);

   $admin_prof = ceil(($profit / 100) * 25);
   $investor_prof = $profit - $admin_prof;
   $date = date("Y-m-d");
   $investor_total = $app["product_orginal_price"] + $investor_prof;

   $pending_payment_query = "INSERT INTO `application_investor_pending_payment`
       (`invest_amount`, `appID`, `investorID`, `cusID`, `date`,`profit`, `total_amount`,payable)
       VALUES ({$app["product_orginal_price"]},
              {$appID},
              {$invesID},
              {$app["cusID"]},
              '{$date}',
              {$investor_prof},
              {$investor_total}, {$investor_total});";

$state = false;
if (DBHelper::set($pending_payment_query)) {
    $insert_id = $con->insert_id;
    $fileName = "app_".$appID."_".RandomString(30).".jpeg";
 
    $image = base64_decode($image);
    file_put_contents("../images/application/".$fileName, $image);
  
    if (DBHelper::set("UPDATE application set status = 3,investorID=$invesID, delivery_image='{$fileName}' WHERE id = {$appID}")) {
        if (DBHelper::set("INSERT INTO `application_installment`(`appID`, `date`, `amount`, `type`) VALUES ({$appID},'{$date}',{$app["advance_payment"]},'A')")) {
            $installment_id = $con->insert_id;
    
            if (DBHelper::set("UPDATE investor_account SET balance = balance - {$app["product_orginal_price"]} where investorID = {$invesID}")) {
                $adminID = $adminID;
                $adminType = $_POST["adminType"];
                $check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = {$adminID}");
                if ($check_admin_account->num_rows <= 0) {
                    DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`) VALUES (0,{$adminID})");
                }

                if ($adminType == 2) {
                    DBHelper::set("UPDATE admin_account set amount = amount + {$app["advance_payment"]} WHERE adminID = {$adminID}");
                } else {
                    DBHelper::set("UPDATE company_account set amount=amount+ {$app["advance_payment"]}");
                }

                DBHelper::set("INSERT INTO `admin_transaction`(`amount`, `date`, `status`, `type`, `adminID`,appID) VALUES ({$app["advance_payment"]},'{$date}',2,'customer',$adminID,$appID)");
     
                echo json_encode(["status"=>1,"message"=>"Action perform successfully"]);
                $state = true;
            } else {
                $state = false;
                DBHelper::set("DELETE FROM `application_investor_pending_payment` WHERE id = {$insert_id}");
                unlink("../images/application/".$fileName);
                DBHelper::set("DELETE FROM `application_installment` WHERE id = {$installment_id}");
                DBHelper::set("UPDATE application set status = 1 WHERE id = {$appID}");
    
                echo json_encode(["status"=>0,"message"=>"Something went in changing application status"]);
            }
        } else {
            $state = false;
            DBHelper::set("DELETE FROM `application_investor_pending_payment` WHERE id = {$insert_id}");
            unlink("../images/application/".$fileName);
            DBHelper::set("UPDATE application set status = 1 WHERE id = {$appID}");
   
            echo json_encode(["status"=>0,"message"=>"Something went in changing application status"]);
        }
    } else {
        $state = false;
        DBHelper::set("DELETE FROM `application_investor_pending_payment` WHERE id = {$insert_id}");
        unlink("../images/application/".$fileName);
        echo json_encode(["status"=>0,"message"=>"Cannot perform the action righ now try again later or contact the developer"]);
    }
}
else{
  echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
}

 }
 // --------------------- Deliver Application End --------------------------



 // --------------------- Get Customer or Investor List start --------------------------
 elseif(trim($type) == "getCustomer_and_Investor_List"){
   $status = validateInput($_POST["status"]);
   if($status == "1"){
     $data = DBHelper::get("SELECT * FROM `customer`");
   }
   else{
    $data = DBHelper::get("SELECT * FROM `investor`");
   }

   $response = [];
   while($row = $data->fetch_assoc()){
     array_push($response,$row);
   }

   echo json_encode($response);
 }
 // --------------------- Get Customer or Investor List End --------------------------




  // --------------------- Getting investor balance start --------------------------
  elseif(trim($type) == "getInvestorBalance"){
    $invesID = validateInput($_POST["invID"]);
    $data = DBHelper::get("SELECT `balance` FROM `investor_account` WHERE investorID = {$invesID}");
    if($data->num_rows > 0){
      $data = $data->fetch_assoc();
      echo json_encode(["status"=>1,"message"=>"Successfully got balance","balance"=>$data["balance"]]);
    }
    else{
      echo json_encode(["status"=>1,"message"=>"Successfully got balance","balance"=>0]);
    }
  }
 // --------------------- Getting investor balance End --------------------------



 // --------------------- Recharge investor account start --------------------------
 elseif(trim($type) == "insert_amount_into_investorProfile"){
  $adminID = $adminID;
  $adminType = $_POST["adminType"];
  $date = date("Y-m-d");
  $amount = abs($_POST["amount"]);
  $tranType = $_POST["tran_type"];
  $ID = $_POST["ID"];
  $des = $_POST["des"];
  
  $check_investor_account = DBHelper::get("SELECT id FROM `investor_account` WHERE investorID = {$ID}");
  if($check_investor_account->num_rows <= 0){
    DBHelper::set("INSERT INTO `investor_account`(`balance`, `investorID`) VALUES (0,{$ID})");
  }

    $check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = {$adminID}");
    if($check_admin_account->num_rows <= 0){
     DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`) VALUES (0,{$adminID})");
    }


  if($tranType == 0){
      // add balance
      if(DBHelper::set("UPDATE investor_account SET balance = balance + {$amount} WHERE investorID = {$ID};")){
        DBHelper::set("INSERT INTO `investor_transaction`(des,`amount`, `type`, `date`, `investorID`, `adminID`) VALUES ('{$des}',$amount,$tranType,'{$date}',$ID,$adminID)");
        
        if($adminType == 2){
          DBHelper::set("UPDATE admin_account set amount = amount + {$amount} WHERE adminID = {$adminID}");
        } 
        else{
          DBHelper::set("UPDATE company_account set amount=amount+ {$amount}");
        }

        DBHelper::set("INSERT INTO `admin_transaction`(`amount`, `date`, `status`, `type`, `adminID`) VALUES ($amount,'{$date}',0,'investor',$adminID)");
        echo json_encode(["status"=>1,"message"=>"Payment added successfully"]);
     }
      else{
        echo json_encode(["status"=>0,"message"=>"Something went wrong in adding balance in investor account try again"]);
      }
  }
  elseif($tranType == 1){
      // subtrack balance
      $investorBalance = DBHelper::get("SELECT balance FROM investor_account WHERE investorID = {$ID}")->fetch_assoc()["balance"];
      if($amount > $investorBalance){
        echo json_encode(["status"=>0,"message"=>"Subtract amount should not be greater then current balance try again"]);
        
      }
      else{
        if(DBHelper::set("UPDATE investor_account SET balance = balance - {$amount} WHERE investorID = {$ID};")){
            DBHelper::set("INSERT INTO `investor_transaction`(des,`amount`, `type`, `date`, `investorID`, `adminID`) VALUES ('{$des}',$amount,$tranType,'{$date}',$ID,$adminID)");
            if($adminType == 2){
                DBHelper::set("UPDATE admin_account set amount = amount + {$amount} WHERE adminID = {$adminID}");
            }
            else{
              DBHelper::set("UPDATE company_account set amount=amount - {$amount}");
            } 

            DBHelper::set("INSERT INTO `admin_transaction`(`amount`, `date`, `status`, `type`, `adminID`) VALUES ($amount,'{$date}',1,'investor',$adminID)");
            echo json_encode(["status"=>1,"message"=>"Payment subtracted successfully"]);
        }
        else{
          echo json_encode(["status"=>0,"message"=>"Transaction failed try again later"]);
        }
      }
    }
 }
 // --------------------- Recharge investor account End --------------------------



 // --------------------- Get investor user start --------------------------
 elseif(trim($type) == "getinvestorUser"){
   $invesID = validateInput($_POST["ID"]);
   $response = [];
   $data = DBHelper::get("SELECT customer.*,application.id as 'appID' from customer INNER JOIN application ON customer.id = cusID WHERE application.investorID = {$invesID};");
   while($row = $data->fetch_assoc()){
     array_push($response,$row);
   }
   echo json_encode($response);
  }
 // --------------------- Get investor user End --------------------------




  // --------------------- Get pending balance start --------------------------
  elseif(trim($type) == "getInvestorPendingBalance"){
    $invesID = validateInput($_POST["ID"]);
    $response = [];
    $data = DBHelper::get("SELECT * FROM `application_investor_pending_payment` WHERE `investorID` = {$invesID} order by id desc;");
    while($row = $data->fetch_assoc()){
      array_push($response,$row);
    }
    echo json_encode($response);
   }
 // --------------------- Get admin profile End --------------------------




  // --------------------- Get admin profile start --------------------------
  elseif(trim($type) == "submitPendingBalance"){
  
    $investID = validateInput($_POST["investID"]);
    $ID = $_POST["id"];
    $amount = $_POST["amount"];
    $payable = $_POST["pay"];

  if($amount <= $payable){
   if(DBHelper::set("UPDATE application_investor_pending_payment set payable = payable - {$amount}, paid = paid + {$amount} WHERE id = {$ID}"))
   {
    DBHelper::set("UPDATE `investor_account` set `balance`= balance + {$amount} WHERE investorID = {$investID}");
    DBHelper::set("UPDATE company_account set amount = amount - {$amount}");
    echo json_encode(["status"=>1,"message"=>"Amount is added in customer account successfully"]);
  } else{
    echo json_encode(["status"=>0,"message"=>"Something went wrong try again"]);
  } 

}
else{
      echo json_encode(["status"=>0,"message"=>"Amount should not be greater then payable amount"]);
}

  }
 // --------------------- Get admin profile End --------------------------



 // --------------------- Get admin profile start --------------------------
 elseif(trim($type) == "getApplicationSpinnerData"){
   $company = [];
   $items = [];

   $data = DBHelper::get("SELECT * FROM `companies`");
   while($row = $data->fetch_assoc()){
     array_push($company,$row);
   }

   $data = DBHelper::get("SELECT * FROM `item_type`");
   while($row = $data->fetch_assoc()){
     array_push($items,$row);
   }

   echo json_encode(["company"=>$company,"items"=>$items]);

 }
 // --------------------- Get admin profile End --------------------------



 // --------------------- Get admin profile start --------------------------
 elseif(trim($type) == "CreateApplication"){
   $phones = json_decode($_POST["phones"],true);
   $proof_person = json_decode($_POST["proof_person"],true);

$cusID = $_POST["cusID"];
$date = date("Y-m-d h:i:s");
$monthly_income =   DBHelper::escape($_POST["monthly_income"]);
$business_type =    DBHelper::escape($_POST["business_type"]);
$bus_address =      DBHelper::escape($_POST["bus_address"]);
$product_name =     DBHelper::escape($_POST["product_name"]);
$company_name_id =  DBHelper::escape($_POST["company_name_id"]);
$model_number =     DBHelper::escape($_POST["model_number"]);
$item_type =        DBHelper::escape($_POST["item_type"]);
$total_price =      DBHelper::escape($_POST["total_price"]);
$age =              DBHelper::escape($_POST["age"]);
$percentage_on_item =  DBHelper::escape($_POST["percentage_on_item"]);
$orginal_price =  DBHelper::escape($_POST["orginal_price"]);
$advance_payment =  DBHelper::escape($_POST["advance_payment"]);
$monthly_payment =  DBHelper::escape($_POST["monthly_payment"]);
$install_months =  DBHelper::escape($_POST["install_months"]);
$ref_by =  DBHelper::escape($_POST["ref_by"]);
$item_desp =  DBHelper::escape($_POST["item_desp"]);

$qry = "INSERT INTO application(item_des,cusID,
age,
monthly_income,
business_type,
business_address,
date,
model_no,
companyID,
product_name,
item_type_id,
product_orginal_price,
percentage_on_prod,
total_price,
installment_months,
monthly_payment,
advance_payment,
ref_by) VALUES (
    '{$item_desp}',
   $cusID,
    $age,
    $monthly_income,
    '{$business_type}',
    '{$bus_address}',
    '{$date}',
    '{$model_number}',
    $company_name_id,
    '{$product_name}',
    $item_type,
    $orginal_price,
    $percentage_on_item,
    $total_price,
    $install_months,
    $monthly_payment,
    $advance_payment,
    '{$ref_by}'
);";

if(DBHelper::set($qry)){
  $app_ID = $con->insert_id;
 
  $stmt = $con->prepare("INSERT INTO `application_mobile_number`(`mobile`, `appID`) VALUES (?,?)");
  $stmt->bind_param("si", $mobile, $appID);
  foreach($phones as $ph){
      if(!empty($ph)){
         $mobile = $ph;
         $appID = $app_ID;
         $stmt->execute();
      }
  }
  
          $fname = $proof_person["fname"]; 
          $org_address = $proof_person["address"];
          $name = $proof_person["name"]; 
          $cnic = $proof_person["cnic"]; 
          $mobile = $proof_person["mobile"]; 
          $bus_address = $proof_person["business_address"]; 
          $bussiness_type = $proof_person["business_type"]; 
          
          $person_image = $proof_person["personal_image"];
          $cnic_image = $proof_person["cnic_image"];

        if(!empty($fname) && !empty($name) && !empty($mobile) && !empty($cnic)){
            if (!empty($person_image)) {
                $person_image = base64_decode($person_image);
                $Proof_Image_Name = "proof_person_profile_".$app_ID."_".$mobile.RandomString(40)."_".".jpeg";
                file_put_contents("../images/proof_person/".$Proof_Image_Name, $person_image);
            } else {
                $Proof_Image_Name = "null";
            }
  
            if (!empty($cnic_image)) {
                $cnic_image = base64_decode($cnic_image);
                $Proof_CNIC_Image = "proof_person_cnic_".$app_ID."_".$mobile.RandomString(40)."_".".jpeg";
                file_put_contents("../images/proof_person/".$Proof_CNIC_Image, $cnic_image);
            } else {
                $Proof_CNIC_Image = "null";
            }
  
            $Proof_Bus_Card = "null";

            DBHelper::set("INSERT INTO `application_proof_person`(
           fname,
           org_address,
          `name`, 
          `cnic_no`,
          `mobile`, 
          `business_type`, 
          `address`, 
          `image`, 
          `cnic_image`, 
          `business_card_image`,
          `appID`) VALUES (
              '{$fname}',
              '{$org_address}',
              '{$name}',
              '{$cnic}',
              '{$mobile}',
              '{$bussiness_type}',
              '{$bus_address}',
              '{$Proof_Image_Name}',
              '{$Proof_CNIC_Image}',
              '{$Proof_Bus_Card}',
               $app_ID
          )");
        }
 
  echo json_encode(["status"=>1,"message"=>"Application created successfully!"]);
 
 }
 else{
   echo json_encode(["status"=>0,"message"=>"Error occurred while creating application try again"]);
 }

 }
 // --------------------- Get admin profile End --------------------------

}
else{
    echo json_encode(["status"=>0,"message"=>"Unauthorized access!"]);
}

?>