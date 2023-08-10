<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $matching_id
 * @property integer $category_id
 */
class MatchingCategory extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['matching_id', 'category_id'];

    #region リレーション
    /**
     * カテゴリ
     *
     * @return Category
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * マッチング
     *
     * @return matching
     */
    public function matching()
    {
        return $this->hasOne(Matching::class, 'id', 'matching_id');
    }
    #endregion

    #region get-attribute
    /**
     * カテゴリ名を返します
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return isset($this->category) ? $this->category->category_name : '';
    }
    #endregion

    #region staticメソッド

    public static function saveMatchingCategory($matchingId, $categories)
    {
        MatchingCategory::where('matching_id', $matchingId)->delete();
        $insertData = [];
        foreach ($categories as $category) {
            $insertData[] = [
                'matching_id' => $matchingId,
                'category_id' => $category
            ];
        }
        MatchingCategory::insert($insertData);
    }
    #endregion
}
