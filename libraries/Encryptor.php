<?php
namespace Libraries;

class Encryptor{
    function decrypt($string, $key) {
        $cipher = "AES-256-CBC";

        // Decode the Base64 encoded string
        $c = base64_decode($string);

        // Get the IV length for the cipher
        $ivlen = openssl_cipher_iv_length($cipher);
        
        // Extract the IV (first $ivlen bytes)
        $iv = substr($c, 0, $ivlen);

        // Extract the ciphertext (remaining bytes)
        $ciphertext = substr($c, $ivlen);

        // Debug: Output IV and ciphertext in hex format to check if they are properly extracted
        echo "IV (Hex): " . bin2hex($iv) . "\n";
        echo "Ciphertext (Hex): " . bin2hex($ciphertext) . "\n";

        // Perform the decryption
        $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        if ($original_plaintext === false) {
            echo "Decryption errorrr: " . openssl_error_string() . "\n";
        }

        return $original_plaintext;
    }
}