<?php
include_once("include.php");

if(isset($_POST["submitRequest"]) && trim($_POST["submitRequest"]) == "submitRequest"){
   $name = validateInput($_POST["name"]);
   $mobile = validateInput($_POST["mobile"]);
   $stockID = validateInput($_POST["id"]);
   $date = date("Y-m-d");

   if(DBHelper::set("INSERT INTO db_shop_buy_request(cus_name,date,cus_mobile,stockID,status,sell_price) VALUES('{$name}','{$date}','{$mobile}',{$stockID},0,0);")){
    echo json_encode(["status"=>1,"message"=>"Request submitted successfully!"]); 
   }
   else{
    echo json_encode(["status"=>0,"message"=>"Error occured while submitting your request!"]);  
   }

}
else{
    // get stock data on the bases of ID
    $stockID = validateInput($_POST["ID"]);
    $qry="SELECT dbs_shop_stock.*,name as 'comp' FROM dbs_shop_stock INNER JOIN 
    mobile_company_dbs ON companyID = mobile_company_dbs.id where dbs_shop_stock.id = {$stockID}";
    $stock=DBHelper::get($qry);
    if($stock->num_rows > 0){
     echo json_encode(["status"=>1,"message"=>"Data found","data"=>$stock->fetch_assoc()]);
    }
    else{
        echo json_encode(["status"=>0,"message"=>"Id not found"]);
    }
}
?>