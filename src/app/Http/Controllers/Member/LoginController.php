<?php

namespace App\Http\Controllers\Member;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ReminderRequest;
use App\User;
use App\Libs\Password;
use App\Mail\SendMail;

use function GuzzleHttp\Promise\all;

class LoginController extends Controller
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        AuthenticatesUsers;

    protected $maxAttempts  = 50;   // ログイン試行回数（回）
    protected $decayMinutes = 0;   // ログインロックタイム（分）
    protected $redirectTo   = '/member'; //ログイン後に表示する画面

    /**
     * 認証を無効にする画面を設定
     */
    public function __construct()
    {
        $this->middleware('auth:members')->except(['index', 'login', 'logout', 'reminder', 'pwReset', 'reminderSendMail', 'pwUpdate', 'pwComplete']);
    }

    /**
     * 認証を指定します
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('members');
    }

    /**
     * ログインIDを指定のカラムに変更する
     *
     * @return void
     */
    public function username()
    {
        return 'login_id';
    }

    /**
     * 認証の条件を設定
     * ログインID、パスワード、ユーザータイプ、削除日
     *
     * @param Request $request
     * @return void
     */
    public function attemptLogin(Request $request)
    {
        return $this->guard()->attempt([
            'login_id' => $request->input('login_id'),
            'password' => $request->input('password'),
            'user_type' => config('const.user.type.member'),
            'status' => config('const.status.valid'),
            'deleted_at' => null
        ]);
    }

    /**
     * 認証前のバリデーション
     *
     * @param Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        if (!isset($request->password)) {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }

        $this->validate($request, [
            'login_id' => 'required|string',
            'password' => 'required|string'
        ]);
    }

    /**
     * ログイン画面
     * @return view
     */
    public function index()
    {
        return view('member.login.index');
    }

    /**
     * ログアウト
     * @return redirect
     */
    public function logout()
    {
        User::flushEventListeners();
        $this->guard()->logout();
        return redirect()->to('member/login/');
    }

    /**
     * リマインダー画面
     * @return view
     */
    public function reminder()
    {
        return view('member.login.reminder');
    }

    /**
     * リマインダーメール送信
     */
    public function reminderSendMail(ReminderRequest $request)
    {
        //ログインIDをrequestより取得
        $loginId     = $request->input('login_id');
        $mailAddress = $request->input('send_mail');

        //ログインIDからユーザーを探す
        $user = User::getMemberByLoginId($loginId);

        //エラーならリダイレクトでエラーと共に戻す
        if (!isset($user)) {
            return redirect()->back()->with('error', config('constMessage.error.E1003'));
        }
        if ($user->login_id !== $mailAddress) {
            return redirect()->back()->with('error', config('constMessage.error.E1004'));
        }

        //認証keyと有効期限をDBへセット
        $authKey = Str::random(64);
        User::saveReminderAuthInfo($user->id, $authKey);
        //パスワード再設定用画面URL生成
        $setUrl       = route('member_reset', ['id' => $loginId]) . '/' . $authKey;


        SendMail::sendReminderPasswordMail($mailAddress, $user->company->company_name, $setUrl);

        return redirect('member/login/reminder')->with('status', 'パスワード再設定用のメールを送信しました');
    }

    /**
     * パスワード再設定画面
     * @param Request $request
     * @return view
     */
    public function pwReset(Request $request)
    {
        $getId      = mb_strstr($request->id, '/', true);
        $login_id   = rtrim($getId, '/');
        $getAuthKey = mb_strstr($request->id, '/', false);
        $authKey    = ltrim($getAuthKey, '/');

        //認証Keyと有効期限を判定(ログインID = メールアドレス)
        $user = User::getMemberByLoginId($login_id);
        $expiredFlg = $user->auth_key_expired_at < date("Y-m-d H:i:s");
        if ($user->auth_key !== $authKey || $expiredFlg) {
            throw new NotFoundHttpException();
        }

        $requestDatas = compact(
            'login_id',
            'authKey'
        );

        return view('member.login.pw_reset', $requestDatas);
    }

    /**
     * パスワード更新
     * @param PasswordRequest $request
     * @return view
     */
    public function pwUpdate(PasswordRequest $request)
    {
        $loginId  = $request->input('login_id');
        $password = $request->input('password');
        $authKey  = $request->input('authKey');

        $user                 = User::where('login_id', $loginId)->first();
        $user->password       = Password::encrypt($password);
        $user->updated_at     = date('Y-m-d H:i:s');
        $user->update_user_id = $user->id;
        $user->save();

        return redirect('member/login/pw-complete');
    }

    /**
     * パスワード再設定完了画面
     * @param PasswordRequest $request
     * @return view
     */
    public function pwComplete()
    {
        return view('member.login.pw_reset_complete');
    }
}
