<?php

namespace App\Models;

use Gomee\Helpers\Arr;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StyleSetItem extends Model
{
    public $table = 'style_set_items';
    public $fillable = ['style_set_id', 'product_id', 'attr_values', 'quantity'];

    public $timestamps = false;
    

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        $data['attr_values'] = explode('-', $this->attr_values);
        return $data;
    }


    /**
     * Get the product that owns the StyleSetItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


}
