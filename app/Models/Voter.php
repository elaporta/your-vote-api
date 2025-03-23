<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'document',
        'dob',
        'address',
        'phone',
        'gender',
        'is_candidate'
    ];

    protected $hidden = [
        'is_candidate',
        'deleted_at'
    ];

    protected function casts() {
        return [
            'dob' => 'date:Y-m-d',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime:Y-m-d H:i:s'
        ];
    }

    // Local scopes
    public function scopeNotCandidate(Builder $query) {
        $query->where('is_candidate', 0);
    }

    public function scopeCandidate(Builder $query) {
        $query->where('is_candidate', 1);
    }

    // Relationships
    public function votes(): HasOne {
        return $this->hasOne(Vote::class, 'candidate_id');
    }

    public function receivedVotes(): HasMany {
        return $this->hasMany(Vote::class, 'candidate_voted_id');
    }
}
