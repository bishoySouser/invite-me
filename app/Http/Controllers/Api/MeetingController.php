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
            'owner' => 'required',
            'invitee' => 'required',
            'subject' => 'required',
            'description' =>'required',
            'date' => 'required',
            'start_time' => 'required',
            'finish_time' => 'required'
        ]);
        return 'done';

        // prams equal request
        $owner = $request->input('owner');
        $invitee = $request->input('invitee');
        $subject = $request->input('subject');
        $description = $request->input('description');
        $date = $request->input('date');
        $start = $request->input('start_time');
        $finish = $request->input('finish_time');

        $meeting = new Meeting([
            'owner' => $owner,
            'invitee' => $invitee,
            'subject' => $subject,
            'description' => $description,
            'data' => $date,
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
