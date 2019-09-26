<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                    'sender' => 'required|numeric',
                    'receiver' => 'required|numeric',
                    'content' => 'required'
                ],
                [
                    'content.required' => 'content is empty'
                
            ]);

            $message = new Message([
                'sender_id' => $request->input('sender'),
                'receiver_id' => $request->input('receiver'),
                'content' => $request->input('content')
            ]);

            if($message->save()){
                $msg = [
                    'msg' => 'Message is send',
                    'message' => $message
                ];
                return response()->json($msg, 201);
            }
            
            $msg = 'message is send.';
            return response()->json($msg, 400);
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
