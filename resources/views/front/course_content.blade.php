@extends('theme.master')
@section('title', "$course->title")
@section('content')

@include('admin.message')

@include('sweetalert::alert')
<!-- courses content header start -->
<section id="class-nav" class="class-nav-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-12">
               
                <div class="class-nav-heading">{{ $course->title }}</div>
            </div>
            <div class="col-lg-5 col-md-6 col-12">
                <div class="class-button certificate-button">
                    <ul>
                        @if($gsetting->certificate_enable == 1)
                        @if($course->certificate_enable == 1)
                        <li>
                            <div class="dropdown">
                                @if(!empty($progress))
                                    <?php
                                    $total_class = $progress->all_chapter_id;
                                    $total_count = count($total_class);

                                    $total_per = 100;

                                    $read_class = $progress->mark_chapter_id;
                                    $read_count =  count($read_class);

                                    $progres = ($read_count/$total_count) * 100;
                                    ?>

                                @endif
                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-trophy"></i>&nbsp; {{ __('frontstaticword.GetCertificate') }}
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @if(!empty($progress))
                                <a class="dropdown-item"> 
                                    {{ $read_count }} {{ __('frontstaticword.of') }} {{ $total_count }}  {{ __('frontstaticword.complete') }}
                                </a>
                                @else
                                <a class="dropdown-item"> 
                                    0 of 
                                    @php
                                        $data = App\CourseChapter::where('course_id', $course->id)->get();
                                        if(count($data)>0){

                                            echo count($data);
                                        }
                                        else{

                                            echo "0";
                                        }
                                    @endphp 
                                    complete 
                                </a>
                                @endif
                                @if(!empty($progress))
                                    @if($read_count == $total_count)
                                    <div class="about-home-btn">
                                        
                                        <a href="{{ route('cirtificate.show', encrypt($course->id)) }}" class="btn btn-secondary" href="#">Get Certificate</a>
                                    </div>
                                    @endif
                                @endif
                              </div>
                            </div>
                        </li>
                        @endif
                        @endif
                        <li>
                            <a href="{{ route('user.course.show',['id' => $course->id, 'slug' => $course->slug ]) }}" class="course_btn"> {{ __('frontstaticword.Coursedetails') }} <i class="fa fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="learning-courses-home" class="learning-courses-home-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="learning-courses-home-video text-white btm-30">
                    <div class="video-item hidden-xs">
                        <div class="video-device">
                            @if($course['preview_image'] !== NULL && $course['preview_image'] !== '')
                                <img src="{{ asset('images/course/'.$course->preview_image) }}" class="img-fluid" alt="Background">
                            @else
                                <img src="{{ Avatar::create($course->title)->toBase64() }}" class="bg_img img-fluid" alt="Background">
                            @endif
                            <div class="video-preview">
                                @php
                                    //if empty 
                                    $z = 0;
                                    $items = App\CourseClass::where('course_id', $course->id)->first();
                                    $coursewatch = App\WatchCourse::where('course_id','=',$course->id)->where('user_id', Auth::User()->id)->first();
                                    if(isset($coursewatch['active']) == 0){
                                        $z = 0;    
                                    }else{
                                        $z = 1;
                                    }
                                
                                @endphp

                               
                                @if(isset($items))
                                    @if(isset($course->chapter[0]->courseclass[0]))

                                    @if($course->chapter[0]->courseclass[0]->type == "video" || $course->chapter[0]->courseclass[0]->type == "audio") 
                                    @if(isset($course->chapter[0]->courseclass[0])) 
                                        @if($course->chapter[0]->courseclass[0]->iframe_url == NULL)
                                            
                                            <a href="{{ route('watchcourse',$course->id) }}" class="btn-video-play @if($z == 0)iframe @endif"><i class="fa fa-play"></i></a>
                                        @else
                                       
                                            @php
                                                $url = Crypt::encrypt($course->chapter[0]->courseclass[0]->iframe_url);
                                            @endphp
                                            <a href="{{ route('watchinframe',[$url, 'course_id' => $course->id]) }}" class="btn-video-play"><i class="fa fa-play"></i></a>
                                        @endif
                                    @else
                                        <a href="{{ route('watchcourse',$course->id) }}" class="btn-video-play @if($z == 0)iframe @endif"><i class="fa fa-play"></i></a>
                                    @endif
                                    @endif
                                    @endif
                                @endif

                            
                             
                                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="learning-courses-home-block">
                    <h3 class="learning-courses-home-heading btm-20"><a href="{{ route('user.course.show',['id' => $course->id, 'slug' => $course->slug ]) }}" title="heading">{{ $course->title }}</a></h3>
                    <div class="learning-courses btm-20 display-inline">{{ $course->user->fname }}</div>

                    @if($course->user->vacation_start == !NULL)
                    <span class="vacation-days text-white">(On Vacation)
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" data-html="true" title="{{ date('d-m-Y | h:i:s A',strtotime($course->user->vacation_start)) }} to {{ date('d-m-Y | h:i:s A',strtotime($course->user->vacation_end)) }}"><i class="fas fa-info-circle"></i></button>

                    </span>)
                    @endif
                    <br>

                    <div class="learning-courses btm-20">{{ $course->short_detail }}</div>

                    @if(!empty($progress))
                        <?php
                        $total_class = $progress->all_chapter_id;
                        $total_count = count($total_class);

                        $total_per = 100;

                        $read_class = $progress->mark_chapter_id;
                        $read_count =  count($read_class);

                        $progres = ($read_count/$total_count) * 100;
                        ?>
    
                    <div class="progress-block">
                        <div class="one histo-rate">
                            <span class="bar-block" style="width: 100%">
                                <span id="bar-one" style="width: <?php echo $progres; ?>%" class="bar bar-clr bar-radius">&nbsp;</span> 
                            </span>
                        </div>
                        <i class="fa fa-trophy lft-7"></i>
                    </div>
                    @else
                    <div class="progress-block">
                        <div class="one histo-rate">
                            <span class="bar-block" style="width: 100%">
                                <span id="bar-one" style="width: 0%" class="bar bar-clr bar-radius">&nbsp;</span> 
                            </span>
                        </div>
                        <i class="fa fa-trophy lft-7"></i>
                    </div>
                    @endif
                    
                    @if(isset($items))
                        @if(isset($course->chapter[0]->courseclass[0]))
                        @if($course->chapter[0]->courseclass[0]->type == "video" || $course->chapter[0]->courseclass[0]->type == "audio")
                        @if(isset($course->chapter[0]->courseclass[0]))
                            @if($course->chapter[0]->courseclass[0]->iframe_url == NULL)
                            <div class="learning-courses-home-btn">
                                <a href="{{ route('watchcourse',$course->id) }}" class="@if($z == 0)iframe @endif btn btn-primary" title="Continue">{{ __('frontstaticword.ContinuetoLecture') }}</a>
                            </div>
                            @else
                            <div class="learning-courses-home-btn">
                                @php
                                    $url = Crypt::encrypt($course->chapter[0]->courseclass[0]->iframe_url);
                                @endphp
                                <a href="{{ route('watchinframe',[$url, 'course_id' => $course->id]) }}" class="btn btn-primary" title="Continue">{{ __('frontstaticword.ContinuetoLecture') }}</a>
                            </div>
                            @endif
                        @else
                            <div class="learning-courses-home-btn">
                                <a href="{{ route('watchcourse',$course->id) }}" class="@if($z == 0)iframe @endif btn btn-primary" title="Continue">{{ __('frontstaticword.ContinuetoLecture') }}</a>
                            </div>
                        @endif
                        @endif
                        @endif
                    @endif


                </div>
            </div>
        </div>
    </div>
