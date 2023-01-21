<?php 
 function validateInput($value)
 {
   $data = trim($value);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = $GLOBALS["con"]-> real_escape_string($data);
  return $data;
 }

 function isAdmin($api_key){
  $check = DBHelper::get("select id from app_login where api_key = '{$api_key}' and status = 1");
  return ($check->num_rows > 0) ? true : false;
 }

 // True customer exist
 function customerCheck($mobile,$cnic){
  $check = DBHelper::get("SELECT * FROM customer WHERE cnic = '{$cnic}' or mobile = '{$mobile}'");
  return ($check->num_rows > 0) ? true : false;
 }

  // True investor exist
  function investorCheck($mobile,$cnic){
    $check = DBHelper::get("SELECT * FROM investor WHERE cnic = '{$cnic}' or mobile = '{$mobile}'");
    return ($check->num_rows > 0) ? true : false;
   }

     // True investor exist
  function shopkeeperCheck($mobile,$cnic){
    $check = DBHelper::get("SELECT * FROM shopkeeper WHERE cnic = '{$cnic}' or mobile = '{$mobile}'");
    return ($check->num_rows > 0) ? true : false;
   }

 function is_english($str)
 {
   if (strlen($str) != strlen(utf8_decode($str))) {
     return false;
   } else {
     return true;
   }
 }
 
function RandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>