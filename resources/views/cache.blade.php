@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Cache</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Cache</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="error-page">
    <h2 class="headline text-danger">304</h2>

    <div class="error-content">
      <h3><i class="fas fa-exclamation-triangle text-danger"></i> Cache is cleared !</h3>
      <p>
        You have cleared the application cache by calling the URL in the browser. Many times you face an issue that any changes to the application are not reflecting on web interfaces.
      </p>

    </div>
  </div>
  <!-- /.error-page -->

</section>
<!-- /.content -->


@endsection