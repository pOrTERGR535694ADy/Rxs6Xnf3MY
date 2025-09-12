<?php
// 代码生成时间: 2025-09-13 01:26:51
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 数据库迁移工具类
class DatabaseMigration extends Migration
{
    // 迁移数据库时执行的操作
    public function up()
    {
        Schema::create('example_table', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    // 回滚数据库迁移时执行的操作
    public function down()
    {
        Schema::dropIfExists('example_table');
    }
}
