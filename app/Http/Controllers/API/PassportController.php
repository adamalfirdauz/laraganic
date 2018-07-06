<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\VerifyUser;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Validator;
use Storage;
use App\Transformers\UserTransformer;

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
        dd($input);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        /**
         * Send Email Verificcation
         */
        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);
        Mail::to($user->email)->send(new VerifyMail($user));
        /* End Email Verification */
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

    public function update(Request $request){
        $this->validate($request, [
            'email' => 'email',
            'password' => 'min:6',
            'confirm_password' => 'same:password',
        ]);
        $user = Auth::user();
        if($request->name)
            $user->name = $request->name;
        if($request->email)
            $user->email = $request->email;
        if($request->address)
            $user->address = $request->address;
        if($request->phone)
            $user->phone = $request->phone;
        if($request->password && $request->confirm_password)
            $user->password = bcrypt($request->password);
        if($request->hasFile('img')){
            if($user->img){
                Storage::delete($user->img);
            }
            $img = $request->file('img')->store('users/avatars/'.$user->id);
            $user->img = $img;
        }
        $user->save();
        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta([
                'token' => Auth::user()->token(),
            ])
            ->toArray();
    }
}
