<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

if(isset($_POST["submit"])){
    $file = $_FILES["investorImage"];
    $name = $_POST["name"];
    $cnic= $_POST["cnic"];
    $mobile = $_POST["mobile"];
    $address = $_POST["address"];
    $id = $_POST["ID"];
    $invImage = $_POST["invImage"];

    if(DBHelper::set("UPDATE `investor` SET `name`='{$name}',`cnic`='{$cnic}',`mobile`='{$mobile}',`address`='{$address}' WHERE id =$id and company_id = '{$_SESSION["company_id"]}'")){
      if(!empty($file["name"]) && $file["size"] > 0){
        $fileName = explode(".",$invImage)[0];
        $type=$file["type"];
        $ff = explode(".",$invImage)[0];
        $ttps = explode(".",$invImage)[1];
        $type=explode("/",$type)[1];
        $fileName .=".".$type;
        if(move_uploaded_file($file["tmp_name"],"../../images/investor/".$fileName)){
          DBHelper::set("UPDATE `investor` SET `image`='{$fileName}' where id = {$id} and company_id = '{$_SESSION["company_id"]}'s");
          if(trim($ttps) != trim($type)){
            unlink("../../images/customer/".$ff.".".$ttps);
          }
        }
      }
      header("Location: ../Investor_Profile.php?ID=".$id."&msg=success");
    }
    else{
        header("Location: ../Investor_Profile.php?ID=".$id."&msg=error");
    }
}
else{
    header("Location: ../Investor_Profile.php?ID=".$id."&msg=error");
}

?>