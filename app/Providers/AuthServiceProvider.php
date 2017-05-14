<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
//            if ($request->input('api_token')) {
//                return User::where('api_token', $request->input('api_token'))->first();
//            }

            $header= $request->header('Api-Token');
            $inputToken = $request->get('api-token');

//            //allow send auth only if route is /load_csv
//            if($request->getPathInfo()=='/load_csv_neshto_si'){
//                $inputToken = $request->input('api-token');
//            }
//            else{
//                $inputToken=null;
//            }

            if($header && $header==env('API_KEY') ){
                return new User();
            }
            if ($request->getPathInfo()=='/load_csv'  && $inputToken && $inputToken==env('API_KEY')){
                return new User();
            }

                return null;



        });
    }
}
