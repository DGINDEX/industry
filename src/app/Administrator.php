<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $name_kana
 * @property integer $create_user_id
 * @property string $created_at
 * @property integer $update_user_id
 * @property string $updated_at
 * @property integer $delete_user_id
 * @property string $deleted_at
 */
class Administrator extends Model
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
    protected $fillable = ['user_id', 'name', 'name_kana', 'create_user_id', 'created_at', 'update_user_id', 'updated_at'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            return $user->onCreatingHandler();
        });
        self::updating(function ($user) {
            return $user->onUpdatingHandler();
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

    /**
     * 管理者保存
     *
     * @param [type] $request
     * @param [type] $userId ユーザーID
     * @return Administrator
     */
    public static function saveAdministrator($request, $userId)
    {
        $administrator = Administrator::where('user_id', $userId)->first();
        if (!$administrator) {
            $administrator = new  Administrator();
        }

        $administrator->fill($request->all());
        $administrator->user_id = $userId;
        $administrator->save();

        return $administrator;
    }
}
