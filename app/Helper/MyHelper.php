<?php

namespace App\Helper;

class MyHelper
{
    // Get the hyphen separated phone number
    public static function GetHyphenedPhoneNo($digitalNo) {
        $len = strlen($digitalNo);
        
        if ($len == 7) {
            return substr($digitalNo, 0, 3).'-'.substr($digitalNo, 3, 4);
        } elseif ($len == 10) {
            return substr($digitalNo, 0, 3).'-'.substr($digitalNo, 3, 3).'-'.substr($digitalNo, 6, 4);
        } elseif ($len == 11) {
            return substr($digitalNo, 0, 1).'-'.substr($digitalNo, 1, 3).'-'.substr($digitalNo, 4, 3).'-'.substr($digitalNo, 7, 4);
        } else {
            return $digitalNo;
        }
    } 

    // Get the numerice phone number only (no hyphen, no parantheses, no space...)
    public static function GetNumericPhoneNo($inPhoneNo) {
        $len = strlen($inPhoneNo);
        $numericPhoneNo = "";
        
        for ($idx=0; $idx<$len; $idx++) {
            $currentChar = substr($inPhoneNo, $idx, 1);
            if ($currentChar >= chr(48) && $currentChar <= chr(57)) {
                $numericPhoneNo .= $currentChar;
            }
        }

        return $numericPhoneNo;
    } 
}

?>