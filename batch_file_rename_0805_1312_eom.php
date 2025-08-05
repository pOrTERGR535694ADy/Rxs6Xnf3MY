<?php
// 代码生成时间: 2025-08-05 13:12:56
 * It follows Laravel's best practices for code structure, error handling, and maintainability.
 *
 * @author Your Name
 * @version 1.0.0
 * @package FileManagement
 */

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

class BatchFileRename {
    /**
     * Directory containing the files to rename.
     *
     * @var string
     */
    protected $directory;

    /**
     * Constructor to set the directory path.
     *
     * @param string $directory Path to the directory containing files.
     */
    public function __construct($directory) {
        $this->directory = $directory;
    }

    /**
     * Renames all files in the directory based on a given pattern.
     *
     * @param callable $renameFunction Function to determine the new file name.
     * @return void
     * @throws RuntimeException If directory is not found or not readable.
     */
    public function renameFiles(callable $renameFunction) {
        // Check if the directory exists and is readable.
        if (!is_readable($this->directory)) {
            throw new RuntimeException('Directory not found or not readable: ' . $this->directory);
        }

        try {
            // Iterate over the directory content.
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->directory),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($iterator as $fileinfo) {
                // Skip directories.
                if ($fileinfo->isDir()) {
                    continue;
                }

                // Generate new file name.
                $newName = $renameFunction($fileinfo);

                // Construct full path for old and new file names.
                $oldPath = $fileinfo->getPathname();
                $newPath = $fileinfo->getPath() . '/' . $newName;

                // Rename the file.
                if (File::exists($newPath)) {
                    // If the file exists, log an error and skip it.
                    Log::error("File already exists: {$newPath}");
                    continue;
                }

                if (!File::move($oldPath, $newPath)) {
                    // If moving the file fails, log an error and skip it.
                    Log::error("Failed to rename file: {$oldPath} to {$newPath}");
                    continue;
                }

                // Log the successful rename operation.
                Log::info("File renamed from {$oldPath} to {$newPath}");
            }
        } catch (Exception $e) {
            // Handle any exceptions that may occur during the renaming process.
            Log::error("An error occurred: {$e->getMessage()}");
            throw $e;
        }
    }
}

// Example usage.
try {
    // Initialize the batch file rename service with the target directory.
    $renameService = new BatchFileRename('/path/to/directory');

    // Define a function to rename files.
    $renameFunction = function ($fileinfo) {
        // Example: Append a timestamp to the original file name.
        return $fileinfo->getFilename() . '_' . time();
    };

    // Execute the rename operation.
    $renameService->renameFiles($renameFunction);
} catch (RuntimeException $e) {
    // Handle any runtime exceptions.
    echo "Error: " . $e->getMessage();
}
