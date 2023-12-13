<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AdminController;
use App\Repositories\Banners\BannerRepository;
use Gomee\Helpers\Arr;
use Illuminate\Http\Request;

class BannerController extends AdminController
{
    protected $module = 'banners';

    protected $moduleName = 'Banner';

    protected $flashMode = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BannerRepository $BannerRepository)
    {
        $this->repository = $BannerRepository;
        $this->init();
    }

    public function beforeSave(Request $request, Arr $data)
    {
        if($request->hasFile('file')){
            if (!($file = $this->uploadImage($request, 'file', null, get_content_path('banners'), true, 120, 120))) {
                return redirect()->back()->with('error', "Đã có lỗi xảy ra. Không thể upload file");
            }
    
            $data->image = $file->filename;
        }
        
    }

}
