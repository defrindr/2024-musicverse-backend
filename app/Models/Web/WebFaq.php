<?php

namespace App\Models\Web;

use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model WebFaq
 *
 * @author defrindr
 */
class WebFaq extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'web_faqs';

    protected $fillable = [
        'question',
        'answer',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            $builder->where('question', 'like', "%$keyword%");
        });
    }
}
