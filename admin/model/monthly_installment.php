<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

if(isset($_POST["appID"]) && isset($_POST["amount"])){
  
  $appID = $_POST["appID"];
  $amount = abs($_POST["amount"]);
  $adminID = $_SESSION["isAdmin"];
  $adminType = $_SESSION["type"];
  $date = date("Y-m-d");

  $company_id = $_SESSION["company_id"];
 
  $check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = {$adminID} and company_id = $company_id ");
  if($check_admin_account->num_rows <= 0){
   DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`,company_id) VALUES (0,{$adminID},$company_id)");
  }

  if(DBHelper::set("INSERT INTO `application_installment`(`appID`, `date`, `amount`, `type`,company_id) VALUES ($appID,'{$date}',$amount,'I',$company_id)")){
    if($adminType == 2){
        DBHelper::set("UPDATE admin_account set amount = amount + {$amount} WHERE adminID = {$adminID} and company_id = $company_id");
      }
      else{
        DBHelper::set("UPDATE company_account set amount=amount+ {$amount} and id = $company_id");
      }
    
      DBHelper::set("INSERT INTO `admin_transaction`(`amount`, `date`, `status`, `type`, `adminID`,appID,company_id) VALUES ($amount,'{$date}',2,'customer',$adminID,$appID,$company_id)");
    
      ?>
      <script>
          var id = "<?php echo $_POST["appID"];?>";
          alert("Monthly installment is successfully added");
          location.replace("../print_installement?ID="+id);
      </script>
     <?php  

  }
  else{
    ?>
    <script>
        var id = "<?php echo $_POST["appID"];?>";
        alert("Something went wrong try again");
        location.replace("../View_Application?ID="+id);
    </script>
   <?php  
  }
 
}
else{
  ?>
   <script>
       var id = "<?php echo $_POST["appID"];?>";
       alert("In complete data is provided");
       location.replace("../View_Application?ID="+id);
   </script>
  <?php 
}

?>