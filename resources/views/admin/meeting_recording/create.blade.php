@extends('admin/layouts.master')
@section('title', 'Add Recordings - Admin')
@section('body')

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif


<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-10">
              <h3 class="box-title"> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.MeetingRecordings') }}</h3>
            </div>
            <div  class="col-md-2">
                <div><h4 class="admin-form-text"><a href="{{url('meeting-recordings')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons"><button class="btn btn-xs btn-success abc"> << {{ __('adminstaticword.Back') }}</button> </i></a></h4></div>
            </div>
          </div>
        </div>
         
        <div class="box-body">
          <div class="form-group">
            <form action="{{url('meeting-recordings/')}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }} 

              

              	<div class="row">
                <div class="col-md-6">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}:<sup class="redstar">*</sup></label>
                  <input class="form-control" type="text" name="title" placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Title') }}">
                </div>
                <div class="col-md-6">
                  <label for="exampleInputSlug">{{ __('adminstaticword.Add') }} {{ __('adminstaticword.Meeting') }} {{ __('adminstaticword.URL') }}:<sup class="redstar">*</sup></label>
                  <input type="slug" class="form-control" name="url" id="exampleInputPassword1" placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.URL') }}">
                </div>
              </div>
              <br>
             

              <div class="box-footer">
                <button type="submit" class="btn btn-lg col-md-4 btn-primary">{{ __('adminstaticword.Submit') }}</button>
              </div>

            </form>
          </div>
        </div>
        <!-- /.box -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- /.row -->
</section> 

@endsection
