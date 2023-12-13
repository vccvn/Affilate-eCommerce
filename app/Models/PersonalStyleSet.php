<?php

namespace App\Models;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonalStyleSet extends Model
{
    public $table = 'personal_style_sets';
    public $fillable = ['user_id', 'template_id', 'image_id', 'name', 'type', 'thumbnail_image', 'set_data'];

    public $casts = [
        'set_data' => 'json'
    ];

    protected $__product_parameters__ = [];

    /**
     * Get all of the items for the PersonalStyleSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(PersonalStyleSetItem::class, 'style_set_id', 'id');
    }

    /**
     * Get the user that owns the PersonalStyleSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    

    public function getTemplateItemIDs()
    {
        $data = [];
        foreach ($this->items as $key => $item) {
            $data[] = $item->template_item_id;
        }
        return $data;
    }


    public function getThumbnail()
    {
        if ($this->thumbnail_image) {
            $featured_image = $this->thumbnail_image;
            if (file_exists(public_path($p = get_content_path('style-sets/' . $featured_image)))) {
                return asset($p);
            }
        } 
        
        
        return asset('static/images/default.png');
    }

    public function getSetData()
    {
        if(!is_array($this->set_data)) $this->set_data = json_decode($this->set_data, true);
        if(!is_array($this->set_data)) $this->set_data = [];
        
        return $this->set_data;
    }



    public function getProductParameters()
    {
        $params = [];
        if($this->items && count($this->items)){
            $set_data = $this->getSetData();
            $attributes = array_key_exists('attr_values', $set_data) && is_array($set_data['attr_values']) ? $set_data['attr_values'] : [];
                                                              
            foreach ($this->items as $item) {
                
                $id = 0;
                $data = [
                    'item_name' => '',
                    'categories' => [],
                    'tags' => [],
                    'attributes' => []
                ];
                if($templateItem = $item->templateItem){
                    $data['tags'] = $templateItem->getTagIDs();
                    if($templateItemConfig = $templateItem->templateItemConfig){
                        $data['categories'] = $templateItemConfig->getCateIDs();
                        
                        $id = $templateItemConfig->id;
                        $data['item_config_id'] = $id;
                        if($itemConfig = $templateItemConfig->itemConfig){
                            $data['item_name'] = $itemConfig->name;
                        }
                    }
                    if(!$data['item_name']) $data['item_name'] = $templateItem->name;
                }
                $data['attributes'] = array_key_exists($id, $attributes) ? array_values($attributes[$id]) : [];

                $params[$id] = $data;
            }

        }

        return $params;
    }


    public function getProductParametersAttribute()
    {
        if(count($this->__product_parameters__) == 0){
            $this->__product_parameters__ = $this->getProductParameters();
        }
        return $this->__product_parameters__;
    }

}
