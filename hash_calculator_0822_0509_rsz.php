<?php
// 代码生成时间: 2025-08-22 05:09:20
use Illuminate\Support\Facades\Hash;

/**
 * Hash Calculator Tool using Laravel.
 *
 * This tool is designed to calculate hash values for strings.
 * It provides a simple and secure way to hash data using Laravel's built-in hashing capabilities.
 */
class HashCalculator
{
    /**
     * Calculate the hash value of a given string using Laravel's hashing.
     *
     * @param string $string The string to be hashed.
     * @param string $algorithm The hashing algorithm to use. Defaults to bcrypt.
     *
     * @return string The hashed string.
     *
     * @throws Exception If the hashing algorithm is not supported.
     */
    public function calculateHash($string, $algorithm = 'bcrypt')
    {
        // Check if the provided algorithm is supported by Laravel
        if (!in_array($algorithm, hash_algos())) {
            throw new Exception("Unsupported hashing algorithm: {$algorithm}.");
        }

        // Calculate the hash using Laravel's Hash facade
        return Hash::make($string, ['algorithm' => $algorithm]);
    }
}

// Usage example
try {
    $hashCalculator = new HashCalculator();
    $hashedString = $hashCalculator->calculateHash("Hello, World!", "sha256");
    echo "Hashed string: " . $hashedString;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}