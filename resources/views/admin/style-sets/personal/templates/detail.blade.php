@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', "Cấu hình Style $template->name")

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $template->name)


@section('content')


@php
    $itemExists = [];
    $urlOptions['new'] = 'Thêm mới';
@endphp

<div class="row style-set-template-page">
    <div class="col-12 col-md-6 col-lg-6 col-xl-5">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__body pt-0 pl-0 pr-0 pb-0">
                @include('admin.forms.templates.crazyselect', [
                    'input' => html_input([
                        'type' => 'crazyselect',
                        'name' => 'templateurl',
                        'data' => $urlOptions,
                        '@change' => 'StyleSetTemplate.changeTemplate',
                        'default' => str_replace('http://', 'https://', URL::current())
                    ])
                ])
                <div class="m-section__content crazy-list">
                    @php
                        $data = $template->toFormData();
                        $data['avatar_url'] = $template->getAvatar();
                        $preview = crazy_arr($data);
                        $width = old('width',$preview->width(340));
                        $height = old('height',$preview->height(500));
                        $bg = $preview->avatar_url(asset('static/images/default.png'));
                    @endphp
                    <div class="style-set-template-preview" style="background-image: url('{{$bg}}'); width: {{$width}}px; height: {{$height}}px;">
                        @if ($templateItemConfigs && count($templateItemConfigs))
                            @foreach ($templateItemConfigs as $item)
                            @php
                                $itemExists[] = $item->config_id;
                                $arrItem = new \Gomee\Helpers\Arr($item->toArray());
                                $itemWidth = $arrItem->get('preview_config.width');
                                $itemHeight = $arrItem->get('preview_config.height');
                                $itemTop = $arrItem->get('preview_config.top');
                                $itemLeft = $arrItem->get('preview_config.left');
                                if($itemWidth == null || $itemWidth <= 0) $itemWidth = $width/2;
                                if($itemHeight == null || $itemHeight <= 0) $itemHeight = $itemWidth;
                                if($itemTop === null) $itemTop = ($height - $itemHeight)/2;
                                if($itemLeft === null) $itemLeft = ($width - $itemWidth)/2;
                                

                            @endphp
                                <div class="style-item-config" style="width: {{$itemWidth}}px; height: {{$itemHeight}}px; top: {{$itemTop}}px; left: {{$itemLeft}}px;" id="style-item-config-preview-{{$item->id}}">
                                    <div class="name">{{$item->itemConfig->name}}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <div class="m-section__content style-set-template-inputs">
                    <div class="m-accordion m-accordion--bordered" id="style-template" role="tablist">
                        
                        <div class="m-accordion__item" id="style-vonfirm-form-add_new">
                            <div class="m-accordion__item-head collapsed" role="tab" id="style-template-create_head" data-toggle="collapse" href="#style-template-create_body" aria-expanded="false">
                                {{-- <span class="m-accordion__item-icon">
                                    <i class="fa flaticon-user-ok"></i>
                                </span> --}}
                                <span class="m-accordion__item-title">
                                    Thiết lập template
                                
                                </span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            
                            <div class="m-accordion__item-body collapse" id="style-template-create_body" role="tabpanel" aria-labelledby="style-template-create_head" data-parent="#m_accordion_add" style="">
                                <div class="m-accordion__item-content">

                                    @include($_base.'forms.form', [
                                        'inputs' => array_merge($templateInputs, [
                                            'id' => ['type' => 'hidden', 'id' => 'hidden-id']
                                        ]),
                                        'data' => $template->toFormData(),
                                        'config' => [
                                            'save_button_text' => 'Lưu',
                                            'cancel_button_text' => 'Hủy',
                                            'form_group_options' => [
                                                'group_class' => 'row',
                                                'label_class' => 'col-label col-12 col-sm-6 col-md-5 col-xl-4',
                                                'wrapper_class' => 'col-12 col-sm-6 col-md-7 col-xl-8'
                                            ],
                                        ],
                                        'attrs' => [
                                            'method' => 'post',
                                            'action' => route('admin.style-sets.personal.templates.ajax-update'),
                                            'id' => 'template-form',
                                        ]
                                    ])                              
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>

        
    <div class="col-12 col-md-6 col-lg-6 col-xl-7 ">
        
        <div class="m-portlet m-portlet--tabs">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Items
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
                        @if ($templateItemConfigs && count($templateItemConfigs))
                            @foreach ($templateItemConfigs as $item)
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link {{$loop->index == 0 ? 'active' : ''}}" data-toggle="tab" href="#template_base_item_{{$item->id}}_tab_content" role="tab">
                                        {{$item->itemConfig->name}}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="tab-content">
                    
                @if ($templateItemConfigs && count($templateItemConfigs))
                    @php
                        $itemInp = $itemConfigInputs;
                        $itemInp['template_id'] = [
                            'type' => 'hidden',
                            'value' => $template->id,
                            'id' => 'hidden-template-' . $template->id

                        ];
                        $itemInp['id'] = [
                            'type' => 'hidden'
                        ];
                        
                        $itemInp['config_id'] = [
                            'type' => 'hidden'
                        ];
            
                    @endphp
                    @foreach ($templateItemConfigs as $itemConfig)

                    <div class="tab-pane {{$loop->index == 0 ? 'active' : ''}}" id="template_base_item_{{$itemConfig->id}}_tab_content" role="tabpanel">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xxl-7">

                                <div class="item-list">

                                    <div class="m-accordion m-accordion--bordered" id="style-template-items_{{$itemConfig->id}}_list" role="tablist">
                                    @if ($itemConfig->templateItems && count($itemConfig->templateItems))
                        
                                        @php
                                            $inputList = [];
                                            
                                            $inputList['id'] = [
                                                'type' => 'hidden',
                                                'namespace' => 'hidden_id'
                                            ];
                                            foreach ($itemInputs as $name => $inpCfg) {
                                                $a = $inpCfg;
                                                $a['id'] = 'style-template-item-input-' . $name . '-' . $itemConfig->id;
                                                $inputList[$name] = $a;
                                            }

                                        @endphp
                                        @foreach ($itemConfig->templateItems as $templateItem)
                                            
                                

                                        <div class="m-accordion__item" id="style-template-item-{{$itemConfig->id}}-{{$templateItem->id}}-update">
                                            <div class="m-accordion__item-head collapsed" role="tab" id="style-template-items_{{$itemConfig->id}}-{{$templateItem->id}}_list-update_head" data-toggle="collapse" href="#style-template-items_{{$itemConfig->id}}-{{$templateItem->id}}_list-update_body" aria-expanded="false">
                                                <span class="m-accordion__item-title">
                                                    <div class="thumbnails">
                                                        <img src="{{$templateItem->front_image_url}}" class="front-image">
                                                        <img src="{{$templateItem->back_image_url}}" class="back-image">
                                                        <span class="name">{{$templateItem->name}}</span>
                                                    </div>
                                                
                                                </span>
                                                <span class="m-accordion__item-mode"></span>
                                            </div>
                                            
                                            <div class="m-accordion__item-body collapse" id="style-template-items_{{$itemConfig->id}}-{{$templateItem->id}}_list-update_body" role="tabpanel" aria-labelledby="style-template-items_{{$itemConfig->id}}-{{$templateItem->id}}_list-update_head" data-parent="#style-template-items_{{$itemConfig->id}}-{{$templateItem->id}}_list">
                                                <div class="m-accordion__item-content">
                                                    @php
                                                        $tiData = $templateItem->toFormData();
                                                        $inputList['id']['value'] = $templateItem->id;
                                                        $inputList['tags']['data'] = get_input_tag_data('PS-TEMP-ITEM', $templateItem->id, ['id' => $tiData['tags']]);
                                                    @endphp
                                                    @include($_base.'forms.form', [
                                                        'inputs' => $inputList,
                                                        'data' => $tiData,
                                                        'config' => [
                                                            'button_block_type' => 2,
                                                            'save_button_text' => 'Cập nhật',
                                                            'cancel_button_text' => "Xóa",
                                                            'cancel_button_class' => "danger btn-delete-template-item",
                                                            'form_group_options' => [
                                                                'group_class' => '',
                                                                'label_class' => '',
                                                                'wrapper_class' => ''
                                                            ],
                                                        ],
                                                        'attrs' => [
                                                            'method' => 'post',
                                                            'action' => route('admin.style-sets.personal.templates.update-item'),
                                                            'id' => 'template-item-update-form-' .$itemConfig->id . '-'. $templateItem->id,
                                                            'class' => 'template-item-update-form',
                                                            'data-item-id' =>  $templateItem->id,
                                                            'data-config-id' =>  $itemConfig->id,
                                                            
                                                        ]
                                                    ])                              
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    @endif
                                    </div>
    
                                </div>

                                <div class="m-accordion m-accordion--bordered" id="style-template-items_{{$itemConfig->id}}" role="tablist">
                        


                                    <div class="m-accordion__item" id="style-confirm-form-add_new">
                                        <div class="m-accordion__item-head collapsed" role="tab" id="style-template-items_{{$itemConfig->id}}-create_head" data-toggle="collapse" href="#style-template-items_{{$itemConfig->id}}-create_body" aria-expanded="false">
                                            <span class="m-accordion__item-title">
                                                Thêm Item
                                            
                                            </span>
                                            <span class="m-accordion__item-mode"></span>
                                        </div>
                                        
                                        <div class="m-accordion__item-body collapse" id="style-template-items_{{$itemConfig->id}}-create_body" role="tabpanel" aria-labelledby="style-template-items_{{$itemConfig->id}}-create_head" data-parent="#style-template-items_{{$itemConfig->id}}" style="">
                                            <div class="m-accordion__item-content">
            
                                                @include($_base.'forms.form', [
                                                    'inputs' => array_merge($itemInputs, [
                                                        // 'id' => ['type' => 'hidden', 'id' => 'hidden-id']
                                                    ]),
                                                    'data' => ['template_item_config_id' => $itemConfig->id],
                                                    'config' => [
                                                        'save_button_text' => 'Thêm Mới',
                                                        'hide_cancel_button' => true,
                                                        'form_group_options' => [
                                                            'group_class' => '',
                                                            'label_class' => '',
                                                            'wrapper_class' => ''
                                                        ],
                                                    ],
                                                    'attrs' => [
                                                        'method' => 'post',
                                                        'action' => route('admin.style-sets.personal.templates.create-item'),
                                                        'id' => 'template-item-create-form-' .$itemConfig->id,
                                                        'class' => 'template-item-create-form',
                                                        'data-config-id' =>  $itemConfig->id,
                                                    ]
                                                ])                              
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-12 col-lg-12 col-xxl-5">
                                @php
                                    foreach ($itemConfigInputs as $name => $inp) {
                                        $itemInp[$name]['id'] = $name .'-item-config-'.$itemConfig->id;
                                    }
                                    
                                @endphp
                                @include($_base.'forms.form', [
                                    'inputs' => $itemInp,
                                    'data' => $itemConfig->toFormData(),
                                    'config' => [
                                        'button_block_type' => 1,
                                        'save_button_text' => 'Cập nhật',
                                        'hide_cancel_button' => true,
                                        // 'cancel_button_class' => 'danger btn-delete-item',
                                        // 'cancel_button_url' => route('admin.style-sets.personal.templates.delete-item'),
                                        'form_group_options' => [
                                            'group_class' => '',
                                            'label_class' => '',
                                            'wrapper_class' => ''
                                        ],
                                        'form_group_style' => 'custom',
                                        'log_style' => true,
                                    ],
                                    'attrs' => [
                                        'method' => 'post',
                                        'class' => 'style-template-item-config-update-form',
                                        'data-id' => $itemConfig->id,
                                        'action' => route('admin.style-sets.personal.templates.update-item-config'),
                                        'id' => 'style-template-item-config-update-form-' . $itemConfig->id,
                                    ]
                                ])
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
                

                </div>
            </div>
        </div>
        
        @if (count($itemExists) < count($styleItemConfigs))
        
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Thêm cấu hình Item
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="m-portlet__body pt-0 pl-0 pr-0 pb-0">
        
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        
                        <div class="m-accordion m-accordion--bordered" id="style-template-item-config" role="tablist">
                            @foreach ($styleItemConfigs as $styleItemConfig)
                                @if (in_array($styleItemConfig->id, $itemExists))
                                    @continue
                                @endif
                                @php
                                    $itemInp['config_id'] = [
                                        'type' => 'hidden',
                                        'value' => $styleItemConfig->id
                                    ];
                        
                                @endphp
                                <!--begin::Item-->
                                <div class="m-accordion__item" id="style-confirm-form-{{$styleItemConfig->id}}">
                                    <div class="m-accordion__item-head collapsed" role="tab" id="style-template-item-config_{{$loop->index}}_head" data-toggle="collapse" href="#style-template-item-config_{{$loop->index}}_body" aria-expanded="false">
                                        <span class="m-accordion__item-title">
                                            {{$styleItemConfig->name}}
                                        
                                            
                                        </span>
                                        <span class="m-accordion__item-mode"></span>
                                    </div>
                                    
                                    <div class="m-accordion__item-body collapse" id="style-template-item-config_{{$loop->index}}_body" role="tabpanel" aria-labelledby="style-template-item-config_{{$loop->index}}_head" data-parent="#style-template-item-config" style="">
                                        <div class="m-accordion__item-content">
                                        @php
                                            $itemInp = $itemConfigInputs;
                                            $itemInp['config_id'] = [
                                                'type' => 'hidden',
                                                'value' => $styleItemConfig->id,
                                                'id' => 'hidden-config' . $styleItemConfig->id

                                            ];
                                            $itemInp['template_id'] = [
                                                'type' => 'hidden',
                                                'value' => $template->id,
                                                'id' => 'hidden-template-' . $template->id

                                            ];

                                            
                                        @endphp
                                        @include($_base.'forms.form', [
                                            'inputs' => $itemInp,
                                            'data' => $styleItemConfig->toArray(),
                                            'config' => [
                                                'button_block_type' => 1,
                                                'save_button_text' => 'Thêm',
                                                'hide_cancel_button' => true,
                                                // 'cancel_button_class' => 'danger btn-delete-item',
                                                // 'cancel_button_url' => route('admin.style-sets.personal.templates.delete-item'),
                                                'form_group_options' => [
                                                    'group_class' => '',
                                                    'label_class' => '',
                                                    'wrapper_class' => ''
                                                ],
                                                'form_group_style' => 'custom',
                                                'log_style' => true,
                                            ],
                                            'attrs' => [
                                                'method' => 'post',
                                                'class' => 'style-template-item-config-create-form',
                                                'data-id' => $styleItemConfig->id,
                                                'action' => route('admin.style-sets.personal.templates.create-item-config'),
                                                'id' => 'style-template-item-config-create-form-' . $styleItemConfig->id,
                                            ]
                                        ])
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
        @endif
    </div>

    

</div>
@include('admin._templates.style-set-template-form-modal')

@endsection

<?php
add_js_src('static/features/style-template/script.js');
add_css_link('static/features/style-template/style.min.css');

?>