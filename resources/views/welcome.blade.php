@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Telecom Sale And User Management</div>

                <div class="card-body text-center">
                    <img src="{{ asset('/image/logo.png') }}" alt=""/>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="text-center"> 
                <a href="https://laravel.com/docs">Powered by <strong>Emperorcom Technologies</strong></a></div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
@endsection