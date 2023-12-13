<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use Gomee\Helpers\Arr;
use App\Repositories\Users\UserRepository;

class UserController extends AdminController
{
    protected $module = 'users';

    protected $moduleName = 'Người dùng';
    
    protected $data = [];


    protected $flashMode = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $UserRepository)
    {
        $this->repository = $UserRepository;
        

        $this->init();
        
    }

    public function beforeGetUpdateForm(Request $request, Arr $config, Arr $inputs, Arr $data , Arr $attribues)
    {
        if(!$data->last_name && !$data->first_name){
            $a = explode(' ', $data->name);
            $data->last_name = array_shift($a);
            $data->first_name = implode(' ', $a);
        }
    }

    
    /**
     * can thiệp trước khi luu
     * @param Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $data->name = $data->last_name . ' ' . $data->first_name;
        $this->uploadImageAttachFile($request, $data, 'avatar', get_content_path('avatar'));

        
        $this->data = $data->all();
    }

    public function beforeGetListView($request, $data)
    {
        add_js_data('user_custom_urls', [
            'reset2fa_url' => $this->getModuleRoute('reset2fa')
        ]);
    }
    /**
     * can thiệp sau khi luu
     * @param Request $request
     * @param Model $model dũ liệu đã được luu
     * @return void
     */
    protected function afterSave(Request $request, $model)
    {
        // luu thong tin pro file
        // $this->profiles->saveProfile($model->id, $this->data);

    }

    public function reset2fa(Request $request)
    {
        extract($this->apiDefaultData);

        if(!$request->id || !($user = $this->repository->first(['id' => $request->id]))){
            $message = 'User không tồn tại';
        }else{
            $user->google2fa_secret = null;
            $user->save();
            $status = true;
        }

        return $this->json(compact(...$this->apiSystemVars));
    }



    /**
     * tim kiếm thông tin người dùng 
     * @param Request $request
     * @return json
     */
    public function getUserSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getUserSelectOptions($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

    
    /**
     * tim kiếm thông tin người dùng 
     * @param Request $request
     * @return json
     */
    public function getUserTagData(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getUserTagData($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
