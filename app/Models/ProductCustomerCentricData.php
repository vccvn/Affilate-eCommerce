<?php

namespace App\Models;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCustomerCentricData extends Model
{
    public $table = 'product_customer_centric_datas';
    public $fillable = [
        'product_id', 'body_shape_id', 'skin_color_id', 
        'has_height_limited', 'has_weight_limited', 'has_bmi_limited', 'has_measurement_limited', 'has_age_limited', 
        'min_height', 'max_height', 'min_weight', 'max_weight', 'min_bmi', 'max_bmi', 
        'min_chest', 'max_chest', 'min_waist', 'max_waist', 'min_hip', 'max_hip', 
        'min_age', 'max_age'
    ];

    /**
     * Get the product that owns the ProductCustomerCentricData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    

    /**
     * Get the bodyShape that owns the ProductCustomerCentricData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bodyShape(): BelongsTo
    {
        return $this->belongsTo(BodyShape::class, 'body_shape_id', 'id');
    }

    /**
     * Get the skinColor that owns the ProductCustomerCentricData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skinColor(): BelongsTo
    {
        return $this->belongsTo(SkinColor::class, 'skin_color_id', 'id');
    }
}
