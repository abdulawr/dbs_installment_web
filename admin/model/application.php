<?php
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

$cusID = $_GET["cusID"];
$date = date("Y-m-d h:i:s");

$monthly_income =   DBHelper::escape($_POST["monthly_income"]);
$business_type =    DBHelper::escape($_POST["business_type"]);
$bus_address =      DBHelper::escape($_POST["bus_address"]);
$product_name =     DBHelper::escape($_POST["product_name"]);
$company_name_id =  DBHelper::escape($_POST["company_name_id"]);
$model_number =     DBHelper::escape($_POST["model_number"]);
$item_type =        DBHelper::escape($_POST["item_type"]);
$total_price =      DBHelper::escape($_POST["total_price"]);
$age =              DBHelper::escape($_POST["age"]);
$percentage_on_item =  DBHelper::escape($_POST["percentage_on_item"]);
$orginal_price =  DBHelper::escape($_POST["orginal_price"]);
$advance_payment =  DBHelper::escape($_POST["advance_payment"]);
$monthly_payment =  DBHelper::escape($_POST["monthly_payment"]);
$install_months =  DBHelper::escape($_POST["install_months"]);
$ref_by =  DBHelper::escape($_POST["ref_by"]);
$item_desp =  DBHelper::escape($_POST["item_desp"]);

$qry = "INSERT INTO application(item_des,cusID,
age,
monthly_income,
business_type,
business_address,
date,
model_no,
companyID,
product_name,
item_type_id,
product_orginal_price,
percentage_on_prod,
total_price,
installment_months,
monthly_payment,
advance_payment,
ref_by) VALUES (
    '{$item_desp}',
   $cusID,
    $age,
    $monthly_income,
    '{$business_type}',
    '{$bus_address}',
    '{$date}',
    '{$model_number}',
    $company_name_id,
    '{$product_name}',
    $item_type,
    $orginal_price,
    $percentage_on_item,
    $total_price,
    $install_months,
    $monthly_payment,
    $advance_payment,
    '{$ref_by}'
);";

if(DBHelper::set($qry)){
    $app_ID = $con->insert_id;
   
    $stmt = $con->prepare("INSERT INTO `application_mobile_number`(`mobile`, `appID`) VALUES (?,?)");
    $stmt->bind_param("si", $mobile, $appID);
    for($i = 1; $i<=4; $i++){
        if(!empty($_POST["ph".$i])){
           $mobile = $_POST["ph".$i];
           $appID = $app_ID;
           $stmt->execute();
        }
    }
   
    for($i=1; $i<=2; $i++){
        if(isset($_POST["per".$i])){
    
            $proof_person_image = $_FILES["per_proof_image".$i];
            $proof_cnic_image = $_FILES["per_cnic_image".$i];
            $business_card_image = $_FILES["per_bus_card_file".$i];
    
            $fname = $_POST["fname".$i];
            $org_address = $_POST["org_address".$i];
            $name = $_POST["per_name".$i];
            $cnic = $_POST["per_cnic".$i];
            $mobile = $_POST["per_mobile".$i];
            $bus_address = $_POST["per_address".$i];
            $bussiness_type = $_POST["per_bussiness_type".$i];

            if($proof_person_image["size"] > 0){
             $type = strtolower(explode("/",$proof_person_image["type"])[1]);
             $Proof_Image_Name = "proof_person_profile_".$app_ID."_".$mobile.RandomString(40)."_".".".$type;
             move_uploaded_file($proof_person_image["tmp_name"],"../../images/proof_person/".$Proof_Image_Name);
            }
            else{
              $Proof_Image_Name = "null";
            }
    
            if($proof_cnic_image["size"] > 0){
                $type = strtolower(explode("/",$proof_cnic_image["type"])[1]);
                $Proof_CNIC_Image = "proof_person_cnic_".$app_ID."_".$mobile.RandomString(40)."_".".".$type;
                move_uploaded_file($proof_cnic_image["tmp_name"],"../../images/proof_person/".$Proof_CNIC_Image);
            }
            else{
              $Proof_CNIC_Image = "null";
            }
    
            if($business_card_image["size"] > 0){
                $type = strtolower(explode("/",$business_card_image["type"])[1]);
                $Proof_Bus_Card = "proof_business_card_".$app_ID."_".$mobile.RandomString(40)."_".".".$type;
                move_uploaded_file($business_card_image["tmp_name"],"../../images/proof_person/".$Proof_Bus_Card);
            }
            else{
               $Proof_Bus_Card = "null";
            }

            DBHelper::set("INSERT INTO `application_proof_person`(
             fname,
             org_address,
            `name`, 
            `cnic_no`,
            `mobile`, 
            `business_type`, 
            `address`, 
            `image`, 
            `cnic_image`, 
            `business_card_image`,
            `appID`) VALUES (
                '{$fname}',
                '{$org_address}',
                '{$name}',
                '{$cnic}',
                '{$mobile}',
                '{$bussiness_type}',
                '{$bus_address}',
                '{$Proof_Image_Name}',
                '{$Proof_CNIC_Image}',
                '{$Proof_Bus_Card}',
                 $app_ID
            )");
    
        }
    }
   
    ?>
    <script>
        var id="<?php echo $cusID;?>"
        location.replace("../Application?type=pending&msg=success&ID="+id);
    </script>
    <?php
   
   }
   else{
   // fail to create application
   ?>
   <script>
         var id="<?php echo $cusID;?>"
       location.replace("../Customer_Application?msg=error&ID="+id);
   </script>
   <?php
   }

?>