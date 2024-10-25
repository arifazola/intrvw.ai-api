<?php
namespace App\Helpers;

class OtpGenerator{
    public function generate(): int {
        $otp = "";

        for($i = 0; $i <= 5; $i ++){
            $randomInt = random_int(0, 9);
            $otp .= $randomInt;
        }

        return $otp;
    }
}