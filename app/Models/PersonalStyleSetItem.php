<?php

namespace App\Models;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalStyleSetItem extends Model
{
    public $table = 'personal_style_set_items';
    public $fillable = ['style_set_id', 'template_item_id', 'item_data'];

    public $timestamps = false;
    
    public $casts = [
        'item_data' => 'json'
    ];

    /**
     * Get the templateConfig that owns the PersonalStyleSetItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function templateItem(): BelongsTo
    {
        return $this->belongsTo(PersonalStyleTemplateItem::class, 'template_item_id', 'id');
    }

    /**
     * Get the styleSet that owns the PersonalStyleSetItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function styleSet(): BelongsTo
    {
        return $this->belongsTo(PersonalStyleSet::class, 'style_style_id', 'id');
    }

    public function getItemData()
    {
        if(!is_array($this->item_data)) $this->item_data = json_decode($this->item_data, true);
        return $this->item_data;
    }

}
