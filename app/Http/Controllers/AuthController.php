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
            $token = $data_result['data']['token'];

            // verify token 
            $verifyToken = config('client_be')->request('GET', '/api/auth/verify', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.$token
                ],
                'exceptions' => false
            ]);

            $param2=[];
            $param2 = (string) $verifyToken->getBody();
            $data_result2 = json_decode($param2, true);
            $tb_user_access_menus = $data_result2['data']['reff_user_role']['tb_user_access_menus'];
            $user_role_name = $data_result2['data']['reff_user_role']['user_role_name'];
            $user_role_id = $data_result2['data']['reff_user_role']['id'];

            Session::put('user_role_name', $user_role_name);
            Session::put('user_role_id', $user_role_id);
            Session::put('access_menu', $tb_user_access_menus);
            Session::put('user_real_name', $data_result2['data']['name']);
            Session::put('token', $token);

            if($user_role_id == 1) {
                Session::put('client_account_name', $data_result2['data']['tb_client']['account_name']);
            }

            return json_encode($data_result);

        } catch (BadResponseException $e){
            $response = json_decode($e->getResponse()->getBody());
            //$bad_response = $this->responseData($e->getCode(), $response);
            return json_encode($response);
        }




    }
    
}
