<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
 use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\MailController;



class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
        // $this->middleware('auth:api')->except('login');

    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email|email:rfc,dns',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        return $this->createNewToken($token);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users|email:rfc,dns',
            'password' =>  ['required', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()]
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => Hash::make($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ]);
    }


    public function logout() {

        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);

    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile() {

        return response()->json(['User' => auth()->user()]);

    }


    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function forgotPassword(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'Email not found']);
        }
        else{
            $user->remember_token=Str::random(40);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return response()->json(['message' => 'Please check your mail and reset your password']);

        }

    }



    public function resetPassword(Request $request, $token)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'Email not found']);
        }else{
        $validator = Validator::make($request->all(), [
            'password' =>  ['required', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()]
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
            }

        $user = User::where('remember_token', $token)->first();

         if(!$user)
         {
            return response()->json(['message' => 'token invalid']);
         }
         else
         {
            $user->password = Hash::make($request->password);
            if(empty($user->email_verified_at))
            {
                $user->email_verified_at= date('Y-m-d H:i:s');

            }
            $user->remember_token= Str::random(40);
            $user->save();



        return response()->json(['message' => 'password successfully reset']);
        }
          }




    }


}
