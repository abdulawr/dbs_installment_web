<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

if(isset($_GET["id"]) && isset($_GET["status"])){

    if(DBHelper::set("UPDATE admin set account_status = {$_GET["status"]} WHERE id = {$_GET["id"]}")){
        ?>
        <script>
            var id = "<?php echo $_GET["id"];?>";
            alert("Action perform successfully");
            location.replace("../adminProfile?ID="+id);
        </script>
       <?php 
    }
    else{
        ?>
        <script>
            var id = "<?php echo $_GET["id"];?>";
            alert("Something went wrong try again");
            location.replace("../adminProfile?ID="+id);
        </script>
       <?php  
    }
}
else{
   die("Invalid access is not allowed");
}
?>