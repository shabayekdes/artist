<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\TokensManagerTrait;
use App\Models\User;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use TokensManagerTrait;

    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {

        $request->validate([
            'phone' => ['required'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::where('phone', $request->get('phone') )->first();
        
        if($user == null){
            return response()->json([
                'status' => false, 
                'message' => 'Sorry no account found in this number'], 404);

        }

        if($user->email_verified_at == null){
            return response()->json([
                'status' => false, 
                'message' => 'Your account not verify'], 404);

        }

        return $this->issuePasswordToken($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => ['required','unique:users'],
            'type' => ['required', 'in:2,3'],
            'password' => ['required','confirmed', 'string', 'min:8'],
            'fcm_token' => 'required',
        ]);

        \DB::beginTransaction();
        try {


            $user = User::create([
                'name' => $request->get('name'),
                'phone' => $request->get('phone'),
                'fcm_token' => $request->get('fcm_token'),
                'password' => bcrypt($request->get('password')),
                // 'otp' => rand(1000, 9999)
                'otp' => 1111

            ]);

            $message = 'this verfication code from artist portait: ' . $user->otp;

            $sms = config('services.sms');
            $url = "{$sms['url']}?send_sms&username={$sms['username']}&password={$sms['password']}&numbers={$user->phone}&sender={$sms['sender']}&message={$message}";
            $response = Http::get($url);


            \DB::commit();

            if($response->status() == 200){
                return response()->json(['status' => true, 'message' => 'OTP send successfully']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function otpCheck(Request $request)
    {
        \DB::beginTransaction();

        $request->validate([
            'phone' => ['required','exists:users,phone'],
            'otp' => ['required'],
        ]);

        try {
            $user = User::where('phone', $request->get('phone') )->first();

            if($user->otp != $request->get('otp')){
                return response()->json(['status' => false, 'message' => 'Invalid OTP'], 400);
            }

            $user->update([
                'email_verified_at' => now(),
                'otp' => 0
            ]);

            \DB::commit();

            $token = $user->createToken('Token Name')->accessToken;

            $data = [
                "token_type" => "Bearer",
                "access_token" => $token,
            ];

            return response()->json($data, 200);

        } catch ( \Exception $e ) {
            \DB::rollback();
            return ['something wrong' => false];
        }

    }
        /**
     * @param Request $request
     * @return mixed
     */
    public function otpResend(Request $request)
    {
        \DB::beginTransaction();

        $request->validate([
            'phone' => ['required','exists:users,phone'],
        ]);

        try {
            $user = User::where('phone', $request->get('phone') )->first();


            $user->update([
                // 'otp' => rand(1000, 9999)
                'otp' => 1111
            ]);

            $message = 'this verfication code from artist portait: ' . $user->otp;

            $sms = config('services.sms');
            $url = "{$sms['url']}?send_sms&username={$sms['username']}&password={$sms['password']}&numbers={$user->phone}&sender={$sms['sender']}&message={$message}";
            $response = Http::get($url);

            \DB::commit();

            return response()->json(['status' => true, 'message' => 'OTP send successfully']);

        } catch ( \Exception $e ) {
            \DB::rollback();
            return ['something wrong' => false];
        }

    }
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function forgetPassword(Request $request)
    {
        $request->validate([
            'phone' => ['required','exists:users,phone'],
        ]);

        \DB::beginTransaction();
        try {


            $user = User::where('phone', $request->get('phone') )->first();
            
            $user->update([
                // 'otp' => rand(1000, 9999)
                'otp' => 1111
            ]);
            
            $message = 'this verfication code from artist portait: ' . $user->otp;

            $sms = config('services.sms');
            $url = "{$sms['url']}?send_sms&username={$sms['username']}&password={$sms['password']}&numbers={$user->phone}&sender={$sms['sender']}&message=رساله من تطبيق لوحة فنان الكود الخاص بك هو : 5124";
            $response = Http::get($url);


            \DB::commit();

            if($response->status() == 200){
                return response()->json(['status' => true, 'message' => 'OTP send successfully']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
        }

    }

       /**
     * @param Request $request
     * @return mixed
     */
    public function changePassword(Request $request)
    {
        \DB::beginTransaction();

        $request->validate([
            'phone' => ['required','exists:users,phone'],
            'otp' => ['required'],
            'password' => ['required','confirmed', 'string', 'min:8'],
        ]);

        try {
            $user = User::where('phone', $request->get('phone') )->first();

            if($user->otp != $request->get('otp')){
                return response()->json(['status' => false, 'message' => 'Invalid OTP'], 400);
            }

            $user->update([
                'email_verified_at' => now(),
                'otp' => 0,
                'password' => bcrypt($request->get('password')),
            ]);

            \DB::commit();

            $token = $user->createToken('Token Name')->accessToken;

            $data = [
                "token_type" => "Bearer",
                "access_token" => $token,
            ];

            return response()->json($data, 200);

        } catch ( \Exception $e ) {
            \DB::rollback();
            return ['something wrong' => false];
        }

    }
    
}
