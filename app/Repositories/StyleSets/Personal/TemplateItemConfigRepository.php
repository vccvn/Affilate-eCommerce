<?php

namespace App\Repositories\StyleSets\Personal;

use App\Masks\StyleSets\Personal\TemplateItemConfigCollection;
use App\Masks\StyleSets\Personal\TemplateItemConfigMask;
use App\Validators\StyleSets\Personal\TemplateItemConfigValidator;
use Gomee\Repositories\BaseRepository;
/**
 * validator 
 * 
 */
class TemplateItemConfigRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = TemplateItemConfigValidator::class;
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = TemplateItemConfigMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = TemplateItemConfigCollection::class;


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PersonalStyleTemplateItemConfig::class;
    }

}