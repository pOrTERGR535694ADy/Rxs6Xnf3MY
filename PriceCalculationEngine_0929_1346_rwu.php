<?php
// 代码生成时间: 2025-09-29 13:46:09
namespace App\Services;

use Illuminate\Support\Facades\Log;

class PriceCalculationEngine {

    /**
     * Calculate the final price based on initial price and discounts.
     *
     * @param float $initialPrice
     * @param float $discountRate
     * @param array $additionalFees
     * @return float
     */
    public function calculatePrice(float $initialPrice, float $discountRate, array $additionalFees = []): float {
        // Ensure the initial price is greater than zero
        if ($initialPrice <= 0) {
            Log::error("Initial price must be greater than zero.");
            throw new \Exception("Initial price must be greater than zero.");
        }

        // Calculate the discount amount
        $discountAmount = $initialPrice * ($discountRate / 100);

        // Calculate the price after discount
        $priceAfterDiscount = $initialPrice - $discountAmount;

        // Add additional fees to the price
        $totalAdditionalFees = array_sum($additionalFees);
        $finalPrice = $priceAfterDiscount + $totalAdditionalFees;

        return $finalPrice;
    }
}
