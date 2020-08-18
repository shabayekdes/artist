<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

trait TokensManagerTrait {

    /**
     * @param Request $request
     * @param $grantType
     * @param $clientId
     * @param $clientSecret
     * @return mixed
     */
    private function issueToken(Request $request, $grantType, $clientId, $clientSecret ){
        $params = [
            'grant_type' => $grantType,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'username' => $request->get('phone'),
            'password' => $request->get('password'),
            'scope' => '*'
        ];

        $request->request->add($params);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }

    /**
     * @param $request
     * @param $grantType
     * @return mixed
     */
    private function addClient($request, $grantType){

        $client = Client::where('password_client' , true)->first();

        if(!$client){
            return response()->json(['status' => false, 'message' => 'something happen wrong with token!!' ]);
        }

        return $this->issueToken($request, $grantType, $client->id, $client->secret);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function issuePasswordToken($request){
        return $this->addClient($request, "password");
    }

    /**
     * @param $request
     * @return mixed
     */
    public function issueRefreshToken($request){
        return $this->addClient($request, "refresh_token");
    }
}