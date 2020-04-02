@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Pricing</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Pricing</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col">

        <div class="card">
        <div class="card-header">
          <h3 class="card-title">Manage Pricings</h3>
          @can('pricing-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('pricing.create') }}">CREATE NEW</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
          <table id="pricing-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Amount</th>
              <th>Plan Type</th>
              <th>Action</th>                       
            </tr>
            </thead>
            <tbody> 
             @foreach ($pricings as $key => $price)
              <tr>
                <td>{{ $price->id }}</td>
                <td>{{ $price->amount }}</td>
                <td><i class="fas {{ ($price->plan_type == 'mobile') ? 'fa-mobile-alt' : 'fa-phone-alt' }}"></i>&nbsp;
                {{ ucwords($price->plan_type) }}</td>
                <td>
                  <!--  <a class="btn btn-info" href="{{ route('pricing.show',$price->id) }}">Show</a> -->
                  @can('pricing-edit')
                    <a class="btn" href="{{ route('pricing.edit',$price->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                  @endcan
                  @can('pricing-delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['pricing.destroy', $price->id],'style'=>'display:inline']) !!}
                        <button type="submit" class="btn" title="Delete"><i class="fas fa-trash"></i></button>
                    {!! Form::close() !!}
                  @endcan
                </td>
              </tr>
             @endforeach             
            </tbody>
            <tfoot>
            <tr>
               <th>#</th>
               <th>Amount</th>
               <th>Plan Type</th>
               <th>Action</th>                
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- <div class="col">&nbsp;</div> -->
    </div>
  </div>
</section> 
<!-- /.content -->

@endsection