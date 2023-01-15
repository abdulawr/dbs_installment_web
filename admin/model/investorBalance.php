<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

$company_id = $_SESSION["company_id"];

if(isset($_POST["ID"]) && isset($_POST["type"])){
  $adminID = $_SESSION["isAdmin"];
  $adminType = $_SESSION["type"];
  $date = date("Y-m-d");
  $amount = abs($_POST["amount"]);
  $tranType = $_POST["type"];
  $ID = $_POST["ID"];
  $des = $_POST["des"];
  
  $check_investor_account = DBHelper::get("SELECT id FROM `investor_account` WHERE investorID = {$ID} and company_id = $company_id");
  if($check_investor_account->num_rows <= 0){
    DBHelper::set("INSERT INTO `investor_account`(`balance`, `investorID`,company_id) VALUES (0,{$ID},$company_id)");
  }

    $check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = {$adminID} and company_id = $company_id");
    if($check_admin_account->num_rows <= 0){
     DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`,company_id) VALUES (0,{$adminID},$company_id)");
    }


  if($tranType == 0){
      // add balance
      if(DBHelper::set("UPDATE investor_account SET balance = balance + {$amount} WHERE investorID = {$ID} and company_id = $company_id;")){
        DBHelper::set("INSERT INTO `investor_transaction`(des,`amount`, `type`, `date`, `investorID`, `adminID`,company_id) VALUES ('{$des}',$amount,$tranType,'{$date}',$ID,$adminID,$company_id)");
        
        if($adminType == 2){
          DBHelper::set("UPDATE admin_account set amount = amount + {$amount} WHERE adminID = {$adminID} and company_id = $company_id");
        } 
        else{
          DBHelper::set("UPDATE company_account set amount=amount+ {$amount} where id=$company_id");
        }

        DBHelper::set("INSERT INTO `admin_transaction`(`amount`, `date`, `status`, `type`, `adminID`,company_id) VALUES ($amount,'{$date}',0,'investor',$adminID,$company_id)");
        ?>
        <script>
            var ID = "<?php echo $ID;?>"
            alert("Payment added successfully");
            location.href = "../Investor_Profile?ID="+ID;
        </script>
        <?php
     }
      else{
        ?>
        <script>
            var ID = "<?php echo $ID;?>"
            alert("Something went wrong in adding balance in investor account try again");
            location.href = "../Investor_Profile?ID="+ID;
        </script>
        <?php
      }
  }
  elseif($tranType == 1){
      // subtrack balance
      $investorBalance = DBHelper::get("SELECT balance FROM investor_account WHERE investorID = {$ID}")->fetch_assoc()["balance"];
      if($amount > $investorBalance){
        ?>
        <script>
            var ID = "<?php echo $ID;?>"
            alert("Subtract amount should not be greater then current balance try again");
            location.href = "../Investor_Profile?ID="+ID;
        </script>
        <?php
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
            ?>
            <script>
                var ID = "<?php echo $ID;?>"
                alert("Payment subtracted successfully");
                location.href = "../Investor_Profile?ID="+ID;
            </script>
            <?php
        }
        else{
          ?>
            <script>
            var ID = "<?php echo $ID;?>"
            alert("Transaction failed try again later");
            location.href = "../Investor_Profile?ID="+ID;
            </script>
          <?php  
        }
      }
    }

}
else{
    ?>
    <script>
    alert("Invalid data is provided!");
    location.href = "../InvestorList";
    </script>
  <?php 
}
