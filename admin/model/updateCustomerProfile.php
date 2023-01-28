<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $cnic= $_POST["cnic"];
    $mobile = $_POST["mobile"];
    $address = $_POST["address"];
    $id = $_POST["id"];
    $cusImage = $_POST["cusImage"];
    $file = $_FILES["investorImage"];

if(DBHelper::set("UPDATE `customer` SET `name`='{$name}',`cnic`='{$cnic}',`mobile`='{$mobile}',`address`='{$address}' WHERE id =$id and company_id = '{$_SESSION["company_id"]}' ")){
     
      if(!empty($file["name"]) && $file["size"] > 0){
        $fileName = explode(".",$cusImage)[0];
        $ff = explode(".",$cusImage)[0];
        $ttps = explode(".",$cusImage)[1];
        $type=$file["type"];
        $type=explode("/",$type)[1];
        $fileName .=".".$type;

        if(move_uploaded_file($file["tmp_name"],"../../images/customer/".$fileName)){
          DBHelper::set("UPDATE `customer` SET `image`='{$fileName}' where id = {$id} and company_id = '{$_SESSION["company_id"]}'");
          if(trim($ttps) != trim($type)){
            unlink("../../images/customer/".$ff.".".$ttps);
          }
        }
      }
      header("Location: ../Customer_Profile.php?ID=".$id."&msg=success");
    }
    else{
        header("Location: ../Customer_Profile.php?ID=".$id."&msg=error");
    }
}
else{
    header("Location: ../Customer_Profile.php?ID=".$id."&msg=error");
}

?>