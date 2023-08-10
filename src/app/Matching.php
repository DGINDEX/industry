<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @property integer $id
 * @property integer $company_id
 * @property integer $category_id
 * @property string $project_name
 * @property string $project_content
 * @property string $budget
 * @property string $desired_delivery_date
 * @property string $comment
 * @property string $founding_date
 * @property boolean $status
 * @property string $responsible_name
 * @property string $department
 * @property string $mail
 * @property string $tel
 * @property string $meeting_method
 * @property string $disp_start_date
 * @property string $disp_end_date
 * @property integer $create_user_id
 * @property string $created_at
 * @property integer $update_user_id
 * @property string $updated_at
 * @property integer $delete_user_id
 * @property string $deleted_at
 */
class Matching extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'project_name', 'project_content', 'budget', 'desired_delivery_date', 'comment', 'founding_date', 'status', 'responsible_name', 'department', 'mail', 'tel', 'meeting_method', 'disp_start_date', 'disp_end_date', 'create_user_id', 'created_at', 'update_user_id', 'updated_at'];


    public static $searchKey = [
        'project_name', 'company_name', 'category_id', 'status', 'keyword'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($matching) {
            return $matching->onCreatingHandler();
        });
        self::updating(function ($matching) {
            return $matching->onUpdatingHandler();
        });
    }

    /**
     * Model作成時の処理
     *
     * @return void
     */
    private function onCreatingHandler()
    {
        if (Auth::check()) {
            $this->create_user_id = Auth::user()->id;
            $this->update_user_id = Auth::user()->id;
        }
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }

    /**
     * model更新時の処理
     *
     * @return void
     */
    private function onUpdatingHandler()
    {
        if (Auth::check()) {
            $this->update_user_id = Auth::user()->id;
        }
        $this->updated_at = date('Y-m-d H:i:s');
    }


    #region リレーション
    /**
     * 企業Modelを返します
     *
     * @return Company
     */
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    /**
     * カテゴリを返します
     *
     * @return void
     */
    public function matchingCategories()
    {
        return $this->hasMany(MatchingCategory::class, 'matching_id', 'id');
    }

    /**
     * 画像を取得
     *
     * @return void
     */
    public function imageInformations()
    {
        return $this->hasMany(ImageInformation::class, 'company_matching_id', 'id')
            ->where(['type' => config('const.image_type.matching')])
            ->orderBy('id');
    }
    #endregion

    #region get-Attribute
    /**
     * カテゴリ名をカンマ区切りで返します
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        if (!isset($this->matchingCategories)) {
            return '';
        }
        $str = $this->matchingCategories->implode('category_name', ',');
        return $str;
    }

    /**
     * 会社名取得
     *
     * @return string
     */
    public function getCompanyNameAttribute()
    {
        return isset($this->company) ? $this->company->company_name : '';
    }

    /**
     * ステータス名取得
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        return isset($this->status) ? config('const.matching.status_name')[$this->status] : '';
    }

    #endregion

    /**
     * 受付開始日取得
     *
     * @return string
     */
    public function showDispStartDate($format = 'Y/m/d')
    {
        return isset($this->disp_start_date) ? date($format, strtotime($this->disp_start_date)) : '';
    }

    /**
     * 受付終了日取得
     *
     * @return string
     */
    public function showDispEndDate($format = 'Y/m/d')
    {
        return isset($this->disp_end_date) ? date($format, strtotime($this->disp_end_date)) : '';
    }

    /**
     * 画像の取得用パスを返します(1枚目)
     *
     * @return string
     */
    public function getFirstImageUrlAttribute()
    {
        if (!isset($this->imageInformations) || !isset($this->imageInformations[0])) {
            //画像がない場合はNoImageを返します
            return '/images/noimage.png';
        }
        return $this->imageInformations[0]->image_url;
    }


    /**
     * 画像のalt_textを返します(1枚目)
     *
     * @return string
     */
    public function getFirstAltTextAttribute()
    {
        if (!isset($this->imageInformations) || !isset($this->imageInformations[0])) {
            //画像がない場合はNoImageを返します
            return 'NoImage';
        }

        $altText = $this->imageInformations[0]->alt_text;
        return isset($altText) ? $altText : '';
    }


    /**
     * 受付期間を確認して状態を変更
     *
     * @return void
     */
    public static function updateStatus()
    {
        \Log::channel('status')->info('start status update!');

        //受付開始日が今日以前の案件の状態を「受付前⇒受付中」に変更
        $matchingBefore = Matching::where('status', config('const.matching.status.before'))
            ->where('disp_start_date', '<=', date('Y-m-d'));
        //受付終了日が昨日以前の案件の状態を「受付中⇒受付終了」に変更
        $matchingAccepting = Matching::where('status', config('const.matching.status.accepting'))
            ->where('disp_end_date', '<', date('Y-m-d'));

        if (!isset($matchingBefore) && isset($matchingAccepting)) {
            \Log::channel('status')->info('There is no target.');
            return;
        }

        $matchingBefore->update(['status' => config('const.matching.status.accepting')]);
        $matchingAccepting->update(['status' => config('const.matching.status.closed')]);

        \Log::channel('status')->info('end status update!');
    }


    /**
     * 保存
     *
     * @param [type] $request
     * @return Matching
     */
    public static function saveMatching($request)
    {
        $matching = Matching::find($request->id);

        if (!$matching) {
            $matching = new Matching();
        }

        $matching->fill($request->all());
        $matching->save();

        return $matching;
    }

    /**
     * 検索
     *
     * @param [type] $conditions
     * @return query
     */
    public static function searchByConditions($conditions)
    {
        $query = self::select('matchings.*')->with(['company', 'matchingCategories.category']);

        if (Auth::check() && Auth::user()->user_type == config('const.user.type.member')) {
            //企業ユーザーの場合は、ログイン企業の案件のみ表示
            $query = $query->where('company_id', Auth::user()->company->id);
        }

        if (!Auth::check()) {
            //フロントサイトの場合は、状態が受付中・受付終了の案件のみ表示
            $query = $query->where('status', '!=', config('const.matching.status.before'));
        }

        foreach ($conditions as $key => $value) {
            if (!isset($value) || !in_array($key, self::$searchKey)) {
                continue;
            }
            switch ($key) {
                case 'project_name':
                    $query = $query->where($key, 'LIKE', sprintf('%%%s%%', $value));
                    break;
                case 'keyword':
                    $query = $query->where(function ($query) use ($value) {
                        $query->Where('project_name', 'LIKE', sprintf('%%%s%%', $value))
                            ->orWhere('project_content', 'LIKE', sprintf('%%%s%%', $value))
                            ->orWhere('comment', 'LIKE', sprintf('%%%s%%', $value))
                            ->orWhereHas('company', function ($query) use ($value) {
                                $query->where('company_name', 'LIKE', sprintf('%%%s%%', $value));
                            })
                            ->orWhereHas('matchingCategories.category', function ($query) use ($value) {
                                $query->where('categories.category_name', 'LIKE', sprintf('%%%s%%', $value));
                            });
                    });

                    break;
                case 'company_name':
                    $query = $query->whereHas('company', function ($query) use ($key, $value) {
                        $query->where($key, 'LIKE', sprintf('%%%s%%', $value));
                    });
                    break;
                case 'category_id':
                    if (!isset($value[0])) {
                        break;
                    }
                    $query = $query->whereHas('matchingCategories', function ($query) use ($key, $value) {
                        $query->whereIn('matching_categories.' . $key,  $value);
                    });
                    break;
                default:
                    $query = $query->where($key, $value);
                    break;
            }
        }
        return $query;
    }
}
