<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', array('as'=>'home', 'uses'=>'HomeController@getIndex'));
Route::get('/expired', array('as'=>'expired', 'uses'=>'HomeController@getExpired'));


/*Admins*/
Route::group(array('namespace' => 'Admin'), function () {
	Route::group(['prefix' => 'admin'], function () {
		Route::get('/login', array('as'=>'admin.login', 'uses'=>'AuthController@getLogin'));
		Route::post('/login', 'AuthController@postLogin');
		Route::get('/logout', array('as'=>'admin.logout', 'uses'=>'AuthController@getLogout'));
		Route::group(array('middleware' => 'auth'), function () {
			/*Dashboard*/
			Route::get('/', array('as'=>'admin.dashboard', 'uses'=>'DashboardController@getIndex'));
			/*Users*/
			Route::get('/users', array('as'=>'admin.users', 'uses'=>'UsersController@getIndex'));
			Route::post('/users/create', array('as'=>'admin.users.create', 'uses'=>'UsersController@postCreate'));
			Route::post('/users/edit/{id}', array('as'=>'admin.users.edit', 'uses'=>'UsersController@postEdit'));
			Route::post('/users/delete/{id}', array('as'=>'admin.users.delete', 'uses'=>'UsersController@postDelete'));
			Route::get('/profile', array('as'=>'admin.profile', 'uses'=>'UsersController@getProfile'));
			Route::get('/profile/edit', array('as'=>'admin.profile.edit', 'uses'=>'UsersController@getEditProfile'));
			Route::post('/profile/edit','UsersController@postEditProfile');
			Route::get('/profile/change-password', array('as'=>'admin.profile.change-password', 'uses'=>'UsersController@getChangePassword'));
			Route::post('/profile/change-password','UsersController@postChangePassword');
			Route::post('/profile/check-password','UsersController@postCheckPassword');
			
			Route::post('/users/change-avatar', array('as'=>'admin.users.change-avatar', 'uses'=>'UsersController@postChangeAvatar'));
			Route::post('/users/auto-username', 'UsersController@postAutoUsername');
			Route::post('/users/auto-password', 'UsersController@postAutoPassword');
			Route::post('/users/check-exist-email', 'UsersController@postCheckExistEmail');
			Route::post('/users/check-exist-nickname', 'UsersController@postCheckExistNickname');

			/*Companies*/
			Route::get('companies', ['uses' => 'CompaniesController@getIndex', 'as' => 'admin.companies']);
			Route::post('companies/create', ['uses' => 'CompaniesController@postCreate', 'as' => 'admin.companies.create']);
			Route::post('companies/edit/{id}', ['uses' => 'CompaniesController@postEdit', 'as' => 'admin.companies.edit']);
			Route::post('companies/delete/{id}', ['uses' => 'CompaniesController@postDelete', 'as' => 'admin.companies.delete']);

			Route::post('companies/branches/create/{company_id}', ['uses' => 'CompaniesController@postCreateBranch', 'as' => 'admin.companies.branches.create']);
			Route::post('companies/branches/edit/{company_id}/{id}', ['uses' => 'CompaniesController@postEditBranch', 'as' => 'admin.companies.branches.edit']);
			Route::post('companies/branches/delete/{company_id}/{id}', ['uses' => 'CompaniesController@postDeleteBranch', 'as' => 'admin.companies.branches.delete']);
		});
	});
});

