<?php
use Crazy\Html\Input;
use Crazy\Helpers\Arr;


add_tinymce_assets();

$input->addClass("tiny-mce");
$input->type="textarea";

?>





<div id="<?php echo $input->id.'-tabs'; ?>" class="tiny-mce-wrapper">
    <ul class="nav nav-tabs justify-content-end" role="tablist">
        <li class="nav-item m-tabs__item mr-auto">
            <a class="btn btn-sm btn-secondary btn-insert-gallery" href="javascript:void(0)">
                <i class="fa fa-images mr-3"></i>
                    Thư viện
            </a>
        </li>
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#editor_tab" role="tab">
                <i class="fa fa-file-word d-none d-md-inline"></i>
                Văn bản
            </a>
        </li>

        
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link" data-toggle="tab" href="#code_tab" role="tab">
                <i class="fa fa-code d-none d-md-inline"></i> 
                Code
            </a>
        </li>
            
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="editor_tab" role="tabpanel">
                
            <?php echo $input; ?>

        </div>
        <div class="tab-pane" id="code_tab" role="tabpanel">
            
        </div>
    </div>
</div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/tinymce.blade.php ENDPATH**/ ?>