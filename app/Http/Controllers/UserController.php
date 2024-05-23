<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\Traits\ApiResponse;
use App\Http\Requests\UserRequest;

use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{

    use ApiResponse;
    public function index()
    {
        $users = User::with('roles')->get();
        $usersWithRoles = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name')
            ];
        });
        return static::successResponse($usersWithRoles,'Data fetch successfully');
    }




    public function createUser(UserRequest $request)
    {

        $user = $request->all();
        $user['password'] = Hash::make($request->password);

        $user = User::create($user);

        $user->assignRole($request->role);

        return static::successResponse($user,'User successfully registered');

    }




    public function updateUser(UserUpdateRequest $request,$id)
    {

        // return $request->all();
        try {
            $user = User::findOrFail($id);
            if ($request->password) {
                $user->password = $request->password;
            }
            if (auth()->user()->hasRole('super-admin')||auth()->user()->hasRole('admin')) {
                if ($request->role) {
                    $role = DB::table('roles')->where('name', $request->role)->first();
                    $currentRole = DB::table('model_has_roles')->where('model_id', $id)->value('role_id');
                    if ($currentRole != $role->id) {
                        DB::table('model_has_roles')
                            ->where('model_id', $id)
                            ->update(['role_id' => $role->id]);
                    }
                }
            }
          $user->update($request->all());

            $user = User::where('id', $request->id)->first();
            $roles = $this->get_role($user);
            $response = [
                "role" => $roles,
                ];

        return static::successResponse($user,'Data updated successfully');

        } catch (Exception $e) {
           return static::errorResponse();
        }

    }
    protected function get_role($user)
    {
        return $user->getRoleNames();
    }

    public function deleteUser($id)
    {
        try {
            User::destroy($id);
            return static::successResponse('No data found','delete successfully');
        } catch (Exception $e) {
            return static::errorResponse();
        }
    }


}
