<?php

namespace App\Repositories\StyleSets\Personal;

use App\Masks\StyleSets\Personal\ItemConfigCollection;
use App\Masks\StyleSets\Personal\ItemConfigMask;
use App\Validators\StyleSets\Personal\ItemConfigValidator;
use Gomee\Repositories\BaseRepository;
/**
 * validator 
 * 
 */
class ItemConfigRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = ItemConfigValidator::class;
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = ItemConfigMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = ItemConfigCollection::class;


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PersonalStyleItemConfig::class;
    }

}