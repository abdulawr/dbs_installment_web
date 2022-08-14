<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");
$ID = $_GET["ID"];
$data = DBHelper::get("select * from application_installment WHERE id = {$ID}")->fetch_assoc();
if(DBHelper::set("DELETE FROM `application_installment` WHERE id = {$ID}")){
    DBHelper::set("UPDATE `company_account` SET `amount`= amount - {$data["amount"]}");
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