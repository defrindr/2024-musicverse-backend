<?php

namespace App\Models\Master;

use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model Country
 *
 * @author defrindr
 */
class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'countries';

    protected $fillable = [
        'country',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            $builder->where('country', 'like', "%$keyword%");
        });
    }
}
