<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

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
    public function scopeVoter(Builder $query) {
        $query->where('is_candidate', 0);
    }

    public function scopeCandidate(Builder $query) {
        $query->where('is_candidate', 1);
    }
}
