<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use Illuminate\Http\Request;
use Redirect;


class OrderStatusController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:orderstatus-list|orderstatus-create|orderstatus-edit|orderstatus-delete', ['only' => ['index','show']]);
         $this->middleware('permission:orderstatus-create', ['only' => ['create','store']]);
         $this->middleware('permission:orderstatus-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:orderstatus-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $orderstatus = OrderStatus::orderBy('id','ASC')->paginate(5);
        return view('orderstatus.index',compact('orderstatus'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $data = [];        
        return view('orderstatus.create',compact('data'));
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
            'name' => 'required'
        ]);
    
        $input = $request->all();
    
        $orderstatus = OrderStatus::create($input);
    
        return redirect()->route('orderstatus.index')
                        ->with('success','Order Status created successfully');
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
        $orderstatus = OrderStatus::find($id);
    
        return view('orderstatus.edit',compact('orderstatus'));
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
            'name' => 'required'
        ]);
    
        $input = $request->all();

        $orderstatus = OrderStatus::find($id);
        $orderstatus->update($input);
    
        return redirect()->route('orderstatus.index')
                        ->with('success','Order Status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrderStatus::find($id)->delete();
        return redirect()->route('orderstatus.index')
                        ->with('success','Order Status deleted successfully');
    }
}
