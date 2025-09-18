<?php
// 代码生成时间: 2025-09-19 06:09:34
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BatchFileRenameTool {

    /**
     * @var string The directory path to scan for files.
     */
    protected $directoryPath;

    /**
     * @var string The prefix to add to each file name.
     */
    protected $prefix;

    /**
     * @var string The suffix to add to each file name.
     */
    protected $suffix;

    /**
     * @var int The starting number for the prefix.
     */
    protected $startNumber;

    /**
     * BatchFileRenameTool constructor.
     *
     * @param string $directoryPath The directory path to scan for files.
     * @param string $prefix The prefix to add to each file name.
     * @param string $suffix The suffix to add to each file name.
     * @param int $startNumber The starting number for the prefix.
     */
    public function __construct($directoryPath, $prefix, $suffix, $startNumber = 1) {
        $this->directoryPath = $directoryPath;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->startNumber = $startNumber;
    }

    /**
     * Rename all files in the directory with the specified prefix and suffix.
     *
     * @return void
     */
    public function renameFiles() {
        $files = File::allFiles($this->directoryPath);

        if ($files->isEmpty()) {
            throw new \Exception('No files found in the specified directory.');
        }

        $this->startNumber = $this->startNumber ?: 1;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $extension = $file->getExtension();
            $newFilename = $this->prefix . $this->startNumber . $this->suffix . '.' . $extension;

            $newPath = $file->getPath() . '/' . $newFilename;

            if (!File::move($file->getPathname(), $newPath)) {
                throw new \Exception("Failed to rename file: {$filename} to {$newFilename}.");
            }

            $this->startNumber++;
        }
    }
}

// Usage example
try {
    $renameTool = new BatchFileRenameTool(
        __DIR__ . '/files', // Directory path
        'prefix_',  // Prefix
        '_suffix', // Suffix
        1           // Start number
    );

    $renameTool->renameFiles();
    echo "Files have been successfully renamed.\
";
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}";
}
