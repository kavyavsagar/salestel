<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Redirect;
use DB;
use Validator,Response,File;

class MeetingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array();

        return view('meeting.index', compact('data'));
    }

    public function join(Request $request)
    {

        $this->validate($request, [
            'meetingid' => 'required'
        ]);
        $user = auth()->user();
        $data = array("meetingid" => $request->input('meetingid'), 'fullname' => $user->fullname, 'email' => $user->email);

        return view('meeting.join',compact('data'));
    }

    public function start(Request $request)
    {
        $data = array();

        $user = auth()->user();
        $data = array("meetingid" => time(), 'fullname' => $user->fullname, 'email' => $user->email);

        return view('meeting.start', compact('data'));
    }

}
?>