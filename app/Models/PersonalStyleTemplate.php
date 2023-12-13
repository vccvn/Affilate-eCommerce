<?php

namespace App\Models;

use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Style template
 * @property File $avatar
 */
class PersonalStyleTemplate extends Model
{
    public $table = 'personal_style_templates';
    public $fillable = [
        'name', 'avatar_id',
        'use_height', 'use_weight', 'use_bmi',
        'min_height', 'max_height',
        'min_weight', 'max_weight',
        'min_bmi', 'max_bmi',
        'width', 'height'
    ];

    /**
     * Get all of the items for the PersonalStyleTemplate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemConfigs(): HasMany
    {
        return $this->hasMany(PersonalStyleTemplateItemConfig::class, 'template_id', 'id');
    }

    /**
     * Get all of the items for the PersonalStyleTemplate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(PersonalStyleTemplateItem::class, 'template_id', 'id');
    }

    /**
     * Get the avatar that owns the PersonalStyleTemplate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(File::class, 'avatar_id', 'id');
    }

    public function getAvatar()
    {
        return $this->avatar ? $this->avatar->getUrl() : asset('static/images/default.png');
    }
    public function getThumbnail()
    {
        return $this->avatar ? $this->avatar->getThumbnail() : asset('static/images/default.png');
    }
}
