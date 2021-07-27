@extends('admin/layouts.master')
@section('title', 'Edit Course - Admin')
@section('body')

<div class="box">
  <div class="box-header">
    <h3 >{{$cor->title }}</h3>
  </div>
  <div class="box-body">
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  </div>    
</div>

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">

        <div class="content-header">
        </div>
        <div class="box-body">
          <div class="nav-tabs-custom">
            <div class="row">
              <div class="col-md-2">
                 <ul class="nav nav-stacked" id="nav-tab" role="tablist">

              @php
                $involvement = App\Involvement::firstWhere(['user_id' => Auth::user()->id,'course_id' => $cor->id]);

              @endphp

              @if(isset($involvement))

                <li  class="active"  role="presentation"><a href="#d" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.CourseChapter') }}</a></li>
                <li  class=""  role="presentation"><a href="#e" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.CourseClass') }}</a></li>

              @else
              <li role="presentation" class="active"><a href="#a" aria-controls="home" role="tab" data-toggle="tab">{{ __('adminstaticword.Course') }}</a></li>
              <li class=""  role="presentation"><a href="#b" aria-controls="profile" role="tab" data-toggle="tab">{{ __('adminstaticword.CourseInclude') }}</a></li>
              <li  class=""  role="presentation"><a href="#c" aria-controls="messages" role="tab" data-toggle="tab">{{ __('adminstaticword.WhatLearns') }}</a></li>
              <li  class=""  role="presentation"><a href="#d" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.CourseChapter') }}</a></li>
              <li  class=""  role="presentation"><a href="#e" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.CourseClass') }}</a></li>
              <li  class=""  role="presentation"><a href="#market" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.RelatedCourse') }}</a></li>
              <li  class=""  role="presentation"><a href="#copy" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.Question') }}</a></li>
              {{-- <li  class=""  role="presentation"><a href="#ans" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.Answer') }}</a></li> --}}
              <li  class=""  role="presentation"><a href="#jj" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.ReviewRating') }}</a></li>
              <li  class=""  role="presentation"><a href="#an" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.Announcement') }}</a></li>
              <li  class=""  role="presentation"><a href="#report" aria-controls="settings" role="tab" data-toggle="tab">{{ __('adminstaticword.ReviewReport') }}</a></li>
              <li  class=""  role="presentation"><a href="#topic" aria-controls="topic" role="tab" data-toggle="tab">{{ __('adminstaticword.QuizTopic') }}</a></li>
             
              @if($gsetting->appointment_enable == 1)
              <li  class=""  role="presentation"><a href="#appoint" aria-controls="Appointment" role="tab" data-toggle="tab">{{ __('adminstaticword.Appointment') }}</a></li>
              @endif

              <li  class=""  role="presentation"><a href="#paper" aria-controls="topic" role="tab" data-toggle="tab">{{ __('adminstaticword.PreviousPaper') }}</a></li>


              
              @endif
           
            </ul>
              </div>
              <div class="col-md-10">
                <div class="tab-content">

              @if(isset($involvement))
                <div role="tabpanel" class="fade tab-pane in active" id="d">
                  @include('admin.course.coursechapter.index')
                </div>
                <div role="tabpanel" class="fade tab-pane" id="e">
                  @include('admin.course.courseclass.index')
                </div>
              @else
              <div role="tabpanel" class="tab-pane fade in active" id="a">
                @include('admin.course.editcor')
              </div>
              <div role="tabpanel" class="tab-pane fade" id="b">
                @include('admin.course.courseinclude.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="c">
                @include('admin.course.whatlearns.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="d">
                @include('admin.course.coursechapter.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="e">
                @include('admin.course.courseclass.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="market">
                @include('admin.course.relatedcourse.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="copy">
                @include('admin.course.questionanswer.index')
              </div>
              {{-- <div role="tabpanel" class="fade tab-pane" id="ans">
                @include('admin.course.answer.index')
              </div> --}}
              <div role="tabpanel" class="fade tab-pane" id="jj">
                @include('admin.course.reviewrating.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="an">
                @include('admin.course.announsment.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="report">
                @include('admin.course.reviewreport.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="topic">
                @include('admin.course.quiztopic.index')
              </div>
             
              <div role="tabpanel" class="fade tab-pane" id="appoint">
                @include('admin.course.appointment.index')
              </div>

              <div role="tabpanel" class="fade tab-pane" id="paper">
                @include('admin.course.previous_paper.index')
              </div>

              @endif


             
            </div>
                
              </div>
            </div>
            <!-- Nav tabs -->
           

            <!-- Tab panes -->
            

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection


@section('script')


<script type="text/javascript">
  
  <script>
    
    $( "#sortable" ).sortable({
      items: "tr",
      cursor: 'move',
      opacity: 0.6,
      update: function() {
          sendOrderToServer();
      }
    });

    function sendOrderToServer() {

      var order = [];
      var token = $('meta[name="csrf-token"]').attr('content');
      $('tr.row1').each(function(index,element) {
        order.push({
          id: $(this).attr('data-id'),
          position: index+1
        });
      });

      $.ajax({
        type: "POST", 
        dataType: "json", 
        url: "{{ route('class-sort') }}",
        data: {
           order: order,
          _token: "{{ csrf_token() }}",
        },
        success: function(response) {
            if (response.status == "success") {
              console.log(response);
            } else {
              console.log(response);
            }
        }
      });
    }
</script>


</script>

<script>
(function($) {
"use strict";
  $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#nav-tab a[href="' + activeTab + '"]').tab('show');
    }
  });
})(jQuery);
</script>

@endsection
  