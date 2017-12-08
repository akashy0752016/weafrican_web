<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//amp
Route::amp('amp', ['as' => 'my-route', 'uses' => 'AmpController@index']);

//Fineuploader url
Route::group(['prefix' => 'media'], function() {
	Route::post('upload-media', 'MediasController@postUploadMedia')->middleware('auth');
	Route::post('post-chunks', 'MediasController@postCombinedChunks')->middleware('auth');
	Route::delete('destroy-media/{uuid}', 'MediasController@postDestroyMedia')->middleware('auth');
});
	

//Social Login
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('message', 'Auth\LoginController@providerMessage');

Route::group(['middleware' => ['before']], function(){
	Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

	Auth::routes();

	Route::get('logout', 'Auth\LoginController@logout');
	//new url for register page
	Route::get('register','Auth\RegisterController@register');

	Route::get('cms/{slug}', ['uses' => 'CmsController@index', 'as' => 'cms']);

	Route::get('mobile/{slug}', ['uses' => 'CmsController@getCmsPage']);

	Route::get('events-plans', 'SubscriptionPlanPagesController@event');
	Route::get('business-premium-membership-plans', 'SubscriptionPlanPagesController@premium');
	Route::get('banner-sponsorship-package', 'SubscriptionPlanPagesController@sponsor');
	Route::get('business-ads-packages', 'SubscriptionPlanPagesController@banner');
	Route::get('search', 'SubscriptionPlanPagesController@search');
	Route::resource('contact', 'ContactController');
	Route::resource('about', 'AboutController');
	Route::resource('services', 'ServicesController');
	Route::get('africa-events','EventController@index');
	
	Route::get('{status}-page', function ($status) {
    	return view('errors.'.$status);
	});

	Route::resource('register-business', 'UserBusinessController');
	Route::get('resend-otp', 'UserBusinessController@resendotp');
	Route::get('otp', 'UserBusinessController@otp');
	Route::get('emailVerify', 'UserBusinessController@otp');
	Route::get('verifySecurity', 'UserBusinessController@securityQuestion');
	Route::post('check-securityans', 'UserBusinessController@checkSecurityQuestion');
	Route::post('check-otp', 'UserBusinessController@checkOtp');
	Route::post('country-details', 'AjaxController@countryDetails');
	Route::post('country', 'AjaxController@countryList');
	Route::post('state', 'AjaxController@stateList');
	Route::post('city', 'AjaxController@cityList');
	Route::post('category', 'AjaxController@categoryList');
	Route::post('subcategory', 'AjaxController@subcategoryList');
	Route::post('eventbanner', 'AjaxController@getBusinessEventBanner');
	Route::get('subscription', 'SubscriptionPlansController@subscription');


	Route::group(['middleware' => ['auth']], function() {

		//Route::get('otp', 'UserBusinessController@otp');
		Route::get('upload', 'UserBusinessController@uploadForm');
		Route::post('upload-document', 'UserBusinessController@uploadDocument');
		Route::resource('business-product', 'BusinessProductsController');
		Route::post('send_message', 'BusinessFollowerListController@sendMessage');//Ajax function to send push Notification
		Route::post('add/event-password', 'BusinessEventsController@createEventPassword');
		Route::get('change/event-password', 'BusinessEventsController@changeEventPassword');
		Route::post('update/event-password', 'BusinessEventsController@updateEventPassword');
		Route::resource('business-event', 'BusinessEventsController');
		Route::get('business-following', 'BusinessFollowerListController@getFollowingList');
		Route::resource('business-follower', 'BusinessFollowerListController');
		Route::resource('business-video', 'BusinessVideosController');
		Route::resource('business-service', 'BusinessServicesController');
		Route::post('event/participants/download-csv/{eventId}', 'BusinessEventsController@exportToCsv');
		Route::resource('banners', 'BannersController');
		Route::delete('home/banner/{id}', 'BannersController@deleteHomeBanner');
		Route::delete('business/banner/{id}', 'BannersController@deleteBusinessBanner');
		Route::delete('event/banner/{id}', 'BannersController@deleteEventBanner');
		Route::get('home/banner/block/{id}','BannersController@blockHomeBanner');
		Route::get('event/banner/block/{id}','BannersController@blockEventBanner');
		Route::get('mobileVerify', 'UserBusinessController@verifyMobile');
		Route::get('verifyMobile', 'UserBusinessController@mobileOtp');
		Route::get('resend-mobile-otp', 'UserBusinessController@resendMobileOtp');
		Route::resource('change-mobile', 'UserBusinessController@changeMobile');
		Route::post('update-mobile', 'UserBusinessController@updateMobile');
		Route::post('check-mobile-otp', 'UserBusinessController@checkMobileOtp');
		Route::resource('portfolio', 'UserBusinessPortfolioController');
		Route::resource('my-account', 'MyAccountController');
		Route::resource('subscription-plans', 'SubscriptionPlansController');
		Route::resource('business-banner', 'BusinessBannerController');
		Route::get('business/banner/block/{id}','BusinessBannerController@block');
		Route::get('business/banner/buy/{id}','BusinessBannerController@buyBusinessSubscriptionPlan');
		Route::resource('sponsor-banner', 'HomePageBannerController');
		Route::get('sponsor/banner/block/{id}','HomePageBannerController@block');
		Route::get('sponsor/banner/buy/{id}','HomePageBannerController@buySponsorSubscriptionPlan');
		Route::resource('event-banner', 'EventBannerController');
		Route::get('event-banner/block/{id}','EventBannerController@block');
		Route::get('event/banner/buy/{id}','EventBannerController@buyEventSubscriptionPlan');
		//Premium Plan
		Route::get('premium/plan/buy/{id}','SubscriptionPlansController@buyPremiumSubscriptionPlan');
		Route::get('premium-plan-details', 'UserSubscriptionPlansController@getPremiumPlanDetails');

		Route::post('/payment/callback', 'PaymentController@checkPaymentStatus');
		Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
		Route::post('/payment', 'PaymentController@redirectTopaymentPage');

		Route::post('deactivated-plan/{id}', 'UserSubscriptionPlansController@deactivatePremiumAutorenew');
		Route::delete('business-unfollow', 'BusinessFollowerListController@unfollowBusiness');

		Route::resource('account-details', 'UserAccountController');

		//delete product images
		Route::post('delete/product/all-images/{id}', 'BusinessProductsController@deleteAllImage')->name('product.deleteAllImage');
		Route::post('delete/product/image/{id}/{image}', 'BusinessProductsController@deleteSingleImage')->name('product.deleteImage'); 

		Route::post('delete/portfolio/all-images/{id}', 'UserBusinessPortfolioController@deleteAllImage')->name('portfolio.deleteAllImage');
		Route::post('delete/portfolio/image/{id}/{image}', 'UserBusinessPortfolioController@deleteSingleImage')->name('portfolio.deleteImage'); 

		//enduser
		Route::get('create-business', 'UserBusinessController@createBusiness');

	});
});

