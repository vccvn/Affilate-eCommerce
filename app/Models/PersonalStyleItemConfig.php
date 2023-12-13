<?php

namespace App\Models;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonalStyleItemConfig extends Model
{
    public $table = 'personal_style_item_configs';
    public $fillable = ['name', 'priority', 'preview_config'];

    public $casts = [
        'config' => 'json',
    ];


    
    /**
     * Get all of the templateItems for the PersonalStyleItemConfig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function templateItems(): HasMany
    {
        return $this->hasMany(PersonalStyleTemplateItemConfig::class, 'config_id', 'id');
    }

    public function beforeDelete()
    {
        $this->templateItems()->delete();
    }

    public function toFormData()
    {
        $data = $this->toArray();
        if(array_key_exists('preview_config', $data)) {
            if(!is_array($data['preview_config'])) $data['preview_config'] = json_decode($data['preview_config'], true);
        }
        $data['preview_config'] = [];
        
    }

    

    public function getPreviewConfigData()
    {
        $config = is_array($this->preview_config)?$this->preview_config:json_decode($this->preview_config, true);
        if(!$config){
            $config = ['top' => null, 'left' => null, 'width' => null, 'height' => null];
        }
        return $config;
    }


}
