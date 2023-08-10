<?php

/*
 * 企業管理
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Libs\AuthSso;
use App\Category;
use App\Company;
use App\Industry;
use App\CompanyCategory;
use App\User;
use App\ImageInformation;
use App\Libs\Utility;
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

class CompanyController extends Controller
{

    /**
     * 企業管理
     * @return view
     */
    public function index(Request $request)
    {

        $conditions = $request->all();
        $orderBy = $request->input('orderby') ?: 'id';
        $sort = $request->input('sort') ?: 'asc';
        $categories = $request->input('category_id') ?: null;

        $companyQuery = Company::searchByConditions($conditions);
        $companyList = $this->setOrderBy($companyQuery, $orderBy, $sort);
        $companyList = $companyList->paginate(config('const.paginate_num.default'));

        //セレクトボックス作成
        $categoryList =  Category::getCategory();
        $industryList = Industry::getIndustry();
        $companyStatusList = ['' => config('const.unselected')] + config('const.status_name');

        //リクエストデータセット
        $requestDatas = compact('categoryList', 'industryList', 'companyStatusList', 'categories', 'companyList', 'conditions');

        return view('admin.company.index', $requestDatas);
    }

    /**
     * 企業詳細画面
     * @return view
     */
    public function edit($id = null)
    {
        if (isset($id)) {
            $company = Company::with(['user', 'companyCategories.category'])
                ->find($id);
            //データがない場合はエラー画面へ
            if (!isset($company)) {
                $errorCode = 404;
                $errorMessage = config('constMessage.http.404');
                $requestData = compact('errorCode', 'errorMessage');
                return view('errors.errorHttpResponse', $requestData);
            }
            $imageInfos = $company->imageInformations;
        } else {
            $company = new Company();
            $imageInfos = [];
        }

        //セレクトボックス作成
        $categoryList =  Category::getCategory();
        $industryList = Industry::getIndustry();
        $categories = $company->companyCategories->pluck('category_id');

        //リクエストデータセット
        $requestDatas = compact('company', 'categoryList', 'industryList', 'categories', 'imageInfos');

        return view('admin.company.edit', $requestDatas);
    }

    /**
     * 企業保存
     *
     * @param UserRequest $request
     * @return void
     */
    public function update(CompanyRequest $request)
    {
        $categories = $request->input('category_id');
        DB::beginTransaction();
        try {
            //usersの保存
            $user = User::saveUser($request, $request->user_id, config('const.user.type.member'));
            //companiesの保存
            $company = Company::saveCompany($request, $user->id);
            //company_category保存
            CompanyCategory::saveCompanyCategory($company->id, $categories);
            //image_information保存
            ImageInformation::saveImageInfo(config('const.image_type.company'), $request, $company->id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        return redirect('admin/company/edit/' . $company->id)->with('success', config('constMessage.success.M1001'));
    }

    /**
     * 削除
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        //企業削除
        $company = Company::find($id);

        if (!$company) {
            return redirect('admin/company')->with('error', config('constMessage.error.E1003'));
        }

        DB::beginTransaction();
        try {
            //企業削除
            $company->deleted_at = date('Y-m-d H:i:s');
            $company->delete_user_id = Auth::user()->id;
            $company->save();

            //ユーザーテーブル削除
            $user = $company->user;
            $user->deleted_at = date('Y-m-d H:i:s');
            $user->delete_user_id = Auth::user()->id;
            $user->save();

            //企業カテゴリ削除
            CompanyCategory::where('company_id', $company->id)->delete();

            //画像情報削除(物理削除)
            ImageInformation::where([
                'company_matching_id' =>  $company->id,
                'type' => config('const.image_type.company')
            ])->delete();

            //企業に紐づく画像を全て削除
            $folderPath = ImageInformation::getFolderPath(config('const.image_type.company')) . $company->id;
            Utility::deleteFolder($folderPath);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        return redirect('admin/company')->with('error', config('constMessage.success.M1002'));
    }


    /**
     * 企業の画像削除
     *
     * @param [type] $id
     * @return void
     */
    public function imageDelete($id)
    {
        //画像削除
        $imageInfo = ImageInformation::find($id);

        if (!$imageInfo) {
            return redirect('admin/company')->with('error', config('constMessage.error.E1003'));
        }

        $companyId = $imageInfo->company_matching_id;
        DB::beginTransaction();
        try {

            //画像情報削除(物理削除)
            $imageInfo->delete();

            //画像を削除
            $folderPath = ImageInformation::getFolderPath(config('const.image_type.company')) . $companyId . '/' . $id;
            Utility::deleteFolder($folderPath);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }

        return redirect('admin/company/edit/' . $companyId)->with('success', config('constMessage.success.M1002'));
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
            case 'industry_name':
                $query = $query->join('industries', 'industries.id', '=', 'companies.industry_id')
                    ->orderby('industries.industry_name', $sort);
                break;
            case 'status_name':
                $query = $query->join('users', 'users.id', '=', 'companies.user_id')
                    ->orderby('users.status', $sort);
                break;
            default:
                $query = $query->orderby($orderby, $sort);
                break;
        }
        return $query;
    }
}
