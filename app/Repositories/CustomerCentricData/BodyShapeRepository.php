<?php

namespace App\Repositories\CustomerCentricData;

use Gomee\Repositories\BaseRepository;
/**
 * validator 
 * 
 */
use App\Validators\CustomerCentricData\BodyShapeValidator;
use App\Masks\CustomerCentricData\BodyShapeMask;
use App\Masks\CustomerCentricData\BodyShapeCollection;
class BodyShapeRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = BodyShapeValidator::class;
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = BodyShapeMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = BodyShapeCollection::class;


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\BodyShape::class;
    }

}