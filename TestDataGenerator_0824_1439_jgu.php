<?php
// 代码生成时间: 2025-08-24 14:39:44
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestDataGenerator {

    /**
     * Generate a specified number of test users.
     *
     * @param int $count The number of users to generate.
     * @return void
     */
    public function generateUsers(int $count): void {
        for ($i = 0; $i < $count; $i++) {
            try {
                // Generate random data for the user
                $name = Str::random(10);
                $email = Str::random(10) . "@example.com";
                $password = bcrypt(Str::random(10));

                // Insert the user into the database
                DB::table('users')->insert([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } catch (\Exception $e) {
                // Handle any errors that occur during user generation
                \Log::error("Error generating user: " . $e->getMessage());
            }
        }
    }

    /**
     * Generate a specified number of test posts.
     *
     * @param int $count The number of posts to generate.
     * @return void
     */
    public function generatePosts(int $count): void {
        for ($i = 0; $i < $count; $i++) {
            try {
                // Generate random data for the post
                $title = Str::random(10);
                $content = Str::random(50);
                $user_id = DB::table('users')->inRandomOrder()->first()->id;

                // Insert the post into the database
                DB::table('posts')->insert([
                    'title' => $title,
                    'content' => $content,
                    'user_id' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } catch (\Exception $e) {
                // Handle any errors that occur during post generation
                \Log::error("Error generating post: " . $e->getMessage());
            }
        }
    }

    // Additional methods for generating other types of test data can be added here
}
