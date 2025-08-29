<?php
// 代码生成时间: 2025-08-29 15:15:12
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class BatchFileRenameTool extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:rename';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量重命名指定目录下的文件';

    /**
     * 执行命令
     */
    public function handle()
    {
        // 获取用户输入的目录和规则
        $sourceDirectory = $this->ask('请输入源目录路径');
        $newNamePattern = $this->ask('请输入新的文件命名规则（例如：new_name_{{index}}.ext）');

        if (!file_exists($sourceDirectory)) {
            $this->error('指定的目录不存在');
            return;
        }

        // 获取指定目录下的所有文件
        $files = scandir($sourceDirectory);
        array_shift($files); // 移除 '.'
        array_shift($files); // 移除 '..'

        if (empty($files)) {
            $this->info('目录下没有文件需要重命名');
            return;
        }

        // 批量重命名文件
        foreach ($files as $index => $file) {
            $oldPath = $sourceDirectory . '/' . $file;
            $newName = str_replace('{{index}}', $index + 1, $newNamePattern);
            $newPath = $sourceDirectory . '/' . $newName;

            if (file_exists($newPath)) {
                $this->error('文件重命名失败，因为新文件名已存在: ' . $newName);
                continue;
            }

            if (rename($oldPath, $newPath)) {
                $this->info('文件重命名为: ' . $newName);
            } else {
                $this->error('文件重命名失败: ' . $file);
            }
        }

        $this->info('批量文件重命名完成');
    }
}
