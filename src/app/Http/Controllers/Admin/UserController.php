<?php

/*
 * ユーザー管理
 */

namespace App\Http\Controllers\Admin;

use App\Administrator;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Libs\AuthSso;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /**
     * ユーザー管理
     * @return view
     */
    public function index(Request $request)
    {
        //セレクトボックス作成
        $userStatusBox = ['' => config('const.unselected')] + config('const.status_name');

        $sort = $request->input('sort') ?: 'asc';
        $orderBy = $request->input('orderby') ?: 'id';
        $conditions = $request->all();

        $userQuery = User::searchByConditions($conditions);
        $userList = $this->setOrderBy($userQuery, $orderBy, $sort);
        $userList = $userList->paginate(config('const.paginate_num.default'));

        //リクエストデータセット
        $requestDatas = compact('userStatusBox', 'userList', 'conditions');

        return view('admin.user.index', $requestDatas);
    }

    /**
     * 会員詳細画面
     * @return view
     */
    public function edit($id = null)
    {
        if (isset($id)) {
            $user = User::where([
                'id' => $id,
                'user_type' => config('const.user.type.administrator')
            ])->first();
            //データがない場合はエラー画面へ
            if (!isset($user)) {
                $errorCode = 404;
                $errorMessage = config('constMessage.http.404');
                $requestData = compact('errorCode', 'errorMessage');
                return view('errors.errorHttpResponse', $requestData);
            }
        } else {
            //新規の場合は空のモデルを作成
            $user = new User();
        }

        //リクエストデータセット
        $requestDatas = compact('user');

        return view('admin.user.edit', $requestDatas);
    }

    /**
     * 保存
     *
     * @param UserRequest $request
     * @return void
     */
    public function update(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::saveUser($request, $request->id, config('const.user.type.administrator'));
            Administrator::saveAdministrator($request, $user->id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        return redirect('admin/user/edit/' . $user->id)->with('success', config('constMessage.success.M1001'));
    }

    /**
     * 削除
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        $user = User::where([
            'id' => $id,
            'user_type' => config('const.user.type.administrator')
        ])->with(['administrator'])->first();

        if (!$user) {
            return redirect('admin/user')->with('error', config('constMessage.error.E1003'));
        }

        $user->deleted_at = date('Y-m-d H:i:s');
        $user->delete_user_id = Auth::user()->id;
        $user->save();

        $user->administrator->delete_user_id = Auth::user()->id;
        $user->administrator->deleted_at = date('Y-m-d H:i:s');
        $user->administrator->save();

        return redirect('admin/user')->with('success', config('constMessage.success.M1002'));
    }

    /**
     * ソート
     *
     * @param [type] $query
     * @param [type] $orderby
     * @param [type] $sort
     * @return qurey
     */
    public function setOrderBy($query, $orderby, $sort)
    {
        switch ($orderby) {
            case 'name':
            case 'name_kana':
                $query = $query->join('administrators', 'administrators.user_id', '=', 'users.id')
                    ->orderby('administrators.' . $orderby, $sort);
                break;
            default:
                $query = $query->orderby($orderby, $sort);
                break;
        }
        return $query;
    }
}
