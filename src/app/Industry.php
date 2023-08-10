<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $industry_name
 * @property integer $create_user_id
 * @property string $created_at
 * @property integer $update_user_id
 * @property string $updated_at
 * @property integer $delete_user_id
 * @property string $deleted_at
 */
class Industry extends Model
{
    use HasFactory;
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['industry_name', 'create_user_id', 'created_at', 'update_user_id', 'updated_at'];


    /**
     * 全業種取得
     *
     * @return Array
     */
    public static function getIndustry()
    {
        return Industry::pluck('industry_name', 'id');
    }
}
