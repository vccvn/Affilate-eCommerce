<?php 
$request = request();

$keyword = $request->search; 
$per_page = $request->per_page; 

$searchby = $request->searchby; 
$orderby = $request->orderby; 
$sorttype = $request->sorttype; 
$sort_list = ['' => 'Kiểu sắp xếp', 'ASC'=>'Tăng dần','DESC'=>'Giảm dần'];

if($sorttype && strtolower($sorttype)!='desc'){
    $sorttype = 'ASC';
}
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];

// tim kiem
if(!isset($searchable)){
    $searchable = [];
}elseif(!is_array($searchable)){
    $searchable = explode(',', str_replace(' ','',$searchable));
}

$searchable = array_merge(['' => 'Tìm theo...'], $searchable);

// sap xep
if(!isset($sortable)){
    $sortable = [];
}elseif(!is_array($sortable)){
    $sortable = explode(',', str_replace(' ','',$sortable));
}

$sortable = array_merge(['' => 'Sắp xếp theo...'], $sortable);


// them css

add_custom_css('.filter-block .filter-form div[class*="col-"]', [
    'margin-bottom' => '15px'
]);


?>

        <div class="filter-block align-middle d-block d-md-none d-xl-block">
            <form action="" method="get" class="filter-form">
                <div class="form-group row mb-0">
                    <div class="col-sm-6 col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control " name="search" value="<?php echo e($keyword); ?>" placeholder="Nhập từ khóa">
                            
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="searchby" id="searchby" class="form-control">
                            <?php $__currentLoopData = $searchable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(is_numeric($key)){
                                    $v = $val;
                                }else{
                                    $v = $key;
                                }
                            ?>
                            <option value="<?php echo e($v); ?>" <?php echo e(strtolower($searchby) == strtolower($v) ? 'selected':''); ?>><?php echo e($val); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="orderby" id="orderby" class="form-control">
                            <?php $__currentLoopData = $sortable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(is_numeric($key)){
                                    $v = $val;
                                }else{
                                    $v = $key;
                                }
                            ?>
                            <option value="<?php echo e($v); ?>" <?php echo e(strtolower($orderby) == strtolower($v) ? 'selected':''); ?>><?php echo e($val); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="sorttype" id="sortype" class="form-control">
                            <?php $__currentLoopData = $sort_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $vl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k); ?>" <?php echo e(strtoupper($sorttype) == $k ? 'selected':''); ?>><?php echo e($vl); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="per_page" id="per_page" class="form-control">
                            <?php $__currentLoopData = $per_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e($val == $per_page ? 'selected':''); ?>><?php echo e($text); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                
                    </div>
                   <div class="col-12 col-sm-6 col-md-1">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> <span class="d-md-none">Tìm kiếm</span> </button>
                    </div>
                </div>
            </form>
        </div>
    

        <div class="filter-block align-middle d-none d-md-block d-xl-none">
            <form action="" method="get" class="filter-form">
                <div class="form-group row mb-0">
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control " name="search" value="<?php echo e($keyword); ?>" placeholder="Nhập từ khóa">
                            
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select name="searchby" id="searchby" class="form-control">
                            <?php $__currentLoopData = $searchable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(is_numeric($key)){
                                    $v = $val;
                                }else{
                                    $v = $key;
                                }
                            ?>
                            <option value="<?php echo e($v); ?>" <?php echo e(strtolower($searchby) == strtolower($v) ? 'selected':''); ?>><?php echo e($val); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-1">

                        <div>
                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow filter-menu-dropdown m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                    <i class="la la-plus m--hide"></i>
                                    <i class="la la-ellipsis-h"></i>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <div class="form-group">
                                                    <div>
                                                        <label for="orderby-2">Sắp xếp theo</label>
    
                                                    </div>
                                                    <div>
                                                        <select name="orderby" id="orderby-2" class="form-control">
                                                            <?php $__currentLoopData = $sortable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                if(is_numeric($key)){
                                                                    $v = $val;
                                                                }else{
                                                                    $v = $key;
                                                                }
                                                            ?>
                                                            <option value="<?php echo e($v); ?>" <?php echo e(strtolower($orderby) == strtolower($v) ? 'selected':''); ?>><?php echo e($val); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div>
                                                        <label for="orderby-2">Kiểu sắp xếp </label>
    
                                                    </div>
                                                    <div>
                                                        <select name="sorttype" id="sortype-" class="form-control">
                                                            <?php $__currentLoopData = $sort_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $vl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($k); ?>" <?php echo e(strtoupper($sorttype) == $k ? 'selected':''); ?>><?php echo e($vl); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div>
                                                        <label for="orderby-2">Kết quả trên trang</label>
    
                                                    </div>
                                                    <div>
                                                        <select name="per_page" id="per_page" class="form-control">
                                                            <?php $__currentLoopData = $per_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($val); ?>" <?php echo e($val == $per_page ? 'selected':''); ?>><?php echo e($text); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="col-12 col-sm-6 col-md-2">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> <span class="d-md-none">Tìm kiếm</span> </button>
                    </div>
                </div>
            </form>
        </div>
    

<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/_templates/list-filter.blade.php ENDPATH**/ ?>