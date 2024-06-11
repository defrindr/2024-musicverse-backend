<?php

namespace App\Models\Audition;

use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkillCategory extends Model
{
    use HasFactory, SoftDeletes;

    const UPLOADED_PATH = 'auditions/skill/';

    protected $table = 'skill_categories';

    protected $fillable = [
        'name',
        'icon',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            $builder->where('name', 'like', "%$keyword%");
        });
    }
}
