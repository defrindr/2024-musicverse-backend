<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 'ADMINISTRATOR';

    const ROLE_TALENT = 'TALENT';

    const ROLE_PRODUCER = 'PRODUCER';

    const ROLE_REGISTER = 'REGISTER';

    const TOKEN_EXPIRED_TIME = 525600;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'country',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            $builder->where('name', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->orWhere('role', 'like', "%$keyword%")
                ->orWhere('country', 'like', "%$keyword%");
        });
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    /**
     * Mendapatkan nama tabel
     *
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getTableColumns()
    {
        $class = with(new static);

        return $class->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($class->getTable());
    }
}
