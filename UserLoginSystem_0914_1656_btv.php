<?php
// 代码生成时间: 2025-09-14 16:56:47
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// UserLoginController 负责处理用户登录验证
class UserLoginController extends Controller
{
    public function login(Request $request)
    {
        // 验证请求数据
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 尝试登录用户
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            // 登录成功，生成token并返回
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;
            return response()->json(['token' => $token, 'user' => $user], 200);
        } else {
            // 登录失败，返回错误信息
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    // 注册新用户
    public function register(Request $request)
    {
        // 验证请求数据
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // 创建新用户
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        // 生成token并返回
        $token = $user->createToken('authToken')->accessToken;
        return response()->json(['token' => $token, 'user' => $user], 201);
    }
}
