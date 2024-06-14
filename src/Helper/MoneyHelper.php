<?php

namespace App\Helper;

class MoneyHelper
{
    public static function isGreaterThanByAtLeast100(int $number1, int $number2): bool
    {
        return $number1 - $number2 >= 100;
    }
}