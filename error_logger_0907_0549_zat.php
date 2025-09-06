<?php
// 代码生成时间: 2025-09-07 05:49:22
use Illuminate\Support\Facades\Log;
use Psr\Log\LogLevel;

class ErrorLogger {
    // 定义日志文件路径
    private string $logFilePath;

    // 构造函数，设置日志文件路径
    public function __construct(string $logFilePath) {
        $this->logFilePath = $logFilePath;
    }

    // 记录错误日志
    public function logError($message, $level = LogLevel::ERROR): void {
        try {
            // 检查日志文件路径是否存在
            if (!file_exists($this->logFilePath) && !is_writable($this->logFilePath)) {
                throw new \Exception("Log file path is not writable.");
            }

            // 使用 Laravel 的日志系统记录错误
            Log::channel('custom')->write($level, $message, ['extra' => 'Extra info']);

            // 记录错误到自定义日志文件
            file_put_contents($this->logFilePath, '[' . date('Y-m-d H:i:s') . '] ' . $message . "\
", FILE_APPEND);

        } catch (\Exception $e) {
            // 错误处理
            Log::error("Error logging error: " . $e->getMessage());
        }
    }

    // 添加日志文件路径
    public function setLogFilePath(string $logFilePath): void {
        $this->logFilePath = $logFilePath;
    }

    // 获取日志文件路径
    public function getLogFilePath(): string {
        return $this->logFilePath;
    }
}
