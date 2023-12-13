@php
    $inputList = [];
    
    $inputList['id'] = [
        'type' => 'hidden',
        'namespace' => 'hidden_id'
    ];
    foreach ($itemInputs as $name => $inpCfg) {
        $a = $inpCfg;
        $a['id'] = 'style-template-item-input-' . $name . '-' . $templateItem->template_item_config_id;
        $inputList[$name] = $a;
    }

@endphp

    <div class="m-accordion__item" id="style-template-item-{{$templateItem->template_item_config_id}}-{{$templateItem->id}}-update">
        <div class="m-accordion__item-head collapsed" role="tab" id="style-template-items_{{$templateItem->template_item_config_id}}-{{$templateItem->id}}_list-update_head" data-toggle="collapse" href="#style-template-items_{{$templateItem->template_item_config_id}}-{{$templateItem->id}}_list-update_body" aria-expanded="false">
            <span class="m-accordion__item-title">
                <div class="thumbnails">
                    <img src="{{$templateItem->front_image_url}}" class="front-image">
                    <img src="{{$templateItem->back_image_url}}" class="back-image">
                    <span class="name">{{$templateItem->name}}</span>
                </div>
            
            </span>
            <span class="m-accordion__item-mode"></span>
        </div>
        
        <div class="m-accordion__item-body collapse" id="style-template-items_{{$templateItem->template_item_config_id}}-{{$templateItem->id}}_list-update_body" role="tabpanel" aria-labelledby="style-template-items_{{$templateItem->template_item_config_id}}-{{$templateItem->id}}_list-update_head" data-parent="#style-template-items_{{$templateItem->template_item_config_id}}-{{$templateItem->id}}_list">
            <div class="m-accordion__item-content">
                @php
                    $tiData = $templateItem->toFormData();
                    $inputList['tags']['data'] = get_input_tag_data('PS-TEMP-ITEM', $templateItem->id, ['id' => $tiData['tags']]);
                    $inputList['id'] = [
                        'type' => 'hidden',
                        'namespace' => 'hidden_id',
                        'value' => $templateItem->id
                    ];
                    
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
                        'id' => 'template-item-update-form-' .$templateItem->template_item_config_id . '-'. $templateItem->id,
                        'class' => 'template-item-update-form',
                        'data-item-id' =>  $templateItem->id,
                        'data-config-id' =>  $templateItem->template_item_config_id,
                        
                    ]
                ])                              
            </div>
        </div>
    </div>