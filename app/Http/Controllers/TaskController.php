<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\User;
use Redirect;
use DB;
use Carbon\Carbon;
use Validator,Response,File;

class TaskController extends Controller
{
    //
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:task-list|task-create|task-edit|task-delete',
            ['only' => ['index','show']]);
         $this->middleware('permission:task-create', ['only' => ['create','store']]);
         $this->middleware('permission:task-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        //  
        $Team = [];
        
        array_push($Team, auth()->user()->id);

        if(auth()->user()->hasRole('Team Lead')){
            $tusers =  User::where('parentid', '=', auth()->user()->id)
                        ->get()
                        ->pluck('id')->toArray();

            $Team = array_merge($Team, $tusers);
        }

        $query = DB::table('tasks AS t')
            ->join('users AS u1', 'u1.id', '=', 't.assigned_by')
            ->select('u1.fullname', 't.*')
            ->where('t.status','<>', 2);// not completed
       
        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            $query->whereIn('t.assigned_by', $Team);
        }
        
        $data = $query->get();

        return view('task.index',compact('data'));
     
    }

    public function completed(Request $request)
    {
        //  
        $Team = [];
        
        array_push($Team, auth()->user()->id);

        if(auth()->user()->hasRole('Team Lead')){
            $tusers =  User::where('parentid', '=', auth()->user()->id)
                        ->get()
                        ->pluck('id')->toArray();

            $Team = array_merge($Team, $tusers);
        }

        $query = DB::table('tasks AS t')
            ->join('users AS u1', 'u1.id', '=', 't.assigned_by')
            ->select('u1.fullname', 't.*')
            ->where('t.status','=', 2);//  completed
       
        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            $query->whereIn('t.assigned_by', $Team);
        }
        
        $data = $query->get();

        return view('task.completed',compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = [];
       // if(auth()->user()->hasAnyRole(['Coordinator', 'Admin'])) { 
            // admin, coordinator
            $users = User::where('status', '=', 1)->get()->pluck('fullname', 'id')->toArray(); 

        // }else if(auth()->user()->hasRole('Team Lead')){
        //     $users = [auth()->user()->id => auth()->user()->fullname];

        //     $tusers =  User::where('status', '=', 1)->where('parentid', '=', auth()->user()->id)
        //             ->get()
        //             ->pluck('fullname', 'id')->toArray();

        //     $users = $users + $tusers; 
        // }
        return view('task.create',compact( 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request, [
            'description'   => 'required',
            'priority' => 'required',
            'assigned_by' => 'required', 
            'start_date' => 'required' 
        ]); 
        
        $input = $request->all();

         // The "right" way defining default datetimes
        $datetime = date('Y-m-d', strtotime($input['start_date']));
        $input['start_date'] = $datetime;
       
        $task = Task::create($input);
        $insert = [];

        $history = [
            'task_id' => $task->id,
            'comment'   => 'add new task lists',
            'added_by' => auth()->user()->id,
            'created_at'  => \Carbon\Carbon::now(), # new \Datetime()
            'updated_at'  => \Carbon\Carbon::now()  # new \Datetime()
        ];
        DB::table('task_histories')->insert($history);
               
        return redirect()->route('task.index')
                        ->with('success','Task created successfully');
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

        $task = DB::table('tasks AS t')
	            ->join('users AS u1', 'u1.id', '=', 't.assigned_by')
	            ->select('u1.fullname', 't.*')
	            ->where('t.id', $id)
	            ->first();           
  
        $histories = DB::table('task_histories As th')
                    ->join('users AS u1', 'u1.id', '=', 'th.added_by')
                    ->select('u1.fullname', 'th.*')
                    ->where('task_id', $id)
                    ->orderBy('created_at', 'DESC')
                    ->get();


        return view('task.show',compact('task', 'histories'));
    }
        // Change the order status
    public function changeStatus(Request $request){
        
        $this->validate($request, [      
            'taskid'   => 'required',
            'comment' => 'required'     
        ]); 

        $input = $request->all();       

        $task = Task::find($input['taskid']);
        
        $up = array('updated_at' => \Carbon\Carbon::now());
        if(isset($input['status']) && $input['status']){
        	$up['status'] = $input['status'];
        }
        ## Update task
        $task->update($up);

            // add history
            $history = [
                'task_id' => $input['taskid'],
                'comment'   => $input['comment']?$input['comment']: '',
                'added_by'  => auth()->user()->id,
                'created_at'  => \Carbon\Carbon::now(), # new \Datetime()
                'updated_at'  => \Carbon\Carbon::now()  # new \Datetime()
            ];
            DB::table('task_histories')->insert($history);
     	
     	if($input['return'] == 'task.show'){
     		return redirect()->route($input['return'], $task->id)
                        ->with('success','Task status updated successfully');
     	}else{
     		return redirect()->route($input['return'])
                        ->with('success','Task status updated successfully');
     	}
        
        

    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $task = Task::find($id);
        $users = [];
      // if(auth()->user()->hasAnyRole(['Coordinator', 'Admin'])) { 
            // admin, coordinator
            $users = User::where('status', '=', 1)->get()->pluck('fullname', 'id')->toArray(); 

        // }else if(auth()->user()->hasRole('Team Lead')){
        //     $users = [auth()->user()->id => auth()->user()->fullname];

        //     $tusers =  User::where('parentid', '=', auth()->user()->id)->where('status', '=', 1)
        //             ->get()
        //             ->pluck('fullname', 'id')->toArray();

        //     $users = $users + $tusers;
        // }      
    
        return view('task.edit',compact('task', 'users'));
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
        $this->validate($request, [
            'description'   => 'required',
            'priority' => 'required',
            'assigned_by' => 'required', 
            'start_date' => 'required'                
        ]); 
        
        $input = $request->all();


        $insert = [];

        $task = Task::find($id);
       
        // The "right" way defining default datetimes
        $datetime = date('Y-m-d', strtotime($input['start_date']));
        $input['start_date'] = $datetime;

        $task->update($input);

     
        return redirect()->route('task.index')
                        ->with('success','Task updated successfully');

    }
	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {        

        // Task Status history
        DB::table('task_histories')->where('task_id',$id)->delete();

        // Task
        $task = Task::find($id);
        $task->delete(); 

        return redirect()->route('task.index')
                        ->with('success','Task deleted successfully');
    }
}