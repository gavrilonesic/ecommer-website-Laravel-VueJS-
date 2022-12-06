<?php

Route::group(['namespace' => 'Admin'], function () {
    Route::group(['middleware' => ['admin.auth']], function () {
        Route::get('/emails', 'EmailController@index')->middleware('check-permission:manage-emails|email-listing')->name('email.index');
        Route::get('/emails/{email}/edit', 'EmailController@edit')->middleware('check-permission:manage-emails|edit-email')->name('email.edit');
        Route::put('/emails/{email}/edit', 'EmailController@update')->middleware('check-permission:manage-emails|edit-email')->name('email.update');
        Route::delete('/emails/{email}/delete', 'EmailController@destroy')->middleware('check-permission:manage-emails|restore-default-email')->name('email.delete');
        Route::get('emails/{email}/send-test', 'EmailController@sendTest')->middleware('check-permission:manage-emails|send-test-email')->name('email.send_test');

        Route::get('/', 'HomeController@index')->middleware('check-permission:dashboard')->name('admin.dashboard');
        Route::get('/get-graph-data', 'HomeController@getGraphData')->middleware('check-permission:dashboard')->name('admin.dashboard.graph');
        Route::get('/edit-profile', 'AccountController@edit')->name('admin.edit');
        Route::put('/edit-profile', 'AccountController@update')->name('admin.update');
        Route::put('/change-password', 'AccountController@changePassword')->name('admin.change_password');

        //admin users
        Route::get('/users', 'UserController@index')->middleware('check-permission:manage-users|user-listing')->name('user.index');
        Route::get('/users/create', 'UserController@create')->middleware('check-permission:manage-users|add-user')->name('user.create');
        Route::post('/users/create', 'UserController@store')->middleware('check-permission:manage-users|add-user')->name('user.store');
        Route::get('/users/{user}/edit', 'UserController@edit')->middleware('check-permission:manage-users|edit-user')->name('user.edit');
        Route::put('/users/{user}/edit', 'UserController@update')->middleware('check-permission:manage-users|edit-user')->name('user.update');
        Route::get('/users/{user}/show', 'UserController@show')->middleware('check-permission:manage-users|user-listing')->name('user.show');
        Route::delete('/users/{user}/delete', 'UserController@destroy')->middleware('check-permission:manage-users|delete-user')->name('user.delete');
        Route::delete('/users/{user}/deleteimage', 'UserController@deleteimage')->name('user.deleteimage');

        //brands
        Route::get('/brands', 'BrandController@index')->middleware('check-permission:manage-brands|brand-listing')->name('brand.index');
        Route::get('/brands/create', 'BrandController@create')->middleware('check-permission:manage-brands|add-brand')->name('brand.create');
        Route::post('/brands/create', 'BrandController@store')->middleware('check-permission:manage-brands|add-brand')->name('brand.store');
        Route::get('/brands/{brand}/edit', 'BrandController@edit')->middleware('check-permission:manage-brands|edit-brand')->name('brand.edit');
        Route::put('/brands/{brand}/edit', 'BrandController@update')->middleware('check-permission:manage-brands|edit-brand')->name('brand.update');
        Route::get('/brands/{brand}/show', 'BrandController@show')->middleware('check-permission:manage-brands|brand-listing')->name('brand.show');
        Route::delete('/brands/{brand}/delete', 'BrandController@destroy')->middleware('check-permission:manage-brands|delete-brand')->name('brand.delete');
        Route::delete('/brands/{brand}/deleteimage', 'BrandController@deleteimage')->name('brand.deleteimage');

        //banners
        Route::get('/banners', 'BannerController@index')->middleware('check-permission:manage-banners|banner-listing')->name('banner.index');
        Route::get('/banners/create', 'BannerController@create')->middleware('check-permission:manage-banners|add-banner')->name('banner.create');
        Route::post('/banners/create', 'BannerController@store')->middleware('check-permission:manage-banners|add-banner')->name('banner.store');
        Route::get('/banners/{banner}/edit', 'BannerController@edit')->middleware('check-permission:manage-banners|edit-banner')->name('banner.edit');
        Route::put('/banners/{banner}/edit', 'BannerController@update')->middleware('check-permission:manage-banners|edit-banner')->name('banner.update');
        Route::get('/banners/{banner}/show', 'BannerController@show')->middleware('check-permission:manage-banners|banner-listing')->name('banner.show');
        Route::delete('/banners/{banner}/delete', 'BannerController@destroy')->middleware('check-permission:manage-banners|delete-banner')->name('banner.delete');

        //blogs
        Route::get('/blogs', 'BlogController@index')->middleware('check-permission:manage-blogs|blog-listing')->name('blog.index');
        Route::get('/blogs/create', 'BlogController@create')->middleware('check-permission:manage-blogs|add-blog')->name('blog.create');
        Route::post('/blogs/create', 'BlogController@store')->middleware('check-permission:manage-blogs|add-blog')->name('blog.store');
        Route::get('/blogs/{blog}/edit', 'BlogController@edit')->middleware('check-permission:manage-blogs|edit-blog')->name('blog.edit');
        Route::put('/blogs/{blog}/edit', 'BlogController@update')->middleware('check-permission:manage-blogs|edit-blog')->name('blog.update');
        Route::get('/blogs/{blog}/show', 'BlogController@show')->middleware('check-permission:manage-blogs|blog-listing')->name('blog.show');
        Route::delete('/blogs/{blog}/delete', 'BlogController@destroy')->middleware('check-permission:manage-blogs|delete-blog')->name('blog.delete');

        //blogs
        Route::get('/reviews', 'ReviewController@index')->middleware('check-permission:manage-reviews|review-listing')->name('review.index');
        //Route::post('/reviews', 'ReviewController@indexstore')->middleware('check-permission:manage-reviews|review-listing')->name('review.indexstore');
        Route::get('/reviews/create', 'ReviewController@create')->name('review.create');
        Route::post('/reviews/create', 'ReviewController@store')->name('review.store');
        Route::get('/reviews/{review}/edit', 'ReviewController@edit')->middleware('check-permission:manage-reviews|edit-review')->name('review.edit');
        Route::put('/reviews/{review}/edit', 'ReviewController@update')->middleware('check-permission:manage-reviews|edit-review')->name('review.update');
        Route::put('/reviews/{review}/change-status', 'ReviewController@changeStatus')->middleware('check-permission:manage-reviews|edit-review')->name('review.changeStatus');
        Route::get('/reviews/{review}/show', 'ReviewController@show')->middleware('check-permission:manage-reviews|review-listing')->name('review.show');
        Route::delete('/reviews/{review}/delete', 'ReviewController@destroy')->middleware('check-permission:manage-reviews|delete-review')->name('review.delete');

        //blog categories
        Route::get('/blogcategory', 'BlogCategoryController@index')->middleware('check-permission:manage-blog-category|blog-category-listing')->name('blogcategory.index');
        Route::get('/blogcategory/create', 'BlogCategoryController@create')->middleware('check-permission:manage-blog-category|add-blog-category')->name('blogcategory.create');
        Route::post('/blogcategory/create', 'BlogCategoryController@store')->middleware('check-permission:manage-blog-category|add-blog-category')->name('blogcategory.store');
        Route::get('/blogcategory/{blogcategory}/edit', 'BlogCategoryController@edit')->middleware('check-permission:manage-blog-category|edit-blog-category')->name('blogcategory.edit');
        Route::put('/blogcategory/{blogcategory}/edit', 'BlogCategoryController@update')->middleware('check-permission:manage-blog-category|edit-blog-category')->name('blogcategory.update');
        Route::get('/blogcategory/{blogcategory}/show', 'BlogCategoryController@show')->middleware('check-permission:manage-blog-category|blog-category-listing')->name('blogcategory.show');
        Route::delete('/blogcategory/{blogcategory}/delete', 'BlogCategoryController@destroy')->middleware('check-permission:manage-blog-category|delete-blog-category')->name('blogcategory.delete');
        Route::delete('/blogcategory/{blogcategory}/deleteimage', 'BlogCategoryController@deleteimage')->name('blogcategory.deleteimage');

        Route::get('/attributes', 'AttributeController@index')->middleware('check-permission:manage-attributes|attribute-listing')->name('attribute.index');
        Route::get('/attributes/create', 'AttributeController@create')->middleware('check-permission:manage-attributes|add-attribute')->name('attribute.create');
        Route::post('/attributes/create', 'AttributeController@store')->middleware('check-permission:manage-attributes|add-attribute')->name('attribute.store');
        Route::get('/attributes/{attribute}/edit', 'AttributeController@edit')->middleware('check-permission:manage-attributes|edit-attribute')->name('attribute.edit');
        Route::put('/attributes/{attribute}/edit', 'AttributeController@update')->middleware('check-permission:manage-attributes|edit-attribute')->name('attribute.update');
        Route::get('/attributes/{attribute}/show', 'AttributeController@show')->middleware('check-permission:manage-attributes|attribute-listing')->name('attribute.show');
        Route::delete('/attributes/{attribute}/delete', 'AttributeController@destroy')->middleware('check-permission:manage-attributes|delete-attribute')->name('attribute.delete');

        //products
        Route::get('/products', 'ProductController@index')->middleware('check-permission:manage-products|product-listing')->name('product.index');
        Route::get('/product/search', 'ProductController@search')->middleware('check-permission:manage-products|product-listing')->name('product.search');
        Route::get('/products/create', 'ProductController@create')->middleware('check-permission:manage-products|add-product')->name('product.create');
        Route::post('/products/create', 'ProductController@store')->middleware('check-permission:manage-products|add-product')->name('product.store');
        Route::post('/products/createMatrix', 'ProductController@createMatrix')->middleware('check-permission:manage-products|add-product|edit-product')->name('product.matrix');
        Route::get('/products/{product}/edit', 'ProductController@edit')->middleware('check-permission:manage-products|edit-product')->name('product.edit');
        Route::put('/products/{product}/edit', 'ProductController@update')->middleware('check-permission:manage-products|edit-product')->name('product.update');
        //Route::get('/products/{product}/show', 'ProductController@show')->name('product.show');
        Route::delete('/products/{product}/delete', 'ProductController@destroy')->middleware('check-permission:manage-products|delete-product')->name('product.delete');
        Route::get('/products/{product}/status', 'ProductController@status')->middleware('check-permission:manage-products|add-product|edit-product')->name('product.status');
        Route::get('/products/csv/{file}', 'ProductController@csv')->middleware('check-permission:manage-products|import-product')->name('product.csv');
        Route::post('/products/csv/{file}', 'ProductController@execute')->middleware('check-permission:manage-products|import-product')->name('product.execute');
        Route::get('/products/export', 'ProductController@export')->middleware('check-permission:manage-products|export-product')->name('product.export');
        Route::get('/products/export-google-feed', 'ProductController@exportGoogleFeed')->middleware('check-permission:manage-products|export-product')->name('product.exportGoogleFeed');
        Route::get('/products/copy-product-field', 'ProductController@copyProductField')->middleware('check-permission:manage-products|add-product|edit-product')->name('product.copy_product_field');
        Route::post('/products/copy-product-field', 'ProductController@copyProductField')->middleware('check-permission:manage-products|add-product|edit-product');

        //customers
        Route::get('/customers', 'CustomerController@index')->middleware('check-permission:manage-customers|customer-listing')->name('customer.index');
        Route::get('/customers/{customer}/loginasuser', 'CustomerController@loginAsUser')->middleware('check-permission:manage-customers|customer-listing')->name('customer.loginasuser');
        Route::get('/customers/create', 'CustomerController@create')->middleware('check-permission:manage-customers|add-customer')->name('customer.create');
        Route::post('/customers/create', 'CustomerController@store')->middleware('check-permission:manage-customers|add-customer')->name('customer.store');
        Route::get('/customers/{customer}/edit', 'CustomerController@edit')->middleware('check-permission:manage-customers|edit-customer')->name('customer.edit');
        Route::put('/customers/{customer}/edit', 'CustomerController@update')->middleware('check-permission:manage-customers|edit-customer')->name('customer.update');
        Route::get('/customers/{customer}/show', 'CustomerController@show')->name('customer.show');
        Route::delete('/customers/{customer}/delete', 'CustomerController@destroy')->middleware('check-permission:manage-customers|delete-customer')->name('customer.delete');
        Route::get('/customers/{customer}/reset_password_link', 'CustomerController@ResetPasswordLink')->middleware('check-permission:manage-customers|add-customer|edit-customer')->name('customer.reset_password_link');
        Route::post('/customers/{customer}/address/create', 'CustomerController@addressCreate')->middleware('check-permission:manage-users|add-customer')->name('user.address.store');
        Route::get('/customers/{address}/address/edit', 'CustomerController@addressEdit')->middleware('check-permission:manage-users|edit-customer')->name('user.address.edit');
        Route::put('/customers/{address}/address/edit', 'CustomerController@addressUpdate')->middleware('check-permission:manage-users|edit-customer')->name('user.address.update');
        Route::delete('/customers/{address}/address/delete', 'CustomerController@addressdestroy')->middleware('check-permission:manage-customers|delete-customer')->name('address.delete');

        //carousels
        Route::get('/carousels', 'CarouselController@index')->middleware('check-permission:manage-carousel')->name('carousel.index');
        Route::get('/carousels/create', 'CarouselController@create')->middleware('check-permission:manage-carousel|add-carousel')->name('carousel.create');
        Route::post('/carousels/create', 'CarouselController@store')->middleware('check-permission:manage-carousel|add-carousel')->name('carousel.store');
        Route::get('/carousels/{carousel}/edit', 'CarouselController@edit')->middleware('check-permission:manage-carousel|edit-carousel')->name('carousel.edit');
        Route::put('/carousels/{carousel}/edit', 'CarouselController@update')->middleware('check-permission:manage-carousel|edit-carousel')->name('carousel.update');
        Route::get('/carousels/{carousel}/show', 'CarouselController@show')->middleware('check-permission:manage-carousel|carousel-carousel')->name('carousel.show');
        Route::delete('/carousels/{carousel}/delete', 'CarouselController@destroy')->middleware('check-permission:manage-carousel|delete-carousel')->name('carousel.delete');
        Route::delete('/carousels/{carousel}/deleteimage', 'CarouselController@deleteimage')->middleware('check-permission:manage-carousel|edit-carousel')->name('carousel.deleteimage');

        //coupons
        Route::get('/coupons', 'CouponController@index')->middleware('check-permission:manage-coupons|coupon-listing')->name('coupon.index');
        Route::get('/coupons/create', 'CouponController@create')->middleware('check-permission:manage-coupons|add-coupon')->name('coupon.create');
        Route::post('/coupons/create', 'CouponController@store')->middleware('check-permission:manage-coupons|add-coupon')->name('coupon.store');
        Route::get('/coupons/{coupon}/edit', 'CouponController@edit')->middleware('check-permission:manage-coupons|edit-coupon')->name('coupon.edit');
        Route::put('/coupons/{coupon}/edit', 'CouponController@update')->middleware('check-permission:manage-coupons|edit-coupon')->name('coupon.update');
        Route::get('/coupons/{coupon}/show', 'CouponController@show')->middleware('check-permission:manage-coupons|coupon-listing')->name('coupon.show');
        Route::delete('/coupons/{coupon}/delete', 'CouponController@destroy')->middleware('check-permission:manage-coupons|delete-coupon')->name('coupon.delete');

        Route::get('/categories', 'CategoryController@index')->middleware('check-permission:manage-categories|category-listing')->name('category.index');
        Route::get('/categories/create', 'CategoryController@create')->middleware('check-permission:manage-categories|add-category')->name('category.create');
        Route::post('/categories/create', 'CategoryController@store')->middleware('check-permission:manage-categories|add-category')->name('category.store');
        Route::get('/categories/{category}/edit', 'CategoryController@edit')->middleware('check-permission:manage-categories|edit-category')->name('category.edit');
        Route::put('/categories/{category}/edit', 'CategoryController@update')->middleware('check-permission:manage-categories|edit-category')->name('category.update');
        Route::get('/categories/{category}/show', 'CategoryController@show')->middleware('check-permission:manage-categories|category-listing')->name('category.show');
        Route::delete('/categories/{category}/delete', 'CategoryController@destroy')->middleware('check-permission:manage-categories|delete-category')->name('category.delete');
        Route::get('/categories/{category}/status', 'CategoryController@status')->middleware('check-permission:manage-categories|add-category|edit-category')->name('category.status');
        Route::get('/categories/csv/{file}', 'CategoryController@csv')->middleware('check-permission:manage-categories|import-category')->name('category.csv');
        Route::post('/categories/csv/{file}', 'CategoryController@execute')->middleware('check-permission:manage-categories|import-category')->name('category.execute');
        Route::get('/categories/export', 'CategoryController@export')->middleware('check-permission:manage-categories|export-category')->name('categories.export');
        Route::delete('/categories/{category}/deleteimage', 'CategoryController@deleteimage')->name('categories.deleteimage');

        Route::get('/{importType}/import', 'FileController@import')->middleware('check-permission:manage-categories|import-{parameter}')->name('file.import');
        Route::post('/{importType}/import', 'FileController@csvUpload')->name('file.csv_upload');
        Route::get('/inquiry/search', 'CategoryInquiryController@index')->middleware('check-permission:manage-categories|category-listing')->name('inquiry.search');

        // CMS Pages
        Route::get('/cms-pages', 'CmsPageController@index')->middleware('check-permission:manage-cms-pages|cms-page-listing')->name('cms_page.index');
        Route::get('/cms-pages/create', 'CmsPageController@create')->middleware('check-permission:manage-cms-pages|add-cms-page')->name('cms_page.create');
        Route::post('/cms-pages/create', 'CmsPageController@store')->middleware('check-permission:manage-cms-pages|add-cms-page')->name('cms_page.store');
        Route::get('/cms-pages/{cmsPage}/edit', 'CmsPageController@edit')->middleware('check-permission:manage-cms-pages|edit-cms-page')->name('cms_page.edit');
        Route::put('/cms-pages/{cmsPage}/edit', 'CmsPageController@update')->middleware('check-permission:manage-cms-pages|edit-cms-page')->name('cms_page.update');
        Route::get('/cms-pages/{cmsPage}/show', 'CmsPageController@show')->middleware('check-permission:manage-cms-pages|cms-page-listing')->name('cms_page.show');
        Route::delete('/cms-pages/{cmsPage}/delete', 'CmsPageController@destroy')->middleware('check-permission:manage-cms-pages|delete-cms-page')->name('cms_page.delete');
        Route::delete('/cms-pages/{cmsPage}/deleteimage', 'CmsPageController@deleteimage')->name('cms_page.deleteimage');

        //Orders
        Route::get('/orders', 'OrderController@index')->middleware('check-permission:manage-orders|order-listing')->name('order.index');
        Route::post('/order-item/{order}/status', 'OrderController@status')->middleware('check-permission:manage-orders|order-listing')->name('order.status');
        Route::get('/orders/bulk', 'OrderController@bulkUpdate')->middleware('check-permission:manage-orders|order-listing')->name('order.bulk.edit');
        Route::post('/orders/bulk', 'OrderController@bulkUpdate')->middleware('check-permission:manage-orders|order-listing')->name('order.bulk.update');
        Route::get('/order-item/{order}/status', 'OrderController@status')->name('order.status.view');
        Route::get('/orders/order-cancel/{order_id}', 'OrderController@orderCancel')->middleware('check-permission:manage-orders|order-listing')->name('order.cancel');
        Route::get('/orders/invoice/{type}', 'OrderController@invoice')->name('order.invoice');
        Route::get('/order-item/{order}/show', 'OrderController@show')->name('order.view');
        Route::delete('/orders/{order}/delete', 'OrderController@destroy')->name('order.delete');

        //testimonials
        Route::get('/testimonials', 'TestimonialController@index')->middleware('check-permission:manage-testimonials|testimonial-listing')->name('testimonial.index');
        Route::get('/testimonials/create', 'TestimonialController@create')->middleware('check-permission:manage-testimonials|add-testimonial')->name('testimonial.create');
        Route::post('/testimonials/create', 'TestimonialController@store')->middleware('check-permission:manage-testimonials|add-testimonial')->name('testimonial.store');
        Route::get('/testimonials/{testimonial}/edit', 'TestimonialController@edit')->middleware('check-permission:manage-testimonials|edit-testimonial')->name('testimonial.edit');
        Route::put('/testimonials/{testimonial}/edit', 'TestimonialController@update')->middleware('check-permission:manage-testimonials|edit-testimonial')->name('testimonial.update');
        Route::get('/testimonials/{testimonial}/show', 'TestimonialController@show')->middleware('check-permission:manage-testimonials|testimonial-listing')->name('testimonial.show');
        Route::delete('/testimonials/{testimonial}/delete', 'TestimonialController@destroy')->middleware('check-permission:manage-testimonials|delete-testimonial')->name('testimonial.delete');
        Route::delete('/testimonials/{testimonial}/deleteimage', 'TestimonialController@deleteimage')->name('testimonial.deleteimage');

        //clients
        Route::get('/clients', 'ClientController@index')->middleware('check-permission:manage-clients|client-listing')->name('client.index');
        Route::get('/clients/create', 'ClientController@create')->middleware('check-permission:manage-clients|add-client')->name('client.create');
        Route::post('/clients/create', 'ClientController@store')->middleware('check-permission:manage-clients|add-client')->name('client.store');
        Route::get('/clients/{client}/edit', 'ClientController@edit')->middleware('check-permission:manage-clients|edit-client')->name('client.edit');
        Route::put('/clients/{client}/edit', 'ClientController@update')->middleware('check-permission:manage-clients|edit-client')->name('client.update');
        Route::delete('/clients/{client}/delete', 'ClientController@destroy')->middleware('check-permission:manage-clients|delete-client')->name('client.delete');
        Route::delete('/clients/{client}/deleteimage', 'ClientController@deleteimage')->name('client.deleteimage');

        //contactforms
        Route::get('/contactforms', 'ContactFormController@contactformlist')->middleware('check-permission:manage-contactforms|contactform-listing')->name('contactform.index');
        Route::put('/contactforms/{contactform}/edit', 'ContactFormController@update')->middleware('check-permission:manage-contactforms|edit-contactform')->name('contactform.update');
        Route::delete('/contactforms/{contactform}/delete', 'ContactFormController@deletecontactentry')->middleware('check-permission:manage-contactforms|delete-contactform')->name('contactform.delete');

        //Order Status
        Route::get('/order-status', 'OrderStatusController@index')->middleware('check-permission:manage-order-status|order-status-listing')->name('order_status.index');
        Route::get('/order-status/create', 'OrderStatusController@create')->middleware('check-permission:manage-order-status|add-order-status')->name('order_status.create');
        Route::post('/order-status/create', 'OrderStatusController@store')->middleware('check-permission:manage-order-status|add-order-status')->name('order_status.store');
        Route::get('/order-status/{orderStatus}/edit', 'OrderStatusController@edit')->middleware('check-permission:manage-order-status|edit-order-status')->name('order_status.edit');
        Route::put('/order-status/{orderStatus}/edit', 'OrderStatusController@update')->middleware('check-permission:manage-order-status|edit-order-status')->name('order_status.update');
        Route::get('/order-status/{orderStatus}/show', 'OrderStatusController@show')->middleware('check-permission:manage-order-status|order-status-listing')->name('order_status.show');
        Route::delete('/order-status/{orderStatus}/delete', 'OrderStatusController@destroy')->middleware('check-permission:manage-order-status|delete-order-status')->name('order_status.delete');

        Route::group(['prefix' => 'settings', 'middleware' => ['check-permission:manage-settings']], function () {
            Route::get('/payment-settings', 'PaymentSettingController@index')->name('payment_settings');
            Route::get('/payment-settings/{paymentSetting}', 'PaymentSettingController@edit')->name('payment_settings.edit');
            Route::put('/payment-settings/{paymentSetting}', 'PaymentSettingController@update')->name('payment_settings.update');
            Route::get('/shipping-settings', 'ShippingSettingController@index')->name('shipping_settings');
            //Route::get('/shipping-settings', 'ShippingSettingController@index')->name('shipping_settings');
            Route::get('/shipping-settings/{shippingZone}/add', 'ShippingSettingController@add')->name('shipping_settings.add');
            Route::post('/shipping-settings/{shippingZone}/add', 'ShippingSettingController@store')->name('shipping_settings.store');
            Route::get('/shipping-settings/{shippingSetting}/edit', 'ShippingSettingController@edit')->name('shipping_settings.edit');
            Route::post('/shipping-settings/{shippingSetting}/edit', 'ShippingSettingController@update')->name('shipping_settings.update');
            Route::get('/shipping-settings/{shippingSetting}/edit-shipping-setting', 'ShippingSettingController@edit')->name('shipping_settings.edit_shipping_setting');
            Route::delete('/shipping-settings/{shippingSetting}/delete', 'ShippingSettingController@destroy')->name('shipping_settings.delete');
            Route::get('/shipping-settings/{shippingSetting}/status', 'ShippingSettingController@status')->name('shipping_settings.status');
            //Route::put('/shipping-settings/{shippingSetting}', 'ShippingSettingController@update')->name('shipping_settings.update');
            Route::get('/{page}', 'SettingController@index')->name('settings');
            Route::post('/{page}', 'SettingController@store')->name('settings.store');
        });
        Route::group(['prefix' => 'video'], function () {
            Route::get('/', 'VideoController@index')->middleware('check-permission:manage-videos|video-listing')->name('video.index');
            Route::get('/create', 'VideoController@create')->middleware('check-permission:manage-videos|add-video')->name('video.create');
            Route::post('/create', 'VideoController@store')->middleware('check-permission:manage-videos|add-video')->name('video.store');
            Route::get('{video}/edit', 'VideoController@edit')->middleware('check-permission:manage-videos|edit-video')->name('video.edit');
            Route::put('{video}/edit', 'VideoController@update')->middleware('check-permission:manage-videos|edit-video')->name('video.update');
            Route::delete('/{video}/delete', 'VideoController@destroy')->middleware('check-permission:manage-videos|delete-video')->name('video.delete');
        });
    });

    // Login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

    // // Register
    // Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
    // Route::post('register', 'Auth\RegisterController@register');

    // Passwords
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

    // Must verify email
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('admin.verification.resend');
    Route::get('email/verify', 'Auth\VerificationController@show')->name('admin.verification.notice');
    Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('admin.verification.verify');

});
