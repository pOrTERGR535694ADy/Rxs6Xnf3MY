<?php
// 代码生成时间: 2025-09-23 13:13:54
class MemoryUsageAnalyzer {

    /**
     * Get the current memory usage in bytes.
     *
     * @return int
     */
    public function getCurrentMemoryUsage() {
        return memory_get_usage();
    }

    /**
     * Get the peak memory usage in bytes.
     *
     * @return int
     */
    public function getPeakMemoryUsage() {
        return memory_get_peak_usage();
    }

    /**
     * Get the memory limit in bytes.
     *
     * @return int
     */
    public function getMemoryLimit() {
        $memoryLimit = ini_get('memory_limit');
        if ($memoryLimit === '-1') {
            return 'Unlimited';
        }

        $memoryLimit = $this->convertToBytes($memoryLimit);
        return $memoryLimit;
    }

    /**
     * Convert the memory limit from a string to bytes.
     *
     * @param string $memoryLimit
     * @return int
     */
    private function convertToBytes($memoryLimit) {
        $memoryLimitValue = substr($memoryLimit, 0, -1);
        $memoryLimitUnit = substr($memoryLimit, -1);

        switch (strtoupper($memoryLimitUnit)) {
            case 'G':
                return $memoryLimitValue * 1024 * 1024 * 1024;
            case 'M':
                return $memoryLimitValue * 1024 * 1024;
            case 'K':
                return $memoryLimitValue * 1024;
            default:
                return (int) $memoryLimitValue;
        }
    }
}

// Example usage:
$analyzer = new MemoryUsageAnalyzer();
$currentMemoryUsage = $analyzer->getCurrentMemoryUsage();
$peakMemoryUsage = $analyzer->getPeakMemoryUsage();
$memoryLimit = $analyzer->getMemoryLimit();

echo "Current Memory Usage: " . $currentMemoryUsage . " bytes
";
echo "Peak Memory Usage: " . $peakMemoryUsage . " bytes
";
echo "Memory Limit: " . (is_numeric($memoryLimit) ? $memoryLimit . " bytes" : $memoryLimit) . "
";
