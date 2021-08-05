<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//see vendor\laravel\ui\auth-backend
use Illuminate\Http\Request; //see https://laravel.com/docs/8.x/requests

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers; //use the authenticateusers trait

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    protected $redirectTo = '/';

    //protected $redirectTo = request()->URL();

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        //$this->middleware('auth')->except('ForcedRedirectTo');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() //overrides showLoginForm function in authenticatesusers.php
    {
        session()->put('previousUrl', url()->previous());
        /*store the URL of the previous page (value) in the key 'previousUrl'
          see https://laravel.com/docs/8.x/session#storing-data
          url()->previous() gets the full URL for the previous request 
          see https://laravel.com/docs/8.x/urls#accessing-the-current-url
          */

        //return view('auth.login');
        return view('auth.custom-login');
    }

    public function redirectTo()
    {
        //dd(session()->get('previousUrl'));
        /*code condition to make exception for redirection when route is admin/login*/
        //$current_uri = $request->path();
        /* see https://laravel.com/docs/8.x/requests#retrieving-the-request-path */

        return str_replace(url('/'), '', session()->get('previousUrl', '/'));
        /* str_replace(find, replace, string, count)
           find	 Required. Specifies the value to find
           replace	Required. Specifies the value to replace the value in find
           string	Required. Specifies the string to be searched
           count	Optional. A variable that counts the number of replacements

           url('/') generates the base URL 
           see https://laravel.com/docs/8.x/urls#generating-urls
        
           session()->get('key', 'default')
           retrieve the value stored in key
           the default value returned if the specified key does not exist in the session 
        */
        /*if( $current_uri != 'admin/login')
        {
            return str_replace(url('/'), '', session()->get('previousUrl', '/'));
            /* str_replace(find, replace, string, count)
            find	 Required. Specifies the value to find
            replace	Required. Specifies the value to replace the value in find
            string	Required. Specifies the string to be searched
            count	Optional. A variable that counts the number of replacements

            url('/') generates the base URL 
            see https://laravel.com/docs/8.x/urls#generating-urls
            
            session()->get('key', 'default')
            retrieve the value stored in key
            the default value returned if the specified key does not exist in the session 
            */
        //}
    }

    /*public function CustomRedirectTo(Request $request)
    {

        //session()->flash('success', 'Registration successful'); 
        // return '/companies';
        $current_uri = $request->path();

        if( $current_uri != 'admin/login')
        {
            //dd($current_uri);

            return str_replace(url('/'), '', session()->get('previousUrl', '/'));
            /* str_replace(find, replace, string, count)
            find	 Required. Specifies the value to find
            replace	Required. Specifies the value to replace the value in find
            string	Required. Specifies the string to be searched
            count	Optional. A variable that counts the number of replacements

            url('/') generates the base URL 
            see https://laravel.com/docs/8.x/urls#generating-urls
            
            session()->get('key', 'default')
            retrieve the value stored in key
            the default value returned if the specified key does not exist in the session 
            */
        //}

        //return '/admin/login';
    //}

}
