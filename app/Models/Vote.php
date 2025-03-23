<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'candidate_voted_id',
        'date'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected function casts() {
        return [
            'date' => 'datetime:Y-m-d H:i:s',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime:Y-m-d H:i:s'
        ];
    }

    // Relationships
    public function voters(): BelongsTo {
        return $this->belongsTo(Voters::class, 'candidate_id');
    }

    public function candidates(): BelongsTo {
        return $this->belongsTo(Voters::class, 'candidate_voted_id');
    }
}
