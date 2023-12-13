<?php

namespace App\Models;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalStyleSetComboItem extends Model
{
    public $table = 'personal_style_set_combo_items';
    public $fillable = ['style_set_id', 'product_id', 'attr_values', 'quantity'];

    

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
