<?php
class DBHelper{
    public static function set($query)
    {
      $con=$GLOBALS["con"];
      if($con->query($query))
      {
       return true;
      }
      else{
          return false;
      }
    }

    public static function get($query)
    {
        $con=$GLOBALS["con"];
        return $con->query($query);
    }

    public static function escape($str)
    {
        $con=$GLOBALS["con"];
        return $con->real_escape_string($str);
    }

    public static function intCodeRandom($length = 8)
    {
      $intMin = (10 ** $length) / 10; // 100...
      $intMax = (10 ** $length) - 1;  // 999...

      $codeRandom = mt_rand($intMin, $intMax);

      return $codeRandom;
    }
}

?>