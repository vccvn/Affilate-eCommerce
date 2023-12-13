<?php

namespace App\Http\Controllers\Clients;

# use App\Http\Controllers\Clients\ClientController;

use App\Masks\StyleSets\Personal\StyleSetCollection;
use App\Repositories\Products\ProductRepository;
use App\Repositories\StyleSets\Personal\ItemConfigRepository;
use App\Repositories\StyleSets\Personal\StyleSetItemRepository;
use Illuminate\Http\Request;
use Gomee\Helpers\Arr;

use App\Repositories\StyleSets\Personal\StyleSetRepository;
use App\Repositories\StyleSets\Personal\TemplateItemConfigRepository;
use App\Repositories\StyleSets\Personal\TemplateItemRepository;
use App\Repositories\StyleSets\Personal\TemplateRepository;
use Gomee\Engines\Helper;
use Illuminate\Support\Facades\DB;

/**
 * @property-read ItemConfigRepository $itemConfigRepository
 * @property-read TemplateItemConfigRepository $templateItemConfigRepository
 * @property-read TemplateItemRepository $templateItemRepository
 * @property-read TemplateRepository $templateRepository
 * @property-read StyleSetItemRepository $styleSetItemRepository
 * @property-read ProductRepository $productRepository
 */
class PersonalStyleSetController extends ClientController
{
    protected $module = 'style-sets';

