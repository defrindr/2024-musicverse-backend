<?php

namespace App\Models\Clinic;

use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model AnimalType
 *
 * @author defrindr
 */
class AnimalType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clinic_animal_types';

    protected $fillable = ['type'];

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            $builder->where('type', 'like', "%$keyword%");
        });
    }
}
