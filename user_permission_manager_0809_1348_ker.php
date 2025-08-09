<?php
// 代码生成时间: 2025-08-09 13:48:28
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// 用户模型
class User extends Model
{
    use HasFactory;

    // 用户与角色的多对多关系
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    // 检查用户是否具有特定角色
    public function hasRole(string $roleName): bool
    {
        foreach ($this->roles as $role) {
            if ($role->name === $roleName) {
                return true;
            }
        }
        return false;
    }
}

// 角色模型
class Role extends Model
{
    use HasFactory;

    // 角色与权限的多对多关系
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }
}

// 权限模型
class Permission extends Model
{
    use HasFactory;
}

// 服务类，管理用户权限
class PermissionManager
{
    // 添加角色给用户
    public function assignRoleToUser(User $user, Role $role): void
    {
        try {
            $user->roles()->attach($role->id);
        } catch (\Exception $e) {
            // 错误处理
            Log::error('Error assigning role to user: ' . $e->getMessage());
        }
    }

    // 移除用户的角色
    public function removeRoleFromUser(User $user, Role $role): void
    {
        try {
            $user->roles()->detach($role->id);
        } catch (\Exception $e) {
            // 错误处理
            Log::error('Error removing role from user: ' . $e->getMessage());
        }
    }

    // 检查用户是否具有特定权限
    public function checkPermission(User $user, string $permissionName): bool
    {
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission->name === $permissionName) {
                    return true;
                }
            }
        }
        return false;
    }
}

// 用于创建用户、角色和权限的工厂
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];
    }
}

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}

// 数据迁移文件
// user_role 表迁移
class UserRoleTableSeeder extends Seeder
{
    public function run(): void
    {
        // 种子数据
    }
}

// role_permission 表迁移
class RolePermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        // 种子数据
    }
}

// 控制器
class PermissionController extends Controller
{
    public function assignRole(Request $request, User $user, Role $role)
    {
        $permissionManager = new PermissionManager();
        $permissionManager->assignRoleToUser($user, $role);
        return response()->json(['message' => 'Role assigned successfully.']);
    }

    public function removeRole(Request $request, User $user, Role $role)
    {
        $permissionManager = new PermissionManager();
        $permissionManager->removeRoleFromUser($user, $role);
        return response()->json(['message' => 'Role removed successfully.']);
    }

    public function checkPermission(Request $request, User $user, $permissionName)
    {
        $permissionManager = new PermissionManager();
        $hasPermission = $permissionManager->checkPermission($user, $permissionName);
        return response()->json(['hasPermission' => $hasPermission]);
    }
}
