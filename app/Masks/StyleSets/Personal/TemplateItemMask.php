<?php
namespace App\Masks\StyleSets\Personal;

use App\Masks\Files\FileMask;
use App\Masks\Tags\TagRefCollection;
use App\Models\PersonalStyleTemplateItem;
use Gomee\Masks\Mask;

class TemplateItemMask extends Mask
{

    protected function init(){
        $this->map([
            'templateItemConfig' => TemplateItemConfigMask::class,
            'frontImage' => FileMask::class,
            'backImage' => FileMask::class,
            'tagRefs' => TagRefCollection::class
        ]);
    }

    protected function onLoaded()
    {
        $this->front_image_url = $this->getFrontImage();
        $this->back_image_url = $this->getBackImage();
        $this->tag_ids = $this->getTagIDs();
        
    }
    
}