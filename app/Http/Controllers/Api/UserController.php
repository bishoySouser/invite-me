<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function userList($id)
    {
        $user_type = User::where('id',$id)->pluck('user_type');
        $users = User::where('user_type','!=',$user_type[0])
                    ->where('user_type','!=','Admin')->get();
        $response = [
            'msg' => 'User list except '.$user_type[0],
            'users' => $users
        ];
        
        return response()->json($response, 200);
    }
}
