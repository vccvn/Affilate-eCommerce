<?php

namespace App\Http\Controllers\Admin\Ecommerce\CCD;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BodyShape;
use Illuminate\Http\Request;
use Gomee\Helpers\Arr;

use App\Repositories\CustomerCentricData\BodyShapeRepository;

class BodyShapeController extends AdminController
{
    protected $module = 'customer-centric-data.body-shapes';

    protected $moduleName = 'Dáng người';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var BodyShapeRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BodyShapeRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    /**
     * xu ly truoc khi update
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeSave(Request $request, Arr $data, BodyShape $bodyShape = null)
    {
        if($request->hasFile('thumbnail')){
            if (!($file = $this->uploadImage($request, 'thumbnail', null, BodyShape::getImagePath()))) {
                return redirect()->back()->with('error', "Đã có lỗi xảy ra. Không thể upload file");
            }
            
            if($bodyShape){
                $bodyShape->deleteThumbnail();
            }
    
    
            $data->thumbnail = $file->filename;
        }
    }
}
