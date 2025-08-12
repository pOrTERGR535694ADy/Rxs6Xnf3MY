<?php
// 代码生成时间: 2025-08-12 12:13:50
use Illuminate\Support\Facades\Http;
use Throwable;

class NetworkConnectionChecker {

    /**
     * Check if a given URL is reachable.
     *
     * @param string $url The URL to check.
     * @return array
     */
    public function checkUrl(string $url): array {
        // Initialize the response array with default values
        $response = [
            'success' => false,
            'message' => 'Unknown error occurred.'
        ];

        try {
            // Attempt to send a GET request to the URL
            $response = Http::timeout(5)
                ->get($url);

            // If the response is successful, update the response array
            if ($response->successful()) {
                $response['success'] = true;
                $response['message'] = 'URL is reachable.';
            } else {
                $response['message'] = 'URL is not reachable.';
            }
        } catch (Throwable $e) {
            // If an exception occurs, update the response array with the error message
            $response['message'] = $e->getMessage();
        }

        return $response;
    }
}

// Example usage
$checker = new NetworkConnectionChecker();
$url = 'https://www.example.com';
$result = $checker->checkUrl($url);

// Output the result
echo json_encode($result);
