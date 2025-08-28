<?php
// 代码生成时间: 2025-08-29 05:31:42
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ErrorLogCollector {

    /**
     * Collects an error and logs it to a file.
     *
     * @param Exception $exception The exception to be logged.
     * @return void
     */
    public function collect(Exception $exception): void
    {
        try {
            // Get the log message from the exception.
            $message = $this->getLogMessage($exception);

            // Write the message to the log file.
            Storage::append(
                config('error_log_collector.log_file'),
                $message
            );

            // Optional: Log the error to the system's log.
            Log::error($message);

        } catch (Exception $e) {
            // Handle any exceptions that occur during the collection process.
            Log::error("Error collecting log: " . $e->getMessage());
        }
    }

    /**
     * Formats the log message from the given exception.
     *
     * @param Exception $exception The exception to format.
     * @return string
     */
    protected function getLogMessage(Exception $exception): string
    {
        // Format the log message with date, file, line, and message.
        return now()->format("Y-m-d H:i:s") . " - " .
               $exception->getFile() . ":" . $exception->getLine() . " - " .
               $exception->getMessage();
    }
}

/**
 * Configuration for the error log collector.
 *
 * This configuration should be placed in a config file, e.g., config/error_log_collector.php
 */

return [
    'log_file' => 'error_log.txt',
];
