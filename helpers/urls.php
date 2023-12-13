<?php

use Illuminate\Support\Facades\URL;
if(!function_exists('hasEmptyPathInUri')){
    function hasEmptyPathInUri(){
        $url = url('');
        $request = request();
        $url2 = str_replace('https://', 'http://', $url);
        
        $uri = str_replace($url, '', isset($_SERVER) && isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']: str_replace('https://', 'http://', URL::full()));

        $uri = str_replace($url2, '', $uri);
        if($uri){
            $uri = preg_replace('/^\//i', '', $uri);
            $s = explode('?', $uri);
            
            $cleanUri = implode('/', array_filter(explode('/', $raw = array_shift($s)), function($v){
                return strlen($v) > 0;
            }));
            $pi = preg_replace('/^\//i', '', $request->getPathInfo());
            if($raw != $cleanUri || $cleanUri != $pi){
                $redir = url($cleanUri);
                if(count($s)){
                    $redir.='?'. implode('?', $s);
                }
                return $redir;
            }
    
        }
        return false;
        
    }
}

if(!function_exists('get_root_path')){
    function get_root_path($f = null){
        $path = env('HOSTING_MANAGER_PATH', '/var/www/html/users') . ($f ? '/' . $f : '');
        return $path;
    }
}

if(!function_exists('get_content_path')){
    /**
     * lay path chua id bi mat cua user
     *
     * @param string $f
     * @return string
     */
    function get_content_path($f = null, $ownor_id = 0){
        $path = env('STATIC_CONTENT_PATH', 'static/contents'). ($f ? '/' . ltrim($f, '/') : '');
        return $path;
    }
}

if(!function_exists('content_path')){
    /**
     * lay path chua id bi mat cua user
     *
     * @param string $f
     * @return string
     */
    function content_path($f = null, $ownor_id = 0){
        $path = env('STATIC_CONTENT_PATH', 'static/contents'). ($f ? '/' . ltrim($f, '/') : '');
        return $path;
    }
}



if (!function_exists('parse_query_data')) {

    /**
     * chuẩn hóa query string
     * @param string $query query or url
     * @param array $data mang cac tham so
     * @param string|array $ignore ten tham so dc bo qua
     * @return array
     */
    function parse_query_data($query = null)
    {
        $arr = [];
        if ($query && is_string($query)) {
            try {
                $a = explode('?', $query);
                if(count($a) == 2) $query = $a[1];
                parse_str($query, $d);
                if ($d) {
                    $arr = $d;
                }
            } catch (Exception $e) {
                // eo can lam gi cung dc
            }
        }
        $arr;

    }
}
if (!function_exists('parse_query_string')) {

    /**
     * chuẩn hóa query string
     * @param string $query co san
     * @param array $data mang cac tham so
     * @param string|array $ignore ten tham so dc bo qua
     * @return string
     */
    function parse_query_string($query = null, array $data = [], $ignore = null, $raw = false)
    {
        $arr = [];
        if ($query && is_string($query)) {
            try {
                parse_str($query, $d);
                if ($d) {
                    $arr = $d;
                }
            } catch (Exception $e) {
                // eo can lam gi cung dc
            }
        }

        if (is_array($data)) {
            foreach ($data as $name => $value) {
                if (!is_null($value) && (is_numeric($value) || is_string($value)) && strlen($value) > 0) {
                    $arr[$name] = $value;
                }
            }
        }
        $s = '';
        if ($arr) {
            // nếu là array
            if(is_array($ignore)){
                foreach ($arr as $n => $v) {
                    if(!in_array($n, $ignore)){
                        $s .= "$n=".($raw ? $v: urlencode($v))."&";
                    }
                }
                $s = trim($s, '&');
                return $s;
            }
            // neu la string
            if($ignore && isset($arr[$ignore])) unset($arr[$ignore]);
            foreach ($arr as $n => $v) {
                $s .= "$n=".($raw ? $v: urlencode($v))."&";
            }
            $s = trim($s, '&');
        }
        return $s;
    }
}

if(!function_exists('url_merge')){
    /**
     *
     * add quey string to url
     * @param string $url dung dan lien ket
     * @param array $name mang query hoac ten bien neu la bien don
     * @param string $val gia tri bien
     * @return string $url
     */

    function url_merge($url, $name = null, $val = null, $ignore = null, $raw = false){
        $u = $url;
        $r = [];
        $f = explode('?',$url);
        $q = '';
        $u = $f[0];
        if(count($f)>1){
            $q = $f[1];
        }
        if($name){
            if(is_string($name)) $r[$name] = $val;
            elseif(is_array($name)){
                foreach($name as $n => $v){
                    if(is_string($n)){
                        $r[$n] = $v;
                    }
                }
            }

        }
        if($q || $r){
            $u.='?'.parse_query_string($q, $r, $ignore, $raw);
        }
        return $u;
    }
}


if(!function_exists('url_relative')){
    /**
     * xóa link asset và thay bằng /
     * @param string $url đường dẫn tuyệt đối
     *
     * @return string trả về url
     */
    function url_relative(string $url) : string
    {
        // tìm các chứa địa chỉ trang chủ thay bằng /
        $search = rtrim(asset('/'), '/').'/';
        $replace = '/';
        $newUrl = str_replace($search, $replace, $url);
        return $newUrl;
    }
}




if(!function_exists('get_post_url')){
    /**
     * lấy dường dẩn url
     * @param \App\Models\Post|App\Transformers\PostTransformer|\Gomee\Helpers\Arr $post
     * @return string
     */
    function get_post_url($post)
    {
        // kiểm tra 1 vai trường hợp
        if($post->dynamic_slug) $dynamic_slug = $post->dynamic_slug;
        elseif ($dynamic = get_model_data('dynamic', $post->dynamic_id)) $dynamic_slug = $dynamic->slug;
        elseif($dynamic = get_dynamic(['dynamic_id' => $post->dynamic_id])){
            set_model_data('dynamic', $dynamic->id, $dynamic);
            $dynamic_slug = $dynamic->slug;
        }
        else{
            return null;
        }
        return route('client.posts.view', ['dynamic' => $dynamic_slug, 'post' => $post->slug]);
    }
}


if(!function_exists('get_post_category_url')){
    /**
     * lấy dường dẩn danh mục bài viết
     * @param \App\Models\Category|App\Transformers\PostCategoryTransformer|\Gomee\Helpers\Arr $category
     * @return string
     */
    function get_post_category_url($category)
    {
        // nếu ko phải là post category thì trả về null
        if($category->type != 'post') return null;
        // nếu kênh ko tồn tại
        if(!($dynamic = get_model_data('dynamic', $category->dynamic_id))) return null;
        // nếu không có danh mục cha
        $params = ['dynamic' => $dynamic->slug];
        $route = 'client.posts.categories.';
        if(!$category->parent_id || ($t = count($categories = $category->getTree())) < 2){
            $route .= 'view-simple';
            $params['slug'] = $category->slug;
        }
        // nếu chỉ có 2 level
        elseif($t == 2){
            $route .= 'view-child';
            $params['parent'] = $categories[0]->slug;
            $params['child'] = $category->slug;
        }
        // 2 level tro len
        else{
            $route .= 'view-'.$t.'-level';
            $arrParams = ['first', 'second', 'third', 'fourth'];
            for ($i=0; $i < $t; $i++) {
                $params[$arrParams[$i]] = $categories[$i]->slug;
            }
        }
        return route($route, $params);
    }
}


if(!function_exists('get_product_category_url')){
    /**
     * lấy dường dẩn danh mục bài viết
     * @param \App\Models\Category|
     * @return string
     */
    function get_product_category_url($category)
    {
        // nếu ko phải là post category thì trả về null
        if($category->type != 'product') return null;
        // nếu kênh ko tồn tại
        // nếu không có danh mục cha
        $params = [];
        $route = 'client.products.categories.';

        if(product_setting()->category_url_type == 'unique' || !$category->parent_id || ($t = count($categories = $category->getTree())) < 2){
            $route .= 'view-simple';
            $params['slug'] = $category->slug;
            // $params['id'] = $category->id;
            
        }
        // nếu chỉ có 2 level
        elseif($t == 2){
            $route .= 'view-child';
            $params['parent'] = $categories[0]->slug;
            $params['child'] = $category->slug;
            // $params['id'] = $category->id;
        }
        // 2 level tro len
        else{
            $route .= 'view-'.$t.'-level';
            $arrParams = ['first', 'second', 'third', 'fourth'];
            for ($i=0; $i < $t; $i++) {
                $params[$arrParams[$i]] = $categories[$i]->slug;
            }
            // $params['id'] = $category->id;
        }
        return route($route, $params);
    }
}


if(!function_exists('get_project_category_url')){
    /**
     * lấy dường dẩn danh mục bài viết
     * @param \App\Models\Category|
     * @return string
     */
    function get_project_category_url($category)
    {
        // nếu ko phải là post category thì trả về null
        if($category->type != 'project') return null;
        // nếu kênh ko tồn tại
        // nếu không có danh mục cha
        $params = [];
        $route = 'client.projects.categories.';
        if(!$category->parent_id || ($t = count($categories = $category->getTree())) < 2){
            $route .= 'view-simple';
            $params['slug'] = $category->slug;
        }
        // nếu chỉ có 2 level
        elseif($t == 2){
            $route .= 'view-child';
            $params['parent'] = $categories[0]->slug;
            $params['child'] = $category->slug;
        }
        // 2 level tro len
        else{
            $route .= 'view-'.$t.'-level';
            $arrParams = ['first', 'second', 'third', 'fourth'];
            for ($i=0; $i < $t; $i++) {
                $params[$arrParams[$i]] = $categories[$i]->slug;
            }
        }
        return route($route, $params);
    }
}



if(!function_exists('get_page_url')){
    /**
     * lấy dường dẩn danh mục bài viết
     * @param \App\Models\Page|App\Mask\Pages\PageMask|\Gomee\Helpers\Arr $page
     * @return string
     */
    function get_page_url($page)
    {
        // nếu ko phải là post page thì trả về null
        $params = [];
        $route = 'client.pages.';
        if(!$page->parent_id || ($t = count($pages = $page->getTree())) < 2){
            $route .= 'view-simple';
            $params['slug'] = $page->slug;
        }
        // nếu chỉ có 2 level
        elseif($t == 2){
            $route .= 'view-child';
            $params['parent'] = $pages[0]->slug;
            $params['child'] = $page->slug;
        }
        // 2 level tro len
        else{
            $route .= 'view-'.$t.'-level';
            $arrParams = ['first', 'second', 'third', 'fourth'];
            for ($i=0; $i < $t; $i++) {
                $params[$arrParams[$i]] = $pages[$i]->slug;
            }
        }
        return route($route, $params);
    }
}


if(!function_exists('get_product_url')){
    /**
     * lấy dường dẩn sản phẩm
     * @param \App\Models\Product|App\Masks\Products\ProductMask|\Gomee\Helpers\Arr
     * @return string
     */
    function get_product_url($product)
    {
        if(!$product->slug) return null;
        return route('client.products.detail', ['slug' => $product->slug]);
    }
}

if(!function_exists('get_project_url')){
    /**
     * lấy dường dẩn sản phẩm bài viết
     * @param \App\Models\Project|App\Masks\Projects\ProjectMask|\Gomee\Helpers\Arr
     * @return string
     */
    function get_project_url($project)
    {
        // nếu ko phải là post page thì trả về null
        $params = [];
        return route('client.projects.detail', ['slug' => $project->slug]);
    }
}


if(!function_exists('get_dynamic_url')){
    /**
     * lấy dường dẩn sản phẩm bài viết
     * @param \App\Models\Dynamic|App\Masks\Dynamics\DynamicMask|\Gomee\Helpers\Arr
     * @return string
     */
    function get_dynamic_url($dynamic)
    {
        // nếu ko phải là post page thì trả về null
        $params = [];
        return route('client.posts', ['dynamic' => $dynamic->slug]);
    }
}

