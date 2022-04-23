<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Frontend\FrontendOrderController;
use App\Http\Controllers\Backend\GenericController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SslCommerzPaymentController;

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

    Route::get('/', [HomeController::class,"welcome"])->name('welcome');

    Route::get("/register",[RegisterController::class,"index"])->name("register");
    Route::post("/register",[RegisterController::class,"register"])->name("register");
    Route::get("/login",[LoginController::class,"index"])->name("login");
    Route::post("/login",[LoginController::class,"login"])->name("login");
    Route::post('/logout',[LoginController::class,'logout'])->name('logout');
    Route::get("/password/email",[ForgotPasswordController::class,"index"])->name("password.email");
    Route::post("/password/email",[ForgotPasswordController::class,"sendMail"])->name("password.email");
    Route::get("/password/reset",[ForgotPasswordController::class,"resetForm"])->name("password.reset");
    Route::post("/password/reset",[ForgotPasswordController::class,"reset"])->name("password.reset");
    
    
    
    Route::group(["prefix"=>"customer","middleware"=>["auth","customer"]],function(){
        Route::get("/dashboard",[HomeController::class,"customerDashboard"])->name("customer.dashboard");
        Route::get("/myaccount",[HomeController::class,"myaccount"])->name("myaccount");
        Route::post("/myaccount/update",[HomeController::class,"updateAccount"])->name("myaccount.update");
        Route::get('/product/view/{id}',[FrontendOrderController::class,'showproduct'])->name('product.view');
        Route::get('/cart/add{id}',[FrontendOrderController::class,'addToCart'])->name('cart.add');
        Route::group(["middleware"=>["cart"]],function(){
            Route::get('/cart/view',[FrontendOrderController::class,'viewCart'])->name('cart.view');
            Route::get('/cart/clear',[FrontendOrderController::class,'clearCart'])->name('cart.clear');
            Route::post("/cart/upadte",[FrontendOrderController::class,"updateCart"])->name("cart.update");
            Route::get("/cart/delete/{cart_id}",[FrontendOrderController::class,"deleteCart"])->name("cart.delete");
        });
        Route::post("/search",[ProductController::class,"search"])->name("search");
        Route::get("/my-orders",[HomeController::class,"myorders"])->name("myorders");
        Route::get("/my-order/details/{id}",[HomeController::class,"orderDetails"])->name("my-order.details");
    });

    

    /*============ Admin or Backend Routes ===============*/

    Route::group(['prefix'=>'admin','middleware'=>['auth','admin']],function(){
        Route::get("/dashboard",[HomeController::class,"adminDashboard"])->name("admin.dashboard");
         // Product Routes
        Route::get('/product',[ProductController::class,'product'])->name('admin.product.show');
        Route::get('/product/create',[ProductController::class,'productCreate'])->name('product.create');
        Route::post('/product/store',[ProductController::class,'productStore'])->name('product.store');
        Route::get("/product/show/{id}",[ProductController::class,"show"])->name("admin.product.single");
        Route::get('/product/edit/{id}',[ProductController::class,'productEdit'])->name('product.edit');
        Route::put('/product/update',[ProductController::class,'productUpdate'])->name('product.update');
        Route::get('/product/delete/{id}',[ProductController::class,'productDelete'])->name('product.delete');

        // Category Routes
        Route::get('/category',[CategoryController::class,'category'])->name('admin.category.show');
        Route::get('/category/form',[CategoryController::class,'categoryForm'])->name('category.form');
        Route::post('/category/post',[CategoryController::class,'categoryPost'])->name('category.post');
        Route::get("/category/edit/{id}",[CategoryController::class,"edit"])->name("category.edit");
        Route::post("/category/update",[CategoryController::class,"update"])->name("category.update");
        Route::get("category/delete/{id}",[CategoryController::class,"delete"])->name("category.delete");

        // Category Routes
        Route::get('/generic',[GenericController::class,'generic'])->name('admin.generic.show');
        Route::get('/generic/form',[GenericController::class,'genericForm'])->name('generic.form');
        Route::post('/generic/post',[GenericController::class,'genericPost'])->name('generic.post');
        Route::get("/generic/edit/{id}",[GenericController::class,"edit"])->name("generic.edit");
        Route::post("/generic/update",[GenericController::class,"update"])->name("generic.update");
        Route::get("generic/delete/{id}",[GenericController::class,"delete"])->name("generic.delete");

       
        

        //Customer related routes
        Route::get('/customer',[CustomerController::class,'customer'])->name('admin.customer.show');
        Route::get('/customer/form',[CustomerController::class,'customerForm'])->name('customer.form');
        Route::post('/customer/post',[CustomerController::class,'customerPost'])->name('customer.post');
        Route::get("/customer/delete/{id}",[CustomerController::class,"delete"])->name("customer.delete");

        Route::get('/stock',[StockController::class,'stock'])->name('admin.stock.show');
        Route::get('/stock/form',[StockController::class,'stockForm'])->name('stock.form');
        Route::post('/stock/post',[StockController::class,'stockPost'])->name('stock.post');

        Route::get('/order',[OrderController::class,'order'])->name('admin.order.show');
        Route::get('/order/form',[OrderController::class,'stockForm'])->name('order.form');
        Route::post('/order/post',[OrderController::class,'stockPost'])->name('order.post');
        Route::get("/order/details/{id}",[OrderController::class,"orderDetails"])->name("order.details");
        Route::get("/order/edit/{id}",[OrderController::class,"editOrder"])->name("order.edit");
        Route::get("/order/delete/{id}",[OrderController::class,"deleteOrder"])->name("order.delete");
    });

    /*============ Payment Gateway Routes ===============*/
    Route::group(['middleware'=>'auth'],function (){
        Route::get('/checkout',[FrontendOrderController::class,'checkout'])->name('checkout'); 
        //form dekhbo
        Route::post('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay'); 
        // submit korbo
        Route::post('/success', [SslCommerzPaymentController::class, 'success']);
        Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
        Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
        Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
                
                
    });
