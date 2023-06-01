<?php

namespace App\Helper;

class MyHelper
{  
    // All OPS Codes
    static $allOpsCodes = ["Local", "Highway", "Admin"];

    // All Job Types
    static $allJobTypes = ["Import", "Export", "Empty Repo", "Yard Move", "Other", "CBSA"];

    // All Movement Types
    static $allMovementTypes = ["Container Pickup", "Container Drop", "Chassis Pickup", "Chassis Drop", "Port Pickup", "Port Drop",
                                 "Customer Pickup", "Customer Drop", "Other Pickup", "Other Drop", "Live Pickup", "Live Drop", "HarbourLink Pickup", "HarbourLink Drop", 
                                 "Empty Pickup", "Empty Drop", "Bobtail Pickup", "Bobtail Drop", "Cancelled Leg", "Dead Run", "Street Turn"];

    //=================================================================================================================================================================

    // Get all Job Types
    public static function GetAllOpsCodes() {
        return(MyHelper::$allOpsCodes);
    }  

    // Get all Job Types
    public static function GetAllJobTypes() {
        return(MyHelper::$allJobTypes);
    }  

    // Get all Movement Types
    public static function GetAllMovementTypes() {
        return(MyHelper::$allMovementTypes);
    }  
                                 
    // Get commonly used Movement Types
    public static function GetCommonMovementTypes() {
        $commonMTs = [];
        for ($i=0; $i<12; $i++) {
            $commonMTs[$i] = MyHelper::$allMovementTypes[$i];
        }

        return($commonMTs);
    }  

    // Get the 'created' booking status
    public static function BkCreatedStaus() {
        return "bk_created";
    }  

    // Get the 'created' container status
    public static function CntnrCreatedStaus() {
        return "cntnr_created";
    }  

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