Route::group(['prefix' => 'admin'], function() {
	Route::get('login', 'AdminController@login');
	Route::post('login', 'AdminController@postLogin');
	Route::group(['middleware' => ['admin']], function () {
		Route::get('dashboard', 'AdminController@index');
		Route::get('user/blocked/{id}','AdminUsersController@block');
		Route::resource('users', 'AdminUsersController');
		Route::get('getSearch', 'AdminUsersController@getSearch');
		Route::get('getCSV', 'AdminUsersController@exportToCsv');
		Route::get('business/block/{id}','AdminUserBusinessesController@block');
		Route::get('business/unapproved','AdminUserBusinessesController@unapproved');
		Route::resource('business', 'AdminUserBusinessesController');
		Route::get('premium-business/block/{id}','AdminPremiumUserBusinessesController@block');
		Route::resource('premium-business', 'AdminPremiumUserBusinessesController');
		Route::get('bussiness/category/block/{id}', 'AdminBussinessCategoriesController@block');
		Route::resource('bussiness/category', 'AdminBussinessCategoriesController');
		//Route::get('bussiness/sub-category/block/{id}', 'AdminBussinessSubcategoriesController@block');
		//Route::resource('bussiness/sub-category', 'AdminBussinessSubcategoriesController');
		Route::get('event/block/{id}', 'AdminBusinessEventsController@block');
		Route::resource('event', 'AdminBusinessEventsController');
		Route::get('business/identity/proof/validate/{id}','AdminUserBusinessesController@identityProofVerfied');
		Route::get('business/proof/validate/{id}','AdminUserBusinessesController@businessProofVerfied');
		Route::get('business/user/validate/{id}','AdminUserBusinessesController@businessUserVerify');
		Route::get('subscription/plan/block/{id}','AdminSubscriptionPlansController@block');
		Route::resource('subscription/plan', 'AdminSubscriptionPlansController');
		Route::get('product/block/{id}','AdminBusinessProductsController@block');
		Route::resource('product', 'AdminBusinessProductsController');
		Route::get('service/block/{id}','AdminBusinessServicesController@block');
		Route::resource('service', 'AdminBusinessServicesController');
		Route::get('video/block/{id}','AdminBusinessVideosController@block');
		Route::resource('video', 'AdminBusinessVideosController');
		Route::get('home/banner/block/{id}','AdminBannersController@blockHomeBanner');
		Route::get('business/banner/block/{id}','AdminBannersController@blockBusinessBanner');
		Route::get('event/banner/block/{id}','AdminBannersController@blockEventBanner');
		Route::resource('banner', 'AdminBannersController');
		Route::resource('cms', 'AdminCmsPagesController');
		Route::resource('fcm-notification', 'AdminFcmNotificationController');
		Route::post('send/notification', 'AdminFcmNotificationController@sendNotification');
		Route::resource('app-feedback', 'AdminAppFeedbackController');
		Route::get('app-feedback/block/{id}','AdminAppFeedbackController@block');
		Route::resource('reviews', 'AdminBusinessReviewsController');
		Route::get('reviews/block/{id}','AdminBusinessReviewsController@block');
		Route::resource('conversation', 'AdminUserConversationsController');
		Route::get('get/conversations/{senderId}/{receiverId}', 'AdminUserConversationsController@getConversations');
		Route::get('get/message/{senderId}', 'AdminUserConversationsController@getMessage');
		Route::delete('business/banner/{id}', 'AdminBannersController@deleteBusinessBanner');
		Route::delete('event/banner/{id}', 'AdminBannersController@deleteEventBanner');
		Route::get('category/event/block/{id}', 'AdminEventCategoriesController@block');

		Route::resource('category/event', 'AdminEventCategoriesController');
		Route::resource('seating-plan', 'AdminSeatingPlanController');
		Route::get('seating-plan/block/{id}', 'AdminSeatingPlanController@block');
		Route::resource('security-question', 'AdminSecurityQuestionsController');
		Route::get('security-question/block/{id}', 'AdminSecurityQuestionsController@block');
		Route::resource('transaction/history', 'AdminTransactionController');
		Route::resource('portfolio', 'AdminUserPortfolioController');
	});
});


Route::get('event-login','EventAuth\LoginController@getLogin');
Route::post('event-login','EventAuth\LoginController@postLogin');
Route::get('event-logout','EventAuth\LoginController@logout');
Route::group(['prefix' => 'event'], function() {
	Route::group(['middleware' => ['event']], function () {
		Route::get('dashboard','EventController@dashboard');
		Route::get('search','EventController@searchTicket');
		Route::get('search-ticket','EventController@getEventTickets');
		Route::post('confirm-ticket','EventController@confirmTicket');
	});
});

