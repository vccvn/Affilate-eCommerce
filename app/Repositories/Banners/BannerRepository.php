<?php

namespace App\Repositories\Banners;

use App\Masks\Banners\BannerCollection;
use App\Masks\Banners\BannerMask;
use App\Models\Banner;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Pages\PageRepository;
use Gomee\Repositories\BaseRepository;

class BannerRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass
     */
    protected $validatorClass = 'App\Validators\Banners\BannerValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'BannerResource';

    // /**
    //  * @var string $collectionClass
    //  */
    // protected $collectionClass = 'BannerCollection';

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = BannerMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = BannerCollection::class;

    // protected $defaultSortBy
    //     = [
    //         'priority' => 'ASC'
    //     ];

    /**
     * danh muc bai viet
     *
     * @var CategoryRepository
     */
    public $categoryRepository;


    /**
     * trang
     *
     * @var PageRepository
     */
    public $pagetRepository;

    /**
     * dynamic
     *
     * @var DynamicRepository
     */
    public $dynamicRepository;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Banner::class;
    }

}