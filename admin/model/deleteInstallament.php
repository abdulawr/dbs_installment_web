<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");
$ID = $_GET["ID"];
$data = DBHelper::get("select * from application_installment WHERE id = {$ID}")->fetch_assoc();

$company_id = $_SESSION["company_id"];
$company_account = DBHelper::get("SELECT * FROM `company_account` WHERE id = $company_id");
$balance = $company_account->fetch_assoc()["amount"];

if($balance < $data["amount"]){
    ?>
    <script>
        alert("Company does not have enough balance to perform this transcation");
        location.href = "../View_Application?ID=<?php echo $_GET['appID'];?>";
    </script>
    <?php
    exit;
}

if(DBHelper::set("DELETE FROM `application_installment` WHERE id = {$ID}")){
    DBHelper::set("UPDATE `company_account` SET `amount`= amount - {$data["amount"]} where id = $company_id");
    ?>
    <script>
        alert("Successfully deleted");
        location.href = "../View_Application?ID=<?php echo $_GET['appID'];?>";
    </script>
    <?php
}
else{
    ?>
   <script>
        alert("Something went wrong try again");
        location.href = "../View_Application?ID=<?php echo $_GET['appID'];?>";
    </script>
    <?php
    exit;
}
?>