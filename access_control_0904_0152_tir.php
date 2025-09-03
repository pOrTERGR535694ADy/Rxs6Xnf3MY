<?php
// 代码生成时间: 2025-09-04 01:52:44
// access_control.php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;

// 定义路由
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware('admin');

// 定义中间件
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// 注册自定义门控
Gate::define('admin-access', function ($user) {
    return $user->isAdmin();
});

// 注册自定义视图组件
Blade::component('admin.dashboard', \Modules\Admin\View\Components\Dashboard::class);

/**
 * 控制器
 */
class AccessControlController extends Controller
{
    /**
     * 显示仪表板
     */
    public function dashboard()
    {
        if (!Gate::allows('admin-access')) {
            abort(403); // 没有访问权限
        }

        return view('admin.dashboard');
    }
}

/**
 * 用户模型
 */
class User extends Authenticatable
{
    /**
     * 检查用户是否是管理员
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
