<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libs\Password;
use App\Company;
use App\User;
use App\Http\Requests\CsvRequest;
use App\Models\MCode;
use App\Libs\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CsvImportController extends Controller
{
    /**
     * 企業情報CSV取込
     *
     * @return void
     */
    public function index()
    {
        return view('admin.csv_import.index');
    }

    /**
     * 企業情報CSV取込処理
     *
     * @return void
     */
    public function import(CsvRequest $request)
    {
        $csvFolderPath = storage_path('app/public/csv');
        $csvfile       = $request->file('csv');
        $csvfileName   = $csvfile->getClientOriginalName();
        //uploadしたCSVファイルを指定フォルダへ移動
        if (isset($csvfile)) {
            $csvfile->move($csvFolderPath, $csvfileName);
        }

        //CSVファイル読込
        $csvDatas = Utility::readCsvData($csvFolderPath . '/' . $csvfileName);
        $i = 1;
        //$maxUserId = User::max('id');
        Log::channel('csv')->info('---企業情報CSV取り込み開始---');

        //エラーが１件でも発生した場合はロールバック
        $rollbackFlg = false;

        DB::beginTransaction();
        User::flushEventListeners();
        Company::flushEventListeners();
        try {
            foreach ($csvDatas as $csvData) {
                if ($i % 100 == 0) {
                    Log::channel('csv')->info($i . '...');
                }
                //ヘッダーは処理しない
                if ($csvData === reset($csvDatas)) {
                    $i++;
                    continue;
                }
                //$maxUserId++;

                $companyName        = $csvData[0]; //会社名
                $companyNameKana    = $csvData[1]; //会社名カナ
                $representativeName = $csvData[2]; //代表者名
                $zip                = $csvData[3]; //郵便番号
                $address            = $csvData[4]; //住所（県は「滋賀県」とする」）
                $tel                = $csvData[5]; //tel
                $fax                = $csvData[6]; //fax
                $mail               = $csvData[7]; //メールアドレス
                $hpUrl              = $csvData[8]; //ホームページ
                $businessContent    = $csvData[9]; //事業内容
                $errors             = self::csvValidator($i ,$companyName, $companyNameKana, $representativeName, $zip, $address);
                //CSVにセットされている値を簡易チェック
                if (count($errors) > 0) {
                    Log::channel('csv')->info($errors->all()[0]);
                    $i++;
                    $rollbackFlg = true;
                    continue;
                }
                if(isset($mail) && $mail != '' && User::where('login_id' , $mail)->count() != 0) {
                    Log::channel('csv')->info(config('constMessage.error.E2008'));
                    $errors->add('file', '[' . $i . '行目]' . config('constMessage.error.E2008'));
                    $i++;
                    $rollbackFlg = true;
                    continue;
                }

                $user = User::create([
                    'login_id'       => isset($mail) && $mail != ''? $mail : 'test' . ($i-1) .'@example.com', //?
                    'password'       => Password::encrypt('Company2021'),//?
                    'user_type'      => config('const.user.type.member'),
                    'status'         => config('const.status.valid'),
                ]);
                Company::create([
                    'user_id' => $user->id,
                    'company_name' => $companyName,
                    'company_name_kana' => $companyNameKana,
                    'zip' => $zip,
                    'pref_code' => 25,//滋賀県
                    'address' =>  $address,
                    'tel' => $tel,
                    'fax' => isset($fax) && $fax != '' ? $fax : null,
                    'hp_url' => isset($hpUrl) && $hpUrl != '' ? $hpUrl : null,
                    'industry_id' => 1,//とりあえずの1
                    'representative_name' => $representativeName,
                    'business_content' => isset($businessContent) && $businessContent != '' ? $businessContent : null,
                    'mail' => isset($mail) && $mail != '' ? $mail : null,
                    'mail_send_flg' => 1,
                    'create_user_id' => 1,
                ]);

                $i++;
            }

            if ($rollbackFlg) {
                DB::rollBack();
                Log::channel('csv')->info(config('constMessage.error.E2002'));
                return redirect()->back()->withInput()->withErrors($errors);
            } else {
                DB::commit();
                Log::channel('csv')->info(config('constMessage.message.M1003'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('csv')->info(config('constMessage.error.E2001'));
            Log::channel('csv')->info($e);
            return redirect('csv-import/')->with('error', config('constMessage.error.E2001'));
        }

        Log::channel('csv')->info('---企業情報CSV取り込み完了---');
        \File::delete($csvFolderPath . '/' . $csvfileName);

        return redirect('admin/csv-import/')->with('status', config('constMessage.message.M1004'));
    }


    /**
     * CSVバリデーター
     *
     * @param $i
     * @param $companyName
     * @param $representativeName
     * @param $zip
     * @param $address
     * @return $errors
     */
    private static function csvValidator($i,$companyName, $companyNameKana, $representativeName,$zip, $address)
    {
        $errors = new \Illuminate\Support\MessageBag();
        //[会社名]必須指定
        if (empty($companyName)) {
            $errors->add('file', '[' . $i . '行目]' . config('constMessage.error.E2003'));
        }
        //[会社名カナ]必須指定
        if (empty($companyNameKana)) {
            $errors->add('file', '[' . $i . '行目]' . config('constMessage.error.E2009'));
        }
        //[代表者名]必須指定
        if (empty($representativeName)) {
            $errors->add('file', '[' . $i . '行目]' . config('constMessage.error.E2004'));
        }
        //[郵便番号]形式指定
        if (!preg_match("/^\d{3}\-\d{4}$/", $zip)) {
            $errors->add('file', '[' . $i . '行目]' . config('constMessage.error.E2006'));
        }
        //[住所]形式指定
        if (str_starts_with($address,'滋賀県')) {
            $errors->add('file', '[' . $i . '行目]' . config('constMessage.error.E2007'));
        }
        return $errors;
    }
}
