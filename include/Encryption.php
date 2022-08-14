<?php
class Encryption{
    public static function Encrypt($simple_string)
    {
        $ciphering = "AES-128-CTR"; 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        $encryption_iv = '1234567891011121'; 
        $encryption_key = "tcomprog@gmail.com"; 
        $encryption = openssl_encrypt($simple_string, $ciphering, 
                    $encryption_key, $options, $encryption_iv); 
      return $encryption;
    }
    public static function Decrypt($encryption)
    {
        $decryption_iv = '1234567891011121'; 
        $decryption_key = "tcomprog@gmail.com"; 
        $ciphering = "AES-128-CTR"; 
        $options = 0; 
        $decryption=openssl_decrypt ($encryption, $ciphering,  
                $decryption_key, $options, $decryption_iv); 
                return $decryption; 
    }
}
?>