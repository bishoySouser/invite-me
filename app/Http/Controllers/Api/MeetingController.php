<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Meeting;


class MeetingController extends Controller
{
    private function validateMeeting($request)
    {
        $this->validate($request, [
            'owner' => 'required',
            'invitee' => 'required',
            'subject' => 'required',
            'description' =>'required',
            'date' => 'required',
            'start_time' => 'required',
            'finish_time' => 'required'
        ]);
    }
    public function createMeeting(Request $request)
    {
        //validation request
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

        $meeting = new Meeting([
            'owner' => $owner,
            'invitee' => $invitee,
            'subject' => $subject,
            'description' => $description,
            'date_meeting' => $date,
            'start_time' => $start,
            'finish_time' => $finish
        ]);
        if($meeting->save()){
            $message = [
                'msg' => 'Meeting created. waiting confirm.',
                'meeting' => $meeting
            ];
            
            return response()->json($message, 201);
        }
        return response()->json($response, 404);
    }
}
