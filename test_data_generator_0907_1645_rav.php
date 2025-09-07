<?php
// 代码生成时间: 2025-09-07 16:45:52
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class TestDataGenerator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建测试数据
        $faker = $this->getFaker();

        // 生成数据的条目数量
        $numberOfEntries = config('test_data_generator.entries');

        // 需要填充数据的表名
        $tableName = config('test_data_generator.table');

        // 开始数据库事务
        DB::beginTransaction();
        try {
            for ($i = 0; $i < $numberOfEntries; $i++) {
                DB::table($tableName)->insert([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'created_at' => $faker->dateTimeBetween('-1 year', 'now')
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 清空表数据
        DB::table(config('test_data_generator.table'))->truncate();
    }

    /**
     * 获取Faker实例
     *
     * @return Faker
     */
    private function getFaker()
    {
        return app(Faker::class);
    }
}
