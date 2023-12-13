<?php

namespace App\Http\Controllers\Admin\Ecommerce\CCD;

use App\Http\Controllers\Admin\AdminController;
use App\Models\SkinColor;
use Illuminate\Http\Request;
use Gomee\Helpers\Arr;

use App\Repositories\CustomerCentricData\SkinColorRepository;

class SkinColorController extends AdminController
{
    protected $module = 'customer-centric-data.skin-colors';

    protected $moduleName = 'Màu da';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var SkinColorRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SkinColorRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    /**
     * xu ly truoc khi update
     *
     * @param Request $request
     * @param Arr $data
     * @param SkinColor $skinColor
     * @return void
     */
    public function beforeSave(Request $request, Arr $data, SkinColor $skinColor = null)
    {
        if($request->hasFile('thumbnail')){
            if (!($file = $this->uploadImage($request, 'thumbnail', null, SkinColor::getImagePath()))) {
                return redirect()->back()->with('error', "Đã có lỗi xảy ra. Không thể upload file");
            }
            if($skinColor){
                $skinColor->deleteThumbnail();
            }
    
            $data->thumbnail = $file->filename;
        }
    }

//     public function imageColorPng(Request $request)
//     {
//         $im = Image::create(null, 60, 60, array_values(hexToRgb($this->color)));
//     }
}
