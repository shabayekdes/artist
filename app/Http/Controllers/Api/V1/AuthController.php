<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\TokensManagerTrait;
use App\Models\User;

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
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'password' => bcrypt($request->get('password')),
        ]);

        return $this->issuePasswordToken($request);
    }
}
