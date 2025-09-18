<?php
// 代码生成时间: 2025-09-18 18:07:06
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// 权限模型
class Permission extends Model {
    // 定义与角色的多对多关系
    public function roles() {
        return $this->belongsToMany(Role::class);
    }
}

// 角色模型
class Role extends Model {
    // 定义与权限的多对多关系
    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    // 定义与用户的多对多关系
    public function users() {
        return $this->belongsToMany(User::class);
    }
}

// 用户模型
class User extends Model {
    // 定义与角色的多对多关系
    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    // 检查用户是否具有指定权限
    public function hasPermission($permission) {
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $perm) {
                if ($perm->name === $permission) {
                    return true;
                }
            }
        }
        return false;
    }
}

// 用户权限服务类
class UserPermissionService {
    // 添加权限到角色
    public function addPermissionToRole($roleName, $permissionName) {
        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            throw new \Exception("Role not found");
        }

        $permission = Permission::where('name', $permissionName)->first();
        if (!$permission) {
            throw new \Exception("Permission not found");
        }

        $role->permissions()->attach($permission->id);
    }

    // 移除角色的权限
    public function removePermissionFromRole($roleName, $permissionName) {
        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            throw new \Exception("Role not found");
        }

        $permission = Permission::where('name', $permissionName)->first();
        if (!$permission) {
            throw new \Exception("Permission not found");
        }

        $role->permissions()->detach($permission->id);
    }

    // 给用户分配角色
    public function assignRoleToUser($userName, $roleName) {
        $user = User::where('name', $userName)->first();
        if (!$user) {
            throw new \Exception("User not found");
        }

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            throw new \Exception("Role not found");
        }

        $user->roles()->attach($role->id);
    }

    // 移除用户的角色
    public function removeRoleFromUser($userName, $roleName) {
        $user = User::where('name', $userName)->first();
        if (!$user) {
            throw new \Exception("User not found");
        }

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            throw new \Exception("Role not found");
        }

        $user->roles()->detach($role->id);
    }
}

// 示例用法
try {
    $userService = new UserPermissionService();
    $userService->addPermissionToRole('admin', 'edit_post');
    $userService->assignRoleToUser('john', 'admin');
} catch (Exception $e) {
    // 错误处理
    echo $e->getMessage();
}
