<?php

namespace App\Models\Master;

use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model Language
 *
 * @author defrindr
 */
class Language extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'languages';

    protected $fillable = ['language'];

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            $builder->where('language', 'like', "%$keyword%");
        });
    }
}
