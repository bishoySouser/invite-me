<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\EventDate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
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

    public function editEventInfo(Request $request){
        $name = $request->input('name');
        $start = $request->input('event_start');
        $end = $request->input('event_start');
        $edit = $request->input('edit');

        $id = $request->input('id'); 
        $event = Event::find($id);
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
