<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Document;

/*
 * メール機能
 * 各コントローラーで使用するときはuse App\Mail\SendMail;を記述
 * テストメール送信例：SendMail::sendTestMail();
 * 送信するテンプレートに合わせてパラメータを設定し、それぞれのメールを送るメソッドを作成するか
 * sendEmailに直接パラメータを渡してもOK
 */

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var メール件名 */
    public $subject;

    /** @var view名   */
    public $viewName;

    /** @var viewに渡すパラメータ  */
    public $params;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $viewName, $params)
    {
        $this->subject = $subject;
        $this->viewName = $viewName;
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->viewName)->subject($this->subject);
    }

    /**
     * sendEmail
     * メールの送信とログを書き込む
     *
     * @param [type] $to 送信先
     * @param [type] $subject タイトル
     * @param [type] $viewName テンプレート名
     * @param [type] $params テンプレートに渡すパラメータ
     * @return boolean
     */
    public static function sendEmail($to, $subject, $viewName, $params)
    {
        try {
            \Log::channel('mail')->info('[' . json_encode($to) . ']' . $subject);
            // 送信アドレスが存在しない場合は送信しない

            if ($to === '') {
                \Log::channel('mail')->info('送信先アドレスが存在しないため送信されませんでした');
                return false;
            }

            //dd($to, $subject, $viewName, $params);
            Mail::to($to)->send(new SendMail($subject, $viewName, $params));
            \Log::channel('mail')->info('送信完了:' . $to);
            return true;
        } catch (Exception $ex) {
            \Log::channel('mail')->info('送信失敗:' . $to);
            \Log::channel('mail')->info($ex);
            return false;
        }
    }

    /**
     * パスワード再設定メール
     *
     * @param [type] $to   送信先
     * @param [type] $user ユーザー情報
     * @param [type] $url  再設定URL
     * @return void
     */
    public static function sendReminderPasswordMail($to, $userName, $url)
    {
        // メールの題名
        $subject   = 'パスワード再設定用URLの送付';
        // テンプレート名
        $viewName = 'mail.reminder';

        // テンプレートに渡すパラメータの作成
        $params = [
            'user_name' => $userName,
            'url'  => $url,
        ];

        //メール送信
        SendMail::sendEmail($to, $subject, $viewName, $params);
    }
}
