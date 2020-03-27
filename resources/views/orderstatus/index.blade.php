@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Order Status</h2>
            </div>
            <div class="pull-right">
                @can('orderstatus-create')
                <a class="btn btn-success" href="{{ route('orderstatus.create') }}"> Create New Order Status</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($orderstatus as $status)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ ucwords(str_replace("_"," ",$status->name)) }}</td>
	        <td>
                <form action="{{ route('orderstatus.destroy',$status->id) }}" method="POST">
                    @can('orderstatus-edit')
                    <a class="btn btn-primary" href="{{ route('orderstatus.edit',$status->id) }}">Edit</a>
                    @endcan

                    @csrf
                   <!--  @method('DELETE')
                    @can('orderstatus-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan -->
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

    {!! $orderstatus->render() !!}

@endsection