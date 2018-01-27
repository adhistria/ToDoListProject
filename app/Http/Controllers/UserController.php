<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\User;
use Mockery\Exception;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    //
    public function registerUser(Request $request){
        try{
            $user =new User();
            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'username'=>'required|min:0|max:100|unique:users',
                'password'=>'required|string|min:0|max:20',
            ]);
            if($validator->fails()){
                return response()->json(['code'=>'FAIL','message'=>"OK",'content'=>$validator->errors()],400);
            }
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->name = $request->name;
            $user->save();
            return response()->json(['code'=>'SUCCESS',"message"=>"OK","content"=>null],200);
        }catch (Exception $e){
            return response()->json(['code'=>'FAIL','message'=>"OK",'content'=>$e],400);

        }

    }
    public function authenticate(Request $request){
        // grab credentials from the request
        $credentials = $request->only('username', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
//        return response()->json(compact('token'));
        $user = User::where('username',$request->only('username'))->first();
        $name = $user->name;

        return response()->json(['code'=>'SUCCESS','message'=>'OK','content'=>['token'=>$token,'name'=>$name]]);
    }
    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }
    public function logout(){
        try{
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['status'=>'SUCCESS','message'=>'OK','content'=>null],200);
        }catch (Exception $e){
            return response()->json(['status'=>'FAIL','message'=>'OK','content'=>null],400);
        }

    }
}
