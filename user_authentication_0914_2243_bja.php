<?php
// 代码生成时间: 2025-09-14 22:43:13
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// UserController.php
class UserController extends Controller
{
    public function __construct()
    {
        // 确保只有经过身份验证的用户才能访问这些方法
        $this->middleware('auth');
    }

    /**
     * 登录用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // 用户登录成功
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;
            return response()->json(['token' => $token], 200);
        }

        // 用户登录失败
        return response()->json(['error' => 'Unauthorised'], 401);
    }

    /**
     * 注册新用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        $token = $user->createToken('authToken')->accessToken;
        return response()->json(['token' => $token], 200);
    }

    /**
     * 用户注销
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(['message' => 'Successfully logged out'], 200);
        }
        return response()->json(['error' => 'Unauthorised'], 401);
    }

    /**
     * 获取当前登录用户信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }
}
