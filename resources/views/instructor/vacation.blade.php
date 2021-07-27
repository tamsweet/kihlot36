@extends('admin.layouts.master')
@section('title', 'Vacation - Admin')
@section('body')
 
<section class="content">
   @include('admin.message')
	<div class="row">
        <div class="col-xs-12">
        	<div class="box box-primary">
	           	<div class="box-header with-border">
              	<h3 class="box-title">{{ __('Update Vacation Dates') }}</h3>
           		</div>
	          	<div class="panel-body">
	          		<form action="{{ action('VacationController@update') }}" method="POST" enctype="multipart/form-data">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}
		                
		              	<div class="row">
		                  <div class="col-md-6">
		                    <label for="icon">{{ __('Start Time') }}<sup class="redstar">*</sup></label>
		                    <div class='input-group date' id='datetimepicker1'>
	                          <input name="vacation_start" type='text' class="form-control" value="{{ isset(Auth::user()['vacation_start']) ? date('d-m-Y | h:i:s A',strtotime(Auth::user()['vacation_start'])) : "" }}"/>
	                          <span class="input-group-addon">
	                              <span class="glyphicon glyphicon-calendar"></span>
	                          </span>
	                        </div>

		                  </div>
		              	
		                  <div class="col-md-6">
		                    <label for="currency">{{ __('End Time') }}<sup class="redstar">*</sup></label>
		                   	<div class='input-group date' id='datetimepicker2'>
	                          <input name="vacation_end" type='text' class="form-control" value="{{ isset(Auth::user()['vacation_end']) ? date('d-m-Y | h:i:s A',strtotime(Auth::user()['vacation_end'])) : "" }}"/>
	                          <span class="input-group-addon">
	                              <span class="glyphicon glyphicon-calendar"></span>
	                          </span>
	                        </div>
		                  </div>
		              	</div>
		              	<br>
						<div class="box-footer">
		              		<button value="" type="submit"  class="btn btn-md col-md-1 btn-primary">{{ __('adminstaticword.Save') }}</button>
		              	</div>

		              	

		          	</form>
	          	</div>
	      	</div>
      	</div>
  	</div>
</section>
@endsection


@section('script')

<script>
	 $('#datetimepicker1').datetimepicker({
	    format: 'YYYY-MM-DD H:m:s',
	  });

	  $('#datetimepicker2').datetimepicker({
	    format: 'YYYY-MM-DD H:m:s',
	  });

	
</script>

@endsection


