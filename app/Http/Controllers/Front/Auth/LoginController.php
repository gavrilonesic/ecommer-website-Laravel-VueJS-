<?php

namespace App\Http\Controllers\Front\Auth;

use App\CartStorage;
use App\Http\Controllers\Front\FrontController;
use App\Wishlist;
use Cart;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;

class LoginController extends FrontController
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
    protected $redirectTo = '/my-profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct();

        $this->middleware('guest')->except('logout');
        if ($request->isMethod('post')) {
            config(['shopping_cart.storage' => \App\DBStorage::class]);
        }
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    /*public function login(Request $request) {

    }*/

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        if (Session::has('cartSession')) {
            $cart = Session::get('cartSession');
            Session::forget('cartSession');
        }
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $cartSessionId = $this->guard()->user()->id;

        CartStorage::getSession();
        $cartData = Cart::session($cartSessionId)->getContent()->toArray();

        if (!empty($cartData) && !empty($cart)) {
            foreach ($cart as $key => $value) {
                if (isset($cartData[$value['id']])) {
                    unset($cart[$key]);
                }
            }
        }
        if (!empty($cart)) {
            Cart::session($cartSessionId)->session($cartSessionId)->add($cart);
        }

        // Add to wishlists
        if (!empty($request->slug)) {
            Wishlist::addToWishlist($request->slug);
        }
        if (!empty($request->login_from_checkout)) {
            $this->redirectTo = route('checkout');
        }
        return $this->authenticated($request, $this->guard()->user())
        ?: redirect()->intended($this->redirectPath());
    }
}
