<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use File;
use Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

use JWTFactory;
use JWTAuth;

class UserController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only('email','password');
        
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['msg' => 'invalid username and password'], 401);
            }
        }catch(JWTException $e){
            return response()->json(['msg' => 'could not create token'], 500);
        }
        
        return response()->json( compact('token'));
    }

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
    public function uploadInformation(Request $request){ //update information
        //select user
        $user = User::find($request->input('id'));
        if(empty($user)){
            return response()->json(['msg' => 'User not exist'], 404); 
        }
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
    public function changePassword(Request $request){
        $user = User::find($request->input('id'));
        if(empty($user)){
            return response()->json(['msg' => 'User not exist'], 404); 
        }
        if (!(\Hash::check($request->get('currentPassword'), $user->password))) {
            // The passwords matches
            return response()->json(['msg' => 'Your current password does not matches with the password you provided. Please try again.'], 201);
        }

        if(strcmp($request->get('currentPassword'), $request->get('newPassword')) == 0){
            //Current password and new password are same
            return response()->json(['msg' => "New Password cannot be same as your current password. Please choose a different password."], 201);
        }

        if(strcmp($request->get('newPassword'), $request->get('rePassword')) != 0){
            return response()->json(['msg' => "Re-Password confirmation must match New Password."], 201);
        }

        $validatedData = $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|string|min:6',
        ]);

        //Change Password
        $user->password = bcrypt($request->get('newPassword'));
        $user->save();
        // Mail::to($email)->send(new SendMailable($first_name,$last_name,$email,$passUser));
        $response = [
            'msg' => 'Update your password.'
        ];
        return response()->json($response, 200);
    }

}
