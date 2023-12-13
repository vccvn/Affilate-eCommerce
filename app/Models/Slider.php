<?php

namespace App\Models;
use Gomee\Models\Model;
class Slider extends Model
{
    public $table = 'sliders';
    public $fillable = ['name', 'slug', 'description', 'priority', 'crop', 'width', 'height', 'status', 'trashed_status'];

    

    /**
     * lấy danh sách item thuộc slider
     *
     * @return SliderItem
     */
    public function sliderItems()
    {
        return $this->hasMany('App\Models\SliderItem', 'slider_id', 'id');
    }

    public function items()
    {
        return $this->sliderItems()->orderBy('priority', 'ASC');
    }


    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        
        return $data;
    }

    public function getSizeText()
    {
        return $this->crop ? $this->width . 'x' . $this->height : 'auto';
    }


    public function beforeDelete()
    {
        if(count($this->sliderItems)){
            foreach ($this->sliderItems as $items) {
                $items->delete();
            }
        }
    }
    
}
