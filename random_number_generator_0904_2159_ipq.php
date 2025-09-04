<?php
// 代码生成时间: 2025-09-04 21:59:12
class RandomNumberGenerator {
    /**
     * Generates a random number between $min and $max.
     *
     * @param int $min Minimum value of the range.
     * @param int $max Maximum value of the range.
     * @return int Random number within the specified range.
     * @throws InvalidArgumentException If $min is not less than $max.
     */
    public function generate(int $min, int $max): int {
        // Check if the range is valid
        if ($min >= $max) {
            throw new InvalidArgumentException("The minimum value must be less than the maximum value.");
        }

        // Generate and return a random number
        return rand($min, $max);
    }
}

// Usage example
try {
    $generator = new RandomNumberGenerator();
    $randomNumber = $generator->generate(1, 100);
    echo "Generated random number: $randomNumber";
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage();
}
