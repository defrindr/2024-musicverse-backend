<?php

namespace App\Models\Audition;

use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model Audition
 *
 * @author defrindr
 */
class Audition extends Model
{
    use HasFactory, SoftDeletes;

    const UPLOADED_PATH = '/auditions/files/';

    protected $table = 'auditions';

    protected $fillable = [
        'title',
        'skill_id',
        'date',
        'created_by',
        'description',
        'term',
        'contract',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) {
            // $builder->where('name', 'like', "%$keyword%");
        });
    }

    public function assesments(): HasMany
    {
        return $this->hasMany(AuditionAssesment::class);
    }
}
