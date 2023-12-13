<?php

namespace App\Models;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductFilter extends Model
{
    public $table = 'product_filters';
    public $fillable = ['name', 'description', 'category_id', 'sorttype', 'search'];

   
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    public function productTags()
    {
        return $this->hasMany(TagRef::class, 'ref_id', 'id')->where('tag_refs.ref', 'product-filter');
    }

    // public function tags()
    // {
    //     return $this->productTags()->join('tags', 'tag_refs.tag_id', '=', 'tags.id')->select('tags.name', 'tags.keyword', 'tags.slug');

    // }

    public function tags()
    {
        return $this->productTags()->join('tags', 'tag_refs.tag_id', '=', 'tags.id')->select('tags.name', 'tags.keyword', 'tags.slug');
    }


    public function beforeDelete()
    {
        $this->productTags()->delete();
    }

    public function getSortTypeLabel()
    {
        return array_key_exists($this->sorttype, $so = get_product_sortby_options()) ? $so[$this->sorttype]: "Mặc định";
    }

    public function getTagNames()
    {
        $names = [];

        if($this->tags  && count($this->tags)){
            foreach ($this->tags as $tag) {
                $names[] = htmlentities($tag->name);
            }
        }
        return implode(', ', $names);
    }
    
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        $tags = [];
        if (count($this->productTags)) {
            foreach ($this->productTags as $tagged) {
                $tags[] = $tagged->tag_id;
            }
        }
        $data['tags'] = $tags;
        return $data;
    }



}
