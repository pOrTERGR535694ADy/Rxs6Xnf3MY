<?php
// 代码生成时间: 2025-08-17 03:03:54
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UrlValidator {
    /**
     * Validate URL.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateUrl(Request $request) {
        // Validate the incoming request data.
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            // Return a response with an error message.
            return response()->json(['error' => 'Invalid URL provided.'], 400);
        }

        // Extract the URL from the request.
        $url = $request->input('url');

        // Check if the URL is reachable.
        try {
            $response = Http::HEAD($url)->throw();
            if ($response->successful()) {
                // Return a success response.
                return response()->json(['message' => 'URL is valid and reachable.'], 200);
            } else {
                // Return a response for a non-successful status code.
                return response()->json(['error' => 'URL is not reachable.'], 400);
            }
        } catch (\Exception $e) {
            // Log the exception and return an error response.
            Log::error('URL validation error: ' . $e->getMessage());
            return response()->json(['error' => 'URL validation failed.'], 500);
        }
    }
}
