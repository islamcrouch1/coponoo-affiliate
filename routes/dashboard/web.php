<?php

use Illuminate\Support\Facades\Route;

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





Route::redirect('/dashboard', 'ar/dashboard');
// Route::redirect('/','ar/dashboard');



Route::group(['prefix' => '{lang}'], function () {



    Route::get('/send-conf', 'PasswordResetController@sendConf')->name('send.conf');
    Route::get('/password-reset-request/{country}', 'PasswordResetController@index')->name('password.reset.request');
    Route::post('/password-reset-verify/{country}', 'PasswordResetController@verify')->name('password.reset.verify');
    Route::post('/password-reset-change/{country}', 'PasswordResetController@change')->name('password.reset.change');
    Route::get('/password-reset-confirm-show/{country}', 'PasswordResetController@show')->name('password.reset.confirm.show');
    Route::get('/password-reset-resend/{country}', 'PasswordResetController@resend')->name('resend.code.password');
    Route::post('/password-reset-confirm-password/{country}', 'PasswordResetController@confirm')->name('password.reset.confirm.password');
});

Route::group(['prefix' => '{lang}', 'middleware' => ['role:superadministrator|administrator|affiliate|vendor']], function () {

    Route::get('/dashboard', 'HomeController@index')->name('home')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/ban-users', 'BanController@ban')->name('ban')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::resource('/dashboard/users', 'AdminUsersController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('users/export/', 'AdminUsersController@export')->name('users.export')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('orders/export/', 'AdminUsersController@ordersExport')->name('orders.export')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('withdrawals/export/', 'AdminUsersController@withdrawalsExport')->name('withdrawals.export')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('products/export/', 'AdminUsersController@productsexport')->name('products.export')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('products/export/vendor', 'VendorProductsController@productsexport')->name('products.export.vendor')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::post('products/import/', 'AdminUsersController@import')->name('products.import')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::post('products/import/vendor', 'VendorProductsController@import')->name('products.import.vendor')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::get('/trashed-users', 'AdminUsersController@trashed')->name('users.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-users/{user}', 'AdminUsersController@restore')->name('users.restore')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/activate-users/{user}', 'AdminUsersController@activate')->name('users.activate')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/block-users/{user}', 'AdminUsersController@block')->name('users.block')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/deactivate-users/{user}', 'AdminUsersController@deactivate')->name('users.deactivate')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/monitors-users/{user}', 'AdminUsersController@monitor')->name('users.monitor')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/wallet-users/{user}', 'AdminUsersController@addBalance')->name('users.wallet')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/wallet_all-users', 'AdminUsersController@addBalanceAll')->name('users.wallet_all')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::get('/activate-users/{user}', 'AdminUsersController@activate')->name('users.activate')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/deactivate-users/{user}', 'AdminUsersController@deactivate')->name('users.deactivate')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::get('phone/verify/{country}/{user}', 'PhoneVerificationController@show')->name('phoneverification.notice')->middleware('auth', 'checkstatus', 'checkuser');
    Route::post('phone/verify/{country}', 'PhoneVerificationController@verify')->name('phoneverification.verify')->middleware('auth', 'checkstatus');
    Route::get('/resend-code/{user}/{country}', 'PhoneVerificationController@resend')->name('resend-code')->middleware('auth')->middleware('auth', 'checkstatus', 'checkuser');



    Route::get('/trashed-roles', 'RoleController@trashed')->name('roles.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-roles/{role}', 'RoleController@restore')->name('roles.restore')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::resource('/dashboard/roles', 'RoleController')->middleware('auth', 'verifiedphone', 'checkstatus');




    Route::resource('/dashboard/categories', 'CategoriesController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-categories', 'CategoriesController@trashed')->name('categories.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-categories/{category}', 'CategoriesController@restore')->name('categories.restore')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::resource('/dashboard/vendor-products', 'VendorProductsController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/dashbaord/vendor-products/addcolor/{product}', 'VendorProductsController@addColor')->name('vendor-products.color')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/dashbaord/vendor-products/addcolor/{product}', 'VendorProductsController@storeColor')->name('vendor-products.store_color')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::resource('/dashboard/products', 'ProductsController');
    Route::get('/products-stock/{product}', 'ProductsController@showAddStock')->name('products.stock.add')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/products-store/{product}', 'ProductsController@addStock')->name('products.stock.store')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::get('/products-stock-vendor/{product}', 'VendorProductsController@showAddStock')->name('products.vendor.stock.add')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/products-store-vendor/{product}', 'VendorProductsController@addStock')->name('products.vendor.stock.store')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::get('/products-destroy/{product}', 'ProductsController@destroy')->name('products.destroy.new')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-products', 'ProductsController@trashed')->name('products.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-products/{product}', 'ProductsController@restore')->name('products.restore')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/dashbaord/products/addcolor/{product}', 'ProductsController@addColor')->name('products.color')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/dashbaord/products/addcolor/{product}', 'ProductsController@storeColor')->name('products.store_color')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::get('/dashbaord/products/affiliate/', 'ProductsController@affiliateProducts')->name('products.affiliate')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/dashbaord/products/affiliate/view/{product}', 'ProductsController@affiliateProduct')->name('products.affiliate.view')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::get('/dashbaord/products/affiliate/{category}', 'ProductsController@affiliateProductsCat')->name('products.affiliate.cat')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/cart/{user}/', 'CartController@index')->name('cart')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::post('/cart/{user}/product/{product}/', 'CartController@add')->name('cart.add')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/cart/{user}/remove/{product}/{stock}', 'CartController@remove')->name('cart.remove')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');


    Route::get('/fav/{user}/', 'FavController@index')->name('fav')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/fav/{user}/add/{product}/', 'FavController@add')->name('fav.add')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/fav/{user}/remove/{product}', 'FavController@remove')->name('fav.remove')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');

    Route::resource('/dashboard/orders', 'OrdersController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-orders', 'OrdersController@trashed')->name('orders.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-orders/{order}', 'OrdersController@restore')->name('orders.restore')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/orders-change-status/{order}', 'OrdersController@updateStatus')->name('orders.update.order')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/orders-change-status-admin-vendor/{vorder}', 'OrdersController@updateStatusForVendors')->name('orders.update.status.vendors')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/orders-change-status-all', 'OrdersController@updateStatusAll')->name('orders-change-status-all')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/orders-change-status-all-vendors', 'OrdersController@updateStatusAllVendors')->name('orders-change-status-all-vendors')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/order/affiliate/{user}/', 'OrdersController@storeaffiliate')->name('orders.affiliate')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/affiliate/orders/{user}', 'OrdersController@affiliateIndex')->name('orders.affiliate.show')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/vendor/orders/{user}', 'OrdersController@vendorIndex')->name('orders.vendor.show')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/cancel/order/{order}', 'OrdersController@cancelOrder')->name('orders.affiliate.cancel')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/show/order/{order}', 'OrdersController@affiliateShow')->name('orders.order.show')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/print/order/{order}', 'OrdersController@printOrder')->name('orders.affiliate.print')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/print/vendor-order/{order}', 'OrdersController@printVendorOrder')->name('orders.vendor.print')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/print/vendor-order-admin/{order}', 'OrdersController@printVendorOrderAdmin')->name('orders.vendor.print.admin')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/show/vendor-order/{order}', 'OrdersController@vendorShow')->name('vendor.order.show')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/show/vendor-order-admin/{order}', 'OrdersController@vendorShowAdmin')->name('admin.vendors.orders.show')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::post('/products-change-status/{product}', 'ProductsController@updateStatus')->name('products.update.order')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/products-change-status-all', 'ProductsController@updateStatusAll')->name('products-change-status-all')->middleware('auth', 'verifiedphone', 'checkstatus');




    Route::resource('/dashboard/all_orders', 'AllOrdersController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/dashboard/mandatory', 'AllOrdersController@mandatoryIndex')->name('orders-mandatory-check')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/dashboard/mandatory-vendors', 'AllOrdersController@mandatoryIndexVendors')->name('orders-mandatory-check-vendors')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/all_orders/vendors', 'AllOrdersController@indexOrdersVendors')->name('orders-all-vendors')->middleware('auth', 'verifiedphone', 'checkstatus');



    Route::get('/dashboard/all_orders/{order}/products', 'AllOrdersController@products')->name('all_orders.products')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-all_orders', 'AllOrdersController@trashed')->name('all_orders.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-all_orders/{all_order}', 'AllOrdersController@restore')->name('all_orders.restore')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::resource('/dashboard/addresses', 'AddressesController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-addresses', 'AddressesController@trashed')->name('addresses.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-addresses/{address}', 'AddressesController@restore')->name('addresses.restore')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::resource('/dashboard/countries', 'CountriesController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-countries', 'CountriesController@trashed')->name('countries.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-countries/{country}', 'CountriesController@restore')->name('countries.restore')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::resource('/dashboard/slides', 'SlidesController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-slides', 'SlidesController@trashed')->name('slides.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-slides/{slide}', 'SlidesController@restore')->name('slides.restore')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::resource('/dashboard/shipping_rates', 'ShippingRatesController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-shipping_rates', 'ShippingRatesController@trashed')->name('shipping_rates.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-shipping_rates/{shipping_rate}', 'ShippingRatesController@restore')->name('shipping_rates.restore')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::get('/affiliate/shipping-rates', 'ShippingRatesController@affiliate')->name('shipping_rates.affiliate')->middleware('auth', 'verifiedphone', 'checkstatus');



    Route::resource('/dashboard/bonus', 'BonusController')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::resource('/dashboard/sizes', 'SizesController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-sizes', 'SizesController@trashed')->name('sizes.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-sizes/{size}', 'SizesController@restore')->name('sizes.restore')->middleware('auth', 'verifiedphone', 'checkstatus');



    Route::resource('/dashboard/colors', 'ColorsController')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-colors', 'ColorsController@trashed')->name('colors.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-colors/{color}', 'ColorsController@restore')->name('colors.restore')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::resource('/dashboard/logs', 'LogsController')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::get('/withdrawals/{user}', 'WithdrawalsController@indexaffiliate')->name('withdrawals.index.affiliate')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/withdrawals/request/{user}', 'WithdrawalsController@newRequest')->name('withdrawals.request')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::post('/withdrawals/store/affiliate/{user}', 'WithdrawalsController@storeRequest')->name('withdrawals.affiliate.store')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');


    Route::get('/withdrawals/vendor/{user}', 'WithdrawalsController@indexVendor')->name('withdrawals.index.vendor')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/withdrawals/vendor/request/{user}', 'WithdrawalsController@newVendorRequest')->name('vendor-withdrawals.request')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::post('/withdrawals/store/vendor/{user}', 'WithdrawalsController@storeVendorRequest')->name('withdrawals.vendor.store')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');

    Route::get('/withdrawal/admin', 'WithdrawalsController@index')->name('withdraw.admin')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/withdrawal/update/{withdrawal}', 'WithdrawalsController@updateRequest')->name('withdrawals.update.requset')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::post('/add-note/{user}', 'NotesController@Add')->name('add.note')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/add-onote/{user}/{order}', 'OnotesController@Add')->name('add.onote')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::get('/dashboard/settings/show', 'SettingController@social_links')->name('settings.show')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/dashboard/settings', 'SettingController@store')->name('settings.store')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::get('/dashboard/messages/{user}', 'MessagesController@show')->name('messages.show')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::post('/dashboard/messages/send/{user}', 'MessagesController@add')->name('messages.send')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');



    Route::get('/dashboard/messages-admin/{user}', 'AdminMessagesController@index')->name('messages.admin.show')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/dashboard/messages-admin/send/{user}', 'AdminMessagesController@add')->name('messages.admin.send')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/dashboard/messages-admin/delete/{message}', 'AdminMessagesController@delete')->name('messages.delete')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-messages', 'AdminMessagesController@trashed')->name('messages.trashed')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-messages/{message}', 'AdminMessagesController@restore')->name('messages.restore')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-messages/{message}', 'AdminMessagesController@destroy')->name('messages.destroy')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::get('/dashboard/finances', 'FinancesController@index')->name('finances.index')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::post('/affiliate/return/{order}/{user}', 'RefundController@sendRequest')->name('affiliate.return')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::post('/affiliate/preturn/{product}/{user}/{order}', 'RefundController@sendPrequest')->name('affiliate.preturn')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/admin/refunds', 'AllOrdersController@refundsIndex')->name('admin.refunds')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/admin/prefunds', 'AllOrdersController@prefundsIndex')->name('admin.prefunds')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::post('/admin/reject-return/{order}/{user}', 'RefundController@rejectRequest')->name('admin.return.reject')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/admin/reject-prefund/{order}/{user}/{product}/{prefund}', 'RefundController@rejectPrefund')->name('admin.prefund')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::get('/notification-change/{user}', 'UserNotificationsController@changeStatus')->name('notification-change')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');

    Route::get('/show-notifications/{user}', 'UserNotificationsController@index')->name('notification-show')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');

    Route::get('/notification-change-all/{user}', 'UserNotificationsController@changeStatusAll')->name('notification-change-all')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');


    Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/profile/update', 'ProfileController@update')->name('profile.update')->middleware('auth', 'verifiedphone', 'checkstatus');

    Route::get('/add-to-my-stock/{product}', 'ProductsController@myStockShow')->name('mystock.add')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/complete-stock-order/{product}', 'ProductsController@myStockOrder')->name('mystock.order')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/stock/orders/{user}', 'ProductsController@myStockorders')->name('mystock.orders')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/stock/orders/cancel/{order}', 'ProductsController@myStockCancel')->name('mystock.cancel')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/mystock/products/{product}/{order}', 'ProductsController@myStockProduct')->name('mystock.product')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/mystock/products/', 'ProductsController@myStockProducts')->name('products.aff.mystock')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/dashboard/stock/orders/', 'ProductsController@myStockordersAdmin')->name('stock.orders')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/dashboard/stock/remove/{stock}/{product}', 'ProductsController@stockRemove')->name('stock.remove')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/dashboard/stock/change/{order}', 'ProductsController@stockRemove')->name('stock.orders.change')->middleware('auth', 'verifiedphone', 'checkstatus');


    Route::post('/dashboard/myproducts-store/{user}/{product}', 'AproductsController@store')->name('aproducts.store')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/dashboard/myproducts/{user}', 'AproductsController@show')->name('aproducts.show')->middleware('auth', 'verifiedphone', 'checkstatus', 'checkuser');
    Route::get('/dashboard/myproducts-delete/{user}/{aproduct}', 'AproductsController@delete')->name('aproducts.delete')->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/store/{user}', 'AproductsController@storeShow')->name('store.show')->middleware('auth', 'verifiedphone', 'checkstatus');
});
