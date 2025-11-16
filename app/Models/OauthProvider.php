<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthProvider extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];
}
