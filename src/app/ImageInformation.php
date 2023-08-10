<?php

namespace App;

use App\Libs\Utility;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $no
 * @property integer $company_matching_id
 * @property boolean $type
 * @property string $image_name
 * @property string $alt_text
 */
class ImageInformation extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    protected $table = 'image_informations';

    /**
     * モデルにタイムスタンプを付けるか
     *
     * @var bool
     */
    public  $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['no', 'company_matching_id', 'type', 'image_name', 'alt_text'];


    /**
     * matchingを取得
     *
     * @return Matching
     */
    public function matching()
    {
        return $this->hasOne(Matching::class, 'id', 'company_matching_id');
    }


    /**
     * 画像の取得用パスを返します
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (!isset($this->image_name)) {
            //画像がない場合はNoImageを返します
            return '/images/noimage.png';
        }
        $folderName = $this->type == config('const.image_type.matching') ? 'matching' : 'company';
        return 'storage/' . $folderName . '/' . $this->company_matching_id . '/' . $this->id . '/' . $this->image_name;
    }

    /**
     * タイプごとに画像の保存先パスを返します
     * ついでにフォルダがなかったら作成します
     *
     * @param [type] $type
     * @return string
     */
    public static function getFolderPath($type)
    {
        if ($type == config('const.image_type.matching')) {
            $folder = 'matching/';
        } else {
            $folder = 'company/';
        }
        $folderName = storage_path('app/public/' . $folder);
        //フォルダがない場合は作成します
        if (!file_exists($folderName)) {
            mkdir($folderName);
        }
        return $folderName;
    }


    /**
     * 保存
     *
     * @param [type] $type
     * @param [type] $request
     * @param [type] $companyMatchingId
     * @return void
     */
    public static function saveImageInfo($type, $request, $companyMatchingId)
    {
        $folderName = self::getFolderPath($type);
        $imageInfomations =  $request->input('imageInfo');
        foreach ($imageInfomations as $key =>  $item) {
            $files = $request->file('imageInfo');
            $file = null;
            if (isset($files) && array_key_exists($key, $files)) {
                //登録したファイルを取得
                $file = $files[$key];
            }
            if (!isset($file)  && !isset($item['alt_text'])) {
                continue;
            }
            if ($item['id']) {
                $imageInformation = ImageInformation::find($item['id']);
            } else {
                $imageInformation = new ImageInformation();
            }

            //ファイルがある場合のみ保存
            if (isset($file)) {
                $fileName = $file['photo']->getClientOriginalName();
                $imageInformation->image_name = $fileName;
            }
            $imageInformation->company_matching_id = $companyMatchingId;
            $imageInformation->no = $key;
            $imageInformation->type = $type;
            $imageInformation->alt_text = $item['alt_text'];
            $imageInformation->save();

            //ファイルがある場合のみファイル移動
            if (isset($file)) {
                $folderPath = $folderName . '/' . $companyMatchingId . '/' . $imageInformation->id;
                //ファイルの変更がある場合は一旦フォルダ内のファイル削除※不要なファイルを持たないため
                Utility::deleteFolder($folderPath);
                $file['photo']->move($folderPath, $fileName);
            }
        }
    }
}
