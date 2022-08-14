<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");


if(isset($_GET["ID"])){
    $ID = DBHelper::escape($_GET["ID"]);
    $app = DBHelper::get("select * from application where id = {$ID}")->fetch_assoc();

    if(DBHelper::set("UPDATE application SET advance_payment_status=1,advance_payment_paid={$app["advance_payment"]} WHERE id = {$ID}")){
        ?>
        <script>
            var id = "<?php echo $ID;?>";
            alert("Status change successfully");
            location.replace("../View_Application?ID="+id);
        </script>
        <?php
    }
    else{
        ?>
        <script>
             var id = "<?php echo $ID;?>";
            alert("Something went wrong try again");
            location.replace("../View_Application?ID="+id);
        </script>
        <?php
    }
}
else{
   ?>
   <script>
       alert("Something went wrong try again");
       location.href="../Application";
   </script>
   <?php
}
?>