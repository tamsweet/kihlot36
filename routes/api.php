<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', 'Api\Auth\LoginController@login');
Route::post('fblogin', 'Api\Auth\LoginController@fblogin');
Route::post('googlelogin', 'Api\Auth\LoginController@googlelogin');
Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('refresh', 'Api\Auth\LoginController@refresh');
 
Route::post('forgotpassword', 'Api\Auth\LoginController@forgotApi');
Route::post('verifycode', 'Api\Auth\LoginController@verifyApi');
Route::post('resetpassword', 'Api\Auth\LoginController@resetApi');

Route::get('home', 'Api\MainController@home');

Route::get('course', 'Api\MainController@course');
Route::get('featuredcourse', 'Api\MainController@featuredcourse');
Route::get('recent/course', 'Api\MainController@recentcourse');

Route::get('bundle/courses', 'Api\MainController@bundle');
Route::get('user/faq', 'Api\MainController@studentfaq');
Route::get('instructor/faq', 'Api\MainController@instructorfaq');

Route::get('main', 'Api\MainController@main');

Route::post('course/detail', 'Api\MainController@detailpage');
Route::get('all/pages', 'Api\MainController@pages');
Route::post('instructor/profile', 'Api\MainController@instructorprofile');
Route::post('course/review', 'Api\MainController@review');
Route::post('chapter/duration', 'Api\MainController@duration');

Route::get('apikeys', 'Api\MainController@apikeys');
Route::get('all/courses/detail', 'Api\MainController@coursedetail');
Route::get('all/coupons', 'Api\MainController@showcoupon');

Route::get('aboutus', 'Api\MainController@aboutus');

Route::post('contactus', 'Api\MainController@contactus');

Route::get('payment/apikeys', 'Api\PaymentController@apikeys');

Route::get('blog', 'Api\MainController@blog');
Route::post('blog/detail', 'Api\MainController@blogdetail');
Route::get('recent/blog', 'Api\MainController@recentblog');

Route::get('terms_policy', 'Api\MainController@terms');
Route::get('career', 'Api\MainController@career');
Route::get('zoom', 'Api\MainController@zoom');
Route::get('bigblue', 'Api\MainController@bigblue');


Route::get('course/content/{id}', 'Api\MainController@coursecontent');


Route::group(['middleware' => ['auth:api']], function (){
 	 
	
	Route::post('logout','Api\Auth\LoginController@logoutApi');
   	
    //wishlist
	Route::post('addtowishlist', 'Api\MainController@addtowishlist');
	Route::post('remove/wishlist', 'Api\MainController@removewishlist');
	Route::post('show/wishlist', 'Api\MainController@showwishlist');

    //userprofile
	Route::post('show/profile', 'Api\MainController@userprofile');
	Route::post('update/profile', 'Api\MainController@updateprofile');
	Route::post('my/courses', 'Api\MainController@mycourses');

    //cart
	Route::post('addtocart', 'Api\MainController@addtocart');
 	Route::post('remove/cart', 'Api\MainController@removecart');
	Route::post('show/cart', 'Api\MainController@showcart');
	Route::post('remove/all/cart', 'Api\MainController@removeallcart');
	Route::post('addtocart/bundle', 'Api\MainController@addbundletocart');
	Route::post('remove/bundle', 'Api\MainController@removebundlecart');

    //userprofile
	Route::get('notifications', 'Api\MainController@allnotification');
	Route::get('readnotification/{id}', 'Api\MainController@notificationread');
	Route::post('readall/notification', 'Api\MainController@readallnotification');
	
	//paymentAPI
	Route::post('pay/store', 'Api\PaymentController@paystore');
	Route::get('purchase/history', 'Api\PaymentController@purchasehistory');

	Route::post('instructor/request', 'Api\MainController@becomeaninstructor');

	Route::post('course/progress', 'Api\MainController@courseprogress');
	Route::post('course/progress/update', 'Api\MainController@courseprogressupdate');

	Route::post('course/report', 'Api\MainController@coursereport');

	Route::post('apply/coupon', 'Api\CouponController@applycoupon');
	Route::post('remove/coupon', 'Api\CouponController@remove');

	Route::post('assignment/submit', 'Api\MainController@assignment');

	Route::post('appointment/request', 'Api\MainController@appointment');

	Route::post('question/submit', 'Api\MainController@question');

	Route::post('answer/submit', 'Api\MainController@answer');

	Route::get('invoice', 'Api\MainController@invoicedownload');

	Route::post('appointment/delete/{id}', 'Api\MainController@appointmentdelete');


	Route::post('review/submit', 'Api\MainController@userreview');


	//Instructor API
	Route::get('instructor/dashboard', 'Api\InstructorApiController@dashboard');

});




//Instructor API

//course language API
Route::get('language', 'Api\InstructorApiController@getAlllanguage');
Route::get('language/{id}', 'Api\InstructorApiController@getlanguage');
Route::post('language', 'Api\InstructorApiController@createlanguage');
Route::put('language/{id}', 'Api\InstructorApiController@updatelanguage');
Route::delete('language/{id}','Api\InstructorApiController@deletelanguage');

//categories API
Route::get('category', 'Api\InstructorApiController@getAllcategory');
Route::get('category/{id}', 'Api\InstructorApiController@getcategory');
Route::post('category', 'Api\InstructorApiController@createcategory');
Route::put('category/{id}', 'Api\InstructorApiController@updatecategory');
Route::delete('category/{id}','Api\InstructorApiController@deletecategory');

//subcategories API
Route::get('subcategory', 'Api\InstructorApiController@getAllsubcategory');
Route::get('subcategory/{id}', 'Api\InstructorApiController@getsubcategory');
Route::post('subcategory', 'Api\InstructorApiController@createsubcategory');
Route::put('subcategory/{id}', 'Api\InstructorApiController@updatesubcategory');
Route::delete('subcategory/{id}','Api\InstructorApiController@deletesubcategory');

//childcategories API
Route::get('childcategory', 'Api\InstructorApiController@getAllchildcategory');
Route::get('childcategory/{id}', 'Api\InstructorApiController@getchildcategory');
Route::post('childcategory', 'Api\InstructorApiController@createchildcategory');
Route::put('childcategory/{id}', 'Api\InstructorApiController@updatechildcategory');
Route::delete('childcategory/{id}','Api\InstructorApiController@deletechildcategory');




