<?php
// 代码生成时间: 2025-09-20 02:35:48
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
# 增强安全性
use App\Http\Controllers\Controller;
use App\Models\User;

// UserAuthController负责处理用户认证的逻辑
class UserAuthController extends Controller
{
    // 用户登录的方法
    public function login(Request $request)
    {
        // 验证请求中的数据
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 使用Laravel的Auth facade尝试用户认证
        if (Auth::attempt($credentials)) {
            // 认证成功后，生成token（如果使用Laravel Sanctum或Laravel Passport）
            $token = $request->user()->createToken('authToken')->plainTextToken;

            // 返回成功响应和token
            return response()->json([
                'message' => 'User successfully logged in',
                'token' => $token
            ], 200);
        } else {
            // 认证失败，返回错误响应
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
# 优化算法效率

    // 用户注册的方法
    public function register(Request $request)
    {
        // 验证请求中的数据
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        // 创建新用户
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
# NOTE: 重要实现细节
            'password' => bcrypt($validatedData['password'])
# 扩展功能模块
        ]);

        // 生成token（如果使用Laravel Sanctum或Laravel Passport）
        $token = $user->createToken('authToken')->plainTextToken;

        // 返回成功响应和token
        return response()->json([
            'message' => 'User successfully registered',
            'token' => $token
        ], 201);
    }
}
