<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");


if(isset($_POST["ID"])){
    $ID = DBHelper::escape($_POST["ID"]);
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