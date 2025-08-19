<?php
// 代码生成时间: 2025-08-19 17:34:17
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        // 确保用户必须登录才能访问这些方法
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        // 显示登录表单
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 验证用户输入的数据
# TODO: 优化性能
        $credentials = $request->validate([
# FIXME: 处理边界情况
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            // 尝试使用认证凭据登录
# NOTE: 重要实现细节
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                // 如果登录成功，重定向到首页
                return redirect()->intended('dashboard');
            }
        } catch (\Exception $e) {
            // 错误处理
            return back()->withErrors([
                'error' => '登录失败，请重试。',
            ])->withInput($request->only('email', 'remember'));
        }

        // 登录失败，重定向回登录表单并附带错误信息
        return back()->withErrors([
            'email' => '邮箱或密码不正确。',
# FIXME: 处理边界情况
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
# 改进用户体验
        // 注销用户
        Auth::logout();

        // 重定向回登录表单
        return redirect('login');
    }
# FIXME: 处理边界情况
}
