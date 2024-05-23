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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\MailController;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserLoginRequest;
use Spatie\Permission\Models\Role;
use App\Events\UserRegistered;

use App\Traits\ApiResponse;

class AuthController extends Controller
{

    use ApiResponse;

    public function __construct() {

    }

    public function login(UserLoginRequest $request){


        if (!$token = auth()->attempt(["email" => $request->email, "password" => $request->password])) {
            return static::errorResponse('invalid_credentials');
        }
        $user = User::where('email', $request->email)->first();
        $roles = $this->get_role($user);
        $response = [
            "token" => $this->createNewToken($token),
            "role" => $roles,
        ];
        return $response;
    }

    protected function get_role($user)
    {
        return $user->getRoleNames();
    }

    public function register(UserRequest $request) {

    // return $role =Role::where('name','user')->first();
        $user = $request->all();
        $user['password'] = Hash::make($request->password);
        $user = User::create($user);
        $user->assignRole($request->role);

           // Fire the UserRegistered event
           event(new UserRegistered($user));

        return static::successResponse($user,'User successfully registered');
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
        $response = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
            // 'role'=>auth()->user()->getRoleNames(),

        ];
    //   $response=$response->getRoleNames();
      return $response;
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
