<?php
// 代码生成时间: 2025-08-07 19:50:10
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessManager {
    /**
     * 启动一个新进程
     *
     * @param string $command 要执行的命令
     * @return Process
     */
    public function startProcess($command) {
        try {
            // 创建一个新的进程实例
            $process = new Process($command);
            // 启动进程
            $process->start();
            // 检查进程是否成功启动
            if (!$process->isRunning()) {
                Log::error('Process failed to start: ' . $command);
                throw new ProcessFailedException('Process failed to start.');
            }
            return $process;
        } catch (\Exception $e) {
            Log::error('Error starting process: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 终止一个进程
     *
     * @param Process $process 要终止的进程
     * @return void
     */
    public function stopProcess($process) {
        try {
            // 检查进程是否正在运行
            if ($process->isRunning()) {
                // 终止进程
                $process->stop();
            }
        } catch (\Exception $e) {
            Log::error('Error stopping process: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 获取进程输出
     *
     * @param Process $process 要获取输出的进程
     * @return string
     */
    public function getProcessOutput($process) {
        try {
            // 获取进程输出
            return $process->getOutput();
        } catch (\Exception $e) {
            Log::error('Error getting process output: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 检查进程是否成功执行
     *
     * @param Process $process 要检查的进程
     * @return bool
     */
    public function isProcessSuccessful($process) {
        try {
            // 检查进程退出码是否为0
            return $process->getExitCode() === 0;
        } catch (\Exception $e) {
            Log::error('Error checking process success: ' . $e->getMessage());
            throw $e;
        }
    }
}
