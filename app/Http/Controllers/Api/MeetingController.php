<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\MeetingCreate;
use App\Meeting;
use App\User;


class MeetingController extends Controller
{
    private function validateMeeting($request)
    {
        $this->validate($request, [
            'owner' => 'required|numeric',
            'invitee' => 'required|numeric',
            'subject' => 'required|max:20',
            'description' =>'required|min:10',
            'date' => 'required|date_format:Y-m-d|after:'.date("Y-m-d"),
            'start_time' => 'required|date_format:H:i:s',
        ],
        [
            'date.after' => 'The date must be a date after today.'
        ]);
    }

    public function createMeeting(Request $request)
    {
        //validation request
        $this->validateMeeting($request);

        // prams equal request
        $owner = $request->input('owner');
        $invitee = $request->input('invitee');
        $subject = $request->input('subject');
        $description = $request->input('description');
        $date = $request->input('date');
        $start = $request->input('start_time');

        //add 30 mins to Strat time meeting
        // format: H:i:ss , time , 1800s = 1800/60 = 30mins //
        // Duration Meeting = 1800s = 30Mins
        $newtime = strtotime($start);
        $finish = date("H:i:ss", $newtime  + 1800);

        //status default => pending
        $status = 'pending';
        //insert data in meeting without owner_id & invitee_id
        $meeting = new Meeting([
            'subject' => $subject,
            'description' => $description,
            'date_meeting' => $date,
            'start_time' => $start,
            'finish_time' => $finish,
            'status' => $status
        ]);
        //owner object & invitee object
        $owner = User::find($owner);
        $invitee = User::find($invitee);
        //insert oowner object & invitee object
        $meeting->owner()->associate($owner);
        $meeting->invitee()->associate($invitee);
        //insert done
        if($meeting->save()){
            $message = [
                'msg' => 'Meeting created. waiting confirm.',
                'meeting' => $meeting
            ];
            // send notify when send meeting
            // User::find($invitee)->notify(new MeetingCreate);
            return response()->json($message, 201);
        }
        return response()->json($response, 404);
    }

    public function receiveMeetings($id){
        // meeting list 
        // id => user-id who ower meeting 
        $meetings = Meeting::with('invitee')->where('owner_id', $id)->get();
        //response
        $response = [
            'msg' => 'Meetings list for user',
            'list' => $meetings
        ];

        return response()->json($response, 200);
    }
}
