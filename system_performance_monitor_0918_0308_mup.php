<?php
// 代码生成时间: 2025-09-18 03:08:59
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\PerformanceMonitorException;
use App\Services\SystemServiceInterface;
use Exception;

class SystemPerformanceMonitor implements SystemServiceInterface
{
    // Get CPU usage
    public function getCpuUsage(): float
    {
        $output = shell_exec('top -bn 1 | grep "Cpu(s)" | sed "s/.*, *\([0-9.]*\)%* id.*/\1/;s/.*, *\([0-9.]*\)%* Cpu.*/\1/;"');
        if ($output) {
            $output = trim($output);
            if (is_numeric($output)) {
                return $output;
            }
        }
        throw new PerformanceMonitorException('Failed to get CPU usage');
    }

    // Get memory usage
    public function getMemoryUsage(): float
    {
        $output = shell_exec('free -m | awk \'NR==2{printf \"%.2f\", $3/$2 * 100.0}\'');
        if ($output) {
            $output = trim($output);
            if (is_numeric($output)) {
                return $output;
            }
        }
        throw new PerformanceMonitorException('Failed to get memory usage');
    }

    // Get disk usage
    public function getDiskUsage(): float
    {
        $output = shell_exec('df -h | awk \\'NR==2{print \"{ \\