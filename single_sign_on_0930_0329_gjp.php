<?php
// 代码生成时间: 2025-09-30 03:29:24
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;

// SingleSignOnController.php
class SingleSignOnController extends Controller
{
    // 使用构造函数注入Auth服务
    public function __construct()
    {
        $this->middleware('auth')->only('logout');
    }

    // 登录方法
    public function login(Request $request)
    {
        try {
            // 检查是否为POST请求
            if (!$request->isMethod('post')) {
                return response()->json(['error' => 'Invalid request method.'], 405);
            }

            // 获取第三方登录数据
            $provider = $request->input('provider');

            // 判断是否有提供者
            if (!$provider) {
                return response()->json(['error' => 'Provider not specified.'], 400);
            }

            // 调用Socialite进行第三方登录
            $user = Socialite::driver($provider)->stateless()->user();

            // 检查用户是否存在
            $existingUser = User::where('email', $user->getEmail())->first();

            if ($existingUser) {
                // 用户已存在，更新用户信息
                Auth::login($existingUser);
            } else {
                // 用户不存在，创建新用户
                $newUser = new User();
                $newUser->email = $user->getEmail();
                $newUser->name = $user->getName();
                $newUser->provider_id = $user->getId();
                $newUser->save();
                Auth::login($newUser);
            }

            // 返回登录成功信息
            return response()->json(['message' => 'Logged in successfully.'], 200);
        } catch (Exception $e) {
            // 错误处理
            Log::error('Login error: ' . $e->getMessage());
            return response()->json(['error' => 'Login failed.'], 500);
        }
    }

    // 登出方法
    public function logout()
    {
        try {
            // 退出登录
            Auth::logout();

            // 返回登出成功信息
            return response()->json(['message' => 'Logged out successfully.'], 200);
        } catch (Exception $e) {
            // 错误处理
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json(['error' => 'Logout failed.'], 500);
        }
    }
}
