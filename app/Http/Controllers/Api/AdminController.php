<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\EventDate;
use App\Meeting;
use App\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use JWTFactory;
use JWTAuth;

class AdminController extends Controller
{
    public function useradd(Request $request){
        //validate
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'user_type' => 'required',
        ]);
        //add password
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $user_type = $request->input('user_type');
        $passUser = bcrypt($first_name);
        $password = bcrypt($passUser);

        $dublicteUser = User::where('email', '=', $email)->count();
        if($dublicteUser > 0){
            $response = [
                'error' => 'User is already registered',
            ];
            return response()->json($response, 202);
        }
        //insert user
        $user = new User([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'user_type' => $user_type,
            'password' => $password
        ]);
        
        Mail::to($email)->send(new SendMailable($first_name,$last_name,$email,$passUser));
        //response
        $token = JWTAuth::fromUser($user);
        if ($user->save()) {
            $response = [
                'msg' => 'User created',
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response, 201);
        }

        $response = [
            'msg' => 'An error occurred',
            
        ];

        return response()->json($response, 404);
    }

    public function getMeetings(){ //get all meetings
        $meetings = Meeting::with('invitee')->with('owner')->get();
        $response = [
            'msg' => 'all Meetings.',
            'list' => $meetings,
        ];

        return response()->json($response, 200);
    }

    public function uamInfo(){ //users and meetings count
        $usersCount = User::where('user_type', '!=', 'Admin')->count(); //Users All
        $companysCount = User::where('user_type', '=', 'Company')->count(); //Companies All
        $exhibitorsCount = User::where('user_type', '=', 'Exhibitor')->count(); //Exhibitors All
        $innovatorsCount = User::where('user_type', '=', 'Innovator')->count(); //Innovators All

        $meetingCount = Meeting::count(); //Meetings All

        $response = [
            'msg' => 'Users and Meeting Count.',
            'data' => [
                'UserAll' => $usersCount,
                'Companies' => $companysCount,
                'Exhibitors' => $exhibitorsCount,
                'Innovators' => $innovatorsCount,
                'Meetings' => $meetingCount
            ]
        ];
        return response()->json($response, 200);
    }

    public function eventInfo(){ //get event info and event dates
        $info = Event::find(1);
        $date = EventDate::where('event', 1)->get();
        $response = [
            'msg' => 'event Info.',
            'event_info' => $info,
            'dates' => $date
        ];

        return response()->json($response, 200);
    }

    public function infoMeeting(){ //meeting info for create meeting
        //users
        $users = User::where('user_type', '!=', 'Admin')->orderBy('email')->get();
        //event time
        $event = Event::where('id', 1)->first();
        //event date
        $dates = EventDate::all();
        $response = [
            'msg' => 'Meeting info.',
            'users' => $users,
            'event' => $event,
            'dates' => $dates
        ];
        return response()->json($response, 200);
    }

    public function addEventDate(Request $request){
        $this->validate($request, [
            'event' => 'required|numeric',
            'event_date' => 'required',
        ]);

        $name = $request->input('event');
        $date = $request->input('event_date');

        $event_date = new EventDate([
            'event' => $name,
            'event_date' => $date 
        ]);

        if($event_date->save()){
            $response = [
                'msg' => 'Date created. waiting confirm.',
                'meeting' => $event_date
            ];
            return response()->json($response, 201);
            // send notify when send meeting
            // User::find($invitee)->notify(new MeetingCreate);
        }
        return response()->json($response, 404);
    }

    public function usersList(){ //get users list
        $list =  User::where('user_type', '!=', 'Admin')->get();
        $response = [
            'msg' => 'Users List',
            'list' => $list
        ];

        return response()->json($response, 200);
        // return 'edit event info';
    }

    public function deleteUser($id){ //delete user
        // query: a user has this ($id)
        $user = User::find($id);
        if(!$user){
            return response()->json(['msg' => 'user not exist.'], 202);
        }
        //not delete admin
        if($user->user_type === 'Admin'){
            return response()->json(['msg' => 'user not exist.'], 202);
        }

        $user->delete();
        $response = [
            'msg' => 'The user deleted.'
        ];
        return response()->json($response, 200);
    }

    public function statusCount(){ //get statusMeeting
        $approved = Meeting::where('status', 'approved')->count();
        $pending = Meeting::where('status', 'pending')->count();
        $response = [
            'msg' => 'meeting status count.',
            'approved' => $approved,
            'pending' => $pending
        ];

        return response()->json($response, 200);
    }

    public function editEventInfo(Request $request){
        $name = $request->input('name');
        $start = $request->input('event_start');
        $end = $request->input('event_end');
        $edit = $request->input('edit');

        $id = $request->input('id'); 

        $event = Event::find($id);
        $event->name = $name;
        $event->event_start = $start;
        $event->event_end = $end;
        $event->edit = $edit;

        //update meeting
        if (!$event->update()) {
            return response()->json(['msg' => 'Error during Event info updating'], 404);
        }
        // // send notify when send meeting
        // User::find($invitee)->notify(new MeetingCreate);
        $response = [
            'msg' => 'Change event info. ',
            'event_info' => $event
        ];

        return response()->json($response, 200);
        // return 'edit event info';
    }

    public function deleteEventDate($id){
        // query: a meeting has this ($id)
        $date = EventDate::find($id);
        if(!$date){
            return response()->json(['msg' => 'Date not exist.'], 404);
        }

        $date->delete();
        $response = [
            'msg' => 'The Date deleted.'
        ];
        return response()->json($response, 200);
    }
}
