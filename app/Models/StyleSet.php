<?php

namespace App\Models;

use Gomee\Helpers\Arr;
use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StyleSet extends Model
{
    public $table = 'style_sets';
    public $fillable = ['category_id', 'name', 'slug', 'type', 'description', 'content', 'keywords', 'url', 'customer_id', 'created_by_id'];
    protected $_totalprice = null;
    protected $_discountprice = null;
    protected $_finalprice = null;

    /**
     * Get all of the items for the StyleSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(StyleSetItem::class, 'style_set_id');
    }

    public function details()
    {
        return $this->items()->join('products', 'products.id', '=', 'style_set_items.product_id')
            ->select(
                'style_set_items.*',
                'products.name as product_name',
                'products.slug',
                'products.type as product_type',
                'products.featured_image as product_image'
            );
    }
    /**
     * danh mục
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    /**
     * Get the featureRef associated with the StyleSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function featureRef(): HasOne
    {
        return $this->hasOne(FileRef::class, 'ref_id', 'id')->where('ref', 'style-set-featured-image');
    }


    // public $resources = [];
    /**
     * ket noi voi bang user_meta
     * @return queryBuilder
     */
    public function metadatas()
    {
        return $this->hasMany(Metadata::class, 'ref_id', 'id')->where('ref', 'style-set');
    }


    public function productRefs()
    {
        return $this->hasMany(ProductRef::class, 'ref_id', 'id')->where('ref', 'style-set');
    }


    /**
     * The products that belong to the StyleSet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'style_set_items', 'style_set_id', 'product_id')->withPivot('quantity');
    }

    public function productItems()
    {
        return $this->items()->with('product');
    }

    // public function products()
    // {
    //     return $this->items()
    //         ->join('products', 'products.id', '=', 'style_set_items.product_id')
    //         ->where('products.trashed_status', Product::UNTRASHED)
    //         ->select('style_set_items.product_id', 'style_set_items.style_set_id', 'products.*');
    // }


    public function calculatePrice()
    {

        if ($this->_totalprice === null || $this->_discountprice === null || $this->_finalprice === null) {
            $this->_totalprice = 0;
            $this->_discountprice = 0;
            $this->_finalprice = 0;
            $relations = $this->getRelations();
            if (array_key_exists('items', $relations) && $relations['items'] && count($relations['items'])) {
                foreach ($relations['items'] as $item) {
                    $product = $item->product;
                    $al = 1;
                    if ($item->quantity) {
                        $sl = $item->quantity;
                    }
                    $this->_totalprice += $product->list_price * $sl;
                    $fn = $product->getFinalPrice()  * $sl;

                    $this->_discountprice += is_numeric($fn) ? $fn : 0;
                    $this->_finalprice += is_numeric($fn) ? $fn : 0;
                }
            }
            
            elseif (array_key_exists('products', $relations) && count($this->products)) {
                foreach ($this->products as $product) {
                    $al = 1;
                    if ($product->pivot && $product->pivot->quantity) {
                        $sl = $product->pivot->quantity;
                    }
                    $this->_totalprice += $product->list_price * $sl;
                    $fn = $product->getFinalPrice()  * $sl;

                    $this->_discountprice += is_numeric($fn) ? $fn : 0;
                    $this->_finalprice += is_numeric($fn) ? $fn : 0;
                }
            }
        }
    }

    public function getTotalPriceAttribute()
    {
        $this->calculatePrice();
        return $this->_totalprice;
    }
    public function getDiscountPriceAttribute()
    {
        $this->calculatePrice();
        return $this->_discountprice;
    }
    public function getFinalPriceAttribute()
    {
        $this->calculatePrice();
        return $this->_finalprice;
    }

    public function priceFormat($price_type = 'total')
    {
        $price_type = $price_type != 'discount' ? ($price_type != 'final' ? 'total' : 'final') : 'discount';
        $price = $this->{$price_type . '_price'};
        return get_currency_format($price);
    }

    /**
     * tính giá cuối cùng (sau các loại khuyến mãi)
     * @return double
     */
    public function getDownPercent()
    {
        $price = $this->discount_price;
        // $lp = to_number($this->list_price);
        $list_price = $this->total_price > 0 ? $this->total_price : 1;
        return round(($list_price - $price) / $list_price * 100);
    }


    public function hasDiscount()
    {
        return $this->total_price - $this->discount_price > 0;
    }
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $this->applyMeta();

        $data = $this->toArray();
        $items = [];
        if (count($this->items)) {
            foreach ($this->items as $item) {
                $idata = $item->toFormData();
                $items[] = $idata;
            }
        }
        $data['items'] = $items;
        if ($this->featureRef) {
            $data['featured_image'] = $this->featureRef->file_id;
        }
        return $data;
    }

    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getFeaturedImage($urlencode = false)
    {
        if ($this->featureRef && $file = get_media_file(['id' => $this->featureRef->file_id])) {
            $url = $file->url;
        } else {
            $url = url('static/images/default.png');
        }


        if ($urlencode) return urlencode($url);
        return $url;
    }


    public function renderItems($template)
    {
        $html = '';
        if ($t = count($this->details)) {
            foreach ($this->details as $i => $detail) {
                $d = $detail->toArray();
                $d['image'] = get_product_image($this->product_image);
                $html .= str_eval($template, Arr::entities($d), 0, '');
                if($i>=2){
                    if($t > $i+1) $html .= '<div>...</div>';
                    break;
                }
                // dd($d);
            }
        }
        return $html;
    }
}
