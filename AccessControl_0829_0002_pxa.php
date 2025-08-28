<?php
// 代码生成时间: 2025-08-29 00:02:13
// 使用命名空间来组织代码
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

// 引入异常处理类
use App\Exceptions\Handler;

class AccessControl extends Controller
{
    // 构造函数
    public function __construct()
    {
        // 为类中的所有方法设置中间件
        $this->middleware('auth');
    }

    // 获取用户权限
    public function getUserPermissions($userId)
    {
        try {
            // 通过用户ID获取用户
            $user = User::findOrFail($userId);

            // 检查用户是否具有访问权限
            if (Gate::denies('view-permissions', $user)) {
                return response()->json(['message' => 'You do not have permission to view this user\'s permissions.'], Response::HTTP_FORBIDDEN);
            }

            // 返回用户权限信息
            return response()->json(['permissions' => $user->permissions], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            // 用户不存在处理
            return response()->json(['message' => 'User not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // 其他异常处理
            return response()->json(['message' => 'An error occurred.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // 添加或更新用户权限
    public function updatePermissions(Request $request, $userId)
    {
        try {
            // 通过用户ID获取用户
            $user = User::findOrFail($userId);

            // 检查用户是否具有修改权限
            if (Gate::denies('edit-permissions', $user)) {
                return response()->json(['message' => 'You do not have permission to edit this user\'s permissions.'], Response::HTTP_FORBIDDEN);
            }

            // 更新用户权限
            $user->permissions = $request->permissions;
            $user->save();

            // 返回更新后的用户权限信息
            return response()->json(['permissions' => $user->permissions], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            // 用户不存在处理
            return response()->json(['message' => 'User not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // 其他异常处理
            return response()->json(['message' => 'An error occurred.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
