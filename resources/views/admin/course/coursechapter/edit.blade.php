@extends('admin/layouts.master')
@section('title', 'Edit Chapter - Admin')
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
    <div class="col-xs-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('adminstaticword.EditCourseChapter') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
          <div class="form-group">
            <form id="demo-form" method="post" action="{{url('coursechapter/'.$cate->id)}}"data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('PUT') }}

              <label class="display-none" for="exampleInputSlug">{{ __('adminstaticword.SelectCourse') }}</label>
              <select name="course_id" class="form-control col-md-7 col-xs-12 display-none">
                @foreach($courses as $cou)
                  <option value="{{ $cou->id }}" {{$cate->courses->id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
                @endforeach
              </select>


              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Name') }}:<span class="redstar">*</span></label>
                  <input type="" class="form-control" name="chapter_name" id="exampleInputTitle" value="{{$cate->chapter_name}}">
                  <br>
                </div>


                <div class="col-md-12">
                  
                    <label for="exampleInputDetails">{{ __('adminstaticword.LearningMaterial') }}</label> - <p class="inline info">eg: zip or pdf files</p>
                    <br>
                    <input type="file" name="file" value="{{ $cate->file }}" id="file" class="{{ $errors->has('file') ? ' is-invalid' : '' }} inputfile inputfile-1"/>
                    <label for="file"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>{{ __('adminstaticword.Chooseafile') }}</span></label>
                    <span class="text-danger invalid-feedback" role="alert"></span>

                    <input disabled class="form-control" value="{{$cate->file}}">
                  
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
                   <li class="tg-list-item">              
                    <input class="tgl tgl-skewed" id="status" type="checkbox" name="status" {{ $cate->status == '1' ? 'checked' : '' }} >
                    <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="status"></label>
                  </li>
                  <input type="hidden"  name="free" value="0" for="status" id="status">
                </div>
              </div>
              <br>


              @if($cate->courses->drip_enable == 1)
                <hr>
                
                <div class="row"> 
                  <div class="col-md-6">
                    <label  for="married_status">{{ __('Drip Content Type') }}: </label>
                    <select class="form-control js-example-basic-single" id="drip_type" name="drip_type">
                      <option value="" selected hidden> 
                        {{ __('Select an Option ') }}
                      </option>
                      <option value="date" {{ $cate->drip_type == 'date' ? 'selected' : ''}}>{{ __('Specific Date') }}</option>
                      <option value="days" {{ $cate->drip_type == 'days' ? 'selected' : ''}}>{{ __('Days After Enrollment') }}</option>
                    </select>
                    <br>
                  </div>

                  <div class="col-md-6" @if($cate->drip_type == 'days' || $cate->drip_type == NULL) style="display: none;" @endif id="dripdate">
                    <label>{{ __('Specific Date') }} :</label>
                    <input type="text" id="date_specific1" class="form-control"  name="drip_date" value="{{$cate->drip_date}}">
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('When section should be unlock') }}.</small>
                  </div>

                  <div class="col-md-6" @if($cate->drip_type == 'date' || $cate->drip_type == NULL) style="display: none;" @endif id="dripdays">
                    <label>{{ __('Days After Enrollment') }} :</label>
                    <input type="number" min="1" class="form-control" name="drip_days" value="{{$cate->drip_days}}">
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Enter days') }}.</small>
                  </div>
                </div>
                <br>

                @endif
                <br>



              <div class="box-footer">
                <button type="submit" class="btn btn-md col-md-3 btn-primary">{{ __('adminstaticword.Save') }}</button>
              </div>
            </form>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (right) -->
  </div>
  <!-- /.row -->
</section> 

@endsection


@section('script')

<script>
  $( "#date_specific1" ).datepicker({ minDate: 0});
</script>

<script>
  
  $('#drip_type').change(function() {
      
    if($(this).val() == 'date')
    {
      $('#dripdate').show();
      $("input[name='drip_date']").attr('required','required');
    }
    else
    {
      $('#dripdate').hide();
    }

    if($(this).val() == 'days')
    {
      $('#dripdays').show();
      $("input[name='drip_days']").attr('required','required');
    }
    else
    {
      $('#dripdays').hide();
    }


  });

</script>


@endsection