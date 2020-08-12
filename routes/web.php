<?php


// Route::get('/home', function () {
//     return view('home');
// });

// Route::get('/admin/home', function () {
//     return view('admin.home');
// });

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/home', 'HomeController@index');


// Route::get('/admin/home', 'HomeAdminController@index');

use Illuminate\Support\Facades\Storage;

Route::get('welcome', function () {
    // $path = public_path('storage/public');
    $files = Storage::allFiles();
    // $directories = Storage::allDirectories();
    dd($files);
});

Auth::routes(['register' => false]);

Route::get('admin-login', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('admin-login', 'Admin\LoginController@login');
Route::get('admin/password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin/password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

Route::get('admin/password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/password/update', 'Admin\ResetPasswordController@reset')->name('admin.password.update');

Route::get('admin-email/verify', 'Admin\VerificationController@show')->name('admin.verification.notice');
Route::get('admin-email/verify/{id}', 'Admin\VerificationController@verify')->name('admin.verification.verify');
Route::get('admin-email/resend', 'Admin\VerificationController@resend')->name('admin.verification.resend');



Route::get('email/verify', 'Auth\RegisterController@verifyEmail')->name('email.verify');
// Route::get('email/verify/resend', 'Auth\RegisterController@resendEmail')->name('email.verify.resend');
Route::get('email/verify/{email}/{token}', 'Auth\RegisterController@emailVerified')->name('email.verified');

Route::post('admin-logout', 'Auth\LoginController@logout')->name('admin.logout');
/**********************************************************************************************************/

// Route::get('customer-register', 'Customer\RegisterController@showRegistrationForm');
Route::post('customer-register', 'Auth\RegisterController@register')->name('customer.register');

// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('customer-login', 'CustomerController@index')->name('customer.login');
Route::post('customer-login', 'CustomerController@checkAuth');
Route::post('/password/request', 'Auth\LoginController@index');
// Route::post('customer-login', 'Auth\LoginController@login')->name('login');
// Route::post('customer-login', function () {
//     return view('welcome');
// });
Route::post('customer-logout', 'Auth\LoginController@logout')->name('customer.logout');


// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::get('/password/reset', 'Auth\ForgotPasswordController@index');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


/**********************************************************************************************************/

//Customers' routes
Route::get('/', 'CustomerController@index')->name('customer.index'); //Named routes is in middleware redirectIfauthenticted
Route::get('/welcome', function () {
    return view('welcome');
}); //Named routes is in middleware redirectIfauthenticted
// Route::get('/products', 'ProductsController@index');
Route::get('/customer/getProducts', 'CustomerController@products');
Route::get('/view_product/{slug}', 'CustomerController@index');
// Route::get('/customer/categories', 'CategoriesController@categories');

Route::get('/cart', 'CustomerController@index');

Route::get('/checkout', 'CheckoutController@index');
Route::post('/complete_order', 'CheckoutController@store');
Route::get('/order_confirmation', 'CheckoutController@index');
Route::get('/customer/myAccount', 'CustomerController@myAccount');
Route::get('/purchases/history', 'CustomerController@purchaseHistory');
Route::get('/purchases/current', 'CustomerController@currentBasket');
Route::post('/customer/order/cancel', 'CustomerController@cancelOrder');
Route::post('/customer/order/delete', 'CustomerController@destroyOrder');
// Route::get('/payment', 'AfricasTalkingController@index');

// Route::get('/customer-login', 'CustomerController@index');
// Route::post('/customer/user', 'CustomerController@show'); //get the customer details
// Route::post('/customer-login', 'CustomerController@login');
// Route::post('/customer-register', 'CustomerController@register');
// Route::post('/customer-logout', 'CustomerController@logout');

//paypal payments
//create paypal payments
Route::post('/paypal-create', 'PaypalController@createPayment');
Route::get('/paypal-execute', 'PaypalController@executePayment');
//paypal subscription payments
//create paypal subscription plan
Route::get('/billingPlan/create', 'SubscriptionsController@createPlan');
Route::get('/billingPlan/list', 'SubscriptionsController@listPlan');
Route::get('/billingPlan/{id}', 'SubscriptionsController@showPlan');
Route::get('/billingPlan/{id}/activate', 'SubscriptionsController@activatePlan');
//create paypal subscription agreement
Route::post('/billingPlan/{id}/agreement/create', 'SubscriptionsController@createAgreement')->name('create-agreement');
Route::get('/execute-agreement/{success}', 'SubscriptionsController@executeAgreement');

//mpesa payment
Route::post('mpesa-create', 'MpesaController@create')->name('mpesa-payment');
Route::post('mpesa/callback', 'MpesaController@callback');

//customers routes

// Route::get('/checkAuth', 'CustomerController@checkAuthentication');
// Route::get('/account/admin/checkAuth', 'Auth\LoginController@checkAuthentication');
















/* ********************************************************************************************************/

// Route::POST('admin/home', 'AdminController@index');
// Route::GET('admin', 'Admin\LoginController@showLoginForm')->name('admin.login');
// Route::POST('admin', 'Admin\LoginController@login');
// Route::POST('admin/logout', 'Admin\LoginController@logout');
// Route::POST('password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
// Route::GET('password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
// Route::POST('password/reset', 'Admin\ResetPasswordController@reset');
// Route::GET('password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');





//Admin routes


// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/account/admin/dashboard', 'DashboardController@index')->name('admin.index'); //Named routes is in middleware redirectIfauthenticted
// Route::get('/account/admin/dashboard', 'DashboardController@index');
Route::get('/dashboard/summary', 'DashboardController@summaries');
Route::get('/dashboard/products', 'DashboardController@products');
Route::get('/dashboard/sales', 'DashboardController@sales');

// Categories routes
Route::get('/account/admin/categories', 'CategoriesController@index');
// Route::get('/categories/get', 'CategoriesController@create');
Route::get('/categories/get', 'CategoriesController@create');
Route::post('/categories', 'CategoriesController@store');
Route::put('/categories/{category}', 'CategoriesController@update');
Route::post('/categories/delete', 'CategoriesController@destroy');

//Products routes
Route::get('/account/admin/products', 'ProductsController@index');
Route::get('/products', 'ProductsController@create');
Route::post('/products', 'ProductsController@store');
Route::post('/products/update', 'ProductsController@update');
Route::delete('/products/{product}', 'ProductsController@destroy');
//Orders routes
Route::get('/account/admin/orders', 'ordersController@index');
Route::get('/orders', 'ordersController@create');
Route::post('/orders/{order}', 'ordersController@show');
Route::put('/orders/{order}', 'ordersController@update');
Route::delete('/orders/{order}', 'ordersController@destroy');

//Users routes
Route::get('/account/admin/users', 'EmployeesController@index');
Route::get('/users', 'EmployeesController@create');
Route::post('/users', 'EmployeesController@store');
Route::post('/users/{user}', 'EmployeesController@update');
Route::delete('/users/{user}', 'EmployeesController@destroy');

//Admin Customers routes
Route::get('/account/admin/customers', 'ManageCustomersController@index');
Route::get('/customers', 'ManageCustomersController@create');
Route::post('/customers/update', 'ManageCustomersController@update');
Route::delete('/customers/{customer}', 'ManageCustomersController@destroy');
