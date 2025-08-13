<?php
// 代码生成时间: 2025-08-13 11:45:45
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
# 扩展功能模块

class CartController extends Controller
{
    // 添加商品到购物车
    public function addToCart(Request $request, $productId)
    {
        // 检查商品是否存在
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // 检查用户是否已登录
# 增强安全性
        if (!Auth::check()) {
            return response()->json(['error' => 'User not logged in'], 401);
        }

        // 创建购物车项
        $cartItem = CartItem::create([
            'product_id' => $productId,
# 优化算法效率
            'user_id' => Auth::id(),
            'quantity' => $request->input('quantity', 1),
        ]);

        return response()->json(['message' => 'Product added to cart', 'cart_item' => $cartItem], 200);
    }

    // 获取购物车中的商品
    public function getCartItems()
    {
# 添加错误处理
        // 检查用户是否已登录
        if (!Auth::check()) {
            return response()->json(['error' => 'User not logged in'], 401);
        }

        // 获取用户购物车中的商品
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        return response()->json(['cart_items' => $cartItems], 200);
    }
# 改进用户体验

    // 更新购物车中的商品数量
# 添加错误处理
    public function updateCartItem(Request $request, $cartItemId)
    {
        // 检查购物车项是否存在
# FIXME: 处理边界情况
        $cartItem = CartItem::find($cartItemId);
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }
# FIXME: 处理边界情况

        // 检查用户是否已登录
        if (!Auth::check() || $cartItem->user_id != Auth::id()) {
# 优化算法效率
            return response()->json(['error' => 'User not logged in or unauthorized access'], 401);
# 扩展功能模块
        }

        // 更新购物车项数量
        $cartItem->quantity = $request->input('quantity', 1);
        $cartItem->save();

        return response()->json(['message' => 'Cart item updated', 'cart_item' => $cartItem], 200);
    }

    // 从购物车中移除商品
    public function removeCartItem($cartItemId)
    {
        // 检查购物车项是否存在
        $cartItem = CartItem::find($cartItemId);
# NOTE: 重要实现细节
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        // 检查用户是否已登录
        if (!Auth::check() || $cartItem->user_id != Auth::id()) {
            return response()->json(['error' => 'User not logged in or unauthorized access'], 401);
        }

        // 从购物车中移除商品
        $cartItem->delete();

        return response()->json(['message' => 'Product removed from cart'], 200);
    }
# 扩展功能模块
}