<?php

namespace App\Http\Controllers\Api;

use App\Meeting;
use App\User;
use Auth;

use App\Events\MeetingPosted;

use App\Notifications\MeetingCreate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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
            'status' => $status,
            'do_order' => $invitee
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
            event( new MeetingPosted($meeting) );
            return response()->json($message, 201);
        }
        return response()->json($response, 404);
    }
    
    public function receiveMeetings($id){ /* --Meetings panding-- */
        // query: Meetings where user (id) & pending (Meetings status) and include info user (invitee)
        $meetings = Meeting::with('invitee')
                    ->where('owner_id', $id)
                    ->where('status', 'pending')
                    ->get();
        
        $response = [
            'msg' => 'Meetings list for user',
            'list' => $meetings
        ];

        return response()->json($response, 200);
    }

    public function MeetingEditStatus(Request $request){ //meeting edit in approved
        //valid request
        $this->validate($request, [
            'id' => 'required|numeric',
            'invitee_id' => 'required|numeric',
            'status' => 'required'
        ]);
        // varliable for request
        $id = $request->input('id');
        $invitee= $request->input('invitee_id');
        $status = $request->status;
        //find meeting
        $meeting = Meeting::find($id);
        $meeting->status = $status;
        //update meeting
        if (!$meeting->update()) {
            return response()->json(['msg' => 'Error during meeting updating'], 404);
        }
        // send notify when send meeting
        User::find($invitee)->notify(new MeetingCreate);
        $response = [
            'msg' => 'Meeting Approved',
            'meeting' => $meeting
        ];

        return response()->json($response, 200);

    }
    

    public function changeTimeMeeting(Request $request){ //meeting status "change time"
        //valid request
        $this->validate($request, [
            'id' => 'required|numeric',
            'owner' => 'required|numeric',
            'invitee' => 'required|numeric',
            'do_order' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d|after:'.date("Y-m-d"),
            'start_time' => 'required|date_format:H:i:s'
        ]);

        
        //check if meeting exist through id and owner_id & invitee_id
        $id = $request->input('id'); 
        $meeting = Meeting::find($id);
        if(!$meeting){
            return response()->json(['msg' => 'Meeting not exist. check meeting'], 404);
        }else{
            if($meeting->owner_id !== $request->input('owner') && $meeting->owner_id !== $request->input('invitee') ){
                return response()->json(['msg' => 'Error 404. Check your information'], 404);
            }
        }

        $do_order = $request->input('do_order');
        // check do_order has owenr or invitee
        if($do_order !== $request->input('owner') && $do_order !== $request->input('invitee')){
            return response()->json(['msg' => 'Error 404. Check Users Meeting'], 404);
        }
        $date = $request->input('date');
        $start = $request->input('start_time');
        $status = 'change Time';
        //add 30 mins to Strat time meeting
        // format: H:i:ss , time , 1800s = 1800/60 = 30mins //
        // Duration Meeting = 1800s = 30Mins
        $newtime = strtotime($start);
        $finish = date("H:i:ss", $newtime  + 1800);


        $meeting->date_meeting = $date;
        $meeting->start_time = $start;
        $meeting->finish_time = $finish;
        $meeting->status = $status;
        $meeting->do_order = $do_order;

        //update meeting
        if (!$meeting->update()) {
            return response()->json(['msg' => 'Error during meeting updating'], 404);
        }
        // // send notify when send meeting
        // User::find($invitee)->notify(new MeetingCreate);
        $response = [
            'msg' => 'Change meeting time. ',
            'meeting' => $meeting
        ];

        return response()->json($response, 200);
    }

    public function deleteMeeting($id){ /* --delete one Meeting-- */
        // query: a meeting has this ($id)
        $meeting = Meeting::find($id);
        if(!$meeting){
            return response()->json(['msg' => 'meeting not exist.'], 404);
        }

        $meeting->delete();
        $response = [
            'msg' => 'The meeting deleted.'
        ];
        return response()->json($response, 200);
    }
}
