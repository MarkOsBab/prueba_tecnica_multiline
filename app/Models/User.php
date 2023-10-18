<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function __construct()
    {
        $this->fillable([
            'name',
            'email',
            'password',
        ]);

        $this->hidden = [
            'password',
            'remember_token',
        ];

        $this->casts = [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function createTable()
    {
        if (!Schema::hasTable(env('USERS_TABLE_NAME'))) 
        {
            Schema::create(env('USERS_TABLE_NAME'), function ($table) 
            {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }
}
