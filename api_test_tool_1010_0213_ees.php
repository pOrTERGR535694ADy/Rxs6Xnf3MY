<?php
// 代码生成时间: 2025-10-10 02:13:21
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GuzzleHttp\Client;

class ApiTestController extends Controller
{
    // 构造函数，注入GuzzleHttp Client用于API请求
    protected $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 测试API接口
     *
     * @param Request $request 请求对象
     * @return \Illuminate\Http\JsonResponse 返回API响应结果
     */
    public function testApi(Request $request)
    {
        try {
            // 获取请求参数
            $url = $request->input('url');
            $method = $request->input('method', 'GET');
            $body = $request->input('body');
            $headers = $request->input('headers', []);

            // 检查必要的请求参数
            if (empty($url)) {
                return response()->json(['error' => 'URL is required.'], 422);
            }

            // 发送API请求
            $response = $this->client->{$method}($url, [
                'headers' => $headers,
                'json' => isset($body) ? $body : null,
                'form_params' => is_array($body) ? $body : null,
            ]);

            // 返回API响应结果
            return response()->json(['success' => true, 'response' => $response->getBody()->getContents()], 200);
        } catch (\Exception $e) {
            // 错误处理
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
