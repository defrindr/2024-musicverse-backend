<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model Audition
 * @author defrindr
 */
class Audition extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'auditions';

    protected $fillable = [
        'title',
        'skill_id',
        'date',
        'created_by',
        'description',
        'term',
        'contract'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            // $builder->where('name', 'like', "%$keyword%");
        });
    }
}
