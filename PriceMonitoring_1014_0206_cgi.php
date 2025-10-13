<?php
// 代码生成时间: 2025-10-14 02:06:21
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Notifications\PriceChangeNotification;
use App\Events\PriceChanged;

class PriceMonitoring
{
    // 监控商品价格变化
    public function monitor(Product $product)
    {
        try {
            // 获取当前价格
            $currentPrice = $product->getPrice();
            // 获取上次监控的价格
# 增强安全性
            $lastPrice = $product->last_price;
# FIXME: 处理边界情况

            // 检查价格是否发生变化
            if ($currentPrice !== $lastPrice) {
                // 记录价格变化
# NOTE: 重要实现细节
                $this->recordPriceChange($product, $currentPrice);

                // 发送价格变化通知
                $this->sendPriceChangeNotification($product, $currentPrice);

                // 触发价格变化事件
                event(new PriceChanged($product, $currentPrice));
            }
        } catch (\Exception $e) {
            // 记录错误
            Log::error('Price monitoring error: ' . $e->getMessage());
        }
    }

    // 记录价格变化
    private function recordPriceChange(Product $product, $newPrice)
    {
# FIXME: 处理边界情况
        // 更新商品价格并保存
        $product->last_price = $newPrice;
        $product->save();
    }

    // 发送价格变化通知
    private function sendPriceChangeNotification(Product $product, $newPrice)
    {
        // 发送通知给管理员
        auth()->user()->notify(new PriceChangeNotification($product, $newPrice));
    }
}
