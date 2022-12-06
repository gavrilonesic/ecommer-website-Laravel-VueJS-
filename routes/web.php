<?php

use App\Http\Controllers\BecomeADistributorController;
use Spatie\Honeypot\ProtectAgainstSpam;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/addshipping', 'Front\TestController@AddShipping');

Route::group(['namespace' => 'Front'], function () {
    // Route::get('/home', 'HomeController@index')->name('home');
    // Route::get('/test', 'TestController@index')->name('test');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/contact-us', 'ContactController@index')->name('contact_us');
    Route::post('/contact-us', 'ContactController@store')->name('contactsubmission')->middleware(ProtectAgainstSpam::class);
    Route::get('/become-a-distributor', [BecomeADistributorController::class, 'index'])->name('become_a_distributor.index');
    Route::post('/become-a-distributor', [BecomeADistributorController::class, 'store'])->name('become_a_distributor.store');
    Route::get('/sds', 'SdsController@index')->name('sds');
    Route::post('/sds', 'SdsController@store')->name('sdssubmission')->middleware(ProtectAgainstSpam::class);
    Route::get('/index', 'HomeController@index')->name('home1');
    Route::get('/category/{parentCategory}', 'CategoryController@getChildCategories')->name('category.view');
    Route::get('/category/inquiry/{parentCategory}', 'CategoryController@getCategoryInquiryForm')->name('category.inquiry');
    Route::post('/category/inquiry/{parentCategory}', 'CategoryController@postCategoryInquiryForm')->name('submit.category.inquiry');
    Route::get('/pages/{slug}', 'HomeController@getpage')->name('pages.slug');
    Route::get('/store', 'ProductController@index')->name('store');
    Route::get('/product/search', 'ProductController@search')->name('product.search');
    Route::get('/product/{product}', 'ProductController@detail')->name('product.detail');
    Route::post('newsletter', 'NewsLetterController@index')->name('newsletter');
    Route::post('/product/update-product-detail', 'ProductController@updateProductDetail');
    Route::get('/product/quick-view/{slug}', 'ProductController@quickView')->name('product.quick_view');
    Route::post('/product/addreviews', 'ProductController@addreviews')->name('product.addreview')->middleware(ProtectAgainstSpam::class);
    Route::post('/cart/add/{slug}', 'CartController@add')->name('checking_cart');
    Route::post('/cart/add-to-cart', 'CartController@addToCart')->name('add_to_cart');
    Route::post('/cart/update-to-cart', 'CartController@updateToCart')->name('update_to_cart');
    Route::get('/cart', 'CartController@index')->name('cart');
    Route::get('/add-to-wishlist', 'WishlistController@addTo')->name('add_to_wishlist');

    // Checkout page.
    Route::post('/apply-coupon', 'OrderController@applyCoupon')->name('checkout');
    Route::get('/checkout', 'OrderController@checkout')->name('checkout');
    Route::post('/confirm-order', 'OrderController@confirmOrder')->name('confirm_order')->middleware(ProtectAgainstSpam::class);
    Route::get('/order-place', 'OrderController@placedOrder')->name('place_order');
    Route::post('/order-cancel', 'OrderController@orderCancel')->name('order_cancel');
    Route::get('/shipping', 'ShippingController@index')->name('shipping');
    Route::post('/shipping-quotes', 'ShippingController@getShippingQuotes')->name('shipping_quotes');
    Route::post('/shipping-calculation', 'ShippingController@getLegibleCouriers')->name('get_couriers');
    Route::post('/shipping-calculation', 'ShippingController@shippingCalculation')->name('shipping_calculation');
    // Route::get('sitemap', 'SitemapController@index')->name('sitemap');

    Route::group(['middleware' => ['user.auth']], function () {
        Route::get('/my-profile', 'AccountController@myProfile')->name('my_profile');
        Route::put('/my-profile', 'AccountController@update');
        Route::put('/change-password', 'AccountController@changePassword')->name('change_password');
        Route::get('/my-order', 'OrderController@index')->name('my_order');
        Route::get('/wishlists', 'WishlistController@index')->name('wishlist');
        Route::get('/remove-from-wishlist', 'WishlistController@destroy');
        Route::get('/my-addresses', 'AccountController@myaddresses')->name('my_addresses');
        Route::get('/my-addresses/add', 'AccountController@address_add')->name('add_address');
        Route::post('/my-addresses/add', 'AccountController@address_save')->name('save_address');
        Route::get('/my-addresses/{address}/edit', 'AccountController@address_edit')->name('address.edit');
        Route::put('/my-addresses/{address}/edit', 'AccountController@address_update')->name('address.update');
        Route::delete('/my-addresses/{address}/delete', 'AccountController@address_delete')->name('address.delete');
        Route::post('/uploadimage', 'AccountController@uploadimage')->name('uploadimage');
        Route::get('/view-invoice/{order_id}', 'AccountController@view_invoice')->name('view.downloadinvoice');
    });
    // Login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login')->name('user.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Register
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->name('user.register');

    Route::post('shipping-address', 'AddressController@shippingAddress')->name('user.shipping_address');
    Route::post('address-confirmation', 'AddressController@addressConfirmation')->name('user.address_confirmation');
    Route::post('billing-address', 'AddressController@billingAddress')->name('user.billing_address');
    Route::post('state', 'AddressController@getState')->name('get-state');
    Route::post('city', 'AddressController@getCity')->name('get-city');

    // Passwords
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}/{email}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    // Must verify email
    // Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    // Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    // Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
});

Route::get('/import-live/users', 'ImportLiveController@users');
Route::get('/import-live/user-addresses', 'ImportLiveController@userAddresses');
Route::get('/import-live/user-addresses-company', 'ImportLiveController@userAddressesCompany');
Route::get('/import-live/read-user-addresses', 'ImportLiveController@readUserArray');
Route::get('/import-live/orders', 'ImportLiveController@orders');
Route::get('/import-live/orders-status', 'ImportLiveController@orderStatus');
Route::get('/import-live/orders-guest', 'ImportLiveController@orderGuest');
Route::get('/import-live/order-products', 'ImportLiveController@ordersProducts');
Route::get('/import-live/order-update-transaction', 'ImportLiveController@orderUpdateTransaction');
Route::get('/import-live/update-big-id', 'ImportLiveController@updateBigId');
Route::get('/import-live/redirect-url', 'ImportLiveController@importRedirectUrl');
Route::get('/import-live/map-big-url', 'ImportLiveController@mapBigUrl');
