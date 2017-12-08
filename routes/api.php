<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => ['api']], function (){ 
	Route::post('get/user/business-products', 'ApiController@getUserBusinessProducts');
	Route::post('get/user/business-events', 'ApiController@getUserBusinessEvents');
	Route::post('get/category/businesses', 'ApiController@getBusinessesByCategory');
	Route::post('post/user/business', 'ApiController@postUserBusiness');
	Route::post('post/user/event', 'ApiController@postUserEvent');
	Route::post('post/user/delete/product', 'ApiController@postDeleteProduct');
	Route::post('post/user/delete/event', 'ApiController@postDeleteEvent');
	Route::post('post/event/participants', 'ApiController@postEventParticipants');
	Route::post('post/business/express/{like}', 'ApiController@postBusinessLikes');
	Route::post('post/business/rating', 'ApiController@postBusinessRating');
	Route::post('post/business/reviews', 'ApiController@postBusinessReviews');
	Route::post('post/business/followers', 'ApiController@postBusinessFollowers');
	Route::post('post/business/favourites', 'ApiController@postBusinessFavourites');
	Route::post('get/business-services', 'ApiController@getBusinessServices');
	Route::post('post/user/service', 'ApiController@postUserService');
	Route::post('post/user/delete/service', 'ApiController@postDeleteService');
	Route::post('get/business-events' ,'ApiController@getBusinessEvents');
	Route::post('post/fcm/id' ,'ApiController@postFcmId');
	Route::post('post/app/feedback' ,'ApiController@postAppFeedback');
	Route::post('post/upload/documents' ,'ApiController@postUploadDocuments');
	Route::post('get/business/reviews' ,'ApiController@getBusinessReviews');
	Route::post('get/user/business/details' ,'ApiController@getUserBusinessDetails');	
	Route::post('get/searchBusinesses' ,'ApiController@getSearchBusinesses');
	Route::post('get/searchEvents' ,'ApiController@getSearchEvents');
	Route::post('block/notification' ,'ApiController@blockNotification');
	Route::post('get/app/notification' ,'ApiController@getAppNotification');
	Route::post('post/user/message' ,'ApiController@postUserMessage');
	Route::post('get/user/message' ,'ApiController@getUserMessage');
	Route::post('get/user/all/messages' ,'ApiController@getUserAllMessages');
	Route::post('upload/business/banner', 'ApiController@uploadBusinessBanner');
	Route::post('post/user/details', 'ApiController@postUserDetails');
	Route::post('get/user/details', 'ApiController@getUserDetails');
	Route::post('get/chat/users' , 'ApiController@getChatUsers');
	Route::post('get/previous/messages', 'ApiController@getPreviousMessages');
	Route::post('get/user/business/status', 'ApiController@getUserBusinessStatus');
	Route::post('get/user/attending/event/status', 'ApiController@getUserEventAttendingStatus');

	//New Apis
	Route::post('signup', 'ApiController@signup');
	Route::post('send/otp' ,'ApiController@sendOtp');
	Route::post('checkMobile/otp' ,'ApiController@checkMobileOtp');
	Route::post('check/otp' ,'ApiController@checkOtp');
	Route::post('resend/otp' ,'ApiController@resendOtp');
	Route::post('get/user/portfolio', 'ApiController@getUserPortfolio');
	Route::post('post/user/portfolio', 'ApiController@postUserBusinessPortfolio');
	Route::post('get/user/portfolioDetails', 'ApiController@getUserPortfolioImages');
	Route::post('post/user/portfolioDetails', 'ApiController@postUserPortfolioDetail');
	Route::post('remove/user/portfolioDetails', 'ApiController@removeUserPortfolioDetail');
	Route::post('post/business/productImage', 'ApiController@postBusinessProductImage');
	Route::get('get/business/securityQuestion', 'ApiController@getSecurityQuestion');
	Route::get('get/business/eventSeatingPlans', 'ApiController@getEventSeatingPlans');
	Route::post('remove/product/image', 'ApiController@removeBusinessProductImage');
	Route::post('post/user/event/seatingPlan', 'ApiController@postUserEventSeatingPlan');
	Route::post('get/business/homeBanner', 'ApiController@getHomePageBanners');
	Route::post('get/business/businessBanner', 'ApiController@getBusinessBanners');
	Route::post('get/business/eventBanner', 'ApiController@getEventBanners');
	Route::post('post/event/bookingTickets', 'ApiController@postEventBookTickets');
	Route::post('post/user/location', 'ApiController@getEndUserLocation');
	Route::get('get/subscription/country', 'ApiController@getCountryList');
	Route::post('get/subscription/state', 'ApiController@getStateList');
	Route::post('get/subscription/city', 'ApiController@getCityList');
	Route::post('get/subscription/businessBanner', 'ApiController@getBusinessBannerList');
	Route::post('get/subscription/eventList', 'ApiController@getUpcomingEventList');
	Route::post('get/subscription/homePageBanners', 'ApiController@getSponserBannerList');
	Route::post('get/subscription/eventBanners', 'ApiController@getEventBannerList');
	Route::post('get/subscription/planPurchase', 'ApiController@buySubscriptionPlan');
	Route::post('post/subscription/businessBanner', 'ApiController@postBusinessBanner');
	Route::post('post/subscription/eventBanner', 'ApiController@postEventBanner');
	Route::post('post/subscription/sponsorBanner', 'ApiController@postSponsorBanner');
	Route::post('post/signup/socialLogin', 'ApiController@postGoogleFacebookSignup');
	Route::post('post/banner/block', 'ApiController@blockBanner');
	Route::post('get/transactionHistory', 'ApiController@transactionHistory');
	Route::post('get/subscription/businessBannerImage', 'ApiController@getBusinessBanner');
	Route::post('get/user/notificationList', 'ApiController@getUserNotificationList');
	Route::post('get/business/event/details', 'ApiController@getBusinessEventDetails');
	Route::post('delete/user/notification', 'ApiController@removeUserNotification');
	Route::post('get/business/status', 'ApiController@checkBusinessStatus');
	Route::post('get/eventDetails', 'ApiController@eventIdDetails');

	//Event Ticket Check APP API's
	Route::post('event/login', 'ApiController@eventLogin');
	Route::post('event/get/tickteList', 'ApiController@getEventTicktesList');
	Route::post('event/booked/eventTicktes', 'ApiController@updateEventTickets');

	Route::post('password/email', 'Auth\ForgotPasswordController@getLink');

	Route::post('removeFCM', 'ApiController@deleteFCM');

	//Updated Apis
	Route::post('login', 'ApiController@login');
	Route::post('post/user/product', 'ApiController@postUserProduct');
	//Not using this apis.
	Route::get('get/subscriptionPlans/event', 'ApiController@getEventPlan');
	Route::get('get/subscriptionPlans/business', 'ApiController@getBusinessPlan');
	Route::get('get/subscriptionPlans/sponsor', 'ApiController@getSponsorPlan');

	//Get request api
	Route::get('get/business-categories', 'ApiController@getCategories');
	Route::get('get/business-subCategories/{id}', 'ApiController@getSubCategories');
	Route::get('get/currency/{countryName}', 'ApiController@getCurrency');
	Route::get('get/subscription-plans', 'ApiController@getSubscriptionPlans');
	Route::get('get/business/states' ,'ApiController@getBusinessStates');
	Route::get('get/cmsPages/{slug}' ,'ApiController@getCmsPages');
	Route::get('get/event-categories', 'ApiController@getEventCategories');

	//Version 2 Apis
	Route::group(['prefix' => 'v2'], function () { 
		Route::post('business/video/index', 'Api\v2\BusinessVideoController@index');
		Route::post('business/video/create', 'Api\v2\BusinessVideoController@store');
		Route::post('business/video/show', 'Api\v2\BusinessVideoController@show');
		Route::post('business/video/delete', 'Api\v2\BusinessVideoController@delete');
		Route::post('business/following', 'Api\v2\BusinessFollowersController@getFollowingList');
		Route::post('business/delete/following', 'Api\v2\BusinessFollowersController@deleteFollowingBusiness');
		Route::post('business/follower', 'Api\v2\BusinessFollowersController@getFollowerList');
		Route::post('user-account', 'Api\v2\UserAccountController@store');
		Route::post('get/user-account/details', 'Api\v2\UserAccountController@index');
		Route::post('business/like', 'Api\v2\BusinessLikeController@getLikeList');
		Route::post('premiumPlan', 'Api\v2\SubscriptionPlansController@getPremiumPlan');
		Route::post('sponsorPlan', 'Api\v2\SubscriptionPlansController@getSponsorPlan');
		Route::post('eventPlan', 'Api\v2\SubscriptionPlansController@getEventPlan');
		Route::post('businessPlan', 'Api\v2\SubscriptionPlansController@getBusinessPlan');
		Route::post('premium/autorenew', 'Api\v2\SubscriptionPlansController@premiumAutoRenew');
		Route::post('premium/transaction', 'Api\v2\SubscriptionPlansController@getPremiumTransaction');
		Route::post('remove/portfolio/image', 'ApiController@removeUserPortfolioImage');

		Route::post('create/event-password', 'Api\v2\UsersController@eventPassword');
		Route::post('update/event-password', 'Api\v2\UsersController@updateEventPassword');


	});

});