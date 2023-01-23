<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

$appID = $_POST["appID"];
$discount_amount = $_POST["amount"];
$investor_amount = ceil($discount_amount / 100) * 75;
$company_amount = ceil($discount_amount / 100) * 25;

$company_id = $_SESSION["company_id"];
$company_account = DBHelper::get("SELECT * FROM `company_account` WHERE id = $company_id");
$balance = $company_account->fetch_assoc()["amount"];

if($balance < $company_amount){
    ?>
    <script>
        var id = "<?php echo $appID;?>";
        alert("Company does not have enough balance to perform this transcation");
        location.replace("../View_Application?ID="+id);
    </script>
    <?php 
    exit;
}

$details = DBHelper::get("SELECT * FROM `application` WHERE id = {$appID} and company_id = $company_id")->fetch_assoc();
if(DBHelper::set("UPDATE application set `total_price`= total_price - {$discount_amount},discount_amount={$discount_amount} WHERE id = {$appID}")){
 DBHelper::set("UPDATE `company_account` SET `amount`= amount - {$company_amount} where id = $company_id");
 DBHelper::set("UPDATE investor_account SET balance = balance - {$investor_amount} WHERE investorID = {$details["investorID"]} and company_id = $company_id");

 ?>
 <script>
     var id = "<?php echo $appID;?>";
     alert("Action perform successfully");
     location.replace("../View_Application?ID="+id);
 </script>
 <?php 
}
else{
    ?>
        <script>
            var id = "<?php echo $appID;?>";
            alert("Something went wrong try again");
            location.replace("../View_Application?ID="+id);
        </script>
        <?php 
}


?>