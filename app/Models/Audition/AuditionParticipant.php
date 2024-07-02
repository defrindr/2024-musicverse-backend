<?php

namespace App\Models\Audition;

use App\Models\User;
use Defrindr\Crudify\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model AuditionParticipant
 *
 * @author defrindr
 */
class AuditionParticipant extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_REGISTER = 'registration';

    const STATUS_AUDITION = 'auditions';

    const STATUS_CONTRACT = 'contract';

    protected $table = 'audition_participants';

    protected $fillable = [
        'audition_id',
        'participant_id',
        'status',
        'total_point',
        'rank',
        'room',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        // $builder->where(function ($builder) use ($keyword) {
        //     $builder->where('assesment', 'like', "%$keyword%");
        // });
    }

    public function audition(): BelongsTo
    {
        return $this->belongsTo(Audition::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
