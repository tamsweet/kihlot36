<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use App\Setting;
use Session;
use App\Currency;
use App\InstructorSetting;
use Illuminate\Support\Facades\Validator;
use App\ColorOption;
use Tracker;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);


        try {
            \DB::connection()->getPdo();
            

            $code = @file_get_contents(public_path() . '/code.txt');

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip_address = @$_SERVER['HTTP_CLIENT_IP'];
            }
            //whether ip is from proxy
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip_address = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            //whether ip is from remote address
            else {
                $ip_address = @$_SERVER['REMOTE_ADDR'];
            }

            $d = \Request::getHost();
            $domain = str_replace("www.", "", $d);

            if ($domain == 'localhost' || strstr($domain, '.test') || strstr($domain, '192.168.0') || strstr($domain, 'mediacity.co.in')) {
                // No Code
            }else{
                Tracker::validSettings($code,$domain,$ip_address);
            }

            $data = array();

            if(\DB::connection()->getDatabaseName()){
                if (Schema::hasTable('settings')) {
                   
                    $gsetting = Setting::first();
                    $currency = Currency::first();
                    $isetting = InstructorSetting::first();
                    $zoom_enable = Setting::first()->zoom_enable;

                    $data = array(

                        'gsetting' => $gsetting ?? '',
                        'currency' => $currency ?? '',
                        'isetting' => $isetting ?? '',
                        'zoom_enable' => $zoom_enable ?? '',
                    );



                    view()->composer('*', function ($view) use ($data){

                        try {

                            if(\DB::connection()->getDatabaseName()){
                              if(Schema::hasTable('settings')){
                                
                                
                                $view->with([
                                    'gsetting' => $data['gsetting'],
                                    'currency' => $data['currency'],
                                    'isetting' => $data['isetting'],
                                    'zoom_enable' => $data['zoom_enable'],
                                ]);

                              }
                            }
                        } catch (\Exception $e) {

                        }
                    });

                }
            }
        }catch(\Exception $ex){

          
        }
    
    }
}
