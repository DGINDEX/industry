<?php

/*
 * 企業管理
 */

namespace App\Http\Controllers;

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
     * トップ
     * @return view
     */
    public function index(Request $request)
    {

        //セレクトボックス作成
        $categoryList =  Category::getCategory();
        $industryList = Industry::getIndustry();

        $conditions = $request->all();
        $companyQuery = Company::searchByConditions($conditions);
        $companyList = $companyQuery->orderby('id', 'asc');
        $companyList = $companyList->paginate(config('const.paginate_num.front_company'));

        //検索条件を取得して一覧画面に表示
        $searchKey = null;
        if (isset($request->company_name)) {
            $searchKey .= $request->company_name . ',';
        }
        if (isset($request->category_id) && isset($request->category_id[0])) {
            $searchKey .= Category::find($request->category_id[0])->category_name . ',';
        }
        // if (isset($request->industry_id)) {
        //     $searchKey .= Industry::find($request->industry_id)->industry_name . ',';
        // }
        if (isset($request->company_name_kana)) {
            $searchKey .= mb_convert_kana($request->company_name_kana, 'c', 'UTF-8') . ',';
        }
        if (isset($searchKey)) {
            $searchKey = rtrim($searchKey, ",");
        }

        //リクエストデータセット
        $requestDatas = compact('categoryList', 'industryList', 'companyList', 'searchKey', 'conditions');

        return view('front.company.index', $requestDatas);
    }

    /**
     * 企業詳細画面
     * @return view
     */
    public function detail($id)
    {
        //企業詳細
        $company =  Company::with(['user', 'companyCategories.category'])
            ->find($id);

        if (!$company) {
            return redirect('/');
        }

        $imageInfos = $company->imageInformations;

        //HTTPかHTTPSか判別
        $ssl = $_SERVER['REQUEST_SCHEME'] === 'https' ? 'https' : 'http';

        //リクエストデータセット
        $requestDatas = compact('company', 'imageInfos','ssl');

        return view('front.company.detail', $requestDatas);
    }
}
