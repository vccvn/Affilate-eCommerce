<?php
namespace App\Masks\StyleSets\Personal;

use App\Masks\Categories\CategoryRefCollection;
use App\Masks\Categories\CategoryRefMask;
use App\Masks\Products\AttributeCollection;
use App\Models\PersonalStyleTemplateItemConfig;
use Gomee\Masks\Mask;

class TemplateItemConfigMask extends Mask
{

    protected function init(){
        $this->allow(['getPreviewConfigData', 'toFormData']);
        $this->map([
            'itemConfig' => ItemConfigMask::class,
            'templateItems' => TemplateItemCollection::class,
            'categoryRefs' => CategoryRefCollection::class,
            'attributes' => AttributeCollection::class
        ]);
    }

    protected function onLoaded()
    {
        $this->preview_config = $this->getPreviewConfigData();
        $cateIDs = $this->hasRelation('categoryRefs')?$this->getCateIDs():[];
        $this->category_ids = $cateIDs;
        
    }
    
    public function setRelation($name, $data)
    {
        $this->relations[$name] = $data;
    }
    
}