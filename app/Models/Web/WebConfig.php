<?php

namespace App\Models\Web;

use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Auto-generated Model WebConfig
 *
 * @author defrindr
 */
class WebConfig extends Model
{
    use HasFactory;

    const FOLDER_PATH = 'web-config';

    // protected $table = '';

    protected $fillable = ['type', 'name', 'value'];

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            $builder->where('type', 'like', "%$keyword%");
        });
    }

    public function scopeWithType(Builder $builder, string $type): void
    {
        $builder->where('type', $type);
    }
}
