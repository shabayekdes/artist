<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\TokensManagerTrait;

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
}
