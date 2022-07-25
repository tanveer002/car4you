<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function variant_values() {
        return $this->hasManyThrough(VariantValues::class, ProductVariant::class);
    }

    public function scopeonlyModels() {
        return $this->variant_values()->whereNotNull('parent_id');
    }

    public function scopeonlyValues() {
        return $this->variant_values()->whereNull('parent_id');
    }

    public function locations(){
        return $this->morphMany(Location::class, 'locationable');
    }
}
