<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        User::factory()->create([ // This user's ID will be 1
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user = User::factory()->create([ // This user's ID will be 2.
            'name' => 'test2',
            'email' => 'ex@amp.le',
            'password' => Hash::make('password')
        ]);

        for ($i = 1; $i <= 10; $i++) {
            $post = new Post();
            $post->user_id = $user->id;
            $post->title = "Example title nr. $i";
            $post->content = "CONTENT";
            $post->save();

            for ($j = 1; $j <= 10; $j++) {
                $comment = new Comment();
                $comment->user_id = $user->id;
                $comment->post_id = $post->id;
                $comment->comment = "COMMENT NR $j";
                $comment->save();
            }
        }
    }
}