Route::group(array('namespace' => 'Manager'), function () {
	Route::group(['prefix' => 'management'], function () {
		Route::get('/login', array('as'=>'management.login', 'uses'=>'AuthController@getLogin'));
		Route::post('/login', 'AuthController@postLogin');
		Route::get('/logout', array('as'=>'management.logout', 'uses'=>'AuthController@getLogout'));
		Route::group(array('middleware' => 'auth'), function () {			
			Route::get('/', array('as'=>'management.dashboard', 'uses'=>'DashboardController@getIndex'));
			Route::get('/branch/{id}', array('as'=>'management.changebranch', 'uses'=>'DashboardController@branch'));
		    Route::get('/products', ['as' => 'management.products', 'uses' => 'CommoditiesController@getProducts']);
		    Route::get('/products/search', ['uses' => 'CommoditiesController@searchProducts', 'as' => 'management.products.search']);
		    Route::get('/products/export', ['uses' => 'CommoditiesController@getExport', 'as' => 'management.products.export']);
		    Route::get('/products/edit/{id}', ['uses' => 'CommoditiesController@getUpdate', 'as' => 'management.updateProduct']);
		    Route::post('/products', ['uses' => 'CommoditiesController@postProduct', 'as' => 'management.postProduct']);
		    Route::post('/products/import', ['uses' => 'CommoditiesController@importProduct', 'as' => 'management.importProduct']);
		    Route::post('/products/{id}', ['uses' => 'CommoditiesController@postUpdate', 'as' => 'management.postUpdateProduct']);
		    Route::post('/products/status/{id}', ['uses' => 'CommoditiesController@postUpdateStatus', 'as' => 'management.updateStatusProduct']);
		    Route::post('/products/price/{id}', ['uses' => 'CommoditiesController@postUpdatePrice', 'as' => 'management.updatePriceProduct']);
		    Route::post('/products/delete/{id}', ['uses' => 'CommoditiesController@postDelete', 'as' => 'management.deleteProduct']);
		    
		    Route::get('/price-book', ['uses' => 'CommoditiesController@getPriceBook', 'as' => 'management.PriceBook']);
		    Route::post('/price-book', ['uses' => 'CommoditiesController@createPriceBook', 'as' => 'management.PriceBook.create']);
		    Route::post('/price-book/{id}', ['uses' => 'CommoditiesController@updatePriceBook', 'as' => 'management.PriceBook.update']);
		    Route::post('/price-book/delete/{id}', ['uses' => 'CommoditiesController@deletePriceBook', 'as' => 'management.PriceBook.delete']);
		    Route::post('/price-book/addproduct/{id}', ['uses' => 'CommoditiesController@addproductPriceBook', 'as' => 'management.PriceBook.addproduct']);
		    Route::post('/price-book/delproduct/{id}/{pricebook}', ['uses' => 'CommoditiesController@delproductPriceBook', 'as' => 'management.PriceBook.delproduct']);
		    Route::get('/price-book/export', ['uses' => 'CommoditiesController@getExportPriceBook', 'as' => 'management.PriceBook.export']);
		    Route::get('/price-book/ajax/{id}', ['uses' => 'CommoditiesController@ajaxPriceBook', 'as' => 'management.PriceBook.ajaxGet']);
		    Route::post('/price-book/ajax/{id}', ['uses' => 'CommoditiesController@ajaxPriceBook', 'as' => 'management.PriceBook.ajaxPost']);
		    
		    Route::get('/stock-takes', ['uses' => 'StockTakeController@index', 'as' => 'management.StockTakes']);
		    Route::get('/stock-takes/create', ['uses' => 'StockTakeController@getCreate', 'as' => 'management.stocktake.create']);
		    Route::get('/stock-takes/export', ['uses' => 'StockTakeController@getExport', 'as' => 'management.stocktake.export']);
		    Route::post('/stock-takes/create', ['uses' => 'StockTakeController@postCreate', 'as' => 'management.stocktake.postCreate']);
		    Route::post('/stock-takes/delete/{id}', ['uses' => 'StockTakeController@postDelete', 'as' => 'management.stocktake.postDelete']);

		    /*Sales*/
		    Route::get('/sales', array('as'=>'management.sales', 'uses'=>'SaleController@getSales'));

		    /*products groups*/
		    Route::get('/products/groups', ['uses' => 'CommoditiesController@getProductGroups', 'as' => 'management.products.groups']);
		    Route::post('/products/groups/create', ['uses' => 'CommoditiesController@postCreateGroup', 'as' => 'management.products.groups.create']);
		    Route::post('/products/groups/edit/{id}', ['uses' => 'CommoditiesController@postEditGroup', 'as' => 'management.products.groups.edit']);
		    Route::post('/products/groups/delete/{id}', ['uses' => 'CommoditiesController@postDeleteGroup', 'as' => 'management.products.groups.delete']);
		    
		    /*Purchase Order*/
		    Route::get('/purchase-order', ['uses' => 'PurchaseOrderController@index', 'as' => 'management.purchaseorder.index']);
		    Route::get('/purchase-order/create', ['uses' => 'PurchaseOrderController@getCreate', 'as' => 'management.purchaseorder.create']);
		    Route::get('/purchase-order/export', ['uses' => 'PurchaseOrderController@getExport', 'as' => 'management.purchaseorder.export']);
		    Route::post('/purchase-order/create', ['uses' => 'PurchaseOrderController@postCreate', 'as' => 'management.purchaseorder.postCreate']);
		    Route::post('/purchase-order/delete/{id}', ['uses' => 'PurchaseOrderController@postDelete', 'as' => 'management.purchaseorder.postDelete']);
		    Route::post('/purchase-order/update/{id}', ['uses' => 'PurchaseOrderController@postUpdate', 'as' => 'management.purchaseorder.postUpdate']);
		    
		    /*Purchase Return*/
		    Route::get('/purchase-return', ['uses' => 'PurchaseReturnController@index', 'as' => 'management.purchasereturn.index']);
		    Route::get('/purchase-return/create', ['uses' => 'PurchaseReturnController@getCreate', 'as' => 'management.purchasereturn.create']);
		    Route::get('/purchase-return/export', ['uses' => 'PurchaseReturnController@getExport', 'as' => 'management.purchasereturn.export']);
		    Route::post('/purchase-return/create', ['uses' => 'PurchaseReturnController@postCreate', 'as' => 'management.purchasereturn.postCreate']);
		    Route::post('/purchase-return/delete/{id}', ['uses' => 'PurchaseReturnController@postDelete', 'as' => 'management.purchasereturn.postDelete']);
		    Route::post('/purchase-return/update/{id}', ['uses' => 'PurchaseReturnController@postUpdate', 'as' => 'management.purchasereturn.postUpdate']);
			
			/*Damage Items */
		    Route::get('/damage-items', ['uses' => 'DamageItemsController@index', 'as' => 'management.damageitems.index']);
		    Route::get('/damage-items/create', ['uses' => 'DamageItemsController@getCreate', 'as' => 'management.damageitems.create']);
		    Route::get('/damage-items/export', ['uses' => 'DamageItemsController@getExport', 'as' => 'management.damageitems.export']);
		    Route::post('/damage-items/create', ['uses' => 'DamageItemsController@postCreate', 'as' => 'management.damageitems.postCreate']);
		    Route::post('/damage-items/delete/{id}', ['uses' => 'DamageItemsController@postDelete', 'as' => 'management.damageitems.postDelete']);
		    Route::post('/damage-items/update/{id}', ['uses' => 'DamageItemsController@postUpdate', 'as' => 'management.damageitems.postUpdate']);

		    /*Transfers*/
		    Route::get('/transfers/index', ['uses' => 'TransfersController@index', 'as' => 'management.transfers.index']);
		    Route::get('/transfers/create', ['uses' => 'TransfersController@getCreate', 'as' => 'management.transfers.create']);
		    Route::get('/transfers/export', ['uses' => 'TransfersController@getExport', 'as' => 'management.transfers.export']);
		    Route::post('/transfers/create', ['uses' => 'TransfersController@postCreate', 'as' => 'management.transfers.postCreate']);
		    Route::post('/transfers/delete/{id}', ['uses' => 'TransfersController@postDelete', 'as' => 'management.transfers.postDelete']);
		    Route::post('/transfers/update/{id}', ['uses' => 'TransfersController@postUpdate', 'as' => 'management.transfers.postUpdate']);

		    /*Staffs*/
		    Route::get('/staffs', array('as'=>'management.staffs', 'uses'=>'StaffsController@getIndex'));
		    Route::post('/staffs/change-avatar', array('as'=>'management.staffs.change-avatar', 'uses'=>'StaffsController@postChangeAvatar'));
		    Route::post('/staffs/create', array('as'=>'management.staffs.create', 'uses'=>'StaffsController@postCreate'));
		    Route::post('/staffs/edit/{id}', array('as'=>'management.staffs.edit', 'uses'=>'StaffsController@postEdit'));
		    Route::post('/staffs/delete/{id}', array('as'=>'management.staffs.delete', 'uses'=>'StaffsController@postDelete'));
		    Route::post('/staffs/auto-nickname', array('as'=>'management.staffs.auto-nickname', 'uses'=>'StaffsController@postAutoNickname'));
		    Route::post('/staffs/auto-password', array('as'=>'management.staffs.auto-password', 'uses'=>'StaffsController@postAutoPassword'));
		    Route::post('/staffs/check-exist-email', 'StaffsController@postCheckExistEmail');
		    Route::post('/staffs/check-exist-nickname', 'StaffsController@postCheckExistNickname');

		    /*Customers*/
			Route::get('customers', ['uses' => 'CustomersController@getIndex', 'as' => 'management.customers']);
			Route::post('customers/create', 'CustomersController@postCreate');
			Route::post('customers/edit/{id}', 'CustomersController@postEdit');
			Route::post('customers/delete/{id}', 'CustomersController@postDelete');
			Route::post('customers/check-exist-email', 'CustomersController@postCheckExistEmail');
			Route::get('export', array('as'=>'management.customers.export', 'uses'=>'CustomersController@getExport'));

			/*Suppliers*/
			Route::get('suppliers', ['uses' => 'SuppliersController@getIndex', 'as' => 'management.suppliers']);
			Route::post('suppliers/create', 'SuppliersController@postCreate');
			Route::post('suppliers/edit/{id}', 'SuppliersController@postEdit');
			Route::post('suppliers/delete/{id}', 'SuppliersController@postDelete');
			Route::post('suppliers/check-exist-email', 'SuppliersController@postCheckExistEmail');

			/*Report*/
			Route::get('reports/endday', ['uses' => 'ReportsController@getEndDay', 'as' => 'management.reports.endday']);
			Route::get('reports/sale', ['uses' => 'ReportsController@getSale', 'as' => 'management.reports.sale']);
			Route::get('reports/order', ['uses' => 'ReportsController@getOrder', 'as' => 'management.reports.order']);
			Route::get('reports/product', ['uses' => 'ReportsController@getProduct', 'as' => 'management.reports.product']);
			Route::get('reports/customer', ['uses' => 'ReportsController@getCustomer', 'as' => 'management.reports.customer']);
			Route::get('reports/supplier', ['uses' => 'ReportsController@getSupplier', 'as' => 'management.reports.supplier']);
			Route::get('reports/staff', ['uses' => 'ReportsController@getStaff', 'as' => 'management.reports.staff']);			
			Route::get('reports/financial', ['uses' => 'ReportsController@getFinancial', 'as' => 'management.reports.financial']);

			/*Profiles*/
			Route::get('/profile', array('as'=>'management.profile', 'uses'=>'ProfilesController@getProfile'));
			Route::get('/profile/edit', array('as'=>'management.profile.edit', 'uses'=>'ProfilesController@getEditProfile'));
			Route::post('/profile/edit','ProfilesController@postEditProfile');
			Route::get('/profile/change-password', array('as'=>'management.profile.change-password', 'uses'=>'ProfilesController@getChangePassword'));
			Route::post('/profile/change-password','ProfilesController@postChangePassword');
			Route::post('/profile/check-password','ProfilesController@postCheckPassword');
		});
	});
	Route::group(array('middleware' => 'auth'), function () {
		Route::get('/sale', array('as'=>'sale', 'uses'=>'SaleController@getSale'));
		Route::post('/sale','SaleController@postSale');
		Route::get('/sale/product/{bill_id}/{id}', array('as'=>'sale.product', 'uses'=>'SaleController@getProduct'));
		Route::get('/sale/product/down/{bill_id}/{id}', array('as'=>'sale.product.down', 'uses'=>'SaleController@getDownProduct'));
		Route::get('/sale/product/remove/{bill_id}/{id}/{number}', array('as'=>'sale.product.remove', 'uses'=>'SaleController@getRemoveProduct'));
		Route::get('/sale/bill/create', array('as'=>'sale.bill.create', 'uses'=>'SaleController@getCreateBill'));
		Route::get('/sale/bill/delete/{id}', array('as'=>'sale.bill.delete', 'uses'=>'SaleController@getDeleteBill'));
		Route::get('/sale/products', array('as'=>'sale.ajax.products', 'uses'=>'SaleController@ajax_products'));

		Route::get('/sale/{id}/print', array('as'=>'sale.print', 'uses'=>'SaleController@getSalePrint'));
		Route::get('/sale/{id}/frame-print', array('as'=>'sale.frame-print', 'uses'=>'SaleController@getFramePrint'));
		Route::get('/sale/customers', array('as'=>'sale.ajax.customers', 'uses'=>'SaleController@ajax_customers'));

	});
});


