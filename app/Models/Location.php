<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'state_id',
    ];

    public function locationable()
    {
        return $this->morphTo();
    }

    public function state() {
        return $this->belongsTo(State::class);
    }
}
