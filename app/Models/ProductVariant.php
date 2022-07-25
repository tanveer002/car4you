<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'name',
    ];

    public function variants() {
        return $this->belongsTo(Product::class);
    }

    public function variant_values() {
        return $this->hasMany(VariantValues::class);
    }
}
