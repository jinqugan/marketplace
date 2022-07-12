<?php

namespace App\Traits;

use Exception;

trait MethodTrait {
    
    /**
     * validate credit/debit number using luhn algorithm
     */
    function validateLuhn(string $number): bool
    {
        $sum = 0;
        $flag = 0;

        /**
         * remove space between $number
         */
        $number = preg_replace('/\s+/', '', $number);

        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $add = $flag++ & 1 ? $number[$i] * 2 : $number[$i];
            $sum += $add > 9 ? $add - 9 : $add;
        }

        return $sum % 10 === 0;
    }
}