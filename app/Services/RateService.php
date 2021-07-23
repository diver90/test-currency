<?php


namespace App\Services;


use App\Models\Rate;

class RateService
{
    public static function calcAmount($sum, $base, $quote)
    {
        $baseRate  = Rate::select('rate')->where('symbol', '=', $base)->latest()->first()->rate;
        $quoteRate  = Rate::select('rate')->where('symbol', '=', $quote)->latest()->first()->rate;
        $result['amount'] = $baseRate/$quoteRate*$sum;
        $result['symbol'] = $base;
        $timestamp = time();
        return [$result,$timestamp];
    }
}
