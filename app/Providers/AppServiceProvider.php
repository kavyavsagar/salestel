<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);



        //compose all the views....
        view()->composer('*', function ($view) 
        {   
            $data = [];
            if(isset(auth()->user()->id)){
                $todo = DB::table('tasks AS t')
                    ->select('t.id', 't.description')
                    ->where('t.status','=', 1)
                    ->whereDate('t.start_date', Carbon::today())
                    ->where('t.assigned_by','=', auth()->user()->id)
                    ->get();
                $data['task'] = $todo;

                $dsr = DB::table('dsrs AS d')
                    ->select('d.id', 'd.company', 'd.phone', 'd.reminder_date')                    
                    ->whereDate('d.reminder_date', Carbon::today())
                    ->where('d.refferedby','=', auth()->user()->id)
                    ->get();

                $data['dsr'] = $dsr;
            }

            //...with this variable
            $view->with('todo', $data );    
        });  
    }
}        