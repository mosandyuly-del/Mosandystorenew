<?php
namespace App\Services\Pricing;

class PriceCalculatorService
{
    public function calculate(float $cost, string $type = 'percentage', float $value = 0): array
    {
        $profit = $type === 'fixed' ? $value : round($cost * $value / 100, 2);
        return ['cost' => $cost, 'profit' => $profit, 'selling_price' => $cost + $profit];
    }
}
