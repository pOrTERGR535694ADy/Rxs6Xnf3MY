<?php
// 代码生成时间: 2025-09-20 08:59:14
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataGenerator extends Seeder
{
    public function run()
    {
        // 初始化 Faker Factory
        $faker = Factory::create();

        // 定义要生成的数据量
        $numberOfRecords = 100;

        // 循环生成数据
        for ($i = 0; $i < $numberOfRecords; $i++) {
            try {
                // 这里以用户表为例，生成测试数据
                DB::table('users')->insert([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    // 其他字段根据实际需求添加
                    'created_at' => $faker->dateTimeThisDecade,
                    'updated_at' => $faker->dateTimeThisDecade,
                ]);
            } catch (\Exception $e) {
                // 错误处理
                $this->command->info('An error occurred: ' . $e->getMessage());
            }
        }

        // 输出成功信息
        $this->command->info('Data generated successfully!');
    }
}
