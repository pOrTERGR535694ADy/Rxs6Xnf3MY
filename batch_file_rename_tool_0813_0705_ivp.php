<?php
// 代码生成时间: 2025-08-13 07:05:02
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BatchFileRenameCommand extends Command
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('file:rename')
            ->setDescription('Batch rename files in a directory')
            ->addArgument('directory', InputArgument::REQUIRED, 'The directory containing files to rename')
            ->addArgument('new-name', InputArgument::REQUIRED, 'The new name prefix for the files');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = $input->getArgument('directory');
        $newNamePrefix = $input->getArgument('new-name');

        // Check if the directory exists
        if (!File::isDirectory($directory)) {
            $output->writeln('<error>Directory not found: ' . $directory . '</error>');
            return Command::FAILURE;
        }

        // Get all files in the directory
        $files = File::allFiles($directory);

        // Rename each file
        foreach ($files as $file) {
            $filename = $file->getFilename();
            $newName = $newNamePrefix . '_' . $filename;
            $newPath = $file->getPath() . '/' . $newName;

            try {
                if (File::move($file->getPathname(), $newPath)) {
                    $output->writeln('Renamed: ' . $filename . ' to ' . $newName);
                } else {
                    $output->writeln('<error>Error renaming file: ' . $filename . '</error>');
                }
            } catch (\Exception $e) {
                Log::error('Error renaming file: ' . $filename . ' - ' . $e->getMessage());
                $output->writeln('<error>Error renaming file: ' . $filename . ' - ' . $e->getMessage() . '</error>');
            }
        }

        return Command::SUCCESS;
    }
}

// Create a new application instance
$application = new Application();

// Add the command to the application
$application->add(new BatchFileRenameCommand());

// Run the application with the command line arguments
$application->run();
