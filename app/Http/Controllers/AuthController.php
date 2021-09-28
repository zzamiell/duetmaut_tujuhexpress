<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{
    public function LoginThroughBackend(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        $data = array(
            'username'=> $username,
            'password' => $password
        );

        try {
            $loggedin = config('client_be')->request('POST', '/api/auth/sign-in', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
                'json' => $data
                
            ]);
    
            $param=[];
            $param= (string) $loggedin->getBody();
            $data_result = json_decode($param, true);

            Session::put('token', $data_result['data']['token']);

            return json_encode($data_result);

        } catch (BadResponseException $e){
            $response = json_decode($e->getResponse()->getBody());
            //$bad_response = $this->responseData($e->getCode(), $response);
            return json_encode($response);
        }




    }
    
}
