<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Branch\BranchController;
use App\Http\Controllers\Detail\DetailController;
use App\Http\Controllers\Region\RegionController;
use App\Http\Controllers\Order\OrderUserController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Order\OrderBranchController;
use App\Http\Controllers\Order\OrderRegionController;
use App\Http\Controllers\Producer\ProducerController;
use App\Http\Controllers\Branch\BranchOrderController;
use App\Http\Controllers\Order\OrderProductController;
use App\Http\Controllers\Region\RegionOrderController;
use App\Http\Controllers\Branch\BranchRegionController;
use App\Http\Controllers\Order\OrderCategoryController;
use App\Http\Controllers\Order\OrderCustomerController;
use App\Http\Controllers\Order\OrderProducerController;
use App\Http\Controllers\OrderItem\OrderItemController;
use App\Http\Controllers\Region\RegionBranchController;
use App\Http\Controllers\Branch\BranchProductController;
use App\Http\Controllers\Order\OrderOrderItemController;
use App\Http\Controllers\Product\ProductOrderController;
use App\Http\Controllers\Region\RegionProductController;
use App\Http\Controllers\Branch\BranchCategoryController;
use App\Http\Controllers\Branch\BranchCustomerController;
use App\Http\Controllers\Branch\BranchProducerController;
use App\Http\Controllers\Customer\CustomerUserController;
use App\Http\Controllers\Product\ProductBranchController;
use App\Http\Controllers\Product\ProductRegionController;
use App\Http\Controllers\Region\RegionCategoryController;
use App\Http\Controllers\Region\RegionCustomerController;
use App\Http\Controllers\Region\RegionProducerController;
use App\Http\Controllers\Branch\BranchOrderItemController;
use App\Http\Controllers\Category\CategoryOrderController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Producer\ProducerOrderController;
use App\Http\Controllers\Region\RegionOrderItemController;
use App\Http\Controllers\Category\CategoryBranchController;
use App\Http\Controllers\Category\CategoryRegionController;
use App\Http\Controllers\Customer\CustomerBranchController;
use App\Http\Controllers\Customer\CustomerRegionController;
use App\Http\Controllers\Product\ProductCategoryController;
use App\Http\Controllers\Product\ProductCustomerController;
use App\Http\Controllers\Product\ProductProducerController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Customer\CustomerProductController;
use App\Http\Controllers\OrderItem\OrderItemOrderController;
use App\Http\Controllers\Producer\ProducerProductController;
use App\Http\Controllers\Product\ProductOrderItemController;
use App\Http\Controllers\Category\CategoryCustomerController;
use App\Http\Controllers\Category\CategoryProducerController;
use App\Http\Controllers\Customer\CustomerCategoryController;
use App\Http\Controllers\Customer\CustomerProducerController;
use App\Http\Controllers\OrderItem\OrderItemBranchController;
use App\Http\Controllers\OrderItem\OrderItemRegionController;
use App\Http\Controllers\Producer\ProducerCategoryController;
use App\Http\Controllers\Producer\ProducerCustomerController;
use App\Http\Controllers\Category\CategoryOrderItemController;
use App\Http\Controllers\Customer\CustomerOrderItemController;
use App\Http\Controllers\OrderItem\OrderItemProductController;
use App\Http\Controllers\Producer\ProducerOrderItemController;
use App\Http\Controllers\Branch\BranchRegionCustomerController;
use App\Http\Controllers\Order\OrderProductOrderItemController;
use App\Http\Controllers\OrderItem\OrderItemCategoryController;
use App\Http\Controllers\OrderItem\OrderItemCustomerController;
use App\Http\Controllers\OrderItem\OrderItemProducerController;
use App\Http\Controllers\Customer\CustomerProductOrderItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* Customer */

Route::apiResource('customers.categories', CustomerCategoryController::class)->only(['index']);
Route::apiResource('customers.branches', CustomerBranchController::class)->only(['index']);
Route::apiResource('customers.regions', CustomerRegionController::class)->only(['index']);
Route::apiResource('customers.orderitems', CustomerOrderItemController::class)->only(['index']);
Route::apiResource('customers.products', CustomerProductController::class)->only(['index']);
Route::apiResource('customers.producers', CustomerProducerController::class)->only(['index']);
Route::apiResource('customers.orders', CustomerOrderController::class)->except(['show']);
Route::apiResource('customers.users', CustomerUserController::class)->except(['show']);
Route::apiResource('customers.products.orderitems', CustomerProductOrderItemController::class)->only(['store']);

/* Region */
Route::apiResource('regions', RegionController::class);
Route::apiResource('regions.customers', RegionCustomerController::class)->only(['index']);
Route::apiResource('regions.branches', RegionBranchController::class)->only(['index']);
Route::apiResource('regions.orders', RegionOrderController::class)->only(['index']);
Route::apiResource('regions.orderitems', RegionOrderItemController::class)->only(['index']);
Route::apiResource('regions.products', RegionProductController::class)->only(['index']);
Route::apiResource('regions.producers', RegionProducerController::class)->only(['index']);
Route::apiResource('regions.categories', RegionCategoryController::class)->only(['index']);

