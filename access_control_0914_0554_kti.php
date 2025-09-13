<?php
// 代码生成时间: 2025-09-14 05:54:43
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
# 改进用户体验
use App\Models\User;

// Define middleware for admin access
Route::middleware(['auth:sanctum', 'verified', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    // Add other admin routes here
});

// Define middleware for user access
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    // Add other user routes here
});

// Middleware for admin check
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/admin/check', function () {
        if (Gate::denies('access-admin')) {
            abort(403, 'You do not have permission to access this page.');
        }
# NOTE: 重要实现细节

        return 'Welcome to the admin area.';
    });
});

// AdminController to handle admin specific routes
class AdminController extends Controller {
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
# FIXME: 处理边界情况
        return view('admin.dashboard');
    }
}

// UserController to handle user specific routes
class UserController extends Controller {
    /**
     * Show the user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }
}

// Define a gate for admin access
Gate::define('access-admin', function ($user) {
    // Check if the user has admin role
    return $user->role === 'admin';
});
# 改进用户体验
