<?php

namespace App\Repositories\StyleSets\Personal;

use App\Masks\StyleSets\Personal\StyleSetCollection;
use App\Masks\StyleSets\Personal\StyleSetMask;
use App\Validators\StyleSets\Personal\StyleSampleValidator;
use Gomee\Repositories\BaseRepository;

class StyleSampleRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = StyleSampleValidator::class;
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
     * @var array $defaultSortBy Mảng key value là tên cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'personal_style_sets.id' => 'DESC'
    ];
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
        $this->addDefaultParam('type', 'sample');
        $this->addDefaultValue('type', 'sample');
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


}