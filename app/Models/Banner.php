<?php

namespace App\Models;

use Gomee\Models\Model;

class Banner extends Model
{
    public $table    = 'banners';
    public $fillable = ['type', 'title', 'url', 'image', 'embed_code', 'position', 'alt'];

    public function getImageSrc()
    {
        if($this->image){
            $filename = $this->image;
            $path = get_content_path('banners') . '/';

        }else{
            $path = 'static/images/';
            $filename = 'default.png';
        }

        // if(file_exists($path2 = public_path($path.'120x120/'.$filename))){
        //     $url = asset($path.'120x120/'.$filename);
        // }else{
            $url = asset($path.$filename);
        // }


        return $url;
    }

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        $data['file'] = $data['image'];

        return $data;
    }




}
