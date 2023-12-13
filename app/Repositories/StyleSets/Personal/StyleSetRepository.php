<?php

namespace App\Repositories\StyleSets\Personal;

use App\Masks\StyleSets\Personal\StyleSetCollection;
use App\Masks\StyleSets\Personal\StyleSetMask;
use App\Validators\StyleSets\Personal\StyleSetValidator;
use Gomee\Repositories\BaseRepository;
use Illuminate\Http\Request;

/**
 * validator 
 * @method StyleSetValidator validator(Request $request, array $rules, array $message = []) lấy Đối tượng valdator
 */

class StyleSetRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = StyleSetValidator::class;
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = StyleSetMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = StyleSetCollection::class;


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PersonalStyleSet::class;
    }

    public function beforeGetData($data = [])
    {
        if(array_key_exists('@withFullData', $data)){
            if($data['@withFullData']){
                $data = $this->getFullDataParams($data);
            }
            unset($data['@withFullData']);
            
        }
        return $data;
    }
    public function init()
    {
        # code...
    }

    public function beforeFillter($request)
    {
        
    }

    
    public function getFullDataParams($params = [])
    {
        return array_merge([
            '@withItems' => [
                '@withTemplateItem' => [
                    '@withTemplateItemConfig' => [
                        '@withCategoryRefs' => true
                    ],
                    '@withTagRefs' => true,
                    '@with' => [
                        'backImage', 'frontImage'
                    ]
                ],
                
            ]
        ], $params);
    }

    public function getStyleSets($args = [])
    {
        return $this->mode('mask')->getData($this->getFullDataParams($args));
    }

    public function grandUser($user_id, $ids = [])
    {
        $args = [
            'user_id' => 0,
            'id' => $ids,
            'type' => 'client'
        ];
        if($t = count($results = $this->get($args))){
            foreach ($results as $key => $style) {
                $style->user_id = $user_id;
                $style->type = 'user';
                $style->save();
            }
            return $t;
        }
        return 0;

    }

}