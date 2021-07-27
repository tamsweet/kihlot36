<?php

namespace App\Http\Controllers;

use App\admin;
use Illuminate\Http\Request;
use Auth;
use App\Order;
use App\Charts\UserChart;
use App\User;
use App\Charts\UserDistributionChart;
use App\CompletedPayout;
use Illuminate\Support\Facades\Http;
use Session;
use App\Charts\OrderChart;
use App\Charts\AdminRevenueChart;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        
        if(Auth::User()->role == "admin")
        {

            $userenroll = array(
                Order::whereMonth('created_at', '01')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //January
                Order::whereMonth('created_at', '02')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //Feb
                Order::whereMonth('created_at', '03')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //March
                Order::whereMonth('created_at', '04')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //April
                Order::whereMonth('created_at', '05')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //May
                Order::whereMonth('created_at', '06')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //June
                Order::whereMonth('created_at', '07')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //July
                Order::whereMonth('created_at', '08')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //August
                Order::whereMonth('created_at', '09')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //September
                Order::whereMonth('created_at', '10')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //October
                Order::whereMonth('created_at', '11')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //November
                Order::whereMonth('created_at', '12')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //December
            );

            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $orderdata = collect();

            $orders = Order::select(DB::raw('DATE_FORMAT(created_at, "%M") as month'), DB::raw('count(*) as count'))->where('status','1')
            ->whereYear('created_at',date('Y'))
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->get()
            ->map(function($item) use($months,$orderdata) {
                  
                foreach($months as $month){

                    if($month == $item->month){
                        $orderdata->push($item->count);
                    }else{
                        $orderdata->push(0);
                    }
                }
                

                return $item;

            });

            // return $orderdata;

            $userEnrolled = new OrderChart;

            $userEnrolled->labels($months);
            // $userEnrolled->labels(['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            $userEnrolled->label('Enrolled Users')->title('Total Orders in ' . date('Y'))->dataset('Monthly Enrolled Users', 'area', $userenroll)->options([
                'fill' => 'true',
                'shadow' => true,
                'borderWidth' => '2',
                'color' => '#f9616d',
               
            ]);


            /*Creating Userbarchart*/

            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $userdata = collect();

            $users = User::select(DB::raw('DATE_FORMAT(created_at, "%M") as month'), DB::raw('count(*) as count'))->where('status','1')
            ->whereYear('created_at',date('Y'))
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->get()
            ->map(function($item) use($months,$userdata) {
                  
                foreach($months as $month){

                    if($month == $item->month){
                        $userdata->push($item->count);
                    }else{
                        $userdata->push(0);
                    }
                }
                

                return $item;

            });

            $usersChart = new UserChart;

            $usersChart->labels($months);

            $usersChart->title('Monthly Registered Users in ' . date('Y'))->dataset('Monthly Registered Users', 'bar', $userdata)
            ->backgroundColor("rgba(80,111,228,0.4)")
            ->color("rgba(80,111,228,0.4)")
            ->dashed([0])
            ->fill(true)
            ->linetension(0.1);

            /*End Userbarchart*/

            
            $fillColors = [
                "rgba(255, 205, 86, 0.2)",
                "rgba(255, 99, 132, 0.2)",
                "rgba(22,160,133, 0.2)",
                
            ];

            $admin = User::where('role', '=', 'admin')->count();
            $instructor = User::where('role', '=', 'instructor')->count();
            $user = User::where('role', '=', 'user')->count();

            $data = [$admin, $instructor, $user];


            $pieChart = new UserDistributionChart;
            $pieChart->labels(['Admin', 'Instructor', 'User']);
            $pieChart->minimalist(true);
            $pieChart->title('User Distribution')->dataset('Users by trimester', 'doughnut', $data)
            ->color($fillColors)
            ->backgroundcolor($fillColors);
            

            return view('admin.dashboard', compact('userEnrolled', 'usersChart', 'pieChart'));
        }
        elseif(Auth::User()->role == "instructor")
        {

            return view('instructor.dashboard');
        }
        else
        {
            abort(404, 'Page Not Found.');
        }
        
    }
    

    public function changedomain(Request $request)
    {

        $request->validate([
            'domain' => 'required'
        ]);

        $code = (file_exists(public_path().'/code.txt') &&  @file_get_contents(public_path().'/code.txt') != null) ? @file_get_contents(public_path().'/code.txt') : 0;
        if($code == NULL || $code == 0){
            return back()->withInput()->withErrors(['domain' => 'Purchase code not found please contact support !']);
        }

        $d = $request->domain;
        $domain = str_replace("www.", "", $d);  
        $domain = str_replace("http://", "", $domain);  
        $domain = str_replace("https://", "", $domain);  
        $alldata = ['app_id' => "25613271", 'ip' => $request->ip(), 'domain' => $domain , 'code' => $code];
        $data = $this->make_request($alldata);

        if ($data['status'] == 1)
        {
            $put = 1;
            file_put_contents(public_path().'/config.txt', $put);

            Session::flash('success', 'Domain permission changed successfully !');

            return redirect('/');
        }
        elseif ($data['msg'] == 'Already Register')
        {   
            return back()->withInput()->withErrors(['domain' => 'User is already registered !']);
        }
        else
        {
            return back()->withInput()->withErrors(['domain' => $data['msg']]);
        }

    }

    public function make_request($alldata)
    {
        $response = Http::post('https://mediacity.co.in/purchase/public/api/verifycode', [
            'app_id' => $alldata['app_id'],
            'ip' => $alldata['ip'],
            'code' => $alldata['code'],
            'domain' => $alldata['domain']
        ]);

        $result = $response->json();
        
        if($response->successful()){
            if ($result['status'] == '1')
            {
                $file = public_path() . '/intialize.txt';
                file_put_contents($file, $result['token']);
                file_put_contents(public_path() . '/code.txt', $alldata['code']);
                file_put_contents(public_path() . '/ddtl.txt', $alldata['domain']);
                return array(
                    'msg' => $result['message'],
                    'status' => '1'
                );
            }
            else
            {
                $message = $result['message'];
                return array(
                    'msg' => $message,
                    'status' => '0'
                );
            }
        }else
        {
            $message = "Failed to validate";
            return array(
                'msg' => $message,
                'status' => '0'
            );
        }

       
    }
}
