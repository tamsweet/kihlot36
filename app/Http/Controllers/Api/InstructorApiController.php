<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CourseLanguage;
use App\Course;
use App\Order;
use App\Question;
use App\Answer;
use App\Meeting;
use App\BBL;
use App\JitsiMeeting;
use App\Blog;
use Auth;
use App\CompletedPayout;
use Validator;

class InstructorApiController extends Controller
{

    public function getAlllanguage() {

      	$language = CourseLanguage::get()->toJson(JSON_PRETTY_PRINT);
      	return response($language, 200);
    }

    public function getlanguage($id) {

	    if (CourseLanguage::where('id', $id)->exists()) {
	        $language = CourseLanguage::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
	        return response($language, 200);
	    } else {
	        return response()->json([
	          "message" => "language not found"
	        ], 404);
	    }

    }

    public function createlanguage(Request $request) {

	    $language = new CourseLanguage;
	    $language->name = $request->name;
	    $language->status = isset($request->status)  ? 1 : 0;
	    $language->save();

	    return response()->json([
	        "message" => "language created"
	    ], 201);
    }

    public function updatelanguage(Request $request, $id) {

	    if (CourseLanguage::where('id', $id)->exists()) {
	        $language = CourseLanguage::find($id);

	       	$language->name = is_null($request->name) ? $language->name : $language->name;
	        $language->status = is_null($request->status) ? 1 : 0;
	        $language->save();

	        return response()->json([
	          "message" => "records updated successfully"
	        ], 200);
	    } else {
	        return response()->json([
	          "message" => "language not found"
	        ], 404);
	    }
    }


    public function deletelanguage($id) {
	    if(language::where('id', $id)->exists()) {
	        $language = language::find($id);
	        $language->delete();

	        return response()->json([
	          "message" => "records deleted"
	        ], 202);

	    } else {
	        return response()->json([
	          "message" => "language not found"
	        ], 404);
	    }
    }


    public function dashboard()
    {


    	$auth = Auth::user();

        $course_count = Course::where('user_id', $auth->id)->where('status', '1')->count();
        $featured_course_count = Course::where('user_id', $auth->id)->where('status', '1')->where('featured', '1')->count();
        $enrolled_user = Order::where('instructor_id', $auth->id)->where('status', '1')->count();
        $question = Question::where('instructor_id',  $auth->id)->where('status', '1')->count();
        $answer = Answer::where('instructor_id',  $auth->id)->where('status', '1')->count();
        $blog = Blog::where('user_id', $auth->id)->where('status', '1')->count();
        $zoom_meeting = Meeting::where('owner_id', $auth->id)->count();
        $bigblue_meeting = BBL::where('instructor_id', $auth->id)->count();
        $jitsi_meet = JitsiMeeting::where('owner_id', $auth->id)->count();


        $userenroll_chart = array(
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '01')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //January
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '02')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //Feb
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '03')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //March
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '04')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //April
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '05')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //May
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '06')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //June
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '07')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //July
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '08')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //August
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '09')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //September
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '10')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //October
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '11')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //November
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '12')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //December
        );


        $payout_chart = array(
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '01')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //January
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '02')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //Feb
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '03')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //March
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '04')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //April
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '05')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //May
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '06')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //June
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '07')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //July
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '08')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //August
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '09')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //September
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '10')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //October
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '11')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //November
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '12')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //December
        );


        return response()->json(array(

        	'course_count'=>$course_count, 
            'featured_course_count' => $featured_course_count,
        	'enrolled_user_count'=>$enrolled_user, 
        	'questions_count'=>$question, 
        	'answer_count'=>$answer, 
        	'blog_count'=>$blog, 
        	'zoomm_meeting_count'=>$zoom_meeting, 
        	'bigblue_meeting_count'=>$bigblue_meeting, 
        	'userenroll_chart'=>$userenroll_chart,
        	'payout_chart'=>$payout_chart, 

        	), 
        200);
    }
}
