<?php
// 代码生成时间: 2025-09-01 01:01:06
 * It is designed to be easily understood, maintainable, and extensible.
 */
class SortingAlgorithm {

    /**
     * Sorts an array using the bubble sort algorithm.
     *
     * @param array $array The array to sort.
     * @return array The sorted array.
     * @throws InvalidArgumentException If the input is not an array.
     */
    public function bubbleSort(array $array): array {
        if (!is_array($array)) {
            throw new InvalidArgumentException('Input must be an array.');
        }

        $length = count($array);
        for ($i = 0; $i < $length - 1; $i++) {
            for ($j = 0; $j < $length - 1 - $i; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap elements if they are in the wrong order.
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }

        return $array;
    }
}

// Example usage:
$algorithm = new SortingAlgorithm();
$unsortedArray = [5, 3, 8, 4, 2];
try {
    $sortedArray = $algorithm->bubbleSort($unsortedArray);
    print_r($sortedArray);
} catch (InvalidArgumentException $e) {
    // Handle error if input is not an array.
    echo "Error: " . $e->getMessage();
}