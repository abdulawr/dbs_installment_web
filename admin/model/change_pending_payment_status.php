<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

if(isset($_GET["ID"]) && isset($_GET["investID"])){

 if(DBHelper::set("UPDATE application_investor_pending_payment set status = 1 WHERE id = {$_GET["ID"]} and investorID = {$_GET["investID"]}")){
   $payment = DBHelper::get("SELECT * FROM `application_investor_pending_payment` WHERE id = {$_GET["ID"]} and investorID = {$_GET["investID"]}")->fetch_assoc();
   if(DBHelper::set("UPDATE `investor_account` set `balance`= balance + {$payment["total_amount"]} WHERE investorID = {$_GET["investID"]}")){
    ?>
    <script>
        var ID = "<?php echo $_GET["investID"];?>"
        alert("Application amount is succesfully added into investor account");
        location.href = "../Investor_Profile?ID="+ID;
    </script>
    <?php
   } 
   else{
    DBHelper::set("UPDATE application_investor_pending_payment set status = 0 WHERE id = {$_GET["ID"]} and investorID = {$_GET["investID"]}");  
    ?>
    <script>
        var ID = "<?php echo $_GET["investID"];?>"
        alert("Something went wrong try again");
        location.href = "../Investor_Profile?ID="+ID;
    </script>
    <?php
   }
}
 else{
    ?>
    <script>
        var ID = "<?php echo $_GET["investID"];?>"
        alert("Something went wrong try again");
        location.href = "../Investor_Profile?ID="+ID;
    </script>
    <?php
 }
}
else{
    die("Try to access the data with invalid details");
}

?>