<?php

namespace App\Models;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
/**
 * item style mau
 * @property-read PersonalStyleTemplate $template
 * @property-read PersonalStyleItemConfig $itemConfig
 * 
 * 
 */
class PersonalStyleTemplateItemConfig extends Model
{
    const REF_KEY = 'PSTIC';
    public $table = 'personal_style_template_item_configs';
    public $fillable = ['config_id', 'template_id', 'use_custom_config', 'preview_config'];
    // 'front_image_id', 'back_image_id'

    public $timestamps = false;

    
    public $casts = [
        'config' => 'json',
    ];


    /**
     * Get all of the categoryRefs for the PersonalStyleTemplateItemConfig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoryRefs(): HasMany
    {
        return $this->hasMany(CategoryRef::class, 'ref_id', 'id')->where('ref', self::REF_KEY);
    }

    /**
     * Get the template that owns the PersonalStyleTemplateItemConfig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(PersonalStyleTemplate::class, 'template_id', 'id');
    }

    /**
     * Get the config that owns the PersonalStyleTemplateItemConfig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function itemConfig(): BelongsTo
    {
        return $this->belongsTo(PersonalStyleItemConfig::class, 'config_id', 'id');
    }

    /**
     * Get all of the templateItems for the PersonalStyleTemplateItemConfig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function templateItems(): HasMany
    {
        return $this->hasMany(PersonalStyleTemplateItem::class, 'template_item_config_id', 'id');
    }
    

    public function getPreviewConfigData()
    {
        $config = $this->use_custom_config? ( 
            is_array($this->preview_config)?$this->preview_config:json_decode($this->preview_config, true) 
        ): (
            $this->itemConfig?$this->itemConfig->getPreviewConfigData(): [
                'top' => null, 'left' => null, 'width' => null, 'height' => null
            ]
        );
        return $config;
    }

    
    public function getCateIDs()
    {
        $cates = [];
        if($this->categoryRefs && count($this->categoryRefs)){
            foreach ($this->categoryRefs as $cateRef) {
                if($cateRef->category){
                    $map = $cateRef->category->getMap();
                    if($map){
                        foreach ($map as $id) {
                            if(!in_array($id, $cates)) $cates[] = $id;
                        }
                    }
                }else{
                    $cates[] = $cateRef->category_id;
                }
            }
        }
        return $cates;
    }
    
    public function toFormData()
    {
        $data = $this->toArray();
        if(array_key_exists('preview_config', $data)) {
            if(!is_array($data['preview_config'])) $data['preview_config'] = json_decode($data['preview_config'], true);
        }else{
            $data['preview_config'] = [];
        }
        

        $data['categories'] = $this->getCateIDs();
        
        return $data;
    }
    
}
