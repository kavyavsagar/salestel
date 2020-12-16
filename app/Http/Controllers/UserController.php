<?php
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
    
class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if(auth()->user()->hasRole('Team Lead')){ 
            $data =  User::where('id', '=', auth()->user()->id)
                    ->orWhere('parentid','=', auth()->user()->id)
                    ->where('status', '=', 1)
                    ->orderBy('id','DESC')
                    ->get();
        }else{
            $data = User::orderBy('id','DESC')->where('id', '<>', '1')->where('status', '=', 1)->get();
        }
        
        return view('users.index',compact('data'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //$parents = User::pluck('fullname','fullname')->all();
        
        if(auth()->user()->hasRole('Admin')){ 
            $parents = User::where('parentid', '=', '0')->pluck('fullname', 'id')->toArray();
        }else{
            $parents = User::where('id', '<>', '1')->where('parentid', '=', '0')->pluck('fullname', 'id')->toArray();
        }

        if(auth()->user()->hasRole('Admin')){ 
            $roles = Role::pluck('name','name')->all();
        }else{
            $roles = Role::where('id', '<>', '1')->pluck('name','name')->all();
        }

        return view('users.create',compact('roles', 'parents'));
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
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'phone' => 'required',
            'goal'  => 'required',           
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $parent =  User::find($user->parentid);

        return view('users.show',compact('user', 'parent'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $parents = User::where('id', '<>', $id)
                    ->get()
                    ->pluck('fullname', 'id')->toArray();


        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole', 'parents'));
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
        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            //'roles' => 'required',
            'goal'  => 'required', 
        ]);
    
        $input = $request->all();

        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{

            $input = Arr::except($input,array('password'));    
        }

        $user = User::find($id);
        $user->update($input);

        if($request->input('roles')){
            DB::table('model_has_roles')->where('model_id',$id)->delete();
        
            $user->assignRole($request->input('roles'));
        }
       
        return redirect()->route('users.edit', $id)
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}