<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model AuditionAssesment
 * @author defrindr
 */
class AuditionAssesment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'audition_assesments';

    protected $fillable = [
        'audition_id',
        'assesment',
        'weight'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            // $builder->where('name', 'like', "%$keyword%");
        });
    }

    public function audition(): BelongsTo
    {
        return $this->belongsTo(Audition::class);
    }
}
