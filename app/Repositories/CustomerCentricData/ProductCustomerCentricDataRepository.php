<?php

namespace App\Repositories\CustomerCentricData;

use Gomee\Repositories\BaseRepository;
/**
 * validator 
 * 
 */
use App\Validators\CustomerCentricData\ProductCustomerCentricDataValidator;
use App\Masks\CustomerCentricData\ProductCustomerCentricDataMask;
use App\Masks\CustomerCentricData\ProductCustomerCentricDataCollection;
class ProductCustomerCentricDataRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = ProductCustomerCentricDataValidator::class;
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = ProductCustomerCentricDataMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = ProductCustomerCentricDataCollection::class;


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ProductCustomerCentricData::class;
    }

}