<?php
// 代码生成时间: 2025-08-16 22:26:29
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BulkFileRenamer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:rename {directory} {pattern}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batch rename files in a specified directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the directory and pattern arguments from the command line.
        $directory = $this->argument('directory');
        $pattern = $this->argument('pattern');

        // Check if the directory exists.
        if (!is_dir($directory)) {
            $this->error("The specified directory does not exist: {$directory}");
            return Command::FAILURE;
        }

        // Get all files in the directory.
        $files = glob($directory . '/*');

        // Loop through each file and rename it according to the pattern.
        foreach ($files as $file) {
            if (is_file($file)) {
                // Extract the file extension.
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                // Generate the new file name based on the pattern.
                $newName = $pattern . '.' . $extension;
                // Construct the new file path.
                $newPath = dirname($file) . '/' . $newName;

                // Rename the file.
                if (rename($file, $newPath)) {
                    $this->info("Renamed {$file} to {$newPath}");
                } else {
                    $this->error("Failed to rename {$file} to {$newPath}");
                }
            }
        }

        // Return success status.
        return Command::SUCCESS;
    }
}