/* Branch */
Route::apiResource('branches', BranchController::class);
Route::apiResource('branches.regions.customers', BranchRegionCustomerController::class)-> only(['index','store']);
Route::apiResource('branches.customers', BranchCustomerController::class)-> only(['index']);
Route::apiResource('branches.orders', BranchOrderController::class)-> only(['index']);
Route::apiResource('branches.orderitems', BranchOrderItemController::class)-> only(['index']);
Route::apiResource('branches.products', BranchProductController::class)-> only(['index']);
Route::apiResource('branches.producers', BranchProducerController::class)-> only(['index']);
Route::apiResource('branches.categories', BranchCategoryController::class)-> only(['index']);
Route::apiResource('branches.regions', BranchRegionController::class)-> only(['index']);

/* Order */
Route::apiResource('orders', OrderController::class)->only(['index', 'show']);
Route::apiResource('orders.products.orderitems', OrderProductOrderItemController::class)->except(['index', 'show']);
Route::apiResource('orders.customers', OrderCustomerController::class)->only(['index']);
Route::apiResource('orders.branches', OrderBranchController::class)->only(['index']);
Route::apiResource('orders.regions', OrderRegionController::class)->only(['index']);
Route::apiResource('orders.orderitems', OrderOrderItemController::class)->only(['index']);
Route::apiResource('orders.products', OrderProductController::class)->only(['index']);
Route::apiResource('orders.producers', OrderProducerController::class)->only(['index']);
Route::apiResource('orders.categories', OrderCategoryController::class)->only(['index']);
Route::apiResource('orders.users', OrderUserController::class)->only(['index']);

/* OrderItem */
Route::apiResource('orderitems', OrderItemController::class)->except(['store', 'update']);
Route::apiResource('orderitems.products', OrderItemProductController::class)->only(['index']);
Route::apiResource('orderitems.producers', OrderItemProducerController::class)->only(['index']);
Route::apiResource('orderitems.categories', OrderItemCategoryController::class)->only(['index']);
Route::apiResource('orderitems.orders', OrderItemOrderController::class)->only(['index']);
Route::apiResource('orderitems.customers', OrderItemCustomerController::class)->only(['index']);
Route::apiResource('orderitems.regions', OrderItemRegionController::class)->only(['index']);
Route::apiResource('orderitems.branches', OrderItemBranchController::class)->only(['index']);

/* Product */
Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('products.customers', ProductCustomerController::class)->only(['index']);
Route::apiResource('products.producers', ProductProducerController::class)->only(['index']);
Route::apiResource('products.orderitems', ProductOrderItemController::class)->only(['index']);
Route::apiResource('products.orders', ProductOrderController::class)->only(['index']);
Route::apiResource('products.branches', ProductBranchController::class)->only(['index']);
Route::apiResource('products.regions', ProductRegionController::class)->only(['index']);
Route::apiResource('products.categories', ProductCategoryController::class)->except(['show']);

/* Producer */
Route::apiResource('producers', ProducerController::class);
Route::apiResource('producers.categories', ProducerCategoryController::class)->only(['index']);
Route::apiResource('producers.orderitems', ProducerOrderItemController::class)->only(['index']);
Route::apiResource('producers.orders', ProducerOrderController::class)->only(['index']);
Route::apiResource('producers.customers', ProducerCustomerController::class)->only(['index']);
Route::apiResource('producers.products', ProducerProductController::class)->except(['show']);


/* Category */
Route::apiResource('categories', CategoryController::class);
Route::apiResource('categories.products', CategoryProductController::class)->only(['index']);
Route::apiResource('categories.producers', CategoryProducerController::class)->only(['index']);
Route::apiResource('categories.orderitems', CategoryOrderItemController::class)->only(['index']);
Route::apiResource('categories.orders', CategoryOrderController::class)->only(['index']);
Route::apiResource('categories.customers', CategoryCustomerController::class)->only(['index']);
Route::apiResource('categories.branches', CategoryBranchController::class)->only(['index']);
Route::apiResource('categories.regions', CategoryRegionController::class)->only(['index']);

/* Users */



//Admin Routes
Route::prefix('admin')->group(function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot', [PasswordController::class, 'forgot']);
    Route::post('reset', [PasswordController::class, 'reset'])->name('reset');
    Route::post('verify', [VerifyController::class, 'verify'])->name('verify');
    Route::post('resend', [VerifyController::class, 'resend'])->name('resend');

    // Route::middleware(['auth:sanctum', 'scope.admin', 'verified'])->group(function() {
        //     Route::post('logout', [AuthController::class, 'logout']);
        //     Route::get('user', [AuthController::class, 'user']);
        // });

        Route::middleware(['auth:sanctum', 'scope.admin'])->group(function() {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('user', [AuthController::class, 'user']);

            Route::apiResource('customers', CustomerController::class)->except(['store']);
            Route::apiResource('users', UserController::class)->only(['index', 'show']);
        });
    });


