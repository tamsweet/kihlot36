
@include('admin.message')
<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ __('adminstaticword.Course') }}</h3>
        @if(Auth::user()->role == 'admin')
        <a class="btn btn-info btn-sm" href="{{url('course/create')}}">
          <i class="glyphicon glyphicon">+</i> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Course') }}
        </a>
        @endif

        @if(env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
          @if(Auth::user()->role == 'instructor')

            @php

              $instructor_plan = App\PlanSubscribe::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
              if(isset($instructor_plan))
              {
                $allowed_course = $instructor_plan->plans->courses_allowed;

                $total_course_count = App\Course::where('user_id', Auth::User()->id)->count();
              }

            @endphp
          @endif

        


          @if(Auth::user()->role == 'instructor')
            @if(isset($instructor_plan))
              @if($allowed_course > $total_course_count)

              
                <a class="btn btn-info btn-sm" href="{{url('course/create')}}">
                  <i class="glyphicon glyphicon">+</i> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Course') }}
                </a>
              @endif
            @else
              <div class="list-backup text-right">
                  <ul>
                    <li>
                        {{ __('Instructor Subscription is enabled on portal to add courses you have to buy Plans from your dashboard') }}
                    </li>
                          
                  </ul>

                  @if(Auth::User()->role == "instructor")
                  <h3 class="box-title text-right">{{ __('Subscribe Now') }}</h3>
                  <br>
                  <a target="_blank" class="btn btn-info btn-sm" href="{{ route('plan.page') }}"><li><i class="fas fa-user-tag"></i>{{ __('frontstaticword.InstructorPlan') }}</li></a>
                  @endif
              </div>
            @endif
          @endif
         




        @else

          @if(Auth::user()->role == 'instructor')
            <a class="btn btn-info btn-sm" href="{{url('course/create')}}">
              <i class="glyphicon glyphicon">+</i> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Course') }}
            </a>
          @endif

        @endif

        

      </div>
     
      <!-- /.box-header -->
      <div class="box-body"> 


        <?php $i=0;?>
        <div class="row">

        @if(Auth::User()->role == "admin")
          @foreach($course as $cat)

            
            <?php $i++;?>

              
            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-gray" 
                {{-- style="background: url('{{ url('images/course/'.$cat['preview_image']) }}') center center;" --}}
                >
                  <h3 class="widget-user-username">{{ $cat->title }}</h3>
                  <h5 class="widget-user-desc">@if(isset($cat->user)) {{ $cat->user['fname'] }} @endif</h5>
                </div>
                <div class="widget-user-image">
                  @if($cat['preview_image'] !== NULL && $cat['preview_image'] !== '')
                  <img class="img-circle" src="{{ url('images/course/'.$cat['preview_image']) }}" alt="User Avatar">
                  @else
                  <img class="img-circle" src="{{ Avatar::create($cat->title)->toBase64() }}" alt="User Avatar">
                  @endif
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Type <span class="pull-right">
                        @if($cat->type == '1')
                          Paid
                        @else
                          Free
                        @endif</span></a></li>
             

                    <li>
                      <td><a href="#">Featured<span class="pull-right">
                        <form action="{{ route('course.featured',$cat->id) }}" method="POST">
                          {{ csrf_field() }}
                          <button  type="Submit" class="btn btn-xs {{ $cat->featured ==1 ? 'bg-green' : 'bg-red' }}">
                            @if($cat->featured ==1)
                            {{ __('adminstaticword.Yes') }}
                            @else
                            {{ __('adminstaticword.No') }}
                            @endif
                          </button>
                        </form>
                      </span>
                      </a>
                      </td>
                    </li>

                     <li>
                      <td><a href="#">Status<span class="pull-right">
                         <form action="{{ route('course.quick',$cat->id) }}" method="POST">
                          {{ csrf_field() }}
                          <button  type="Submit" class="btn btn-xs {{ $cat->status ==1 ? 'btn-success' : 'btn-danger' }}">
                            @if($cat->status ==1)
                              {{ __('adminstaticword.Active') }}
                            @else
                              {{ __('adminstaticword.Deactive') }}
                            @endif
                          </button>
                        </form>
                      </span>
                      </a>
                      </td>
                    </li>
                    <li>

                    <div class="row">
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header"><a href="{{ route('course.show',$cat->id) }}">
                          <i class="fa fa-edit"></i>
                          </h5>
                          <span class="description-text">Edit</span>
                          </a>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header"><a>
                      {{-- <i class="fa fa-fw fa-trash-o"></i> --}}
                    
                          <span class="description-text"><form  method="post" action="{{url('course/'.$cat->id)}}
                                  "data-parsley-validate class="form-horizontal form-label-left">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                  <button class="course-delete" onclick="return confirm('Are you sure you want to delete?')"  type="submit" ><i class="fa fa-fw fa-trash-o"></i></button>
                                </form>
                              </h5>Delete</span>
                              </a>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4">
                        <div class="description-block">
                          <h5 class="description-header"><a target="_blank" href="{{ route('user.course.show',['id' => $cat->id, 'slug' => $cat->slug ]) }}"><i class="fa fa-paper-plane"></i></h5>
                          <span class="description-text">View</span>
                          </a>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                    </div>
                  </li>


                  </ul>
                </div>
              </div>
              <!-- /.widget-user -->
            </div>

           

            


              
          @endforeach
             <hr>

             <div class="col-xs-12">

              <div class="pull-right">
                {!! $course->render() !!}
              </div>
            </div>


        @else

          @php
                      
                      
            $cors = App\Course::where('user_id', Auth::User()->id)->get();
          @endphp
                  
         
          @foreach($cors as $cor)

            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-gray" 
                {{-- style="background: url('{{ url('images/course/'.$cat['preview_image']) }}') center center;" --}}
                >
                  <h3 class="widget-user-username">{{ $cor->title }}</h3>
                  <h5 class="widget-user-desc">@if(isset($cor->user)) {{ $cor->user['fname'] }} @endif</h5>
                </div>
                <div class="widget-user-image">
                  @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
                  <img class="img-circle" src="{{ url('images/course/'.$cor['preview_image']) }}" alt="User Avatar">
                  @else
                  <img class="img-circle" src="{{ Avatar::create($cor->title)->toBase64() }}" alt="User Avatar">
                  @endif
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Type <span class="pull-right button bg-yellow">
                        @if($cor->type == '1')
                          Paid
                        @else
                          Free
                        @endif</span></a></li>
             

                    <li>
                      <td><a href="#">Featured<span class="pull-right">
                       
                            @if($cor->featured ==1)
                            {{ __('adminstaticword.Yes') }}
                            @else
                            {{ __('adminstaticword.No') }}
                            @endif
                          
                      </span>
                      </a>
                      </td>
                    </li>

                     <li>
                      <td><a href="#">Status<span class="pull-right">
                         
                            @if($cor->status ==1)
                              {{ __('adminstaticword.Active') }}
                            @else
                              {{ __('adminstaticword.Deactive') }}
                            @endif
                        </form>
                      </span>
                      </a>
                      </td>
                    </li>
                    <li>

                    <div class="row">
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header"><a href="{{ route('course.show',$cor->id) }}">
                          <i class="fa fa-edit"></i>
                          </h5>
                          <span class="description-text">Edit</span>
                          </a>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header"><a>
                      {{-- <i class="fa fa-fw fa-trash-o"></i> --}}
                    
                          <span class="description-text"><form  method="post" action="{{url('course/'.$cor->id)}}
                                  "data-parsley-validate class="form-horizontal form-label-left">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                  <button class="course-delete" onclick="return confirm('Are you sure you want to delete?')"  type="submit" ><i class="fa fa-fw fa-trash-o"></i></button>
                                </form>
                              </h5>Delete</span>
                              </a>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4">
                        <div class="description-block">
                          <h5 class="description-header"><a target="_blank" href="{{ route('user.course.show',['id' => $cor->id, 'slug' => $cor->slug ]) }}"><i class="fa fa-paper-plane"></i></h5>
                          <span class="description-text">View</span>
                          </a>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                    </div>
                  </li>


                  </ul>
                </div>
              </div>
              <!-- /.widget-user -->
            </div>

          @endforeach


        @endif




        </div>

        
      </div>
              
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
