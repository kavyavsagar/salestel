<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meeting;
use Redirect;
use DB;
use Validator,Response;

class MeetingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array();

        $data['roomid'] = 'ecom'.time();

        return view('meeting.host', compact('data'));
    }

    public function host(Request $request)
    {   
        // To create
        $input = $request->all();
        $input['host'] =  auth()->user()->id;
        $input['expiry'] = time() + (6 * 60 * 60);// 7 days; 24 hours; 60 mins; 60 secs

        $meet = Meeting::create($input);
               
        return redirect()->route('meeting.start', $input['room']);
    }

    public function join(Request $request)
    {
        $data = array();
 
        return view('meeting.join',compact('data'));
    }

    public function joined(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'meetid' => 'required',
        ]);
     
        $input = $request->all();
        if(isset($input['meetid']) && $input['meetid']){
            $room = Meeting::where('room', $input['meetid'])->first();
            $cnt = $room? 1: 0;
            $current = time();
          
            $diff = $room->expiry - $current;   

            if($diff < 0){ // url expired
                $validator->after(function($validator) use($diff) {            
                    $validator->errors()->add('meetid', 'Meeting ID already expired');               
                });
            }

            if(!$cnt){
                $validator->after(function($validator) use($cnt) {            
                    $validator->errors()->add('meetid', 'Meeting ID does not exist');               
                });
            }
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }
 
        return redirect()->route('meeting.start', $input['meetid']);
    }

    public function start($id)
    {
        $data = array();
        $data['meetid'] = $id;

        if($id){
            $cnt = Meeting::where('room', $id)->count();
        }

        if(!$id || !$cnt){
            return back()->with('error','Invalid meeting id');
        }

        return view('meeting.start', compact('data'));
    }

}
?>