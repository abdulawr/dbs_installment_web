<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

$ID = DBHelper::escape($_POST["ID"]);
$des = DBHelper::escape($_POST["des"]);

if(DBHelper::set("UPDATE application SET status = 5,rej_des='{$des}' WHERE id = {$ID}")){
    ?>
    <script>
                   var ID = "<?php echo $ID;?>"
                   alert("Action perform successfully");
                   location.href = "../View_Application?ID="+ID;
   </script>
   <?php
}
else{
?>
 <script>
                var ID = "<?php echo $ID;?>"
                alert("Something went wrong try again");
                location.href = "../View_Application?ID="+ID;
</script>
<?php
}

?>