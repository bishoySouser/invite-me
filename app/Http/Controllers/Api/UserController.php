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

    public function uploadProfilePicture(Request $request){ // upload profile 
        //select user
        $user = User::where('id', $request->id)->first();
        //upload image
        
        if($user->avatar){
            $file_path = public_path('img/profile').'/'.$user->avatar;
            File::delete($file_path);
        }
        if($request->photo_url){
            $image = $request->photo_url;
            $new_name = date('Y_m_d_his') . rand() . '.' . $image->getClientOriginalExtension(); //new name for image
            $image->move(public_path('img/profile'), $new_name); // move image to path=>public/img/profile
            $user->avatar = $new_name;
        }else{
            $user->avatar = null;
        }

        if(!$user->update()){
            return response()->json(['msg' => 'Error for upload image'], 205);
        }

        $response = [
            'msg' => 'Update profile picture '
        ];
        return response()->json($response, 200);
    }
    public function uploadInformation(Request $request){
        //select user
        $user = User::find($request->id);
        // if(count($user) < 1){
        //     return response()->json(['msg' => 'User not exist'], 404);
        // }

        $user->first_name = $request->input('firstName');
        $user->last_name = $request->input('lastName');
        $user->company_name = $request->input('company');
        $user->country = $request->input('country');
        //check update
        if(!$user->save()){
            return response()->json(['msg' => 'Error for update your information'], 205);
        }

        $response = [
            'msg' => 'Update your information '
        ];
        return response()->json($response, 200);
    }
}
