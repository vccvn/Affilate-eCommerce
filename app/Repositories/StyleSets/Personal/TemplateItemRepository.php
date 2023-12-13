<?php

namespace App\Repositories\StyleSets\Personal;

use Gomee\Repositories\BaseRepository;
/**
 * validator 
 * 
 */
use App\Validators\StyleSets\Personal\TemplateItemValidator;
use App\Masks\StyleSets\Personal\TemplateItemMask;
use App\Masks\StyleSets\Personal\TemplateItemCollection;
class TemplateItemRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = TemplateItemValidator::class;
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = TemplateItemMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = TemplateItemCollection::class;


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PersonalStyleTemplateItem::class;
    }

}