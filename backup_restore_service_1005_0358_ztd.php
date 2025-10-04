<?php
// 代码生成时间: 2025-10-05 03:58:22
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class BackupRestoreService {

    private $backupPath;
    private $storageDisk;

    /**
     * Constructor to initialize backup path and storage disk.
     *
     * @param string $backupPath Path where backups will be stored.
     * @param string $storageDisk Disk where the backup files will be stored.
     */
    public function __construct($backupPath, $storageDisk = 'local') {
        $this->backupPath = $backupPath;
        $this->storageDisk = $storageDisk;
    }

    /**
     * Creates a new backup of the database.
     *
     * @param string $backupName Name of the backup file.
     * @return bool Returns true on success, false on failure.
     */
    public function createBackup($backupName) {
        try {
            Artisan::call('db:backup', [
                '--destination' => $this->storageDisk,
                '--destinationPath' => $this->backupPath,
                '--filename' => $backupName,
                '--force' => true,
            ]);

            return true;
        } catch (Exception $e) {
            // Log error and handle exception
            Log::error('Backup creation failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Restores the database from a backup file.
     *
     * @param string $backupName Name of the backup file to restore from.
     * @return bool Returns true on success, false on failure.
     */
    public function restoreBackup($backupName) {
        try {
            // Ensure the backup file exists
            if (!Storage::disk($this->storageDisk)->exists($this->backupPath . '/' . $backupName)) {
                Log::error('Backup file not found: ' . $backupName);
                return false;
            }

            Artisan::call('db:restore', [
                '--destination' => $this->storageDisk,
                '--destinationPath' => $this->backupPath,
                '--filename' => $backupName,
                '--force' => true,
            ]);

            return true;
        } catch (Exception $e) {
            // Log error and handle exception
            Log::error('Backup restoration failed: ' . $e->getMessage());
            return false;
        }
    }
}
