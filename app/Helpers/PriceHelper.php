<?php

namespace App\Helpers;

class PriceHelper
{
    public static function idr($number, $decimal = 0, $with_rp = false)
    {
        $result = '';

        if ($with_rp)
            $result .= 'Rp. ';

        $result .= number_format($number, $decimal, ',', '.');
        return $result;
    }
}
