<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Models\UserApiExample;
use App\Models\Post;

class FetchFiveMin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-five-min';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = random_int(1, 10);

        $user = Http::get("https://jsonplaceholder.typicode.com/users/$userId")->json()
            ?? throw new \Exception('Failed to fetch user data');

        $posts = Http::get('https://jsonplaceholder.typicode.com/posts')->json()
            ?? throw new \Exception('Failed to fetch post data');

        $userPosts = collect($posts)->where('userId', $userId)->values()->all();

        $userRecord = UserApiExample::updateOrCreate(
            ['external_id' => $user['id']],
            [
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'raw_data' => json_encode($user),
            ]
        );

        foreach ($userPosts as $post) {
            Post::updateOrCreate(
                ['external_id' => $post['id']],
                [
                    'user_id' => $userRecord->external_id,
                    'description' => $post['title'],
                    'body' => $post['body'],
                ]
            );
        }

        return 0;
    }
}
