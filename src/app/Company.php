<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $industry_id
 * @property string $company_name
 * @property string $company_name_kana
 * @property string $zip
 * @property string $address1
 * @property string $address2
 * @property string $tel
 * @property string $fax
 * @property string $hp_url
 * @property string $representative_name
 * @property string $founding_date
 * @property integer $employees_num
 * @property string $business_content
 * @property string $comment
 * @property string $responsible_name
 * @property string $department
 * @property string $mail
 * @property integer $mail_send_flg
 * @property integer $create_user_id
 * @property string $created_at
 * @property integer $update_user_id
 * @property string $updated_at
 * @property integer $delete_user_id
 * @property string $deleted_at
 */
class Company extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'industry_id', 'company_name', 'company_name_kana', 'zip', 'pref_code', 'address', 'tel', 'fax', 'hp_url', 'representative_name', 'founding_date', 'employees_num', 'business_content', 'comment', 'responsible_name', 'department', 'mail', 'mail_send_flg', 'create_user_id', 'created_at', 'update_user_id', 'updated_at'];


    /**
     * 検索キー
     *
     * @var array
     */
    public static $searchKey = ['company_name', 'company_name_kana', 'industry_id', 'category_id', 'representative_name', 'status'];


    protected static function boot()
    {
        parent::boot();
        self::creating(function ($category) {
            return $category->onCreatingHandler();
        });
        self::updating(function ($category) {
            return $category->onUpdatingHandler();
        });
    }

    /**
     * model作成時に走る処理
     *
     * @return void
     */
    private  function onCreatingHandler()
    {
        if (Auth::check()) {
            $this->create_user_id = Auth::user()->id;
            $this->update_user_id = Auth::user()->id;
        }
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        return true;
    }

    /**
     * model作成時に走る処理
     *
     * @return void
     */
    private  function onUpdatingHandler()
    {
        if (Auth::check()) {
            $this->update_user_id = Auth::user()->id;
        }
        $this->updated_at = date('Y-m-d H:i:s');
        return true;
    }


    /**
     * 案件取得
     */
    public function matchings()
    {
        return $this->hasMany(Matching::class, 'company_id', 'id');
    }

    /**
     * 業種
     */
    public function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }

    /**
     * カテゴリを返します
     *
     * @return void
     */
    public function companyCategories()
    {
        return $this->hasMany(CompanyCategory::class, 'company_id', 'id');
    }

    /**
     * ユーザーモデルを返します
     *
     * @return void
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    /**
     * ステータス名を返します
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        $user = $this->user;
        return isset($user) && isset($user->status) ? config('const.status_name')[$user->status] : '';
    }

    /**
     * 業種名を返します
     *
     * @return string
     */
    public function getIndustryNameAttribute()
    {
        // $industry = $this->industry;
        // return isset($industry) && isset($industry->industry_name) ? $industry->industry_name : '';

        $industry_id = $this->industry_id;
        return isset($industry_id) && isset($industry_id) ? config('const.company.industry_name')[$industry_id] : '';
    }

    /**
     * カンマ区切りでカテゴリ名を返します
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        $str = null;
        if (isset($this->companyCategories)) {
            $str = $this->companyCategories->implode('category_name', ',');
        }

        return isset($str) ? $str : '';
    }

    /**
     * ログイン用メールアドレスを返します
     *
     * @return string
     */
    public function getLoginIdAttribute()
    {
        $user = $this->user;
        return isset($user) && isset($user->login_id) ? $user->login_id : '';
    }

    /**
     * ログインパスワードを返します
     *
     * @return string
     */
    public function getLoginPasswordAttribute()
    {
        $user = $this->user;
        return isset($user) && isset($user->password) ? $user->plain_login_password : '';
    }

    /**
     * ステータスを返します
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        $user = $this->user;
        return isset($user) && isset($user->status) ? $user->status : '';
    }

    /**
     * 県名を返します
     *
     * @return string
     */
    public function getPrefNameAttribute()
    {
        return isset($this->pref_code) ? config('const.pref')[$this->pref_code] : '';
    }

    /**
     * 創立年月日を取得
     *
     * @param string $format
     * @param string $nullValue
     * @return string
     */
    public function showFoundingDate($format = 'Y/m/d', $nullValue = '')
    {
        return isset($this->founding_date) ? date($format, strtotime($this->founding_date)) : $nullValue;
    }

    /**
     * 画像を取得
     *
     * @return void
     */
    public function imageInformations()
    {
        return $this->hasMany(ImageInformation::class, 'company_matching_id', 'id')
            ->where(['type' => config('const.image_type.company')])
            ->orderBy('id');
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
     * 企業の保存
     *
     * @param [type] $request
     * @return Company
     */
    public static function saveCompany($request, $userId)
    {
        $company = Company::find($request->id);

        if (!$company) {
            $company = new Company();
        }
        $company->fill($request->all());

        $company->user_id = $userId;
        //メール送信フラグはデフォルトで０を入れる
        $company->mail_send_flg = config('const.company.default_mail_send_flg');
        $company->save();

        return $company;
    }

    /**
     * 検索
     *
     * @param [type] $conditions
     * @return query
     */
    public static function searchByConditions($conditions)
    {
        $query = self::select('companies.*')
            ->with(['user', 'industry', 'companyCategories.category']);

        foreach ($conditions as $key => $value) {
            if (!in_array($key, self::$searchKey) || !isset($value)) continue;

            switch ($key) {
                case 'company_name':
                case 'representative_name':
                    $query = $query->where($key, 'LIKE', '%' . $value . '%');
                    break;
                case 'company_name_kana':
                    $query = $query->where('company_name_kana', 'LIKE',  $value . '%');
                    break;
                case 'category_id':
                    if (!isset($value[0])) {
                        break;
                    }
                    $query = $query->whereHas('companyCategories', function ($query) use ($key, $value) {
                        $query->whereIn('company_categories.' . $key, $value);
                    });
                    break;
                case 'status':
                    $query = $query->whereHas('user', function ($query) use ($key, $value) {
                        $query->where($key, $value);
                    });
                    break;
                case 'industry_id':
                default:
                    $query = $query->where($key, $value);
                    break;
            }
        }
        return $query;
    }
}
