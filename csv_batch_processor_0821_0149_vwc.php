<?php
// 代码生成时间: 2025-08-21 01:49:29
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use App\Imports\CsvImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CsvBatchProcessor {
    /**
     * Process a batch of CSV files.
     *
     * @param array $csvFilePaths Array of paths to CSV files.
     * @return void
     */
    public function processBatch(array $csvFilePaths) {
        foreach ($csvFilePaths as $filePath) {
            $this->processSingleCsv($filePath);
        }
    }

    /**
     * Process a single CSV file.
     *
     * @param string $filePath Path to a single CSV file.
     * @return void
     */
    public function processSingleCsv(string $filePath) {
        try {
            // Check if file exists
            if (!Storage::exists($filePath)) {
                Log::error("File not found: {$filePath}.");
                return;
            }

            // Read CSV content
            $csvContent = Storage::get($filePath);

            // Create a CSV reader
            $reader = Reader::createFromString($csvContent);
            $csv = array();
            foreach ($reader as $index => $row) {
                if ($index === 0) continue; // Skip header row
                $csv[] = $row;
            }

            // Create a CSV writer
            $writer = Writer::createFromFileObject(new SplTempFileObject());

            // Process each row and save to database
            foreach ($csv as $row) {
                // Here you would have your business logic to process the row and save it to the database
                // For example, create a new model instance and save it
                // $model = new Model();
                // $model->fill($row)->save();
            }

            // After import event
            Excel::afterImport(new class implements AfterImport {
                public function __invoke(AfterImport $event) {
                    // Handle after import event
                }
            });

            Log::info("CSV file processed: {$filePath}.");
        } catch (\Exception $e) {
            Log::error("Error processing CSV file: {$filePath}. Error: {$e->getMessage()}");
        }
    }
}
