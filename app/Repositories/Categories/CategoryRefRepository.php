<?php

namespace App\Repositories\Categories;

use Gomee\Repositories\BaseRepository;

/**
 * danh sách method
 * @method $this select(...$columns) thêm các cột cần select
 * @method $this selectRaw($string) select dạng nguyen bản
 * @method $this from($table) 
 * @method $this fromRaw($string)
 * @method $this join(string $table, string $tableColumn, string $operator = '=', string $leftTableColumn) join vs 1 bang khac
 * @method $this leftJoin($table, $tableColumn, $operator, $leftTableColumn)
 * @method $this crossJoin($_ = null)
 * @method $this where($_ = null)
 * @method $this whereRaw($_ = null)
 * @method $this whereIn($column, $values = [])
 * @method $this whereNotIn($column, $values = [])
 * @method $this whereBetween($column, $values = [])
 * @method $this whereNotBetween($column, $values = [])
 * @method $this whereDay($_ = null)
 * @method $this whereMonth($_ = null)
 * @method $this whereYear($_ = null)
 * @method $this whereDate($_ = null)
 * @method $this whereTime($_ = null)
 * @method $this whereColumn($_ = null)
 * @method $this orWhere($_ = null)
 * @method $this orWhereRaw($_ = null)
 * @method $this orWhereIn($column, $values = [])
 * @method $this orWhereNotIn($column, $values = [])
 * @method $this orWhereBetween($column, $values = [])
 * @method $this orWhereNotBetween($column, $values = [])
 * @method $this orWhereDay($_ = null)
 * @method $this orWhereMonth($_ = null)
 * @method $this orWhereYear($_ = null)
 * @method $this orWhereDate($_ = null)
 * @method $this orWhereTime($_ = null)
 * @method $this orWhereColumn($leftColumn, $operator = '=', $rightColumn)
 * @method $this groupBy($column)
 * @method $this having($_ = null)
 * @method $this havingRaw($_ = null)
 * @method $this orderBy($_ = null)
 * @method $this orderByRaw($_ = null)
 * @method $this skip($_ = null)
 * @method $this take($_ = null)
 * @method $this with($_ = null)
 * @method $this withCount($_ = null)
 * @method $this load($_ = null)
 */

class CategoryRefRepository extends BaseRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\CategoryRef::class;
    }


    /**
     * lấy các category của một ref nào đó
     * @param string $ref
     * @param int $ref_id
     * @return array
     */
    public function getCategoryRefs($ref = 'link', $ref_id = 0)
    {
        $data = [];
        if($ref_id && $categories = $this->get(compact('ref', 'ref_id'))){
            foreach ($categories as $category) {
                $data[] = $category->category_id;
            }
        }
        return $data;
    }
    
    /**
     * cập nhật danh sách category
     * @param string $ref
     * @param int $ref_id
     * @param array $category_id_list
     * @return void
     */
    public function updateCategoryRef(string $ref = 'link', int $ref_id, array $category_id_list = [])
    {

        $ignore = [];
        $addedData = [];
        if(count($categoris = $this->get(compact('ref', 'ref_id')))){
            foreach ($categoris as $category) {
                // nếu category nằm trong số id them thì bỏ qua
                if(!in_array($category->category_id, $category_id_list)) $category->delete();
                // nếu ko thì xóa
                else $ignore[] = $category->category_id;
            }
        }
        if(count($category_id_list)){
            foreach ($category_id_list as $category_id) {
                if($category_id &&!in_array($category_id, $ignore)){
                    // nếu ko nằm trong danh sách bỏ qua thì ta thêm mới
                    $addedData[] = $this->save(compact('ref','ref_id', 'category_id'));
                }
            }
        }
        return $addedData;
    }

}