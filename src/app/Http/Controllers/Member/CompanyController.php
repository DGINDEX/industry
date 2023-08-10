<?php

/*
 * 企業管理
 */

namespace App\Http\Controllers\Member;

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
     * 企業詳細画面
     * @return view
     */
    public function index()
    {
        $company = Company::with(['user', 'companyCategories.category'])
            ->find(Auth::user()->company->id);
        //データがない場合はエラー画面へ
        if (!isset($company)) {
            $errorCode = 404;
            $errorMessage = config('constMessage.http.404');
            $requestData = compact('errorCode', 'errorMessage');
            return view('errors.errorHttpResponse', $requestData);
        }
        $imageInfos = $company->imageInformations;

        //セレクトボックス作成
        $categoryList =  Category::getCategory();
        $industryList = Industry::getIndustry();
        $categories = $company->companyCategories->pluck('category_id');

        //リクエストデータセット
        $requestDatas = compact('company', 'categoryList', 'industryList', 'categories', 'imageInfos');

        return view('member.index', $requestDatas);
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

        //ログイン企業の情報のみ編集可能
        if ($request->id != Auth::user()->company->id) {
            return redirect('/member')->with('error', config('constMessage.error.E1001'));
        }

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
        return redirect('/member')->with('success', config('constMessage.success.M1001'));
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
            return redirect('/member')->with('error', config('constMessage.error.E1003'));
        }

        $companyId = $imageInfo->company_matching_id;

        //ログイン企業の画像のみ保存可能
        if ($companyId != Auth::user()->company->id) {
            return redirect('/member')->with('error', config('constMessage.error.E1003'));
        }

        DB::beginTransaction();
        try {

            //画像情報削除(物理削除)
            $imageInfo->delete();

            //画像を削除
            $folderPath = ImageInformation::getFolderPath(config('const.image_type.member')) . $companyId . '/' . $id;
            Utility::deleteFolder($folderPath);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }

        return redirect('/member')->with('success', config('constMessage.success.M1002'));
    }
}
