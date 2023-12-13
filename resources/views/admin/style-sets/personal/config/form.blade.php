@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', "Cấu hình Style")

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', "Menu")


@section('content')



<div class="row style-set-config">
    <div class="col-12 col-md-6 col-lg-5 col-xl-4">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__body  pt-0 pl-0 pr-0 pb-0">
        
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content style-set-config-inputs">
                        <div class="m-accordion m-accordion--bordered" id="style-config" role="tablist">
                            
                            <div class="m-accordion__item" id="style-vonfirm-form-add_new">
                                <div class="m-accordion__item-head collapsed" role="tab" id="style-config-create_head" data-toggle="collapse" href="#style-config-create_body" aria-expanded="false">
                                    {{-- <span class="m-accordion__item-icon">
                                        <i class="fa flaticon-user-ok"></i>
                                    </span> --}}
                                    <span class="m-accordion__item-title">
                                        Thiết lập khung
                                    
                                    </span>
                                    <span class="m-accordion__item-mode"></span>
                                </div>
                                
                                <div class="m-accordion__item-body collapse" id="style-config-create_body" role="tabpanel" aria-labelledby="style-config-create_head" data-parent="#m_accordion_add" style="">
                                    <div class="m-accordion__item-content">

                                        @include($_base.'forms.form', [
                                            'inputs' => $inputs,
                                            'data' => $data,
                                            'config' => [
                                                'save_button_text' => 'Lưu',
                                                'cancel_button_text' => 'Hủy',
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
                                                'action' => route('admin.style-sets.personal.config.save'),
                                                'id' => 'config-form',
                                            ]
                                        ])                              
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    
                </div>
                
            </div>
        
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Item Mẫu
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="m-portlet__body pt-0 pl-0 pr-0 pb-0">
        
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        
                        <div class="m-accordion m-accordion--bordered" id="style-item-config" role="tablist">
                            @foreach ($items as $item)
                                <!--begin::Item-->
                                <div class="m-accordion__item" id="style-vonfirm-form-{{$item->id}}">
                                    <div class="m-accordion__item-head collapsed" role="tab" id="style-item-config_{{$loop->index}}_head" data-toggle="collapse" href="#style-item-config_{{$loop->index}}_body" aria-expanded="false">
                                        <span class="m-accordion__item-title">
                                            {{$item->name}}
                                        
                                            
                                        </span>
                                        <span class="m-accordion__item-mode"></span>
                                    </div>
                                    
                                    <div class="m-accordion__item-body collapse" id="style-item-config_{{$loop->index}}_body" role="tabpanel" aria-labelledby="style-item-config_{{$loop->index}}_head" data-parent="#style-item-config" style="">
                                        <div class="m-accordion__item-content">
                                        @php
                                            $itemInp = $itemInputs;
                                            $itemInp['id'] = [
                                                'type' => 'hidden',
                                                'value' => $item->id,
                                                'id' => 'hidden-' . $item->id

                                            ];
                                        @endphp
                                        @include($_base.'forms.form', [
                                            'inputs' => $itemInp,
                                            'data' => $item->toArray(),
                                            'config' => [
                                                'button_block_type' => 2,
                                                'save_button_text' => 'Cập nhật',
                                                'cancel_button_text' => 'Xóa',
                                                'cancel_button_class' => 'danger btn-delete-item',
                                                'cancel_button_url' => route('admin.style-sets.personal.config.delete-item'),
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
                                                'class' => 'style-item-config-update-form',
                                                'data-id' => $item->id,
                                                'action' => route('admin.style-sets.personal.config.update-item'),
                                                'id' => 'update-style-item-config-form-' . $item->id,
                                            ]
                                        ])
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            
                            <div class="m-accordion__item" id="style-vonfirm-form-add_new">
                                <div class="m-accordion__item-head collapsed" role="tab" id="style-item-configcreate_head" data-toggle="collapse" href="#style-item-configcreate_body" aria-expanded="false">
                                    {{-- <span class="m-accordion__item-icon">
                                        <i class="fa flaticon-user-ok"></i>
                                    </span> --}}
                                    <span class="m-accordion__item-title">
                                        Thêm mới
                                    
                                    </span>
                                    <span class="m-accordion__item-mode"></span>
                                </div>
                                
                                <div class="m-accordion__item-body collapse" id="style-item-configcreate_body" role="tabpanel" aria-labelledby="style-item-configcreate_head" data-parent="#m_accordion_add" style="">
                                    <div class="m-accordion__item-content">
                                

                                        @include($_base.'forms.form', [
                                            'inputs' => $itemInputs,
                                            'data' => [],
                                            'config' => [
                                                'save_button_text' => 'Thêm',
                                                'cancel_button_text' => 'Hủy',
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
                                                'action' => route('admin.style-sets.personal.config.create-item'),
                                                'id' => 'create-style-item-config-form',
                                            ]
                                        ])                                        
                                    </div>
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

    <div class="col-12 col-md-6 col-lg-7 col-xl-8 ">
        
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Xem Trước
                        </h3>
                    </div>
                </div>
                
            </div>
            
            <div class="m-portlet__body">
                
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content crazy-list">
                        @php
                            $preview = crazy_arr($data);
                            $width = old('width',$preview->width(340));
                            $height = old('height',$preview->height(500));
                            $bg = $preview->avatar_url(asset('static/images/default.png'));
                        @endphp
                        <div class="style-set-config-preview" style="background-image: url('{{$bg}}'); width: {{$width}}px; height: {{$height}}px;">
                            @if ($items && count($items))
                                @foreach ($items as $item)
                                @php
                                    $arrItem = new \Gomee\Helpers\Arr($item->toArray());
                                    $itemWidth = $arrItem->get('preview_config.width', $width/2);
                                    $itemHeight = $arrItem->get('preview_config.height', $itemWidth/2);
                                    $itemTop = $arrItem->get('preview_config.top', ($height-$itemHeight)/2);
                                    $itemLeft = $arrItem->get('preview_config.left', ($width-$itemWidth)/2);
                                    
                                @endphp
                                    <div class="style-item-config" style="width: {{$itemWidth}}px; height: {{$itemHeight}}px; top: {{$itemTop}}px; left: {{$itemLeft}}px;" id="style-item-config-preview-{{$item->id}}">
                                        <div class="name">{{$item->name}}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::Section-->

                    
                
            </div>
        
            <!--end::Form-->
        </div>
        
        
    </div>


</div>


@endsection

<?php
add_js_src('static/features/style-config/script.js');
add_css_link('static/features/style-config/style.min.css');

?>