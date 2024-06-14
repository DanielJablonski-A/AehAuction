<?php

namespace App\Helper;

/**
 * // Przykładowe użycie:
 * $zlotyAmount = 10.50;
 * $groszAmount = MoneyConverter::convertToMinorUnit($zlotyAmount);
 * echo "$zlotyAmount zł = $groszAmount groszy\n";
 *
 * $groszAmount = 1050;
 * $zlotyAmount = MoneyConverter::convertFromMinorUnit($groszAmount);
 * echo "$groszAmount groszy = $zlotyAmount zł\n";
 */

class MoneyConverter
{
    public static function convertToMinorUnit(float $amount): int
    {
        return (int) ($amount * 100);
    }

    public static function convertFromMinorUnit(int $amount): int
    {
        return $amount / 100;
    }

    public static function convertToMinorUnitExtra(float $amount): int
    {
        return (int) ($amount * 1000000);
    }

    public static function convertFromMinorUnitExtra(int $amount): float
    {
        return $amount / 1000000;
    }

    public static function convertToFloat(string $amount): float
    {
        $amount = preg_replace('/[^0-9.,]/', '', $amount);
        $amount = str_replace(',', '.', str_replace('.', '', $amount));

        return (float) $amount;
    }
}

?>
