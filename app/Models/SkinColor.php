<?php

namespace App\Models;

use Gomee\Models\Model;

class SkinColor extends Model
{
    public $table = 'skin_colors';
    public $fillable = ['name', 'description', 'thumbnail', 'color'];

    public static function getImagePath($file = null)
    {
        return content_path('customer-centric-data/skin-colors' . ($file ? '/' . $file : ''));
    }


    public function getThumbnail()
    {
        if ($this->thumbnail) {
            if (preg_match('/^(http|https)\:\/\//', $this->thumbnail)) return $this->thumbnail;
            return asset(static::getImagePath($this->thumbnail));
        }
        return asset('static/images/default.png');
    }
    public function deleteThumbnail()
    {
        if ($this->thumbnail && !preg_match('/^(http|https)\:\/\//', $this->thumbnail) && file_exists($path = static::getImagePath($this->thumbnail))) {
            unlink($path);
        }
    }

    public function beforeDelete()
    {
        $this->deleteThumbnail();
    }
}
