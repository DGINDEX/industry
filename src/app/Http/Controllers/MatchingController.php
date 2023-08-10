<?php

/*
 * 案件管理
 */

namespace App\Http\Controllers;

use App\Category;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\MatchingRequest;
use App\ImageInformation;
use App\Libs\Utility;
use App\Matching;
use App\MatchingCategory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\ErrorHandler\Collecting;

class MatchingController extends Controller
{


    /**
     * トップ
     * @return view
     */
    public function index(Request $request)
    {
        //セレクトボックス作成
        $categoryList =  Category::getCategory();

        $conditions = $request->all();
        $matchingQuery = Matching::searchByConditions($conditions);
        $matchingList = $matchingQuery->orderby('status', 'asc')->orderby('id', 'desc');
        $matchingList = $matchingList->paginate(config('const.paginate_num.front_matching'));

        //検索条件を取得して一覧画面に表示
        $searchKey = null;
        if (isset($request->keyword)) {
            $searchKey .= $request->keyword . ',';
        }
        if (isset($request->category_id) && isset($request->category_id[0])) {
            $searchKey .= Category::find($request->category_id[0])->category_name . ',';
        }
        if (isset($request->status)) {
            $searchKey .= config('const.matching.status_name')[$request->status] . ',';
        }
        if (isset($searchKey)) {
            $searchKey = rtrim($searchKey, ",");
        }

        //リクエストデータセット
        $requestDatas = compact('categoryList', 'matchingList', 'searchKey', 'conditions');

        return view('front.matching.index', $requestDatas);
    }


    /**
     * 案件詳細画面
     * @return view
     */
    public function detail($id)
    {
        //案件詳細
        $matching = Matching::find($id);

        if (!$matching || $matching->status == config('const.matching.status.before')) {
            return redirect('/');
        }

        $imageInfos = $matching->imageInformations;

        //リクエストデータセット
        $requestDatas = compact('matching', 'imageInfos');

        return view('front.matching.detail', $requestDatas);
    }
}
