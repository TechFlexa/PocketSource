<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{


    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $data['token'] =  $user->createToken('PocketSource')->accessToken;
            return response()->json(['success' => true, 'data' => $data], $this->successStatus);
        }
        else{
            return response()->json(['success' => false,'error'=>'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        if($user = User::create($input)) {
            $data['token'] =  $user->createToken('PocketSource')->accessToken;
            $data['name'] =  $user->name;
            return response()->json(['success'=> true, 'data' => $data], $this->successStatus);
        }
        else {
            return response()->json(['success' => false,'error'=>'Unable to register. Probably a database error.'], 401);
        }
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

}
