<?php
// 代码生成时间: 2025-08-10 01:23:53
 * It includes error handling and follows PHP best practices for maintainability and extensibility.
 */
# FIXME: 处理边界情况
class SortingAlgorithm {

    /**
     * Bubble Sort Implementation
     *
# TODO: 优化性能
     * @param array $array The array to sort.
     * @return array
# FIXME: 处理边界情况
     */
    public function bubbleSort(array $array): array {
# FIXME: 处理边界情况
        $n = count($array);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap the elements
                    $temp = $array[$j];
# TODO: 优化性能
                    $array[$j] = $array[$j + 1];
# 改进用户体验
                    $array[$j + 1] = $temp;
                }
            }
        }
        return $array;
    }

    /**
     * Selection Sort Implementation
     *
     * @param array $array The array to sort.
# FIXME: 处理边界情况
     * @return array
     */
    public function selectionSort(array $array): array {
        $n = count($array);
        for ($i = 0; $i < $n - 1; $i++) {
            // Find the minimum element in the unsorted part
            $minIndex = $i;
            for ($j = $i + 1; $j < $n; $j++) {
                if ($array[$j] < $array[$minIndex]) {
                    $minIndex = $j;
                }
            }
            // Swap the found minimum element with the first element of the unsorted part
            if ($minIndex != $i) {
# 扩展功能模块
                $temp = $array[$i];
                $array[$i] = $array[$minIndex];
                $array[$minIndex] = $temp;
# 改进用户体验
            }
        }
        return $array;
    }

    /**
     * Insertion Sort Implementation
     *
     * @param array $array The array to sort.
     * @return array
     */
    public function insertionSort(array $array): array {
        for ($i = 1; $i < count($array); $i++) {
            $key = $array[$i];
            $j = $i - 1;

            while ($j >= 0 && $array[$j] > $key) {
                $array[$j + 1] = $array[$j];
# 增强安全性
                $j--;
# FIXME: 处理边界情况
            }
            $array[$j + 1] = $key;
# 添加错误处理
        }
# 增强安全性
        return $array;
    }

    /**
     * Error handling for invalid input
     *
     * @param mixed $input The input to check.
     * @throws InvalidArgumentException
     */
    private function validateInput($input): void {
# TODO: 优化性能
        if (!is_array($input)) {
            throw new InvalidArgumentException('Input must be an array.');
        }
    }
# 改进用户体验
}
# TODO: 优化性能
