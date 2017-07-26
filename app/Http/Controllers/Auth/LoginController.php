<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use Kodeine\Acl\Models\Eloquent\Role;

//Models
use App\Models\CorreoSolicitudCobro;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
    * Log the user out of the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/terminal/login');
    }


      /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }



      /**
      * Handle a login request to the application.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
      */
     public function login(Request $request)
     {
         //dd( $request->all());
         $this->validateLogin($request);

         // If the class is using the ThrottlesLogins trait, we can automatically throttle
         // the login attempts for this application. We'll key this by the username and
         // the IP address of the client making these requests into this application.
         if ($this->hasTooManyLoginAttempts($request)) {
             $this->fireLockoutEvent($request);

             return $this->sendLockoutResponse($request);
         }

         if ($this->attemptLogin($request)) {
             return $this->sendLoginResponse($request);
         }

         // If the login attempt was unsuccessful we will increment the number of attempts
         // to login and redirect the user back to the login form. Of course, when this
         // user surpasses their maximum number of attempts they will get locked out.
         $this->incrementLoginAttempts($request);

         return $this->sendFailedLoginResponse($request);
     }

     /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }



      /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }



    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        //dd( $request->all());
        $success = false;
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $usuario = $this->guard()->user();
        $rol = '';

        //dd( $usuario->getRoles() );
        // if ( $request->ajax() )//Esta porcion de codigo es para cuando se haga peticon ajax, no olvidar descomentar
        // {
        //
        //      if( $this->authenticated($request, $this->guard()->user()) ) {
        //          return response()->json([
        //             'success' => $success,
        //             'msg' => Lang::get('auth.fallado')
        //          ]);
        //      }
        //      else {
        //
        //         $id  = $usuario->id;
        //         $rol = $usuario->getRoles();
        //         $rol = $rol[$id];
        //
        //         $tiene_envio_frecuencia = CorreoSolicitudCobro::select('shipping_frecuency')
        //                   ->whereExists( function ($query) use ($id) {
        //                      $query->select(\DB::raw(1))
        //                            ->from('users')
        //                            ->whereRaw('correos_solicitud_cobro.user_id = users.id');
        //                   })
        //                   ->where('user_id', '=' , $id)
        //                   ->first();
        //
        //
        //         //dd( $tiene_envio_frecuencia->toArray() );
        //         if ( $tiene_envio_frecuencia ) {
        //            $tiene_envio_frecuencia = $tiene_envio_frecuencia->shipping_frecuency;
        //           // dd( $tiene_envio_frecuencia );
        //         }
        //         $success = true;
        //
        //         return response()->json([
        //             'success' => $success,
        //             'msg' => Lang::get('auth.logueado'),
        //             'redirectPath' => $this->redirectPath(),
        //             'rol' => $rol,
        //             'usuario' => $usuario->first_name.' '.$usuario->last_name,
        //             'usuario_id' => $usuario->id,
        //             'tiene_envio_frecuencia' => $tiene_envio_frecuencia
        //         ]);
        //      }
        // }
        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // if( Auth::check() ) {
        //     return 'autenticado';
        // }else {
        //     return 'no autenticado';
        // }
    }


    /**
    * Get the failed login response instance.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    protected function sendFailedLoginResponse(Request $request)
    {
       $errors = [$this->username() => trans('auth.fallado')];

       if ($request->expectsJson()) {
           return response()->json($errors, 422);
       }

       return redirect()->back()
           ->withInput($request->only($this->username(), 'remember'))
           ->withErrors($errors);
    }


      /**
      * Get the login username to be used by the controller.
      *
      * @return string
      */
     public function username()
     {
         return 'email';
     }


       /**
      * Get the guard to be used during authentication.
      *
      * @return \Illuminate\Contracts\Auth\StatefulGuard
      */
     protected function guard()
     {
         return Auth::guard();
     }


     /**
     * Lógica de Redireccion cuando se loguea
     * @return [type] [description]
     */
    protected function redirectPath()
    {
        if( $this->guard()->user()->hasRole('vendedor') ){

          return $this->redirectTo = 'terminal/pay-order';
        //    return $redirectTo'terminal/pay-order';
        }
          return $this->redirectTo = '/administrador';
      //  return redirect('terminal/login');

    }

}
