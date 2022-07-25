<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantValues extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_variant_id',
        'value',
        'title',
        'parent_id',
    ];

    public function product_variant() {
        return $this->belongsTo(ProductVariant::class);
    }

    public function product(){
        return $this->belongsTo(VariantValues::class,'parent_id');
    }

    public function deliveries() {
        return $this->belongsToMany(ProductVariant::class,
            'user_products_deliveries',
            'variant_value_id',
            'user_id')
            ->withPivot(['product_name','product_model','comments', 'location_id'])
            ->withTimestamps();
    }
}
