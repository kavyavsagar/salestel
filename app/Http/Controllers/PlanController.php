<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Redirect;

class PlanController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        
        $this->middleware('permission:plan-list|plan-create|plan-edit|plan-delete', ['only' => ['index','show']]);
        $this->middleware('permission:plan-create', ['only' => ['create','store']]);
        $this->middleware('permission:plan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:plan-delete', ['only' => ['destroy']]);
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $plans = Plan::orderBy('id','DESC')->get();
        return view('plan.index',compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $plantype = ['fixed', 'mobile'];        
        return view('plan.create',compact('plantype'));
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
            'plan' => 'required',
            'plan_type' => 'required'
        ]);
    
        $input = $request->all();    
        $plan = Plan::create($input);
    
        return redirect()->route('plan.index')
                        ->with('success','Plan created successfully');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $plantype = ['fixed', 'mobile']; 
        $plan = Plan::find($id);
    
        return view('plan.edit',compact('plan','plantype'));
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
            'plan' => 'required',
            'plan_type' => 'required',
        ]);
    
        $input = $request->all();    

        $plan = Plan::find($id);
        $plan->update($input);

        return redirect()->route('plan.index')
                        ->with('success','Plan updated successfully');
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
        Plan::find($id)->delete();
        return redirect()->route('plan.index')
                        ->with('success','Plan deleted successfully');
    }
}
