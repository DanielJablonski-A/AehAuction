<?php

namespace App\Helper;

/**
 * $nettoAmount = 100;
 * $vatRate = 23;
 * $bruttoAmount = TaxCalculator::nettoToBrutto($nettoAmount, $vatRate);
 * echo "Kwota netto: $nettoAmount zł, VAT: $vatRate%, Kwota brutto: $bruttoAmount zł\n";
 *
 * $bruttoAmount = 123;
 * $vatRate = 23;
 * $nettoAmount = TaxCalculator::bruttoToNetto($bruttoAmount, $vatRate);
 * echo "Kwota brutto: $bruttoAmount zł, VAT: $vatRate%, Kwota netto: $nettoAmount zł\n";
 */

class TaxCalculator
{
    public static function nettoDatabaseToBrutto(float $netto, int $vat): int
    {
        $first = $netto * (1 + ($vat / 100));
        $second = MoneyConverter::convertFromMinorUnitExtra($first);
        $third = round($second, 2, PHP_ROUND_HALF_UP);

        return $third;
    }

    public static function bruttoToNetto(int $brutto, int $vat): int
    {
        return MoneyConverter::convertToMinorUnitExtra($brutto / (1 + ($vat / 100)));
    }
}