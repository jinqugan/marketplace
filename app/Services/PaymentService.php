<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Status;

class PaymentService
{
    public function paymentStatus(Array $params = [])
    {
        $statuses = Cache::remember('payment_status', 5, function () {
            return Status::select('id', 'name')
            ->where(['type' => 'payment'])
            ->get();
        });

        if (!empty($params['keyBy'])) {
            $statuses = $statuses->keyBy($params['keyBy']);
        }

        return $statuses->toArray();
    }

    function validateLuhn(string $number): bool
    {
        $sum = 0;
        $flag = 0;

        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $add = $flag++ & 1 ? $number[$i] * 2 : $number[$i];
            $sum += $add > 9 ? $add - 9 : $add;
        }

        return $sum % 10 === 0;
    }

//     public function checkLuhn(string $cardNumber)
//     {
//         $length = strlen($cardNumber);
 
//         for ($i = $length - 1; $i >= 0; $i--) {
    
//             int d = $cardNumber[$i] - '0';
    
//             if (isSecond == true)
//                 d = d * 2;
    
//             // We add two digits to handle
//             // cases that make two digits after
//             // doubling
//             nSum += d / 10;
//             nSum += d % 10;
    
//             isSecond = !isSecond;
//         }
//     return (nSum % 10 == 0);
// }
}
