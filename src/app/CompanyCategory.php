<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $company_id
 * @property integer $category_id
 */
class CompanyCategory extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'category_id'];


    /**
     * カテゴリを返します
     *
     * @return void
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * 配列でカテゴリ名を返します
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        $category = $this->category;
        return isset($category) && isset($category->category_name) ? $category->category_name  : '';
    }

    /**
     * 特定の企業のカテゴリ名を返します
     *
     * @return string
     */
    static function getCategory($id)
    {
        return CompanyCategory::with(['category'])
            ->where('company_id', $id)
            ->pluck('category_id');
    }


    /**
     * 企業カテゴリ保存
     *
     * @param [type] $request
     * @return void
     */
    public static function saveCompanyCategory($companyId, $selectList)
    {
        //一旦companyIdに紐づくデータを全て削除
        CompanyCategory::where('company_id', $companyId)->delete();

        $array = [];
        foreach ($selectList as $categoryId) {
            $array[] = [
                'company_id' => $companyId,
                'category_id' => $categoryId,
            ];
        }
        //参加ユーザー保存
        CompanyCategory::insert($array);
    }
}