    protected $moduleName = 'Style Cá Nhân';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var StyleSetRepository
     */
    public $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        StyleSetRepository $repository,
        TemplateRepository $templateRepository,
        TemplateItemRepository $templateItemRepository,
        ItemConfigRepository $styleItemConfigRepository,
        TemplateItemConfigRepository $templateItemConfigRepository,
        StyleSetItemRepository $styleSetItemRepository,
        ProductRepository $productRepository
    ) {
        $this->repository = $repository->mode('mask');
        $this->styleSetItemRepository = $styleSetItemRepository->mode('mask');
        $this->templateRepository = $templateRepository->mode('mask');
        $this->templateItemRepository = $templateItemRepository->mode('mask');
        $this->itemConfigRepository = $styleItemConfigRepository->mode('mask');
        $this->templateItemConfigRepository = $templateItemConfigRepository->mode('mask');
        $this->productRepository = $productRepository->mode('mask');
        $this->init();
    }

    public function viewMyStyleList(Request $request)
    {
        $args = [];

        if ($user = $request->user()) {
            $args['user_id'] = $user->id;
            $args['type'] = ['', 'user'];
        } elseif ($local_style_list = $request->cookie('style_set_list')) {
            $ids = explode('|', trim($local_style_list));
            if (count($ids)) {
                $args['id'] = $ids;
                $args['type'] = 'client';
            }
        }
        if ($args) {
            $styleSets = $this->repository->getResults($request, $args);
        } else {
            $styleSets = new StyleSetCollection([], 0);
        }

        return $this->viewModule('list', [
            'styleSets' => $styleSets
        ]);
    }


    public function getStyleDetail(Request $request, $id = null)
    {
        $id = $id ? $id : $request->id;
        if (!$id) abort(404);
        $args = [
            'id' => $id
        ];

        if ($user = $request->user()) {
            $args['user_id'] = $user->id;
            $args['type'] = ['', 'user'];
        } elseif ($local_style_list = $request->cookie('style_set_list')) {
            $ids = explode('|', trim($local_style_list));
            if (!$ids || !in_array($id, $ids)) abort(404);
            $args['user_id'] = 0;
            $args['type'] = 'client';
        } else abort(404);
        if (!($style = $this->repository->detail($args))) abort(404);
        $products = Helper::getSetComboProducts($style);
        if (!count($products)) return redirect()->route('client.style-sets.update', ['id' => $style->id]);
        return $this->viewModule('detail', [
            'style' => $style,
            'products' => $products
        ]);
    }


    public function getSuggestProducts(Request $request)
    {
        if (!$request->id || !($style = $this->repository->detail($request->id))) {
            abort(404);
        }
        $i = 0;
        $product_parameters = $style->product_parameters;
        $products = [];

        if ($product_parameters) {
            if ($request->tab && array_key_exists($request->tab, $product_parameters)) {
                $tab = $request->tab;
            } else {
                $tab = array_key_first($product_parameters);
            }
            $products = $this->productRepository->paginate(12)->getResults($request, [
                '@with' => ['promoAvailable'],
                '@styleConditions' => $product_parameters[$tab],
                '@withOption' => true,
                '@withGallery' => true,
                '@withCategory' => true,
                '@sorttype' => 1
            ]);
        } else {
            $tab = 0;
        }

        return $this->viewModule('suggest', [
            'style' => $style,
            'products' => $products,
            'tab' => $tab,
            'page_title' => $style->name,
            'product_parameters' => $product_parameters
        ]);
    }

    public function viewCreateForm(Request $request)
    {
        if (!count($templateList = $this->templateRepository->getListWithAttributes()))
            return redirect()->route('client.alert')->with('message', 'Hệ thống chưa có style mẫu');
        $templateDetail = $templateList[0];

        if (!$templateDetail) return redirect()->route('client.alert')->with('message', 'Hệ thống chưa có style mẫu');
        $style = null;
        $styleItems = [];
        return $this->viewModule('form', [
            'templateDetail' => $templateDetail,
            'templateList' => $templateList,
            'action' => 'create',
            'style' => $style,
            'styleItems' => $styleItems
        ]);
    }

    public function viewUpdateForm(Request $request, $id = null)
    {
        $id = $id ? $id : $request->id;
        if (!$id) abort(404);
        $args = [
            'id' => $id
        ];

        if ($user = $request->user()) {
            $args['user_id'] = $user->id;
            $args['type'] = ['', 'user'];
        } elseif ($local_style_list = $request->cookie('style_set_list')) {
            $ids = explode('|', trim($local_style_list));
            if (!$ids || !in_array($id, $ids)) abort(404);
            $args['user_id'] = 0;
            $args['type'] = 'client';
        } else abort(404);
        if (!($style = $this->repository->detail($args))) abort(404);
        if (!count($templateList = $this->templateRepository->getListWithAttributes()))
            return redirect()->route('client.alert')->with('message', 'Hệ thống chưa có style mẫu');

        $templateDetail = $templateList->getItem(['id' => $style->template_id]);
        if (!$templateDetail)
            return redirect()->route('client.alert')->with('message', 'Hệ thống chưa có style mẫu');

        $templateList = $this->templateRepository->getData([]);
        $styleItems = $this->styleSetItemRepository->getItemTemplateIDs($style->id);
        return $this->viewModule('form', [
            'templateDetail' => $templateDetail,
            'templateList' => $templateList,
            'action' => 'update',
            'style' => $style,
            'styleItems' => $styleItems
        ]);
    }


    public function saveStyle(Request $request)
    {
        $data = $this->repository->validate($request);
        $style = null;
        $user = null;
        if (!$request->id) {
            if ($u = $request->user()) {
                $user = $u;
                $data['user_id'] = $user->id;
                $data['type'] = 'user';
            } else {
                $data['type'] = 'client';
            }
        } elseif ($set = $this->repository->find($request->id)) {
            $style = $set;
        } else {
            abort(404);
        }

        if ($file = $this->uploadImage($request, 'thumbnail', null, get_content_path('style-sets'))) {
            $data['thumbnail_image'] = $file->filename;
        }
        if ($style) {
            $data['set_data'] = array_merge($style->getSetData(), ['attr_values' => $request->attrs ?? []]);
        } else {
            $data['set_data'] = ['attr_values' => $request->attrs ?? []];
        }

        $data['set_data'] = array_merge($data['set_data'], array_copy($data, 'weight', 'height', 'body_shape_id'));


        if (!($styleSet = $this->repository->save($data, $request->id)) || !($this->styleSetItemRepository->updateItems($styleSet->id, $request->items))) return redirect()->back()->withInput()->with('error', 'Lỗi không xác định')->with('error_message', 'Lỗi không xác định');
        if (count($products = Helper::getSetComboProducts($styleSet)))
            $redirect = redirect()->route('client.style-sets.detail', ['id' => $styleSet->id])->with('success_message', ($request->id && $request->id == $styleSet->id ? 'Cập nhật' : 'Tạo ') . ' style ' . $styleSet->name . ' thành công');
        else
            $redirect = redirect()->route('client.style-sets.update', ['id' => $styleSet->id])->with('success_message', ($request->id && $request->id == $styleSet->id ? 'Cập nhật' : 'Tạo ') . ' style ' . $styleSet->name . ' thành công');
        if (!$user) {
            $list = [];
            if ($local_style_list = $request->cookie('style_set_list')) {
                $list = explode('|', trim($local_style_list));
            }
            if (!in_array($styleSet->id, $list)) {
                $list[] = $styleSet->id;
                $redirect->withCookie(cookie('style_set_list', implode('|', $list), 365 * 24 * 60));
            }
        }

        return $redirect;
    }


    public function saveAjaxStyle(Request $request)
    {
        extract($this->apiDefaultData);
        $validator = $this->repository->validator($request);

        if (!$validator->success()) {
            $errors = $validator->errors();
            $message = 'Lỗi thiếu thông tin style';
        } else {

            $data = $validator->inputs();
            $style = null;
            $user = null;

            if (!$request->id) {
                if ($u = $request->user()) {
                    $user = $u;
                    $data['user_id'] = $user->id;
                    $data['type'] = 'user';
                } else {
                    $data['type'] = 'client';
                }
            } elseif ($set = $this->repository->find($request->id)) {
                $style = $set;
            } else {
                $message = 'Style Không tồn tại';
                return $this->json(compact(...$this->apiSystemVars));
            }

            if ($file = $this->uploadImage($request, 'thumbnail', null, get_content_path('style-sets'))) {
                $data['thumbnail_image'] = $file->filename;
            } elseif ($validator->sample && $validator->sample->thumbnail_image && file_exists($f = public_path(get_content_path('style-sets/' . $validator->sample->thumbnail_image)))) {
                $fname = uniqid() . '-' . $validator->sample->thumbnail_image;
                $p = public_path(content_path('style-sets/' . $fname));
                if (file_exists($p)) {
                    $data['thumbnail_image'] = $fname;
                }
            }
            if ($style) {
                $data['set_data'] = array_merge($style->getSetData(), ['attr_values' => $request->attrs ?? []]);
            } else {
                $data['set_data'] = ['attr_values' => $request->attrs ?? []];
            }
            $data['set_data'] = array_merge($data['set_data'], array_copy($data, 'weight', 'height', 'body_shape_id'));

            $items = $validator->sample ? $validator->sample->getTemplateItemIDs() : ($request->items ?? []);

            if (
                !($styleSet = $this->repository->save($data, $request->id)) ||
                !($this->styleSetItemRepository->updateItems($styleSet->id, $items))
            ) {
                $message = 'Lỗi không xác định';
                return $this->json(compact(...$this->apiSystemVars));
            }
            // $redirect = redirect()->)->with('success_message', ($request->id && $request->id == $styleSet->id ? 'Cập nhật' : 'Tạo ') . ' style ' . $styleSet->name . ' thành công');
            $status = true;
            $data = [
                'style' => $styleSet,
                'redirect' => route('client.style-sets.update', ['id' => $styleSet->id])
            ];
            if (!$user) {
                $list = [];
                if ($local_style_list = $request->cookie('style_set_list')) {
                    $list = explode('|', trim($local_style_list));
                }
                if (!in_array($styleSet->id, $list)) {
                    $list[] = $styleSet->id;

                    return $this->json(compact(...$this->apiSystemVars))->withCookie(cookie('style_set_list', implode('|', $list), 365 * 24 * 60));
                }
            }
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function deleteStyle(Request $request, $id = null)
    {
        extract($this->apiDefaultData);
        $id = $id ? $id : $request->id;
        if (!$id) {
            $message = 'Không có thông tin Style';
        } else {
            $args = [
                'id' => $id
            ];
            if ($user = $request->user()) {
                $args['user_id'] = $user->id;
                $args['type'] = ['', 'user'];
            } elseif ($local_style_list = $request->cookie('style_set_list')) {
                $ids = explode('|', trim($local_style_list));
                if (!$ids || !in_array($id, $ids)) {
                    $message = 'Không tìm thấy style';
                } else {
                    $args['user_id'] = 0;
                    $args['type'] = 'client';
                }
            } else $message = 'Không tìm thấy style';

            if (count($args) > 1) {
                if (!($style = $this->repository->first($args))) {
                    $message = 'Không tìm thấy style';
                } else {
                    $style->delete();
                    $status = true;
                    $message = 'Xóa Style Thành công';
                }
            }
        }
        return $this->json(compact($this->apiSystemVars));
    }



    public function getStyleTemplates(Request $request)
    {
        extract($this->apiDefaultData);

        if (!count($list = $this->templateRepository->getData())) {
            $message = 'Không có style mẫu';
        } else {
            $status = true;
            $data = $list;
        }

        return $this->json(compact($this->apiSystemVars));
    }

    public function getStyleTemplateDetail(Request $request, $id = null)
    {
        extract($this->apiDefaultData);

        if (!$id) $id = $request->id;

        return $this->json(compact($this->apiSystemVars));
    }
}
