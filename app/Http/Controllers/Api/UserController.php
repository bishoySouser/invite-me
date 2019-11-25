<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use File;

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

    public function uploadProfilePicture(Request $request){
        //select user
        $user = User::where('id', $request->id)->first();
        //upload image
        $image = $request->photo_url; //path=>C:\xampp\tmp\php3ABB.tmp
        if($user->avatar){
            $file_path = public_path('img/profile').'/'.$user->avatar;
            File::delete($file_path);
        }
        $new_name = rand() . '.' . $image->getClientOriginalExtension(); //new name for image
        $image->move(public_path('img/profile'), $new_name); // move image to path=>public/img/profile

        $user->avatar = $new_name;
        if(!$user->update()){
            return response()->json(['msg' => 'Error for upload image'], 205);
        }
        return $user->avatar;
    }
}
