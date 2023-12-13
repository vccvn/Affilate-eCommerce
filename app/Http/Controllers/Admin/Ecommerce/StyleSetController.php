<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\AdminController;
use App\Models\StyleSet;
use App\Repositories\Files\FileRefRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\StyleSets\StyleSetItemRepository;
use Illuminate\Http\Request;
use Gomee\Helpers\Arr;

use App\Repositories\StyleSets\StyleSetRepository;

class StyleSetController extends AdminController
{
    protected $module = 'style-sets';

    protected $moduleName = 'Style Set';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var StyleSetRepository
     */
    public $repository;
    /**
     * @var MetadataRepository $metadataRepository
     */
    protected $metadataRepository;

    /**
     * @var ProductRepository $productRepository
     */
    protected $productRepository;

    /**
     * lien ket file
     *
     * @var FileRefRepository
     */
    protected $fileRefRepository;
    /**
     * Undocumented variable
     *
     * @var StyleSetItemRepository
     */
    public $styleSetItemRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        StyleSetRepository $repository,
        MetadataRepository $metadataRepository, 
        ProductRepository $productRepository, 
        StyleSetItemRepository $styleSetItemRepository,
        FileRefRepository $fileRefRepository
    )
    {
        $this->repository = $repository;
        $this->metadataRepository = $metadataRepository;
        $this->productRepository = $productRepository;
        $this->styleSetItemRepository = $styleSetItemRepository;
        $this->fileRefRepository = $fileRefRepository;
        $this->init();
    }

    /**
     * can thiệp trước khi luu
     * @param Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $slug = str_slug($request->custom_slug? $request->slug : $request->name);
        $data->slug = $this->repository->getSlug(
            $slug?$slug : uniqid(),
            $request->id
        );

        $orderDetail = $this->styleSetItemRepository->parseItems(is_array($data->items)?$data->items:[]);
        $this->items = $orderDetail['items'];
    }


    
    /**
     * lưu các dữ liệu liên quan như thuộc tính, meta, gallery
     * @param Request $request
     * @param StyleSet $styleSet
     * @param Arr $data dữ liệu từ input đã dược kiểm duyệt
     *
     * @return void
     */
    public function afterSave(Request $request, $styleSet, $data)
    {
        // $this->tagRefRepository->updateTagRef('product', $product->id, $data->tags??[]);
        // meta data
        $this->metadataRepository->saveMany('style-set', $styleSet->id, $data->copy([
            'custom_slug'
        ]));
        $this->styleSetItemRepository->saveStyleSetItems($styleSet->id, $this->items);
        $this->fileRefRepository->updateFileRef('style-set-featured-image', $styleSet->id, $data->featured_image?[$data->featured_image]:[]);
    }


    // get list

    public function beforeGetListData($request)
    {
        $this->repository->with('details');
    }

    /**
     * lấy thông tin sản phẩm và thuộc tính
     * @param Request $request
     * 
     * @return json
     */
    public function getProductInput(Request $request)
    {
        extract($this->apiDefaultData);
        if($itemData = $this->productRepository->getOrderInputData($request->product_id)){
            $status = true;
            $data = $this->view(
                'forms.templates.product-item', 
                array_merge($itemData, [
                    'name' => $request->name,
                    'index' => $request->index
                ])
            )->render();
        }
        
        return $this->json(compact(...$this->apiSystemVars));
    }

    

    /**
     * tim kiếm thông tin sản phẩm
     * @param Request $request
     * @return json
     */
    public function getSetTagData(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getStyleSetTagData($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }



}
