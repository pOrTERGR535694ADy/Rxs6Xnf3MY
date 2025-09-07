<?php
// 代码生成时间: 2025-09-08 05:28:20
 * This class provides a simple interface to manage processes.
 * It includes functionality to start, stop, and list processes.
 */

use Illuminate\Support\Facades\ProcessUtils;
# TODO: 优化性能
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ProcessManager
{
# 扩展功能模块
    /**
     * The list of processes.
     *
# 改进用户体验
     * @var array
     */
    protected $processes = [];

    /**
     * Start a new process.
     *
     * @param string $command The command to execute.
     * @param string|null $cwd The working directory or null to use the default.
     * @param array $env The environment variables.
     * @param array $input The input for the command.
     * @return Process
     */
    public function start($command, $cwd = null, $env = [], $input = [])
    {
        $process = Process::fromShellCommandline($command, $cwd, $env, $input);
        $process->start();

        if (!$process->isRunning()) {
            throw new ProcessFailedException($process);
# 优化算法效率
        }

        $this->processes[$process->getPid()] = $process;

        return $process;
    }

    /**
     * Stop a process by its PID.
     *
     * @param int $pid The PID of the process to stop.
# FIXME: 处理边界情况
     * @return bool
# 增强安全性
     */
    public function stop($pid)
    {
        if (isset($this->processes[$pid]) && $this->processes[$pid]->isRunning()) {
            $this->processes[$pid]->stop();
            unset($this->processes[$pid]);

            return true;
        }

        return false;
    }

    /**
     * List all running processes.
     *
     * @return array
     */
    public function listProcesses()
    {
        return array_filter($this->processes, function ($process) {
            return $process->isRunning();
        });
    }

    /**
     * Check if a process is running by its PID.
     *
# 扩展功能模块
     * @param int $pid The PID of the process to check.
     * @return bool
     */
    public function isRunning($pid)
    {
        return isset($this->processes[$pid]) && $this->processes[$pid]->isRunning();
    }
# 优化算法效率
}
# TODO: 优化性能
