<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;

class PassportController extends Controller
{

    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request, User $user){
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return response()->json(['error' => 'Email atau password salah'], 401);
        }
        $user = $user->find(Auth::user()->id);
        $token = $user->createToken('Yourganic',['user-detail','make-transaction','access-wallet'])->accessToken;
        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta([
                'token' => $token,
            ])
            ->toArray();
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
            'email' => 'required|email',
            'password' => 'required',
            // 'c_password' => 'required|same:password',
            'address' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->assignRole('user');
        $success =  $user;
        $success['token'] =  $user->createToken('Yourganic', ['user-detail','make-transaction','access-wallet'])->accessToken;
        return fractal()
            ->item($success)
            ->transformWith(new UserTransformer)
            ->addMeta([
                'token' => $success['token'],
            ])
            ->toArray();
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

    /**
     * logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);
        $accessToken->revoke();
        return response()->json("success", 202);
    }
}
