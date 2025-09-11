<?php
// 代码生成时间: 2025-09-11 21:14:11
 * It provides a simple interface to add renaming rules and execute the renaming process.
 *
 * @author Your Name
 * @version 1.0
 */

require 'vendor/autoload.php'; // Autoload files using Composer

use Symfony\Component\Finder\Finder;
use Illuminate\Support\Str;

class BatchFileRenamer
{
    /**
     * Directory to scan for files.
     *
     * @var string
     */
    protected $directory;

    /**
     * Array of renaming rules.
     *
     * @var array
     */
    protected $rules = [];

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    /**
     * Add a renaming rule.
     *
     * @param string $search
     * @param string $replace
     * @return $this
     */
    public function addRule(string $search, string $replace): self
    {
        $this->rules[] = ['search' => $search, 'replace' => $replace];
        return $this;
    }

    /**
     * Execute the renaming process.
     *
     * @return void
     */
    public function renameFiles(): void
    {
        $files = Finder::create()->in($this->directory)->files()->name('/\.\w+$/');

        foreach ($files as $file) {
            foreach ($this->rules as $rule) {
                $newFilename = Str::replace($rule['search'], $rule['replace'], $file->getRelativePathname());

                if ($newFilename !== $file->getRelativePathname()) {
                    $newPath = $file->getPath().'/'.basename($newFilename);

                    if (!rename($file->getPathname(), $newPath)) {
                        echo "Error renaming file {$file->getRelativePathname()} to {$newPath}.\
";
                    } else {
                        echo "Renamed {$file->getRelativePathname()} to {$newPath}.\
";
                    }
                }
            }
        }
    }
}

// Example usage
/**
 * Usage: php batch_file_renamer.php "path/to/directory"
 */
if ($argc !== 2) {
    echo "Usage: php batch_file_renamer.php <directory>.\
";
    exit(1);
}

$directory = $argv[1];
$renamer = new BatchFileRenamer($directory);

// Add rules
$renamer->addRule('old', 'new')
          ->addRule('temp', 'final');

// Execute the renaming process
$renamer->renameFiles();
