<?php
// 代码生成时间: 2025-08-02 11:20:10
namespace App\Services;

class SortingAlgorithmService {

    /**
     * Sorts an array using bubble sort algorithm.
     *
     * @param array $array The array to be sorted.
     * @return array The sorted array.
     */
    public function bubbleSort(array $array): array {
        // Error handling for non-array input.
        if (!is_array($array)) {
            throw new \Exception('Input must be an array.');
        }

        $n = count($array);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap elements.
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }
        return $array;
    }

    /**
     * Sorts an array using selection sort algorithm.
     *
     * @param array $array The array to be sorted.
     * @return array The sorted array.
     */
    public function selectionSort(array $array): array {
        // Error handling for non-array input.
        if (!is_array($array)) {
            throw new \Exception('Input must be an array.');
        }

        $n = count($array);
        for ($i = 0; $i < $n - 1; $i++) {
            // Find the minimum element in unsorted array.
            $minIndex = $i;
            for ($j = $i + 1; $j < $n; $j++) {
                if ($array[$j] < $array[$minIndex]) {
                    $minIndex = $j;
                }
            }
            // Swap the found minimum element with the first element.
            $temp = $array[$minIndex];
            $array[$minIndex] = $array[$i];
            $array[$i] = $temp;
        }
        return $array;
    }

    /**
     * Sorts an array using insertion sort algorithm.
     *
     * @param array $array The array to be sorted.
     * @return array The sorted array.
     */
    public function insertionSort(array $array): array {
        // Error handling for non-array input.
        if (!is_array($array)) {
            throw new \Exception('Input must be an array.');
        }

        for ($i = 1; $i < count($array); $i++) {
            $key = $array[$i];
            $j = $i - 1;

            while ($j >= 0 && $array[$j] > $key) {
                $array[$j + 1] = $array[$j];
                $j--;
            }
            $array[$j + 1] = $key;
        }
        return $array;
    }

    // Additional sorting algorithms can be added here.
}
