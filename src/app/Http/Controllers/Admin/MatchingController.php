<?php

/*
 * 案件管理
 */

namespace App\Http\Controllers\Admin;

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
     * 案件管理
     * @return view
     */
    public function index(Request $request)
    {
        $conditions = $request->all();
        $orderby = $request->input('orderby') ?: 'id';
        $sort = $request->input('sort') ?: 'desc';
        $categories = $request->input('category_id') ?: null;

        $matchingQuery = Matching::searchByConditions($conditions);
        $matchingQuery = $this->setOrderBy($matchingQuery, $orderby, $sort);
        $matchingList = $matchingQuery->paginate(config('const.paginate_num.default'));

        $categoryList = Category::getCategory();

        $requestDatas = compact('matchingList', 'categoryList', 'conditions', 'categories');

        return view('admin.matching.index', $requestDatas);
    }

    /**
     * 案件詳細画面
     * @return view
     */
    public function edit($id = null)
    {
        if (isset($id)) {
            $matching = Matching::find($id);
            //データがない場合はエラー画面へ
            if (!isset($matching)) {
                $errorCode = 404;
                $errorMessage = config('constMessage.http.404');
                $requestData = compact('errorCode', 'errorMessage');
                return view('errors.errorHttpResponse', $requestData);
            }
            $imageInfos = $matching->imageInformations;
        } else {
            //新規の場合は空のモデルを作成
            $matching = new Matching();
            $imageInfos = [];
        }

        $categoryList = Category::getCategory();
        $companyList = Company::pluck('company_name', 'id');
        $selectCategories = $matching->matchingCategories->pluck('category_id');

        //リクエストデータセット
        $requestDatas = compact('matching', 'categoryList', 'companyList', 'selectCategories', 'imageInfos');

        return view('admin.matching.edit', $requestDatas);
    }

    /**
     * 案件保存
     *
     * @param MatchingRequest $request
     * @return void
     */
    public function update(MatchingRequest $request)
    {
        $categories = $request->input('category_id');
        DB::beginTransaction();
        try {
            //matching保存
            $matching = Matching::saveMatching($request);
            //matching_category保存
            MatchingCategory::saveMatchingCategory($matching->id, $categories);
            //image_information保存
            ImageInformation::saveImageInfo(config('const.image_type.matching'), $request, $matching->id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        return redirect('admin/matching/edit/' . $matching->id)->with('success', config('constMessage.success.M1001'));
    }

    /**
     * 案件の削除
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        //案件削除
        $matching = Matching::find($id);

        if (!$matching) {
            return redirect('admin/matching')->with('error', config('constMessage.error.E1003'));
        }

        DB::beginTransaction();
        try {
            //案件削除
            $matching->deleted_at = date('Y-m-d H:i:s');
            $matching->delete_user_id = Auth::user()->id;
            $matching->save();

            //画像情報削除(物理削除)
            ImageInformation::where([
                'company_matching_id' =>  $matching->id,
                'type' => config('const.image_type.matching')
            ])->delete();

            //案件に紐づく画像を全て削除
            $folderPath = ImageInformation::getFolderPath(config('const.image_type.matching')) . $matching->id;
            Utility::deleteFolder($folderPath);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }

        return redirect('admin/matching')->with('success', config('constMessage.success.M1002'));
    }

    /**
     * 案件の画像削除
     *
     * @param [type] $id
     * @return void
     */
    public function imageDelete($id)
    {
        //画像削除
        $imageInfo = ImageInformation::find($id);

        if (!$imageInfo) {
            return redirect('admin/matching')->with('error', config('constMessage.error.E1003'));
        }

        $matchingId = $imageInfo->company_matching_id;
        DB::beginTransaction();
        try {

            //画像情報削除(物理削除)
            $imageInfo->delete();

            //案件に紐づく画像を全て削除
            $folderPath = ImageInformation::getFolderPath(config('const.image_type.matching')) . $matchingId . '/' . $id;
            Utility::deleteFolder($folderPath);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }

        return redirect('admin/matching/edit/' . $matchingId)->with('success', config('constMessage.success.M1002'));
    }

    /**
     * ソート設定
     *
     * @param [type] $query
     * @param [type] $orderby
     * @param [type] $sort
     * @return query
     */
    public function setOrderBy($query, $orderby, $sort)
    {
        switch ($orderby) {
            case 'company_name':
                $query = $query->join('companies', 'companies.id', '=', 'matchings.company_id')
                    ->orderby('companies.' . $orderby, $sort);
                break;
            default:
                $query = $query->orderby($orderby, $sort);
                break;
        }
        return $query;
    }
}
