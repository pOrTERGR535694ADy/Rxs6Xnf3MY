<?php
// 代码生成时间: 2025-09-21 14:11:46
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RandomNumberGenerator;

class RandomNumberGeneratorServiceProvider extends ServiceProvider
{
    /**
     * 注册服务绑定。
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('randomNumberGenerator', function ($app) {
            return new RandomNumberGenerator();
        });
    }
}

/**
 * RandomNumberGenerator.php
 *
 * 这个类用于生成随机数。
 *
 * @author 你的姓名
 * @version 1.0
 * @since 2023-04
 */

namespace App\Services;

class RandomNumberGenerator
{
    /**
     * 生成随机数。
     *
     * @param int $min 最小值
     * @param int $max 最大值
     * @return int
     * @throws \InvalidArgumentException
     */
    public function generate(int $min, int $max): int
    {
        // 检查输入参数是否有效
        if ($min > $max) {
            throw new \Exception('最小值不能大于最大值。');
        }

        // 使用mt_rand函数生成随机数，提高随机性
        return mt_rand($min, $max);
    }
}

/**
 * RandomNumberController.php
 *
 * 这个控制器用于处理随机数生成的请求。
 *
 * @author 你的姓名
 * @version 1.0
 * @since 2023-04
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RandomNumberGenerator;
use Illuminate\Support\Facades\Validator;

class RandomNumberController extends Controller
{
    /**
     * 处理随机数生成请求。
     *
     * @param Request $request
     * @param RandomNumberGenerator $randomNumberGenerator
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request, RandomNumberGenerator $randomNumberGenerator)
    {
        // 验证请求参数
        $validator = Validator::make($request->all(), [
            'min' => 'required|integer|min:0',
            'max' => 'required|integer|gt:min',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => '无效的请求参数。'], 400);
        }

        // 获取请求参数
        $min = $request->input('min');
        $max = $request->input('max');

        // 生成随机数
        try {
            $randomNumber = $randomNumberGenerator->generate($min, $max);

            return response()->json(['randomNumber' => $randomNumber]);
        } catch (\Exception $e) {
            // 处理异常
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
