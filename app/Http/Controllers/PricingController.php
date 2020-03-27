<?php

namespace App\Http\Controllers;

use App\Pricing;
use Illuminate\Http\Request;
use Redirect;

class PricingController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:pricing-list|pricing-create|pricing-edit|pricing-delete', ['only' => ['index','show']]);
         $this->middleware('permission:pricing-create', ['only' => ['create','store']]);
         $this->middleware('permission:pricing-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pricing-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $pricings = Pricing::orderBy('id','DESC')->paginate(10);
        return view('pricing.index',compact('pricings'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
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
        return view('pricing.create',compact('plantype'));
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
            'amount' => 'required|numeric',
            'plan_type' => 'required'
        ]);
    
        $input = $request->all();
    
        $pricing = Pricing::create($input);
    
        return redirect()->route('pricing.index')
                        ->with('success','Pricing created successfully');
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
        $pricing = Pricing::find($id);
    
        return view('pricing.edit',compact('pricing','plantype'));
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
            'amount' => 'required|numeric',
            'plan_type' => 'required',
        ]);
    
        $input = $request->all();    

        $pricing = Pricing::find($id);
        $pricing->update($input);

        return redirect()->route('pricing.index')
                        ->with('success','Pricing updated successfully');

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
        Pricing::find($id)->delete();
        return redirect()->route('pricing.index')
                        ->with('success','Pricing deleted successfully');
    }
}
