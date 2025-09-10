<?php
// 代码生成时间: 2025-09-10 12:10:38
class MathTool {

    /**
     * Adds two numbers
     *
     * @param float $num1
     * @param float $num2
     * @return float
     */
    public function add($num1, $num2) {
        return $num1 + $num2;
    }

    /**
     * Subtracts two numbers
     *
     * @param float $num1
     * @param float $num2
     * @return float
     */
    public function subtract($num1, $num2) {
        return $num1 - $num2;
    }

    /**
     * Multiplies two numbers
     *
     * @param float $num1
     * @param float $num2
     * @return float
     */
    public function multiply($num1, $num2) {
        return $num1 * $num2;
    }

    /**
     * Divides two numbers
     *
     * @param float $num1
     * @param float $num2
     * @return float
     */
    public function divide($num1, $num2) {
        if ($num2 == 0) {
            throw new InvalidArgumentException('Cannot divide by zero.');
        }
        return $num1 / $num2;
    }

    /**
     * Calculates the power of a number
     *
     * @param float $base
     * @param float $exponent
     * @return float
     */
    public function power($base, $exponent) {
        return pow($base, $exponent);
    }

    /**
     * Calculates the square root of a number
     *
     * @param float $num
     * @return float
     */
    public function squareRoot($num) {
        if ($num < 0) {
            throw new InvalidArgumentException('Cannot calculate square root of a negative number.');
        }
        return sqrt($num);
    }
}
