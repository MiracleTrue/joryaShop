<?php

namespace App\Http\Controllers\Auth;

use App\Events\EmailCodeRegisterEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterEmailCodeRequest;
use App\Http\Requests\RegisterEmailCodeValidationRequest;
use App\Http\Requests\SmsCodeRegisterRequest;
use App\Http\Requests\SmsCodeRegisterValidationRequest;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserCoupon;
use App\Models\UserHistory;
use App\Notifications\AdminCustomNotification;
use App\Rules\RegisterSmsCodeValidRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectTo()
    {
        return URL::previous();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /*return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'code' => 'required|string',
        ]);*/
        return Validator::make($data, [
            'name' => 'bail|required|string|max:255|unique:users',
            'password' => 'bail|required|string|min:6',
            'email' => 'bail|required|string|email|unique:users',
            'country_code' => 'bail|required|string|regex:/^\d+$/',
            'phone' => [
                'bail',
                'required',
                'string',
                'regex:/^\d+$/',
                function ($attribute, $value, $fail) use ($data) {
                    if (isset($data['country_code'])) {
                        if (User::where([
                            'country_code' => $data['country_code'],
                            'phone' => $value,
                        ])->exists()
                        ) {
                            $fail(trans('basic.users.Phone_has_been_registered_as_user'));
                        }
                    }
                }
            ],
            'code' => [
                'bail',
                'required',
                'string',
                'regex:/^\d+$/',
                new RegisterSmsCodeValidRule($data['country_code'], $data['phone']),
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'country_code' => $data['country_code'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    // POST 通过邮箱验证码注册
    public function sendEmailCode(RegisterEmailCodeRequest $request)
    {
        $email = $request->input('email');

        if (Cache::has('register_email_code-' . $email)) {
            Cache::forget('register_email_code-' . $email);
        }

        event(new EmailCodeRegisterEvent($email));

        return response()->json([]);
    }

    // POST 通过短信验证码注册
    public function sendSmsCode(SmsCodeRegisterRequest $request)
    {
        $phone_number = $request->input('phone');
        $country_code = $request->input('country_code');

        if (Cache::has('register_sms_code-' . $country_code . '-' . $phone_number)) {
            Cache::forget('register_sms_code-' . $country_code . '-' . $phone_number);
        }

        $code = random_int(100000, 999999);
        $data['code'] = $code;
        $response = easy_sms_send($data, $phone_number, $country_code);

        if ($response['aliyun']['status'] == 'success') {

            $ttl = 10;
            Cache::set('register_sms_code-' . $country_code . '-' . $phone_number, $code, $ttl);
            // 60s内不允许重复发送邮箱验证码
            Cache::set('register_sms_code_sent-' . $country_code . '-' . $phone_number, true, 1);

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'response' => $response,
            ]);
        }

        return response()->json($response, 500);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \App\Http\Requests\RegisterEmailCodeRequest
     * @param  \App\Http\Requests\SmsCodeRegisterValidationRequest $request
     * @return \Illuminate\Http\Response
     */
    // public function register(RegisterEmailCodeRequest $request)
    public function register(SmsCodeRegisterValidationRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        /*return $this->registered($request, $user)
            ?: redirect($this->redirectPath());*/

        // user browsing history - initialization
        $this->initializeUserBrowsingHistoryCacheByUser($user);
        // update cart
        $this->updateCart($user);

        /* Send coupons to the newly registered user */
        $coupons = Coupon::where(['scenario' => Coupon::COUPON_SCENARIO_REGISTER])->get()->filter(function (Coupon $coupon) {
            return $coupon->status == Coupon::COUPON_STATUS_USING;
        });
        $coupon_names = '';
        $coupons->each(function (Coupon $coupon) use ($user, &$coupon_names) {
            UserCoupon::create([
                'user_id' => $user->id,
                'coupon_id' => $coupon->id,
                'got_at' => Carbon::now()->toDateTimeString()
            ]);
            $coupon_names .= $coupon->name . ', ';
        });
        $coupon_count = $coupons->count();
        $coupon_names = substr($coupon_names, 0, -2);
        $user->notify(new AdminCustomNotification([
            'title' => 'You just received ' . $coupon_count . ' new coupons: ' . $coupon_names,
            'link' => ''
        ]));
        /* Send coupons to the newly registered user */

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => [
                'return_url' => URL::previous(),
                // 'return_url' => url()->previous(),
                // 'return_url' => Redirect::back()->getTargetUrl(),
                // 'return_url' => redirect()->back()->getTargetUrl(),
                // 'return_url' => $request->headers->get('referer'),
            ],
        ]);
    }

    // user browsing history - initialization
    protected function initializeUserBrowsingHistoryCacheByUser(User $user)
    {
        $browsed_at = today()->toDateString();
        Cache::forever($user->id . '-user_browsing_history_count', 0);
        Cache::forever($user->id . '-user_browsing_history_list', [
            $browsed_at => [],
        ]);
        $user_browsing_histories = UserHistory::where('user_id', $user->id)
            ->where('browsed_at', '>=', $browsed_at)
            ->get()
            ->pluck('product_id')
            ->toArray();
        Cache::forever($user->id . '-user_browsing_history_list_stored', [
            $browsed_at => $user_browsing_histories,
        ]);
    }

    // update cart
    protected function updateCart(User $user)
    {
        $cart = session('cart', []);
        // $cart = Session::get('cart', []);
        foreach ($cart as $product_sku_id => $number) {
            if ($user_cart = Cart::where(['user_id' => $user->id, 'product_sku_id' => $product_sku_id])->first()) {
                // $user_cart->number += $number;
                $user_cart->increment('number', $number);
                $user_cart->save();
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'product_sku_id' => $product_sku_id,
                    'number' => $number
                ]);
            }
        }
        session()->forget('cart');
        // Session::forget('cart');
    }
}
