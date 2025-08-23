<?php
// 代码生成时间: 2025-08-23 09:07:36
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Product}; // Assuming Product model exists

class ProductController extends Controller
{
    // 获取所有产品
    public function index()
    {
        $products = Product::all();
        if ($products->isEmpty()) {
            return response()->json(['error' => 'No products found'], 404);
        }
        return response()->json($products, 200);
    }

    // 获取单个产品
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
    }

    // 创建新产品
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = Product::create($validatedData);
        return response()->json($product, 201);
    }

    // 更新产品
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'description' => 'sometimes|nullable|string',
        ]);

        $product->update($validatedData);
        return response()->json($product, 200);
    }

    // 删除产品
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['success' => 'Product deleted'], 200);
    }
}
