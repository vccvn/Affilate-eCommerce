<?php

namespace App\Repositories\CustomerCentricData;

use Gomee\Repositories\BaseRepository;
/**
 * validator 
 * 
 */
use App\Validators\CustomerCentricData\SkinColorValidator;
use App\Masks\CustomerCentricData\SkinColorMask;
use App\Masks\CustomerCentricData\SkinColorCollection;
class SkinColorRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = SkinColorValidator::class;
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = SkinColorMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = SkinColorCollection::class;


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\SkinColor::class;
    }

}