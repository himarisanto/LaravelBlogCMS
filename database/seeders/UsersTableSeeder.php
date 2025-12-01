<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(value: 'password'),
            'role' => 'admin'
        ]);

        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $categories = ['Technology', 'Lifestyle', 'Food', 'Travel', 'News'];
        foreach ($categories as $c) {
            Category::create(['name' => $c, 'slug' => \Illuminate\Support\Str::slug($c), 'description' => "Posts about $c"]);
        }

        Post::factory()->count(12)->create()->each(function ($post) use ($user) {
            $post->user_id = $user->id;
            $post->published_at = now()->subDays(rand(0, 30));
            $post->save();
            $post->categories()->sync(
            Category::inRandomOrder()->take(rand(1, 2))->pluck('id')->toArray()
            );
        });
    }
}
