<?php
// 代码生成时间: 2025-09-13 20:55:22
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Throwable;

class AuditLogService {

    /**
     * 存储审计日志信息
     *
     * @param string $action 操作描述
     * @param string $user_id 执行操作的用户ID
     * @param array $details 操作的详细信息
     * @return void
     */
    public function log(string $action, string $user_id, array $details): void {
        try {
            // 将审计日志信息插入到数据库
            DB::table('audit_logs')->insert(
                [
                    'action' => $action,
                    'user_id' => $user_id,
                    'details' => json_encode($details),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        } catch (Throwable $e) {
            // 错误处理
            // 这里可以根据需要记录错误日志或者抛出异常
            // 例如：使用Log::error()记录错误日志
            // Log::error($e->getMessage());
            throw $e;
        }
    }
}

/**
 * 审计日志迁移文件
 *
 * 这个迁移文件用于创建审计日志表。
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration {

    /**
     * 运行迁移
     *
     * @return void
     */
    public function up(): void {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->string('user_id');
            $table->text('details');
            $table->timestamps();
        });
    }

    /**
     * 回滚迁移
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('audit_logs');
    }
}
