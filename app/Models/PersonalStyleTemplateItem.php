<?php

namespace App\Models;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * item style mau
 * @property-read File $frontImage
 * @property-read File $cackImage
 * @property-read PersonalStyleTemplate $template
 * @property-read PersonalStyleTemplateItemConfig $config
 * @property-read TagRef[] $tagRefs
 */
class PersonalStyleTemplateItem extends Model
{
    const REF_KEY = 'PS-TEMP-ITEM';
    public $table = 'personal_style_template_items';
    public $fillable = ['template_item_config_id', 'name', 'front_image_id', 'back_image_id'];

    public $timestamps = false;
    
    /**
     * Get the config that owns the PersonalStyleTemplateItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function templateItemConfig(): BelongsTo
    {
        return $this->belongsTo(PersonalStyleTemplateItemConfig::class, 'template_item_config_id', 'id');
    }

    /**
     * Get the frontImage that owns the PersonalStyleTemplateItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function frontImage(): BelongsTo
    {
        return $this->belongsTo(File::class, 'front_image_id', 'id');
    }

    /**
     * Get the backImage that owns the PersonalStyleTemplateItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function backImage(): BelongsTo
    {
        return $this->belongsTo(File::class, 'back_image_id', 'id');
    }

    /**
     * Get all of the tagRefs for the PersonalStyleTemplateItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagRefs(): HasMany
    {
        return $this->hasMany(TagRef::class, 'ref_id', 'id')->where('tag_refs.ref', self::REF_KEY);
    }

    public function tags()
    {
        return $this->tagRefs()->join('tags', 'tag_refs.tag_id', '=', 'tags.id')->select('tag_refs.*', 'tags.name', 'tags.keyword', 'tags.slug');
    }


    public function beforeDelete()
    {
        $this->tagRefs()->delete();
    }

    
    public function getFrontImage()
    {
        return $this->frontImage?$this->frontImage->getUrl(): asset('static/images/default.png');
    }
    public function getBackImage()
    {
        return $this->backImage?$this->backImage->getUrl(): asset('static/images/default.png');
    }

    
    public function getCateIDs()
    {
        return $this->templateItemConfig ? $this->templateItemConfig->getCateIDs() : [];
    }

    public function getTagIDs()
    {
        $tags = [];
        if (count($this->tagRefs)) {
            foreach ($this->tagRefs as $tagged) {
                $tags[] = $tagged->tag_id;
            }
        }
        return $tags;
    }
    
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        
        $data['tags'] = $this->getTagIDs();
        
        return $data;
    }



}
