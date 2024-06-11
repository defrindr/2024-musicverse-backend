<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    const ALLOWED_NAMES = ['instagram', 'tiktok', 'soundcloud', 'youtube', 'website'];

    protected $table = 'social_link';

    protected $fillable = [
        'user_id',
        'name',
        'value',
    ];

    public function scopeUserAndName(Builder $query, User $user, string $name)
    {
        $query->where('user_id', $user->id)->where('name', $name);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
