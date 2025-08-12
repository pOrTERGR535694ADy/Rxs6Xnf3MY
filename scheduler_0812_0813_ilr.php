<?php
// 代码生成时间: 2025-08-12 08:13:22
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule \$schedule)
    {
        // 注册定时任务
        \$schedule->call(function () {
            // 这里放置定时执行的任务逻辑
            info('定时任务执行中...');
        })->daily();

        // 也可以设置特定的时间间隔，例如每小时执行一次
        // \$schedule->call(function () {
        //     // 每小时执行的任务逻辑
        // })->hourly();

        // 更复杂的时间调度，例如每天的特定时间执行任务
        // \$schedule->call(function () {
        //     // 特定时间执行的任务逻辑
        // })->dailyAt('13:00');
    }
}