</section>
<!-- courses content header end -->
<!-- courses-content start -->
<section id="learning-courses" class="learning-courses-about-main-block">
    <div class="container">
        <div class="about-block">
           
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">

                    <a class="nav-item nav-link active text-center" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{ __('frontstaticword.Overview') }}</a>

                    <a class="nav-item nav-link text-center" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">{{ __('frontstaticword.CourseContent') }}</a>

                    <a class="nav-item nav-link text-center" id="nav-live-tab" data-toggle="tab" href="#nav-live" role="tab" aria-controls="nav-live" aria-selected="false">{{ __('frontstaticword.LiveClass') }}</a>

                    <a class="nav-item nav-link text-center" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">{{ __('frontstaticword.Q&A') }}</a>

                    @if(count($announsments) > 0)
                    <a class="nav-item nav-link text-center" id="nav-announcement-tab" data-toggle="tab" href="#nav-announcement" role="tab" aria-controls="nav-announcement" aria-selected="false">{{ __('frontstaticword.Announcements') }}</a>
                    @endif


                    <a class="nav-item nav-link text-center" id="nav-quiz-tab" data-toggle="tab" href="#nav-quiz" role="tab" aria-controls="nav-quiz" aria-selected="false">{{ __('frontstaticword.Quiz') }}</a>

                    @if($gsetting->assignment_enable == 1)
                    @if($course->assignment_enable == 1)
                    <a class="nav-item nav-link text-center" id="nav-assign-tab" data-toggle="tab" href="#nav-assign" role="tab" aria-controls="nav-assign" aria-selected="false">{{ __('frontstaticword.Assignment') }}</a>
                    @endif
                    @endif
                    
                    @if($gsetting->appointment_enable == 1)
                    @if($course->appointment_enable == 1)
                    <a class="nav-item nav-link text-center" id="nav-appoint-tab" data-toggle="tab" href="#nav-appoint" role="tab" aria-controls="nav-appoint" aria-selected="false">{{ __('frontstaticword.Appointment') }}</a>
                    @endif
                    @endif

                    @if(count($papers) > 0)
                    <a class="nav-item nav-link text-center" id="nav-paper-tab" data-toggle="tab" href="#nav-paper" role="tab" aria-controls="nav-paper" aria-selected="false">{{ __('frontstaticword.PreviousPapers') }}</a>
                    @endif

                </div>
            </nav>
               
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="overview-block">
                        <h4>{{ __('frontstaticword.RecentActivity') }}</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="learning-questions-block btm-40">
                                    <h5 class="learning-questions-heading">{{ __('frontstaticword.RecentQuestions') }}</h5>

                                    @if($coursequestions->isEmpty())
                                        <div class="learning-questions-content text-center">
                                            <h3 class="text-center">{{ __('frontstaticword.No') }} {{ __('frontstaticword.RecentQuestions') }}</h3>
                                        </div>
                                    @else
                                        @php
                                            $questions = App\Question::where('course_id', $course->id)->orderBy('created_at','desc')->limit(2)->get();
                                        @endphp
                                        @foreach($questions as $question)
                                        <div class="learning-questions-dtl-block">
                                            <div class="learning-questions-img rgt-20">{{ str_limit($question->user->fname, $limit = 1, $end = '') }}{{ str_limit($question->user->lname, $limit = 1, $end = '') }}</div>
                                            <div class="learning-questions-dtl">{!! $question->question !!}
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                    <div class="learning-questions-heading"><a href="#" id="goTab4" title="browse">{{ __('frontstaticword.Browsequestions') }}</a>
                                    </div>
                                </div>
                            </div>
                            @if(count($announsments) > 0)
                            <div class="col-lg-6">
                                <div class="learning-questions-block btm-40">
                                    <h5 class="learning-questions-heading">{{ __('frontstaticword.RecentAnnouncements') }}</h5>
                                    @if($announsments->isEmpty())
                                        <div class="learning-questions-content text-center">
                                            <h3 class="text-center">{{ __('frontstaticword.No') }} {{ __('frontstaticword.RecentAnnouncements') }}</h3>
                                        </div>
                                    @else
                                        <div id="accordion" class="second-accordion">
                                        @foreach($announsments->take(2) as $announsment)
                                        <div class="card">
                                            <div class="card-header" id="headingFour{{ $announsment->id }}">
                                                <div class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour{{ $announsment->id }}" aria-expanded="true" aria-controls="collapseFour">
                                                        <div class="learning-questions-img rgt-20">{{ str_limit($announsment->user->fname, $limit = 1, $end = '') }}{{ str_limit($announsment->user->lname, $limit = 1, $end = '') }}
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="section"><a href="#" title="questions">{{ $course->user->fname }} {{ $announsment->user->lname }}</a> <a href="#" title="questions">{{ date('jS F Y', strtotime($announsment->created_at)) }}</a></div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="section-dividation text-right">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 offset-3 col-9 offset-sm-0"> 
                                                                <div class="profile-heading">{{ __('frontstaticword.Announcements') }}</div>
                                                            </div>
                                                            
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="collapseFour{{ $announsment->id }}" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                               
                                                <div class="card-body">
                                                    <p class="announsment-text">{!! $announsment->announsment !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        </div>
                                    @endif
                                    <div class="learning-questions-heading"><a id="goTab5" href="" title="browse">{{ __('frontstaticword.Browseannouncements') }}</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="content-course-block">
                            <h4 class="content-course">{{ __('frontstaticword.Aboutthiscourse') }}</h4>
                            <p class="btm-40">{{ $course->short_detail }}</p>
                        </div>
                        <hr>
                        <div class="content-course-number-block">
                            <div class="row">
                                <div class="col-lg-3 col-sm-4">
                                    <div class="content-course-number">{{ __('frontstaticword.Bythenumbers') }}</div>
                                </div>
                                <div class="col-lg-6 col-sm-5">
                                    <div class="content-course-number">
                                        <ul>
                                            <li>{{ __('frontstaticword.studentsenrolled') }}: 
                                                @php
                                                    $data = App\Order::where('course_id', $course->id)->get();
                                                    if(count($data)>0){

                                                        echo count($data);
                                                    }
                                                    else{

                                                        echo "0";
                                                    }
                                                @endphp
                                            </li>
                                            @if($course->language_id == !NULL)
                                            @if(isset($course->language))
                                            <li>{{ __('frontstaticword.Languages') }}: {{ $course->language->name }}</li>
                                            @endif
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3">
                                    <div class="content-course-number">
                                        <ul>
                                            <li>{{ __('frontstaticword.Classes') }}:
                                                @php
                                                    $data = App\CourseClass::where('course_id', $course->id)->get();
                                                    if(count($data)>0){

                                                        echo count($data);
                                                    }
                                                    else{

                                                        echo "0";
                                                    }
                                                @endphp
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="content-course-number">{{ __('frontstaticword.Description') }}</div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="content-course-number content-course-one">
                                        <h5 class="content-course-number-heading">{{ __('frontstaticword.Aboutthiscourse') }}</h5>
                                        <p>{{ $course->short_detail }}<p>
                                        <h5 class="content-course-number-heading">{{ __('frontstaticword.Description') }}</h5>
                                        <p>{!! $course->detail !!}<p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-sm-3">
                                    <div class="content-course-number">{{ __('frontstaticword.Instructor') }}</div>
                                </div>
                                <div class="col-lg-9 col-sm-9">
                                    <div class="content-course-number content-course-number-one">
                                        <div class="content-img-block btm-20">
                                            <div class="content-img">
                                                @php
                                                $fullname = $course->user['fname'] . ' ' . $course->user['lname'];
                                                $fullname = preg_replace('/\s+/', '', $fullname);
                                                @endphp

                                                @if($course->user->user_img != null || $course->user->user_img !='')
                                                  <a href="{{ route('instructor.profile', ['id' => $course->user->id, 'name' => $fullname] ) }}" title="profile"><img src="{{ asset('images/user_img/'.$course->user->user_img) }}" class="img-fluid"  alt="instructor" ></a>
                                                @else
                                                    <a href="{{ route('instructor.profile', ['id' => $course->user->id, 'name' => $fullname] ) }}" title="profile"><img src="{{ asset('images/default/user.jpg')}}" class="img-fluid" alt="instructor"></a>
                                                @endif
                                            </div>
                                            <div class="content-img-dtl">
                                                <div class="profile"><a href="{{ route('instructor.profile', ['id' => $course->user->id, 'name' => $fullname] ) }}" title="profile">{{ $course->user->fname }} {{ $course->user->lname }}
                                                </a></div>
                                                <p>{{ $course->user->email }}</p>
                                            </div>
                                        </div>
                                        <ul>
                                            @if($course->user->twitter_url != NULL)
                                            <li class="rgt-10"><a href="{{ $course->user['twitter_url'] }}" target="_blank" title="twitter"><i class="fab fa-twitter"></i></a></li>
                                            @endif
                                            @if($course->user->fb_url != NULL)
                                            <li class="rgt-10"><a href="{{ $course->user['fb_url'] }}" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
                                            @endif
                                            @if($course->user->linkedin_url != NULL)
                                            <li class="rgt-10"><a href="{{ $course->user['linkedin_url'] }}" target="_blank" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
                                            @endif
                                            @if($course->user->youtube_url != NULL)
                                            <li class="rgt-10"><a href="{{ $course->user['youtube_url'] }}" target="_blank" title="twitter"><i class="fa fa-youtube"></i></a></li>
                                            @endif

                                        </ul>
                                        <p>{!! $course->user->detail !!}<p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="profile-block">
                        <form  method="post" action="{{ action('CourseProgressController@checked', $course->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                            {{ csrf_field() }}
                        
                        <div id="ck-button">
                           <label>
                              <input type="checkbox" name="select-all" class="hidden" id="select-all" /><span>Select All</span>
                           </label>
                        </div>

                        @php
                            $today = Carbon\Carbon::now();
                        @endphp
                       
                        <div id="accordion" class="second-accordion">
                            <?php $i=0;?>
                            @foreach($coursechapters as $coursechapter )
                            <?php $i++;?>

                            @if(Auth::user()->role == "user" && $course->drip_enable == 1 && $coursechapter->drip_type != NULL)

                                @if($coursechapter->drip_type == 'date' && $coursechapter->drip_date != NULL)

                                    @if($today >= $coursechapter->drip_date)

                                        @include('include.course_chapter')

                                    @endif

                                @elseif($coursechapter->drip_type == 'days' && $coursechapter->drip_days != NULL)

                                    @php
                                        $order = App\Order::where('status', '1')->where('user_id', Auth::User()->id)->where('course_id', $course->id)->first();
                                        $days = $coursechapter->drip_days;
                                        $orderDate = optional($order)['created_at'];


                                        $bundle = App\Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

                                        $course_id = array();

                                        foreach($bundle as $b)
                                        {
                                           $bundle = App\BundleCourse::where('id', $b->bundle_id)->first();
                                            array_push($course_id, $bundle->course_id);
                                        }

                                        $course_id = array_values(array_filter($course_id));
                                        $course_id = array_flatten($course_id);

                                        if($orderDate != NULL){
                                            $startDate = date("Y-m-d", strtotime("$orderDate +$days days"));
                                        }
                                        elseif(isset($course_id) && in_array($course->id, $course_id)){
                                            $startDate = date("Y-m-d", strtotime("$bundle->created_at +$days days"));
                                        }

                                        
                                    @endphp

                                    @if($today >= $startDate)

                                        @include('include.course_chapter')

                                    @endif

                                @endif
                            @else

                                @include('include.course_chapter')

                            @endif
                            
                            @endforeach
                        </div>
                        
                        <div class="mark-read-button">
                            <button type="submit" class="btn btn-md btn-primary">
                                {{ __('frontstaticword.MarkasComplete') }}
                            </button>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-live" role="tabpanel" aria-labelledby="nav-live-tab">
                    {{-- <div class="profile-block"> --}}

                        <div id="about-product" class="about-product-main-block">
   

                        @auth

                        @php

                            $user_enrolled = App\Order::where('course_id', $course->id)->where('user_id', Auth::user()->id)->first();

                            $bundle = App\Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

                            $course_id = array();
                              

                            foreach($bundle as $b)
                            {
                             $bundle = App\BundleCourse::where('id', $b->bundle_id)->first();
                              array_push($course_id, $bundle->course_id);
                            }

                            $course_id = array_values(array_filter($course_id));

                            $course_id = array_flatten($course_id);

                        @endphp


                        @if( $user_enrolled != NULL || Auth::user()->role == 'admin' || isset($course_id) || in_array($course->id, $course_id))

                        @if( ! $bigblue->isEmpty() )

                        <div class="btm-30">
                            <h5>{{ __('frontstaticword.BigBlueMeetings') }}</h5>
                            <div class="faq-block">
                                <div class="faq-dtl">
                                    <div id="accordion" class="second-accordion">

                                    @foreach($bigblue as $bbl)
                                    @if($bbl->is_ended != 1)

                                    <div class="card btm-10">
                                        <div class="card-header" id="headingThree{{ $bbl->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree{{ $bbl->id }}" aria-expanded="false" aria-controls="collapseThree">

                                                    {{ $bbl['meetingname'] }}

                                                </button>
                                            </div>

                                        </div>
                                        <div id="collapseThree{{ $bbl->id }}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">

                                        <div class="card-body">
                                            <table class="table">
                                            <tbody>
                                                <td>
                                                  <ul>
                                                    <li><a href="#" title="about">{{ __('frontstaticword.Created') }}: @if(isset($bbl->user)) {{ $bbl->user['fname'] }} {{ $bbl->user['lname'] }} @endif</a></li>
                                                    <li><a href="#" title="about">{{ __('frontstaticword.StartAt') }}: {{ date('d-m-Y | h:i:s A',strtotime($bbl['start_time'])) }}</a></li>
                                                    <li class="comment more">
                                                       {!! $bbl->detail !!}
                                                    </li>

                                                    <li>
                                                        <a href="" data-toggle="modal" data-target="#myModalBBL" title="join" class="btn btn-light" title="course">{{ __('frontstaticword.JoinMeeting') }}</a>
                                                    </li>

                                                    <div class="modal fade" id="myModalBBL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">

                                                              <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.JoinMeeting') }}</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="box box-primary">
                                                              <div class="panel panel-sum">
                                                                <div class="modal-body">

                                                                    <form action="{{ route('bbl.api.join') }}" method="POST">
                                                                        @csrf

                                                                        <div class="form-group">
                                                                            <label>Meeting ID:</label>
                                                                            <input readonly="" type="text" name="meetingid" value="{{ $bbl['meetingid'] }}" class="form-control">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Your Name:</label>
                                                                            <input value="{{ old('name') }}" type="text" required="" name="name" placeholder="enter your name" class="form-control">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Meeting Password:</label>
                                                                            <input type="password" name="password" placeholder="enter meeting password" class="form-control" required="">
                                                                        </div>

                                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                                            {{ __('frontstaticword.JoinMeeting') }}
                                                                        </button>

                                                                    </form>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                    </div>

                                                  </ul>
                                                </td>

                                            </tbody>
                                            </table>
                                        </div>
                                       </div>
                                    </div>

                                    @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endif

                        @if( ! $meetings->isEmpty() )

                        <div class="btm-30">
                            <h5>{{ __('frontstaticword.ZoomMeetings') }}</h5>
                            <div class="faq-block">
                                <div class="faq-dtl">
                                    <div id="accordion" class="second-accordion">


                                    @foreach($meetings as $meeting)

                                    <div class="card btm-10">
                                        <div class="card-header" id="headingFour{{ $meeting->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour{{ $meeting->id }}" aria-expanded="false" aria-controls="collapseFour">

                                                    {{ $meeting['meeting_title'] }}

                                                </button>
                                            </div>

                                        </div>
                                        <div id="collapseFour{{ $meeting->id }}" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">

                                        <div class="card-body">
                                            <table class="table">
                                            <tbody>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <a href="#" title="about">{{ __('frontstaticword.Created') }}: @if(isset($meeting->user)) {{ $meeting->user['fname'] }} {{ $meeting->user['lname'] }} @endif </a>

                                                        </li>
                                                        <li>
                                                           <p>Meeting Owner: {{ $meeting->owner_id }}</p>
                                                        </li>
                                                        <li>
                                                           <p class="btm-10"><a herf="#">{{ __('frontstaticword.StartAt') }}: {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</a></p>
                                                        </li>
                                                        <li>
                                                             <a href="{{ $meeting->zoom_url }}" target="_blank" class="btn btn-light">{{ __('frontstaticword.JoinMeeting') }}</a>
                                                        </li>
                                                    </ul>

                                                </td>
                                            </tbody>
                                            </table>
                                        </div>
                                       </div>
                                    </div>
                                    @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                        {{-- googlemeeting start --}}
                        @if($gsetting->googlemeet_enable == '1')
                        @if( ! $googlemeetmeetings->isEmpty() )

                        <div class="btm-30">
                            <h5> Google Meetings</h5>
                            <div class="faq-block">
                                <div class="faq-dtl">
                                    <div id="accordion" class="second-accordion">


                                    @foreach($googlemeetmeetings as $meeting)



                                    <div class="card btm-10">
                                        <div class="card-header" id="headingFour{{ $meeting->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour{{ $meeting->id }}" aria-expanded="false" aria-controls="collapseFour">

                                                    {{ $meeting['meeting_title'] }}

                                                </button>
                                            </div>

                                        </div>
                                        <div id="collapseFour{{ $meeting->id }}" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">

                                        <div class="card-body">
                                            <table class="table">
                                            <tbody>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <a href="#" title="about">{{ __('frontstaticword.Created') }}: @if(isset($meeting->user)) {{ $meeting->user['fname'] }} {{ $meeting->user['lname'] }} @endif </a>

                                                        </li>
                                                        <li>
                                                           <p>Meeting Owner: {{ $meeting->owner_id }}</p>
                                                        </li>
                                                        <li>
                                                           <p class="btm-10"><a herf="#">{{ __('frontstaticword.StartAt') }}: {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</a></p>
                                                        </li>
                                                        <li>
                                                             <a href="{{ $meeting->meet_url }}" target="_blank" class="btn btn-light">{{ __('frontstaticword.JoinMeeting') }}</a>
                                                        </li>
                                                    </ul>

                                                </td>
                                            </tbody>
                                            </table>
                                        </div>
                                       </div>
                                    </div>
                                    @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                        {{-- googlemeeting end --}}

                        {{-- jitsi start --}}
                        @if($gsetting->jitsimeet_enable == '1')
                        @if( ! $jitsimeetings->isEmpty() )
                        <div class="btm-30">
                            <h5> Jitsi Meetings</h5>
                            <div class="faq-block">
                                <div class="faq-dtl">
                                    <div id="accordion" class="second-accordion">


                                    @foreach($jitsimeetings as $meeting)

                                    <div class="card btm-10">
                                        <div class="card-header" id="headingFour{{ $meeting->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour{{ $meeting->id }}" aria-expanded="false" aria-controls="collapseFour">

                                                    {{ $meeting['meeting_title'] }}

                                                </button>
                                            </div>

                                        </div>
                                        <div id="collapseFour{{ $meeting->id }}" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">

                                        <div class="card-body">
                                            <table class="table">
                                            <tbody>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <a href="#" title="about">{{ __('frontstaticword.Created') }}: @if(isset($meeting->user)) {{ $meeting->user['fname'] }} {{ $meeting->user['lname'] }} @endif </a>

                                                        </li>
                                                        <li>
                                                           <p>Meeting Owner: {{ $meeting->owner_id }}</p>
                                                        </li>
                                                        <li>
                                                           <p class="btm-10"><a herf="#">{{ __('frontstaticword.StartAt') }}: {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</a></p>
                                                        </li>
                                                        <li>
                                                             <a href="{{url('meetup-conferencing/'.$meeting->meeting_id) }}" target="_blank" class="btn btn-light">{{ __('frontstaticword.JoinMeeting') }}</a>
                                                        </li>
                                                    </ul>

                                                </td>
                                            </tbody>
                                            </table>
                                        </div>
                                       </div>
                                    </div>
                                    @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        @endif

                        @endif
                        {{-- jitsi end --}}


                        @endif

                        @endauth
                   
                        </div>
                        
                    {{-- </div> --}}
                </div>

                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="learning-contact-block">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="contact-search-block btm-40">
                                    <div class="learning-contact-search">
                                        @if($coursequestions->isEmpty())
                                            <h4 class="question-text">{{ __('frontstaticword.No') }} {{ __('frontstaticword.RecentQuestions') }}</h4>
                                        @else
                                            <h4 class="question-text">
                                            @php
                                                $quess = App\Question::where('course_id', $course->id)->get();
                                                if(count($quess)>0){

                                                    echo count($quess);
                                                }
                                                else{

                                                    echo "0";
                                                }
                                            @endphp
                                            {{ __('frontstaticword.questionsinthiscourse') }}</h4>
                                        @endif
                                        
                                    </div>
                                    <div class="learning-contact-btn">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">{{ __('frontstaticword.Askanewquestion') }}
                                        </button>

                                        <!--Model start-->
                                        <div id="myModal" class="modal fade" role="dialog">
                                          <div class="modal-dialog modal-lg">
                                          

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">{{ __('frontstaticword.Askanewquestion') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              </div>

                                              <div class="modal-body">
                                                
                                                <form id="demo-form2" method="post" action="{{ url('addquestion', $course->id) }}"
                                                    data-parsley-validate class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}
                                                            
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                        <input type="hidden" name="instructor_id" class="form-control" value="{{$course->user_id}}"  />
                                                        <input type="hidden" name="user_id"  value="{{Auth::user()->id}}" />
                                                      </div>
                                                      <div class="col-md-6">
                                                        <input type="hidden" name="course_id"  value="{{$course->id}}" />
                                                        <input type="hidden" name="status"  value="1" />
                                                      </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                        <label for="detail">{{ __('frontstaticword.Question') }}:<sup class="redstar">*</sup></label>
                                                        <textarea name="question" rows="4"  class="form-control" placeholder=""></textarea>
                                                      </div>
                                                    </div>
                                                    <br>
                                                    <div class="box-footer">
                                                     <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>

                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('frontstaticword.Close') }}</button>
                                              </div>
                                            </div>

                                          </div>
                                        </div>
                                        <!--Model end-->
                                    </div>
                                </div>
                                
                                <div id="accordion" class="second-accordion">
                                    @php
                                        $questions = App\Question::where('course_id', $course->id)->get();
                                    @endphp
                                    @foreach($questions as $ques)
                                    @if($ques->status == 1)
                                    <div class="card btm-10">
                                        <div class="card-header" id="headingThree{{ $ques->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree{{ $ques->id }}" aria-expanded="true" aria-controls="collapseThree">
                                                    <div class="learning-questions-img rgt-10">{{ str_limit($ques->user->fname, $limit = 1, $end = '') }}{{ str_limit($ques->user->lname, $limit = 1, $end = '') }}
                                                    </div>
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-6 col-8">
                                                            <div class="section">
                                                                <a href="#" title="questions">{{ $ques->user->fname }} </a> 
                                                                <a href="#" title="questions">{{ date('jS F Y', strtotime($ques->created_at)) }}</a>
                                                                <div class="author-tag">
                                                                    {{ $ques->user->role }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-lg-5 col-3">
                                                            <div class="section-dividation text-right">
                                                                @php
                                                                    $answer = App\Answer::where('question_id', $ques->id)->get();
                                                                    if(count($answer)>0){

                                                                        echo count($answer);
                                                                    }
                                                                    else{

                                                                        echo "0";
                                                                    }
                                                                @endphp
                                                                {{ __('frontstaticword.Answer') }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 col-1">
                                                            <div class="question-report txt-rgt">
                                                                 <a href="#" data-toggle="modal" data-target="#myModalquesReport{{ $ques->id }}" title="response"><i class="fa fa-flag" aria-hidden="true"></i></a>
                                                            </div>
                                                            
                                                        </div>

                                                    </div>
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-8 col-8"> 
                                                            <div class="profile-heading profile-heading-two">{!! $ques->question !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-3"> 
                                                            <div class="profile-heading txt-rgt"><a href="#" data-toggle="modal" data-target="#myModalanswer{{ $ques->id }}" title="response">{{ __('frontstaticword.AddAnswer') }}</a>
                                                            </div>
                                                        </div>
                                                        

                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <!--Model start-->
                                        <div class="modal fade" id="myModalanswer{{ $ques->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">

                                                  <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.Answer') }}</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="box box-primary">
                                                  <div class="panel panel-sum">
                                                    <div class="modal-body">
                                                    
                                                    <form id="demo-form2" method="post" action="{{ url('addanswer', $ques->id) }}"
                                                        data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                        <input type="hidden" name="question_id"  value="{{$ques->id}}" />
                                                        <input type="hidden" name="instructor_id"  value="{{$course->user_id}}" />
                                                        <input type="hidden" name="ans_user_id"  value="{{Auth::user()->id}}" />
                                                        <input type="hidden" name="ques_user_id"  value="{{$ques->user_id}}" />
                                                        <input type="hidden" name="course_id"  value="{{$ques->course_id}}" />
                                                        <input type="hidden" name="question_id"  value="{{$ques->id}}" />
                                                        <input type="hidden" name="status"  value="1" />       
                                                        
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            {!! $ques->question !!}
                                                            <br>
                                                            <br>
                                                          </div>
                                                          <div class="col-md-12">
                                                            <label for="detail">{{ __('frontstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                                                            <textarea name="answer" rows="4"  class="form-control" placeholder=""></textarea>
                                                          </div>
                                                        </div>
                                                        <br>
                                                        <div class="box-footer">
                                                         <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div> 
                                        </div>
                                        <!--Model close -->

                                        <!--Model start Question Report-->
                                                           
                                        <div class="modal fade" id="myModalquesReport{{ $ques->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">

                                                  <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.Report') }} Question</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="box box-primary">
                                                  <div class="panel panel-sum">
                                                    <div class="modal-body">
                                                    
                                                    <form id="demo-form2" method="post" action="{{ route('question.report', $ques->id) }}"
                                                        data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                        <input type="hidden" name="course_id"  value="{{ $course->id }}" />

                                                        <input type="hidden" name="question_id"  value="{{ $ques->id }}" />
                                                                
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Title') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="Please Enter Title" value="" required>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">{{ __('frontstaticword.Email') }}:<sup class="redstar">*</sup></label>
                                                                <input type="email" class="form-control" name="email" id="title" placeholder="Please Enter Email" value="{{ Auth::user()->email }}" required>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="detail">{{ __('frontstaticword.Detail') }}:<sup class="redstar">*</sup></label>
                                                                <textarea name="detail" rows="4"  class="form-control" placeholder="Enter Detail"></textarea>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <br>
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div> 
                                        </div>
                                      
                                        <!--Model close -->

                                        
                                        <div id="collapseThree{{ $ques->id }}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            @php
                                                $answers = App\Answer::where('question_id', $ques->id)->get();
                                            @endphp
                                            @foreach($answers as $ans)
                                            @if($ans->status == 1)
                                            <div class="card-body">
                                                <div class="answer-block">
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-1 col-2">
                                                            <div class="learning-questions-img-two">{{ str_limit($ans->user->fname, $limit = 1, $end = '') }}{{ str_limit($ans->user->lname, $limit = 1, $end = '') }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-11 col-10">
                                                            
                                                            <div class="section">
                                                                <a href="#" title="questions">{{ $ans->user->fname }}</a> <a href="#" title="questions">{{ date('jS F Y', strtotime($ans->created_at)) }}</a>
                                                                <div class="author-tag">
                                                                    {{ $ans->user->role }}
                                                                </div>
                                                            </div>
                                                            <br>

                                                            <div class="section-answer">
                                                                <a href="#" title="Course">{!! $ans->answer !!}</a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-announcement" role="tabpanel" aria-labelledby="nav-announcement-tab">
                    @if($announsments->isEmpty())
                        <div class="learning-announcement-null text-center">
                            <div class="offset-lg-2 col-lg-8">
                                <h1>{{ __('frontstaticword.Noannouncements') }}</h1>
                                <p>{{ __('frontstaticword.Noannouncementsdetail') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="learning-announcement text-center">
                            <div class="col-lg-12">
                                <div id="accordion" class="second-accordion">
                                    
                                    @foreach($announsments as $announsment)
                                    @if($announsment->status == 1)
                                    <div class="card btm-30">
                                        <div class="card-header" id="headingFive{{ $announsment->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFive{{ $announsment->id }}" aria-expanded="true" aria-controls="collapseFive">
                                                    <div class="learning-questions-img rgt-20">{{ str_limit($announsment->user->fname, $limit = 1, $end = '') }}{{ str_limit($announsment->user->lname, $limit = 1, $end = '') }}
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="section"><a href="#" title="questions">{{ $announsment->user->fname }} {{ $announsment->user->lname }}</a> <a href="#" title="questions">{{ date('jS F Y', strtotime($announsment->created_at)) }}</a></div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="section-dividation text-right">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 offset-3 col-9 offset-sm-0 col-sm-12 offset-md-0 col-md-12"> 
                                                            <div class="profile-heading profile-heading-one">
                                                                {{ __('frontstaticword.Announcements') }}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="collapseFive{{ $announsment->id }}" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>{!! $announsment->announsment !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="tab-pane fade" id="nav-quiz" role="tabpanel" aria-labelledby="nav-quiz-tab">
                    <div class="container">
                        <div class="quiz-main-block">

                          <h5>{{ __('frontstaticword.Objective') }}</h5>
                          <div class="row">
                            @php 
                                $topics = App\QuizTopic::where('course_id', $course->id)->where('type', NULL)->get();
                            @endphp
                            @if(count($topics)>0 )
                              @foreach ($topics as $topic)
                              @if($topic->status == 1)

                                @if(Auth::User()->role == 'instructor' || Auth::User()->role == 'user')
                                <?php 
                                    $order = App\Order::where('course_id', $course->id)->where('user_id', '=', Auth::user()->id)->first();

                                    $days = $topic->due_days;
                                    $orderDate = optional($order)['created_at'];
                                    

                                    $bundle = App\Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

                                        $course_id = array();

                                        foreach($bundle as $b)
                                        {
                                           $bundle = App\BundleCourse::where('id', $b->bundle_id)->first();
                                            array_push($course_id, $bundle->course_id);
                                        }

                                        $course_id = array_values(array_filter($course_id));
                                        $course_id = array_flatten($course_id);

                                        if($orderDate != NULL){
                                            $startDate = date("Y-m-d", strtotime("$orderDate +$days days"));
                                        }
                                        elseif(isset($course_id) && in_array($course->id, $course_id)){
                                            $startDate = date("Y-m-d", strtotime("$bundle->created_at +$days days"));
                                        }
                                ?>

                                @else

                                <?php 
                                    
                                    $startDate = '0';
                                ?>
                                @endif


                                @php
                                    $mytime = Carbon\Carbon::now();
                                @endphp

                               
                               
                                @if($mytime >= $startDate)
                              
                                <div class="col-md-6 col-lg-4">
                                  <div class="topic-block">
                                    <div class="card blue-grey darken-1">
                                      <div class="card-content dark-text">
                                        <span class="card-title">{{$topic->title}}</span>
                                        <p title="{{$topic->description}}">{{str_limit($topic->description, 120)}}</p>
                                        <div class="row">
                                          <div class="col-lg-6 col-7">
                                            <ul class="topic-detail one-topic-detail">
                                              <li>{{ __('frontstaticword.PerQuestionMark') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.TotalMarks') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.TotalQuestions') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.QuizPrice') }}<i class="fa fa-long-arrow-right"></i></li>
                                            </ul>
                                          </div>
                                          <div class="col-lg-6 col-5">
                                            <ul class="topic-detail two-topic-detail">
                                              <li>{{$topic->per_q_mark}}</li>
                                              <li>
                                                @php
                                                    $qu_count = 0;
                                                    $quizz = App\Quiz::get();
                                                @endphp
                                                @foreach($quizz as $quiz)
                                                  @if($quiz->topic_id == $topic->id)
                                                    @php 
                                                      $qu_count++;
                                                    @endphp
                                                  @endif
                                                @endforeach
                                                {{$topic->per_q_mark*$qu_count}}
                                              </li>
                                              <li>
                                                {{$qu_count}}
                                              </li>
                                              
                                              <li>
                                                {{ __('frontstaticword.Free') }}
                                              </li>

                                            </ul>
                                          </div>
                                        </div>
                                      </div>


                                   <div class="card-action text-center">

                                      @php
                                        $users =  App\QuizAnswer::where('topic_id',$topic->id)->where('user_id',Auth::user()->id)->first();
                                        $quiz_question =  App\Quiz::where('course_id',$course->id)->get();

                                      @endphp
                                      @if(empty($users))
                                        @if($quiz_question != null || $quiz_question!= '')
                                         
                                            <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz"> {{ __('frontstaticword.StartQuiz') }}</a>
                                        
                                        @endif
                                      @else
                                         <a href="{{route('start.quiz.show',$topic->id)}}" class="btn btn-block">{{ __('frontstaticword.ShowQuizReport') }} </a>
                                       
                                        @if($topic->quiz_again == '1')
                                         <a href="{{route('tryagain',$topic->id)}}" class="btn btn-block">{{ __('frontstaticword.TryAgain') }} </a>
                                        @endif
                                      @endif
                                        
                                      </div>
                                    
                                    </div>
                                  </div>
                                </div>

                                @endif

                               
                              @endif
                              @endforeach
                            @else
                                
                                <div class="learning-quiz-null text-center">
                                    <div class="col-lg-12">
                                        <h1>{{ __('frontstaticword.Noquiz') }}</h1>
                                        <p>{{ __('frontstaticword.Noquizsdetail') }}</p>
                                    </div>
                                </div> 
                            @endif
                          </div>
                          <h5>{{ __('frontstaticword.Subjective') }}</h5>
                          <div class="row">
                            @php 
                                $topics = App\QuizTopic::where('course_id', $course->id)->where('type', '1')->get();
                            @endphp
                            @if(count($topics)>0 )
                              @foreach ($topics as $topic)
                              @if($topic->status == 1)

                                @if(Auth::User()->role == 'instructor' || Auth::User()->role == 'user')
                                <?php 
                                    $order = App\Order::where('course_id', $course->id)->where('user_id', '=', Auth::user()->id)->first();

                                    $days = $topic->due_days;
                                    $orderDate = optional($order)['created_at'];

                                    $bundle = App\Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

                                        $course_id = array();

                                        foreach($bundle as $b)
                                        {
                                           $bundle = App\BundleCourse::where('id', $b->bundle_id)->first();
                                            array_push($course_id, $bundle->course_id);
                                        }

                                        $course_id = array_values(array_filter($course_id));
                                        $course_id = array_flatten($course_id);

                                        if($orderDate != NULL){
                                            $startDate = date("Y-m-d", strtotime("$orderDate +$days days"));
                                        }
                                        elseif(isset($course_id) && in_array($course->id, $course_id)){
                                            $startDate = date("Y-m-d", strtotime("$bundle->created_at +$days days"));
                                        }
                                ?>

                                @else

                                <?php 
                                    
                                    $startDate = '0';
                                ?>
                                @endif


                                @php
                                    $mytime = Carbon\Carbon::now();
                                @endphp

                               
                               
                                @if($mytime >= $startDate)
                              
                                <div class="col-md-6 col-lg-4">
                                  <div class="topic-block">
                                    <div class="card blue-grey darken-1">
                                      <div class="card-content dark-text">
                                        <span class="card-title">{{$topic->title}}</span>
                                        <p title="{{$topic->description}}">{{str_limit($topic->description, 120)}}</p>
                                        <div class="row">
                                          <div class="col-lg-6 col-7">
                                            <ul class="topic-detail one-topic-detail">
                                              <li>{{ __('frontstaticword.PerQuestionMark') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.TotalMarks') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.TotalQuestions') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.QuizPrice') }}<i class="fa fa-long-arrow-right"></i></li>
                                            </ul>
                                          </div>
                                          <div class="col-lg-6 col-5">
                                            <ul class="topic-detail two-topic-detail">
                                              <li>{{$topic->per_q_mark}}</li>
                                              <li>
                                                @php
                                                    $qu_count = 0;
                                                    $quizz = App\Quiz::get();
                                                @endphp
                                                @foreach($quizz as $quiz)
                                                  @if($quiz->topic_id == $topic->id)
                                                    @php 
                                                      $qu_count++;
                                                    @endphp
                                                  @endif
                                                @endforeach
                                                {{$topic->per_q_mark*$qu_count}}
                                              </li>
                                              <li>
                                                {{$qu_count}}
                                              </li>
                                              
                                              <li>
                                                {{ __('frontstaticword.Free') }}
                                              </li>

                                            </ul>
                                          </div>
                                        </div>
                                      </div>


                                   <div class="card-action text-center">

                                      @php
                                        $users =  App\QuizAnswer::where('topic_id',$topic->id)->where('user_id',Auth::user()->id)->first();
                                        $quiz_question =  App\Quiz::where('course_id',$course->id)->get();

                                      @endphp
                                      @if(empty($users))
                                        @if($quiz_question != null || $quiz_question!= '')
                                         
                                            <a href="{{route('sub_start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz"> {{ __('frontstaticword.StartQuiz') }}</a>
                                        
                                        @endif
                                      @else
                                         <a href="{{route('sub.start.quiz.show',$topic->id)}}" class="btn btn-block">{{ __('frontstaticword.ShowQuizReport') }} </a>
                                       
                                        @if($topic->quiz_again == '1')
                                         <a href="{{route('sub.tryagain',$topic->id)}}" class="btn btn-block">{{ __('frontstaticword.TryAgain') }} </a>
                                        @endif
                                      @endif
                                        
                                      </div>
                                    
                                    </div>
                                  </div>
                                </div>

                                @endif

                               
                              @endif
                              @endforeach
                            @else
                                
                                <div class="learning-quiz-null text-center">
                                    <div class="col-lg-12">
                                        <h1>{{ __('frontstaticword.Noquiz') }}</h1>
                                        <p>{{ __('frontstaticword.Noquizsdetail') }}</p>
                                    </div>
                                </div> 
                            @endif
                          </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-assign" role="tabpanel" aria-labelledby="nav-assign-tab">
                    <div class="container">
                        <div class="assignment-main-block">
                            <h3>{{ __('frontstaticword.YourAssignments') }}</h3>
                          <div class="row">

                            <div class="col-md-8">

                                <div class="row">
                                @foreach($assignment as $assign)
                                    <div class="col-md-12">
                                        <div class="assignment-tab-block">
                                            <div class="categories-block assign-tab-one text-center">

                                                <table>
                                                    <td>
                                                        <div class="row">

                                                        <div class="col-md-6">
                                                        @if($assign->type == 1)
                                                         <a href="" data-toggle="tooltip" data-placement="top" title="{{ $assign->rating }}/10 scores"><i class="far fa-check-circle" title="approved"></i></a>
                                                        @else
                                                        <i class="far fa-times-circle" title="pending"></i>
                                                        @endif
                                                        <span>{{ __('frontstaticword.Title') }}:{{ $assign->title }}</span>
                                                        </div>
                                                         <div class="col-md-6">
                                                            <div class="assignment-delete-block text-right">

                                                            <a href="{{ asset('files/assignment/'.$assign->assignment) }}" download="{{$assign->assignment}}" title="Download"> <i class="fa fa-download"></i></a>

                                                            
                                                            <form  method="post" action="{{url('assignment/delete/'.$assign->id)}}" ata-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                                <button  type="submit" class="assign-remove-btn display-inline" title="Delete"> <i class="fas fa-trash-alt"></i></button>
                                                              </form>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    </td>
                                                
                                              
                                                </table>
                                               
                                            </div>
                                        </div>
                                    </div>
                                
                                @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="contact-search-block btm-40">
                                    
                                    <div class="udemy-contact-btn text-center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignmodel">{{ __('frontstaticword.SubmitAssignment') }}
                                        </button>
                                    </div>



                                    <div class="modal fade" id="assignmodel" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.SubmitAssignment') }}</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="box box-primary">
                                              <div class="panel panel-sum">
                                                <div class="modal-body">
                                                    <form id="demo-form2" method="post" action="{{ route('assignment.submit', $course->id) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id"  value="{{ Auth::user()->id }}" />

                                                        <input type="hidden" name="instructor_id"  value="{{ $course->user_id }}" />
                                                                
                                                        <div class="row">
                                                          <div class="col-md-12">

                                                            <div class="form-group">
                                                                <label for="exampleInputDetails">{{ __('adminstaticword.ChapterName') }}:<sup class="redstar">*</sup></label>
                                                                <select style="width: 100%" name="course_chapters" class="form-control js-example-basic-single" required>
                                                                <option value="none" selected disabled hidden> 
                                                                  {{ __('Select Chapter') }}
                                                                </option>
                                                                  @foreach($coursechapters as $c)
                                                                  <option value="{{ $c->id }}">{{ $c->chapter_name }}</option>
                                                                  @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Title') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="Please Enter Title" value="" required>
                                                            </div>
                                                                
                                                            <div class="form-group">
                                                                
                                                                <div class="wrapper">
                                                                   <label for="detail">{{ __('frontstaticword.AssignmentUpload') }}:<sup class="redstar">*</sup></label> 
                                                                  <div class="file-upload">
                                                                    <input type="file" name="assignment" class="form-control" />
                                                                    <i class="fa fa-arrow-up"></i>
                                                                  </div>
                                                                </div>
                                                            </div> 
                                                            
                                                          </div>
                                                          
                                                        </div>
                                                        
                                                        <hr>
                                                        <div class="box-footer text-center">
                                                         <button type="submit" class="btn btn-sm btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                          </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-appoint" role="tabpanel" aria-labelledby="nav-appoint-tab">
                    <div class="container">
                        <div class="appointment-main-block">
                            <h3>{{ __('frontstaticword.YourAppointment') }}</h3>
                          <div class="row">

                            <div class="col-md-8">
                                @foreach($appointment as $appoint)
                                    <div class="col-md-12">
                                        <div class="assignment-tab-block">
                                            <div class="categories-block assign-tab-one text-center">
                                                <ul>
                                                    <li class="btm-5"><span>{{ $appoint->title }}</span></li>
                                                    <li class="btm-5"><span>{!! $appoint->detail !!}</span></li>
                                                    <li>
                                                   
                                                        <form  method="post" action="{{url('appointment/delete/'.$appoint->id)}}" ata-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart"> {{ __('frontstaticword.Delete') }}</button>
                                                      </form>

                                                    </li>
                                                    @if($appoint->accept == 1)
                                                    <li><a href="" data-toggle="modal" data-target="#myModalresponse" title="response">Response</a></li>

                                                    <div class="modal fade" id="myModalresponse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">

                                                              <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.Response') }}</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="box box-primary">
                                                              <div class="panel panel-sum">
                                                                <div class="modal-body">
                                                                  <div class="instructor-detail">
                                                                    <ul>
                                                                        <li>

                                                                            <div class="instructor-img btm-30">
                                                                                @if($appoint->user->user_img != null || $appoint->user->user_img !='')
                                                                                <a href="{{ route('instructor.profile', $course->user->id) }}" title="instructor"><img src="{{ asset('images/user_img/'.$appoint->instructor->user_img) }}" width="100px" height="100px" class="img-fluid img-circle"/></a>
                                                                                @else

                                                                                <a href="{{ route('instructor.profile', $course->user->id) }}" title="instructor"><img src="{{ asset('images/default/user.jpg')}}" width="100px" height="100px" class="img-fluid img-circle"/></a>
                                                                                @endif
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            {{ __('frontstaticword.Instructor') }}: {{ $appoint->instructor->fname }} {{ $appoint->instructor->lname }}
                                                                        </li>
                                                                        <li>
                                                                            {{ __('frontstaticword.Email') }}: {{ $appoint->instructor->email }}
                                                                        </li>
                                                                        <li>
                                                                            {{ __('frontstaticword.Response') }}: {!! $appoint->reply !!}
                                                                        </li>

                                                                    </ul>
                                                                  </div>
                                                                
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div> 
                                                    </div>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                
                                @endforeach
                            </div>
                            <div class="col-md-4">
                                <div class="contact-search-block btm-40">
                                    <div class="udemy-contact-btn text-center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#appointmodel">{{ __('frontstaticword.RequestAppointment') }}
                                        </button>
                                    </div>
                                    <div class="modal fade" id="appointmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.RequestAppointment') }}</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="box box-primary">
                                              <div class="panel panel-sum">
                                                <div class="modal-body">
                                                    <form id="demo-form2" method="post" action="{{ route('appointment.request', $course->id) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id"  value="{{ Auth::user()->id }}" />

                                                        <input type="hidden" name="instructor_id"  value="{{ $course->user_id }}" />
                                                        
                                                        
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.User') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" name="fname" value="{{ Auth::user()->email }}" class="form-control" disabled />
                                                            </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Instructor') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" name="instructor" value="{{ $course->user->email }}" class="form-control" disabled/>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        
                                                                
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Title') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="Please Enter Title" value="">
                                                            </div>
                                                          </div>

                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Date') }}:<sup class="redstar">*</sup></label>
                                                                <input type="datetime-local" class="form-control" id="date_time" name="date_time" placeholder="Please Enter Title" value="">
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="detail">{{ __('frontstaticword.Detail') }}:<sup class="redstar">*</sup></label>
                                                                <textarea id="detail" name="detail" class="form-control" placeholder="Enter your details" value=""></textarea>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        
                                                        <hr>
                                                        <div class="box-footer">
                                                         <button type="submit" class="btn btn-sm btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>

                @if(count($papers) > 0)

                <div class="tab-pane fade" id="nav-paper" role="tabpanel" aria-labelledby="nav-paper-tab">
                    
                    <div class="assignment-main-block">
                        <h3>{{ __('frontstaticword.AllPapers') }}</h3>
                      <div class="row">

                        <div class="col-md-12">

                            <div class="row">
                            @foreach($papers as $paper)
                            @if($paper->status == 1)
                                <div class="col-md-12">
                                    <div class="assignment-tab-block">
                                        <div class="categories-block assign-tab-one text-center">

                                            <table>
                                                <td>
                                                    <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="koh-tab-content">
                                                          <div class="koh-tab-content-body">
                                                            <div class="koh-faq">
                                                              <div class="koh-faq-question">

                                                                <i class="far fa-check-circle" title="pending"></i>

                                                                <span class="koh-faq-question-span">{{ __('frontstaticword.Title') }}:{{ $paper->title }}</span>

                                                                @if($paper->detail != NULL)
                                                                    <i class="fa fa-sort-down" aria-hidden="true"></i>
                                                                @endif
                                                              </div>
                                                              <div class="koh-faq-answer">
                                                                {!! $paper->detail !!}
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>

                                                    </div>


                                                     <div class="col-md-6">
                                                        <div class="assignment-delete-block text-right">

                                                        <a href="{{ asset('files/papers/'.$paper->file) }}" download="{{$paper->file}}" title="Download"> <i class="fa fa-download"></i></a>

                                                        
                                                        
                                                    </div>
                                                </div>




                                                </td>
                                            
                                          
                                            </table>
                                           
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                            </div>
                        </div>
                        

                      </div>
                    </div>
                    
                </div>

                @endif
            </div>
                
            
    </div>
</section>
<!-- courses-content end -->

@endsection

@section('custom-script')
<!-- iframe script -->
<script>

// Example of using an event listener and public method to build a primitive slideshow:
$(document).bind('cbox_closed', function(){

  setTimeout($.colorbox.close, 1);
  
  $.ajax({

        type : 'GET',
        data : {userid : '{{ Auth::user()->id }}', chapterid : '{{ $course->id }}'},
        url  : "{{ url('activestatus') }}",
        success : function(data){
            console.log(data);

            if(data.code == 200){
                console.log(data.msg);
            }else{
                console.log(data.msg);
            }

        }

  });

});
</script>



<script>

(function($) {
  "use strict";
  $(document).ready(function(){

    $(".group1").colorbox({rel:'group1'});
    $(".group2").colorbox({rel:'group2', transition:"fade"});
    $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
    $(".group4").colorbox({rel:'group4', slideshow:true});
    $(".ajax").colorbox();
    $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
    $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
    $(".iframe").colorbox({iframe:true, width:"100%", height:"100%"});
    $(".inline").colorbox({inline:true, width:"50%"});
    $(".callbacks").colorbox({
      onOpen:function(){ alert('onOpen: colorbox is about to open'); },
      onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
      onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
      onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
      onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
    });

    $('.non-retina').colorbox({rel:'group5', transition:'none'})
    $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});


    
    
    $("#click").click(function(){ 
      $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
      return false;
    });
  });
})(jQuery);

</script>



<!-- script to remain on active tab -->
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
<!-- link for another tab -->
<script>
(function($) {
  "use strict";
    $("#goTab4").click(function(){
        $("#nav-tab a:nth-child(4)").click();
        return false;
    });

    $("#goTab5").click(function(){
        $("#nav-tab a:nth-child(5)").click();
        return false;
    });
})(jQuery);    
</script>

<script type="text/javascript">
    $('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;                       
        });
    }
});
</script>

<script>
(function($) {
  "use strict";
    tinymce.init({selector:'textarea'});
})(jQuery);
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(this).on("click", ".koh-faq-question", function() {
        $(this).parent().find(".koh-faq-answer").toggle();
        $(this).find(".fa").toggleClass('active');
    });
});
</script>

@endsection


<style>
    .hidden {position:absolute;visibility:hidden;opacity:0;}
    input[type=checkbox] + label {
      color: #ccc;
      font-style: italic;
    } 
    input[type=checkbox]:checked + label {
      color: #f00;
      font-style: normal;
    }

</style>
