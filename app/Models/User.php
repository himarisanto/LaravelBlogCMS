<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\UiServiceProvider;
use App\Models\Post;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public  function is_admin()
    {
        return $this->role === 'admin';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [    
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // public static function routes(array $options = [])
    // {
    //     if (! static::$app->providerIsLoaded(UiServiceProvider::class)) {
    //         throw new RuntimeException('In order to use the Auth::routes() method, please install the laravel/ui package.');
    //     }

    //     static::$app->make('router')->auth($options);
    // }
}
