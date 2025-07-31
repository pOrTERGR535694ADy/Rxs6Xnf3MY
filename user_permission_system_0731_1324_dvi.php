<?php
// 代码生成时间: 2025-07-31 13:24:17
// 引入LARAVEL框架的核心类
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

// 设置数据库连接
DB::extend('mysql', function ($config) {
    return new \Illuminate\Database\Connectors\MySqlConnector($config);
});

// 创建数据库连接实例
$capsule = new DB();
$capsule->addConnection([
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'database' => 'laravel',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'   => '',
]);

// 设置Eloquent ORM
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

// 定义模型
class Permission extends Model {
    protected $table = 'permissions';
    protected $fillable = ['name', 'description'];
}

class User extends Model {
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];

    // 用户与权限的一对多关系
    public function permissions() {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }
}

// 添加权限
function addPermission($name, $description) {
    try {
        $permission = new Permission();
        $permission->name = $name;
        $permission->description = $description;
        $permission->save();

        return ['status' => 'success', 'message' => 'Permission added successfully'];
    } catch (\Exception $e) {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// 删除权限
function deletePermission($id) {
    try {
        Permission::destroy($id);
        return ['status' => 'success', 'message' => 'Permission deleted successfully'];
    } catch (\Exception $e) {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// 分配权限给用户
function assignPermissionToUser($userId, $permissionId) {
    try {
        $user = User::find($userId);
        if (!$user) {
            return ['status' => 'error', 'message' => 'User not found'];
        }

        $user->permissions()->attach($permissionId);
        return ['status' => 'success', 'message' => 'Permission assigned successfully'];
    } catch (\Exception $e) {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// Unassign permission from user
function unassignPermissionFromUser($userId, $permissionId) {
    try {
        $user = User::find($userId);
        if (!$user) {
            return ['status' => 'error', 'message' => 'User not found'];
        }

        $user->permissions()->detach($permissionId);
        return ['status' => 'success', 'message' => 'Permission unassigned successfully'];
    } catch (\Exception $e) {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// 示例用法
// 添加权限
$response = addPermission('admin', 'Full access to the system');
echo json_encode($response);

// 分配权限给用户
$response = assignPermissionToUser(1, 1);
echo json_encode($response);

// 删除权限
$response = deletePermission(1);
echo json_encode($response);

// 取消分配权限
$response = unassignPermissionFromUser(1, 1);
echo json_encode($response);
