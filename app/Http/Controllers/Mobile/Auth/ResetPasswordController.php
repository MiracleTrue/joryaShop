<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Events\EmailCodeResetEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetEmailCodeRequest;
use App\Http\Requests\ResetEmailCodeValidationRequest;
use App\Http\Requests\SmsCodeResetRequest;
use App\Http\Requests\SmsCodeResetValidationRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     * @var string
     */
    protected $redirectTo = '/mobile';

    private $overrideSessionKey = 'overridePassword';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // GET 输入短信验证码页面
    public function smsShow(Request $request)
    {
        return view('mobile.auth.passwords.sms');
    }

    // POST 验证短信验证码
    public function smsSubmit(SmsCodeResetValidationRequest $request)
    {
        //        if (Cache::has('reset_sms_code-' . $request->input('country_code') . '-' . $request->input('phone')))
        //        {
        //            Cache::forget('reset_sms_code-' . $request->input('country_code') . '-' . $request->input('phone'));
        //        }

        $user = User::where([
            'country_code' => $request->input('country_code'),
            'phone' => $request->input('phone'),
        ])->first();

        /*存储:重置密码 Session 信息*/
        $request->session()->put($this->overrideSessionKey, [
            'status' => true,
            'auth' => $user
        ]);

        return redirect()->route('mobile.reset.override.show');
    }

    // GET 重置新密码页面
    public function overrideShow(Request $request)
    {
        return view('mobile.auth.passwords.override');
    }

    // POST 重置密码为新密码
    public function overrideSubmit(Request $request)
    {
        $overrideSession = $request->session()->pull($this->overrideSessionKey, null);

        if ($overrideSession && $overrideSession['status'] === true)
        {
            $password = $request->input('password');
            $auth = $overrideSession['auth'];

            $user = User::find($auth->id);
            $user->password = bcrypt($password);
            $user->save();


            return redirect()->route('mobile.reset.success.show');

        } else
        {
            return redirect()->route('mobile.reset.sms.show');
        }

    }

    // GET 重置密码成功页面
    public function success(Request $request)
    {
        return view('mobile.auth.passwords.success');
    }
}
