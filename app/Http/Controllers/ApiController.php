<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\BusinessLike;
use App\BussinessCategory;
use App\SubscriptionPlan;
use App\BusinessProduct;
use App\BusinessEvent;
use App\UserBusiness;
use App\BusinessService;
use App\BusinessReview;
use App\BusinessFollower;
use App\BusinessNotification;
use App\UserConversation;
use App\EventParticipant;
use App\CmsPage;
use App\EventCategory;
use App\CountryList;
use App\UserPortfolio;
use App\UserPortfolioImage;
use App\SecurityQuestion;
use App\EventSeatingPlan;
use App\BusinessProductImage;
use App\HomePageBanner;
use App\BusinessEventSeat;
use App\EventTransaction;
use App\SoldEventTicket;
use App\EventTicket;
use App\UserSubscriptionPlan;
use App\BusinessBanner;
use App\EventBanner;
use App\Helper;
use App\UserNotification;
use App\FcmUser;
use App\BusinessRating;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendBookingTickets;
use Validator;
use Image;
use File;
use DB;

class ApiController extends Controller
{
    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = new User();
        $this->category = new BussinessCategory();
        $this->eventCategory = new EventCategory();
        $this->subscriptionPlan = new SubscriptionPlan();
        $this->businessProduct = new BusinessProduct();
        $this->businessEvent = new BusinessEvent();
        $this->userBusiness = new UserBusiness();
        $this->businessService = new BusinessService();
        $this->businessReviews = new BusinessReview();
        $this->userConversation = new UserConversation();
        $this->cmsPages = new CmsPage();
        $this->country = new CountryList();
        $this->portfolio = new UserPortfolio();
        $this->portfolioImage = new UserPortfolioImage();
        $this->securityQuestion = new SecurityQuestion();
        $this->eventSeatingPlan = new EventSeatingPlan();
        $this->payment = new PaymentController();
        $this->businessBanner = new BusinessBanner();
        $this->eventBanner = new EventBanner();
        $this->homePageBanner = new HomePageBanner();
        $this->eventTickets = new EventTicket();
    }

    /**
     * Function: Register User/Login User.
     * Url: api/login
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $response = $this->user->apiLogin($request);
        return $response;
    }

    /**
     * Function: Register User.
     * Url: api/signup
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request)
    {
        $response = $this->user->apiSignup($request);
        return $response;
    }

    /**
     * Function: Get Business category.
     * Url: api/get/business-categories
     * Request type: Get
     *
     * @param  
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories()
    {    
        $categoryData = array();
        $response = $this->category->apiGetCategory();

        if ($response != NULL)
            return response()->json(['status' => 'success','response' => $response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any category ']);
    }

    /**
     * Function: Get Business sub category by id.
     * Url: api/get/business-subCategories
     * Request type: Get
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubCategories($id)
    {    
        $response = $this->category->apiGetSubCategory($id);

        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' => $response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any sub-category ']);
    }

    /**
     * Function: Get currency according to country Name.
     * Url: api/get/currency/{countryName}
     * Request type: Get
     *
     * @param  string $countryName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrency($countryName)
    {    
        $response = $this->country->apiGetCurrency($countryName);

        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' => $response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any currency ']);
    }

    /**
     * Function: Get user portfolio details according to businessID.
     * Url: api/get/user/portfolio
     * Request type: Get
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserPortfolio(Request $request)
    {    
        $input = $request->input();
        $response = $this->portfolio->apiGetUserPortfolio($input);

        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' => $response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find user portfolio details']);
    }

    /**
     * Function: Get Event category.
     * Url: api/get/bussiness-categories
     * Request type: Get
     *
     * @param  Void
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventCategories()
    {
        $response = $this->eventCategory->apiGetEventCategory();
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any  event category ']);
    }

    /**
     * Function: Get all Subscription plans.
     * Url: api/get/subscription-plans
     * Request type: Get
     *
     * @param  Void
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubscriptionPlans()
    {
        $response = $this->subscriptionPlan->apiGetSubscriptionPlans();
        if ($response != NULL && $response->count()){
            $temp = array();
            $k=0;
            foreach ($response as $key => $value) {
                $temp[$k]['id'] = $value->id;
                $temp[$k]['title'] = $value->title;
                $temp[$k]['slug'] = $value->slug;
                $temp[$k]['type'] = $value->type;
                $temp[$k]['coverage'] = $value->coverage;
                $temp[$k]['price'] = number_format($value->price,2, '.', '');
                $temp[$k]['validity_period'] = $value->validity_period;
                $temp[$k]['keywords_limit'] = $value->keywords_limit;
                $temp[$k]['is_blocked'] = $value->is_blocked;
                $k++;
            }
            return response()->json(['status' => 'success','response' =>$temp]);
        }
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Subscription Plan ']);
    }

    /**
     * Function: Get Business Events of user.
     * Url: api/get/user/business-events
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBusinessEvents(Request $request)
    {   
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessEvent->apiGetUserBusinessEvents($input);
        if ($response != NULL && count($response))
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Event.']);
    }

    /**
     * Function: Get Businesses according to category Id.
     * Url: api/get/category/businesses
     * Request type: Get
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessesByCategory(Request $request)
    {  
        $input = $request->input();
        $validator = Validator::make($input, [
                'userId' => 'required',
                'categoryId' => 'required',
                'city' => 'required',
                'state' => 'required',
                'index' => 'required',
                'limit' => 'required',
                'timestamp' => 'required',
                'timezone' => 'required',
        ]);

       if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->userBusiness->apiGetBusinessesByCategory($input);
        date_default_timezone_set ($input['timezone']);
        $day = date("D",$input['timestamp']);
        $time = date("H:i A",$input['timestamp']);
        if ($response != null && count($response)){
            foreach ($response as $value) {
                $value->is_open=0;
                foreach ($value as $key => $value1) {
                    if($key=="working_hours")
                    {
                        $temp = preg_split('/\r\n|\r|\n/', $value1);
                        foreach ($temp as $value2) {
                            if(stripos($value2,$day) !== false)
                            {
                                $tim_arr = explode(" to ", (trim(substr($value2, strpos($value2, ":") + 1))));
                                if(stripos($value2,"Closed") !== false)
                                {
                                    $value->is_open=0;
                                }elseif(stripos($value2,"24 Hours Open") !== false)
                                {
                                    $value->is_open=1;
                                }elseif(count($tim_arr)>1)
                                {
                                    if(date("H:i A",strtotime($tim_arr[0]))<=$time and date("H:i A",strtotime($tim_arr[1]))>=$time)
                                    {
                                        $value->is_open=1;
                                    }else
                                    {
                                        $value->is_open=0;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return response()->json(['status' => 'success','response' =>$response]);
        }
        else{
            return response()->json(['status' => 'exception','response' => 'Could not find any Business.']);
        }
    }

    /**
     * Function: create and update User Business Details.
     * Url: api/post/user/business
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserBusiness(Request $request)
    {   
        $response = $this->userBusiness->apiPostUserBusiness($request);
        return $response;
    }

    /**
     * Function: create and update User Business Portfolio Details.
     * Url: api/post/user/portfolio
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserBusinessPortfolio(Request $request)
    {   
        $response = $this->portfolio->postUserBusinessPortfolio($request);
        return $response;
    }

    /**
     * Function: create and update User Business Details.
     * Url: api/get/user/portfolioDetails
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserPortfolioImages(Request $request)
    {   
        
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->portfolioImage->apiGetUserPortfolioImages($input);
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Portfolio Images.']);
        return $response;
    }

    /**
     * Function: To remoce User portfolio Images and description
     * Url: api/remove/user/portfolioDetails
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeUserPortfolioDetail(Request $request)
    {   
        
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->portfolioImage->apiRemoveUserPortfolioImages($input);
        return $response;
    }

    /**
     * Function: create and update User Portfolio Details.
     * Url: api/post/user/portfolioDetails
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserPortfolioDetail(Request $request)
    {   
        $response = $this->portfolioImage->apiPostUserPortfolioDetail($request);
        return $response;
    }

    /**
     * Function: create and update User Event Details.
     * Url: api/post/user/event
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserEvent(Request $request)
    {   
        $input = $request->input();
        $response = $this->businessEvent->apiPostUserEvent($input);
        return $response;
    }

    /**
     * Function: create and update User Event Seatingplan Details.
     * Url: api/post/user/event/seatingPlan
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserEventSeatingPlan(Request $request)
    {   
        $response = $this->businessEvent->apiPostEventSeatingPlan($request);
        return $response;
    }

    /**
     * Function: delete event.
     * Url: api/post/user/delete/event
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteEvent(Request $request)
    {   
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $event = BusinessEvent::where('user_id',$input['userId'])->where('id',$input['eventId'])->withCount('participations')->first();
        
        if($event && $event->soldEventTickets->count() > 0) {
            return response()->json(['status' => 'exception', 'response' => 'Event could not be deleted. Because Event tickets had been sold.']);
        } elseif($event->participations_count > 0) {
            return response()->json(['status' => 'exception', 'response' => 'Event could not be deleted. Because Event has participants.']);
        } else{
            if ($event && $event->delete())
                return response()->json(['status' => 'success', 'response' => 'Event deleted successfully.']);
            else
                return response()->json(['status' => 'exception', 'response' => 'Event could not be deleted.Please try again.']);
        }
    }

    /**
     * Function: Post event participants
     * Url: api/post/event/participants
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEventParticipants(Request $request)
    {   
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessEvent->apiPostEventAttendingUsers($input);
        return $response;
    }

    /**
     * Function: Post business like 
     * Url: api/post/business/likes
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessLikes(Request $request, $status)
    {   
        $input = $request->input();

        $check = BusinessLike::where('user_id',$input['userId'])->where('business_id',$input['businessId'])->first();

        $response = ['is_like' => null, 'is_dislike' => null, 'result' => 0, 'Total_likes' => null, 'Total_dislikes' => null];

        if($check)
        {
            if ($status == 'like') {

                $response['is_like'] = ($check->is_like) ? null: 1;
                ($check->is_dislike) ? ($response['result'] = 1) : '';

            } else {

                $response['is_dislike'] = ($check->is_dislike) ? null: 1;
                ($check->is_like) ? ($response['result'] = 1) : '';
                
            }
            if ($response['is_like'] == null && $response['is_dislike'] == null) {

                $check->delete();
                $response['Total_likes'] = BusinessLike::where('business_id', $input['businessId'])->where('is_like',1)->count('is_like');
                $response['Total_dislikes'] = BusinessLike::where('business_id',$input['businessId'])->where('is_dislike',1)->count('is_dislike');
                $response['result'] = 0;
                $response = array_except($response,['is_like', 'is_dislike']);

                return response()->json(['status' => 'success','response' => $response]);

            }elseif ($check->update(['is_like' => $response['is_like'], 'is_dislike' => $response['is_dislike']]))
            {

                $response['Total_likes'] = BusinessLike::where('business_id', $input['businessId'])->where('is_like',1)->count('is_like');
                $response['Total_dislikes'] = BusinessLike::where('business_id',$input['businessId'])->where('is_dislike',1)->count('is_dislike');
                $response = array_except($response,['is_like', 'is_dislike']);
                return response()->json(['status' => 'success','response' => $response]);

            }
        }else
        {
            if($status=='like')
            {
                $input['is_like'] = 1;
                $input['is_dislike'] = 0;
                $response['is_like'] = 1;
            }else
            {
                $input['is_like'] = 0;
                $input['is_dislike'] = 1;
                $response['is_dislike'] = 1;
            }
            $response['result'] = 1;
            $input['user_id'] = $input['userId'];
            $input['business_id'] = $input['businessId'];
            $input = array_intersect_key($input, BusinessLike::$updatable);
            $likes = BusinessLike::create($input);
            if($likes->save())
            {
                $response['Total_likes'] = BusinessLike::where('business_id', $input['business_id'])->where('is_like',1)->count('is_like');
                $response['Total_dislikes'] = BusinessLike::where('business_id',$input['business_id'])->where('is_dislike',1)->count('is_dislike');
                $response = array_except($response,['is_like', 'is_dislike']);
                return response()->json(['status' => 'success','response' => $response]);
            }else
            {
                return response()->json(['status' => 'failure','response' => 'System Error:Please try again.']);
            }
        }
    }

    /**
     * Function: Post business rating
     * Url: api/post/business/rating
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessRating(Request $request)
    {
        $input = $request->input();
     
        $check = DB::table('business_ratings')->where('user_id', $input['userId'])->where('business_id', $input['businessId'])->pluck('id')->first();

        if ($check)
        {   
            DB::table('business_ratings')->where('id', $check)->update(['rating' => $input['rating'] ]); 
            return response()->json(['status' => 'success','response' => array("message" => 'Business rating Updated successfully', "avgRating" => BusinessRating::where('business_id',$input['businessId'])->avg('rating'))]);

        } else {

            DB::table('business_ratings')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'rating' => $input['rating']]);
            return response()->json(['status' => 'success','response' => array("message" => 'Business rating saved successfully', "avgRating" => BusinessRating::where('business_id',$input['businessId'])->avg('rating'))]);
       }
    }

    /**
     * Function: Post business reviews
     * Url: api/post/business/reviews
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessReviews(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'userId' => 'required',
            'businessId' => 'required',
            'review' => 'required',
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = DB::table('business_reviews')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId'], 'review' => $input['review']]);
        $reviewCount = BusinessReview::whereBusinessId($input['businessId'])->count();

        if($response)
            return response()->json(['status' => 'success','response' => $reviewCount]);
         else
            return response()->json(['status' => 'success','response' => 'Unable to post review.Please try again.']);
    }

    /**
     * Function: Post business followers
     * Url: api/post/business/followers
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessFollowers(Request $request)
    {
        $input = $request->input();

        $check = DB::table('business_followers')->where('user_id', $input['userId'])->where('business_id', $input['businessId'])->pluck('id')->first();

        if($check)
        {   
            DB::table('business_followers')->where('id', $check)->delete();
            $response['count'] = BusinessFollower::whereBusinessId($input['businessId'])->count();
            $response['follower'] = 0;
            return response()->json(['status' => 'success','response' => $response]);

        } else {

            DB::table('business_followers')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId']]);
            $response['count'] = BusinessFollower::whereBusinessId($input['businessId'])->count();
            $response['follower'] = 1;
            return response()->json(['status' => 'success','response' => $response]);
       }
    }

    /**
     * Function: Post business favourites
     * Url: api/post/business/favourites
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessFavourites(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        $check = DB::table('business_favourites')->where('user_id', $input['userId'])->where('business_id', $input['businessId'])->pluck('id')->first();
        if($check)
        {   
            DB::table('business_favourites')->where('id', $check)->delete();
            return response()->json(['status' => 'success','response' => 'User remove this business from favourite list.']);

        } else {

            DB::table('business_favourites')->insert(['user_id' => $input['userId'], 'business_id' => $input['businessId']]);
            return response()->json(['status' => 'success','response' => 'User add this business in favourite list']);
       }
    }

    /**
     * Function: Get services of Business user.
     * Url: api/get/business-services
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessServices(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $response = $this->businessService->apiGetBusinessServices($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Service.']);
    }

    /**
     * Function: create and update service Details of business user.
     * Url: api/post/user/service
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserService(Request $request)
    {   
        $response = $this->businessService->apiPostUserService($request);
        return $response;
    }

    /**
     * Function: delete Service.
     * Url: api/post/user/delete/service
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteService(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $service = BusinessService::where('user_id',$input['userId'])->where('id',$input['serviceId'])->first();

        if($service && $service->delete()){
            return response()->json(['status' => 'success', 'response' => 'Service deleted successfully.']);
        } else {
            return response()->json(['status' => 'exception', 'response' => 'Service could not be deleted.Please try again.']);
        }
    }

    /**
     * Function: Send Otp.
     * Url: api/send/otp
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendOtp(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'countryCode' => 'sometimes|required',
            'mobileNumber' => 'sometimes|required',
            'userId' => 'required'
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception', 'response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception', 'response' =>  'All fields are required']);   
            }
        }

        $user = $this->user->whereId($input['userId'])->first();
        if($user)
        {
            if(($user->country_code!="" or $user->country_code!=null) and ($user->mobile_number!="" or $user->mobile_number!=null))
            {
                $userBusiness = new UserBusinessController();
                $res = json_decode($userBusiness->sendVerificationCode($user->country_code, $user->mobile_number));

                if($res->success==true)
                {
                    return response()->json(['status' => 'success', 'response' => "OTP has been sent to your mobile number."]);  
                }else
                {
                    return response()->json(['status' => 'exception', 'response' =>  $res->errors->message]);  
                }
            }else
            {
                return response()->json(['status' => 'exception', 'response' => "Country code or mobile number cannot be blank."]); 
            }
        }else
        {
            return response()->json(['status' => 'failure', 'response' =>  'User dose not exits.']); 
        }
    }

    /**
     * Function: Check Otp.
     * Url: api/check/otp
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOtp(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'failure','response' => ['message' => 'All fields are required.']]);
        }

        $response = $this->user->apiCheckOtp($input);
        return $response;
    }

    /**
     * Function: Check Otp.
     * Url: api/checkMobile/otp
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkMobileOtp(Request $request)
    {   
        $input = $request->input();

        $validator = Validator::make($input, [
            'countryCode' => 'sometimes|required',
            'mobileNumber' => 'sometimes|required',
            'userId' => 'required',
            'otp' => 'required'
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception', 'response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception', 'response' =>  'All fields are required']);   
            }
        }

        $user = $this->user->whereId($input['userId'])->first();
        if($user)
        {
            if(($user->country_code!="" or $user->country_code!=null) and ($user->mobile_number!="" or $user->mobile_number!=null))
            {
                $userBusiness = new UserBusinessController();
                $res = json_decode($userBusiness->verifyVerificationCode($user->country_code, $user->mobile_number, $input['otp']));

                if($res->success==true)
                {
                    $user->mobile_verified = 1;
                    if($user->save())
                    {
                        return response()->json(['status' => 'success', 'response' => "Your mobile number verified successfully."]); 
                    }else
                    {
                        return response()->json(['status' => 'exception', 'response' => "Your status could not be updated. Please try again."]); 
                    }
                }else
                {
                    return response()->json(['status' => 'exception', 'response' =>  $res->errors->message]);  
                }
            }else
            {
                return response()->json(['status' => 'exception', 'response' => "Country code or mobile number cannot be blank."]);
            }
        }else
        {
            return response()->json(['status' => 'failure', 'response' =>  'User dose not exits.']); 
        }
    }

    /**
     * Function: Resend Otp.
     * Url: api/resend/otp
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendOtp(Request $request)
    {   
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'failure','response' => ['message' => 'All fields are required.']]);
        }

        $response = $this->user->apiResendOtp($input);
        
        if($response == 1)
        {
            return response()->json(['status' => 'success', 'response' => ['message' => 'New OTP has been send to the registerd email address']]);
        }else if($response == 2) {
            return response()->json(['status' => 'failure', 'response' => ['message' => 'Unable to generate new OTP. Please try again!']]);
        }else if($response == 3){
            return response()->json(['status' => 'failure', 'response' => ['message' => 'Mail Cannot be sent! Please try again!!']]);
        }else{
            return response()->json(['status' => 'failure', 'response' => ['message' => 'Email does not exist.']]);
        }
    }

    /**
     * Function: search events by lat,long/country,state.
     * Url: api/get/business-events
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessEvents(Request $request)
    {  
        $input = $request->input();
        $validator = Validator::make($input, [
                'userId' => 'required',
                'state' => 'required',
                'city' => 'required',
                'index' => 'required',
                'limit' => 'required',
                'timezone' =>'required',
        ]);

        if ($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->businessEvent->apiGetBusinessEvents($input);
        
        if(count($response))
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Event.']);
    }

    /**
     * Function: Save user fcm registration Ids.
     * Url: api/post/fcm/id
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFcmId(Request $request)
    {  
        $input = $request->input();

        if ($input['fcmRegId'] == DB::table('fcm_users')->where('user_id', $input['userId'])->pluck('fcm_reg_id')->first()) {
            return response()->json(['status' => 'success','response' =>'Fcm registration id updated successfully.']);
        }

        $check = DB::table('fcm_users')->where('user_id', $input['userId'])->pluck('user_id')->first();
        
        if ($check){
            $response = DB::table('fcm_users')->where('user_id', $input['userId'])->update(['fcm_reg_id' => $input['fcmRegId']]);

            if ($response)
                return response()->json(['status' => 'success','response' =>'Fcm registration id updated successfully.']);
            else
                return response()->json(['status' => 'failure','response' =>'System Error:Unable to update Fcm registration id for this user.']);

        } else {
            $response = DB::table('fcm_users')->insert(['user_id' => $input['userId'], 'user_role_id' => $input['roleId'], 'fcm_reg_id' => $input['fcmRegId']]);

            if($response)
                return response()->json(['status' => 'success','response' =>' Fcm registration id for this user save successfully.']);
            else
                return response()->json(['status' => 'failure','response' =>'System Error:Unable to save Fcm registration id for this user.']);
        }
    }

    /**
     * Function: Post app feedback.
     * Url: api/post/app/feedback
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAppFeedBack(Request $request)
    {  
        $input = $request->input();
        if($input == NULL)
        {
            return response()->json(['status' => 'success','response' => 'Input parmeters are missing.']);
        }

        $user = DB::table('app_feedbacks')->where('user_id', $input['userId'])->first();
        if($user){
            return response()->json(['status' => 'success','response' => 'This user already gave feedback']);
        }
        else {
            $feedback = DB::table('app_feedbacks')->insert(['user_id' => $input['userId'], 'feedback' => $input['feedback']]);
            if($feedback)
                return response()->json(['status' => 'success','response' => 'User feedback save successfully']);
            else
                return response()->json(['status' => 'failure','response' => 'System Error:Unable to save feedback.Please try again.']);
        }
    }

    /**
     * Function: Upload document(identity & business proof)
     * Url: api/post/upload/documents
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUploadDocuments(Request $request)
    {  
        $input = $request->input();
        $validator = Validator::make($input, [
            'businessId' => 'required',
            'businessProof' => 'sometimes',
            'business_proof_ext' => 'sometimes',
            'identityProof' => 'sometimes',
            'identity_proof_ext' => 'sometimes',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->userBusiness->apiPostUploadDocuments($input);
        return $response;
    }

    /**
     * Function: get all business reviews by business id
     * Url: api/get/business/reviews/{businessId}
     * Request type: Post
     *
     * @param   \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessReviews(Request $request)
    {  
        $input = $request->input();
        $response = $this->businessReviews->apiGetBusinessReview($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any review.']);
    }

    /**
     * Function: get business user details by business id
     * Url: api/get/user/business/details
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBusinessDetails(Request $request)
    {  
        $input = $request->input();
        $response = $this->userBusiness->apiGetUserBusinessDetails($input);
        if($response != NULL)
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any business details.']);
    }
    /**
     * Function: get business states according to countryName
     * Url: api/get/business/states
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessStates(Request $request)
    {  
        $input = $request->input();
        $response = $this->userBusiness->apiGetBusinessStates($input);
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not found any state']);
    }

    /**
     * Function: get search business by using search term
     * Url: api/get/searchBusinesses
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchBusinesses(Request $request)
    {  
        $validator = Validator::make($request->all(), UserBusiness::$searchValidator);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $input = $request->input(); 
        date_default_timezone_set ($input['timezone']);
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');
        $current_day_this_month  = date('Y-m-d');
        $top = 'SELECT id,user_id,first_name,middle_name,address,city,state,country,pin_code,currency,country_code,mobile_number,email,image,latitude,longitude,business_id,bussiness_category_id,bussiness_subcategory_id,title,keywords,about_us,website,working_hours,banner,business_logo,identity_proof,business_proof,is_identity_proof_validate,is_business_proof_validate,is_agree_to_terms,is_blocked,is_update,created_at, updated_at,deleted_at,ratings,reviews,products,portfolios,is_top,portfolio_id,is_premium,matched_products,matched_services, planPurchaseDate FROM (';
        $subscribed = $top . 'SELECT bb.country as bbcountry, bb.state as bbstate, bb.city as bbcity,u.first_name, u.middle_name, u.address, u.city, u.state, u.country, u.pin_code, u.currency, u.country_code, u.mobile_number, u.email, u.image, u.latitude, u.longitude, usp.created_at as planPurchaseDate, (CASE WHEN u.user_role_id=5 THEN "1" ELSE "0" END) as is_premium, ub.*, (SELECT AVG(rating) FROM business_ratings WHERE business_ratings.business_id = ub.id) AS ratings, (SELECT COUNT(*) FROM business_reviews WHERE business_reviews.business_id = ub.id) AS reviews, (SELECT COUNT(*) FROM business_products WHERE business_products.business_id = ub.id AND business_products.deleted_at IS NULL) AS products, (SELECT COUNT(*) FROM user_portfolio_images WHERE user_portfolio_images.business_id = ub.id) AS portfolios, 1 AS is_top, (SELECT id FROM user_portfolios as up WHERE u.id=up.user_id) as portfolio_id, (SELECT COUNT(*) FROM business_products as bp WHERE  bp.business_id = ub.id AND bp.title LIKE "%'.$input['term'].'%") as matched_products, (SELECT COUNT(*) FROM business_services as bs WHERE bs.business_id = ub.id AND bs.title LIKE "%'.$input['term'].'%") as matched_services FROM user_businesses AS ub INNER JOIN users AS u ON ub.user_id = u.id LEFT JOIN user_subscription_plans AS usp ON ub.user_id = usp.user_id LEFT JOIN business_banners AS bb ON usp.id = bb.user_subscription_plan_id WHERE  usp.subscription_plan_id =6 AND ub.is_blocked =0 AND usp.subscription_date<= "'.$current_day_this_month.'" AND usp.expired_date>= "'.$current_day_this_month.'" AND (u.deleted_at IS NULL OR u.deleted_at = "") AND (ub.deleted_at IS NULL OR ub.deleted_at = "")  AND usp.status="success" AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1';
        $unsubscribed = $top . 'SELECT u.first_name, u.middle_name, u.address, u.city, u.state, u.country, u.pin_code, u.currency, u.country_code, u.mobile_number, u.email, u.image, u.latitude, u.longitude, NULL AS planPurchaseDate, (CASE WHEN u.user_role_id=5 THEN "1" ELSE "0" END) as is_premium, ub.*, (SELECT AVG(rating) FROM business_ratings WHERE business_ratings.business_id = ub.id) AS ratings, (SELECT COUNT(*) FROM business_reviews WHERE business_reviews.business_id = ub.id) AS reviews, (SELECT COUNT(*) FROM business_products WHERE business_products.business_id = ub.id AND business_products.deleted_at IS NULL) AS products,(SELECT COUNT(*) FROM user_portfolio_images WHERE user_portfolio_images.business_id = ub.id) AS portfolios, 0 AS is_top, (SELECT id FROM user_portfolios as up WHERE u.id=up.user_id) as portfolio_id, (SELECT COUNT(*) FROM business_products as bp WHERE  bp.business_id = ub.id AND bp.title LIKE "%'.$input['term'].'%") as matched_products, (SELECT COUNT(*) FROM business_services as bs WHERE bs.business_id = ub.id AND bs.title LIKE "%'.$input['term'].'%") as matched_services FROM user_businesses AS ub INNER JOIN users AS u ON ub.user_id = u.id WHERE ub.is_blocked =0 AND (u.deleted_at IS NULL OR u.deleted_at = "") AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1';
        if (isset($input['categoryId'])) {
            $subscribed = $subscribed . ' AND (ub.bussiness_category_id='.$input['categoryId'].' OR bb.business_category_id='.$input['categoryId'].')';
            $unsubscribed = $unsubscribed . ' AND ub.bussiness_category_id='.$input['categoryId'].'';
            if(isset($input['subcategoryID']))
            {
                $subscribed = $subscribed . ' AND (ub.bussiness_subcategory_id='.$input['subcategoryId'].' OR bb.business_subcategory_id='.$input['subcategoryId'].')';
                $unsubscribed = $unsubscribed . ' AND ub.bussiness_subcategory_id='.$input['subcategoryId'].'';
            }

            /*$subscribed = $subscribed . ' AND u.country ="'.$input['country'].'" AND u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'" AND (ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%") AND usp.is_expired=0 ORDER BY usp.transaction_date ASC, ub.id ASC';
            $unsubscribed = $unsubscribed . ' AND u.country ="'.$input['country'].'" AND u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'" AND (ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%") ORDER BY ub.id ASC';*/
            $subscribed = $subscribed . ' AND usp.is_expired=0 HAVING (((u.country ="'.$input['country'].'" AND u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'") OR (bbcountry ="'.$input['country'].'" AND bbstate = "'.$input['state'].'" AND bbcity = "'.$input['city'].'")) AND ((ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%") OR (matched_products > 0 OR matched_services > 0))) ORDER BY usp.transaction_date ASC, ub.id ASC';
            $unsubscribed = $unsubscribed . ' AND (u.country ="'.$input['country'].'" AND u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'") HAVING (((ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%")) OR (matched_products > 0 OR matched_services > 0)) ORDER BY ub.id ASC';
            $subscribed = $subscribed . ') as subscribed';
            $unsubscribed = $unsubscribed . ') as unsubscribed';
            $query = 'SELECT * FROM (' . $subscribed . ' UNION ' . $unsubscribed . ') as business_list GROUP BY user_id,id ORDER BY  planPurchaseDate DESC, is_top DESC LIMIT '.$input['index'].','.$input['limit'].'';
            $response = DB::select($query);
            
        } else {
            $productIds = BusinessProduct::where('title', 'LIKE', '%'.$input['term'].'%')->pluck('business_id');
            $serviceIds = BusinessService::where('title', 'LIKE', '%'.$input['term'].'%')->pluck('business_id');

            $Ids = $productIds->merge($serviceIds); 
           
            $ids = UserBusiness::where('title', 'LIKE', '%'.$input['term'].'%')->orWhere('keywords', 'LIKE', '%'.$input['term'].'%')->orWhere('business_id', 'LIKE', '%'.$input['term'].'%')->where('is_blocked',0)->where('is_identity_proof_validate',1)->where('is_business_proof_validate',1)->orwhereIn('id', $Ids)->pluck('id');
            if($ids->count())
            {
                /*$subscribed = $subscribed . ' AND u.country ="'.$input['country'].'" AND u.state = "'.$input['state'].'"  AND u.city = "'.$input['city'].'" AND (ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%") AND usp.is_expired=0 AND usp.status="success" ORDER BY usp.transaction_date ASC, ub.id ASC';
                $unsubscribed = $unsubscribed . ' AND u.country ="'.$input['country'].'" AND u.state = "'.$input['state'].'"  AND u.city = "'.$input['city'].'" AND (ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%") ORDER BY ub.id ASC';*/
                /*$subscribed = $subscribed . ' AND usp.is_expired=0 AND usp.status="success" HAVING ((((u.country ="'.$input['country'].'" AND u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'") OR (bbcountry ="'.$input['country'].'" AND bbstate = "'.$input['state'].'" AND bbcity = "'.$input['city'].'")) AND ((ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%")) OR (matched_products > 0 OR matched_services > 0))) ORDER BY usp.transaction_date ASC, ub.id ASC';*/
                if(preg_match('/^[a-zA-Z]{3}\d{3}$/', $input['term'])){

                    $subscribed = $subscribed . ' AND usp.is_expired=0 AND usp.status="success" HAVING (((ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%")  OR (matched_products > 0 OR matched_services > 0))) ORDER BY usp.transaction_date ASC, ub.id ASC';
                    $unsubscribed = $unsubscribed . '  HAVING (((ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%")) OR (matched_products > 0 OR matched_services > 0)) ORDER BY ub.id ASC';

                } else {
                    $subscribed = $subscribed . ' AND usp.is_expired=0 AND usp.status="success" HAVING (((ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%")  OR (matched_products > 0 OR matched_services > 0)) AND ((u.country ="'.$input['country'].'" AND u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'") OR (bbcountry ="'.$input['country'].'" AND bbstate = "'.$input['state'].'" AND bbcity = "'.$input['city'].'"))) ORDER BY usp.transaction_date ASC, ub.id ASC';
                    $unsubscribed = $unsubscribed . ' AND (u.country ="'.$input['country'].'" AND u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'") HAVING (((ub.title LIKE "%'.$input['term'].'%" OR ub.keywords LIKE "%'.$input['term'].'%" OR ub.business_id LIKE "%'.$input['term'].'%")) OR (matched_products > 0 OR matched_services > 0)) ORDER BY ub.id ASC';
                }

                $subscribed = $subscribed . ') as subscribed';
                $unsubscribed = $unsubscribed . ') as unsubscribed';
                $query = 'SELECT * FROM (' . $subscribed . ' UNION ' . $unsubscribed . ') as business_list GROUP BY user_id,id ORDER BY  planPurchaseDate DESC, is_top DESC LIMIT '.$input['index'].','.$input['limit'].'';
                $response = DB::select($query);
            }else
            {
                $response = null;
            }
        }
        $day = date("D",$input['timestamp']);
        $time = date("H:i A",$input['timestamp']);
        if ($response != null && count($response)){
            foreach ($response as $value) {
                $value->is_open=0;
                foreach ($value as $key => $value1) {
                    if($key=="working_hours")
                    {
                        $temp = preg_split('/\r\n|\r|\n/', $value1);
                        foreach ($temp as $value2) {
                            if(stripos($value2,$day) !== false)
                            {
                                $tim_arr = explode(" to ", (trim(substr($value2, strpos($value2, ":") + 1))));
                                if(stripos($value2,"Closed") !== false)
                                {
                                    $value->is_open=0;
                                }elseif(stripos($value2,"24 Hours Open") !== false)
                                {
                                    $value->is_open=1;
                                }elseif(count($tim_arr)>1)
                                {
                                    if(date("H:i A",strtotime($tim_arr[0]))<=$time and date("H:i A",strtotime($tim_arr[1]))>=$time)
                                    {
                                        $value->is_open=1;
                                    }else
                                    {
                                        $value->is_open=0;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return response()->json(['status' => 'success','response' =>$response]);
        }
        else{
            return response()->json(['status' => 'exception','response' => 'Could not found any Business']);
        }
    }

     /**
     * Function: get search events by using search term
     * Url: api/get/searchEvents
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchEvents(Request $request)
    {    
        $validator = Validator::make($request->all(), ['userId' => 'required',
        'city' => 'required',
        'state' => 'required',
        'country' => 'required',
        'index' => 'required',
        'limit' => 'required',
        'term' => 'required',
        'timezone' => 'required',
        'categoryId' => 'numeric'] );

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $input = $request->input();
        date_default_timezone_set ($input['timezone']);
        //date_default_timezone_set ('Asia/Kolkata');
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');
        $current_day_this_month  = date('Y-m-d');
        $currentDateTime = date("Y-m-d H:i:s");

        $top = 'SELECT id,event_log_id,user_id,business_id,event_category_id,name,keywords,slug,description,organizer_name,start_date_time,end_date_time,banner,address,city,state,country,pin_code,latitude,longitude,total_seats,is_blocked,mobile_number,is_top,category, planPurchaseDate FROM (';
        $subscribed = $top . 'SELECT be.*,eb.created_at as planPurchaseDate, u.mobile_number, 1 AS is_top, (SELECT title FROM event_categories as ec where ec.id=be.event_category_id) as category  FROM business_events as be JOIN user_businesses AS ub ON be.user_id=ub.user_id INNER JOIN users as u on u.id = be.user_id LEFT JOIN user_subscription_plans as usp ON usp.user_id=be.user_id LEFT JOIN event_banners as eb ON eb.business_event_id=be.id WHERE usp.subscription_plan_id =10 AND usp.is_expired=0 AND usp.status="success" AND be.is_blocked =0 AND (u.deleted_at IS NULL OR u.deleted_at = "") AND (be.deleted_at IS NULL OR be.deleted_at = "") AND be.is_blocked=0 AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 AND usp.subscription_date<= "'.$current_day_this_month.'" AND usp.expired_date>= "'.$current_day_this_month.'"';
        $unsubscribed = $top . 'SELECT be.*, NULL AS planPurchaseDate, u.mobile_number,0 AS is_top, (SELECT title FROM event_categories as ec where ec.id=be.event_category_id) as category FROM business_events as be JOIN user_businesses AS ub ON be.user_id=ub.user_id INNER JOIN users as u on u.id = be.user_id WHERE (u.deleted_at IS NULL OR u.deleted_at = "") AND (be.deleted_at IS NULL OR be.deleted_at = "") AND be.is_blocked=0 AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1';

        if (isset($input['categoryId'])) {
            /*$subscribed = $subscribed . ' AND be.event_category_id='.$input['categoryId'].' AND be.is_blocked = 0 AND be.country = "'.$input['country'].'" AND be.state = "'.$input['state'].'" AND be.city = "'.$input['city'].'" AND (be.name LIKE "%'.$input['term'].'%" or be.keywords LIKE "%'.$input['term'].'%" OR be.event_log_id LIKE "%'.$input['term'].'%") AND DATE(be.end_date_time) >= CURDATE() ORDER BY usp.transaction_date ASC, be.id ASC) as subscribed';
            $unsubscribed = $unsubscribed . ' AND be.event_category_id='.$input['categoryId'].' AND be.is_blocked = 0 AND be.country = "'.$input['country'].'" AND be.state = "'.$input['state'].'" AND be.city = "'.$input['city'].'" AND (be.name LIKE "%'.$input['term'].'%" or be.keywords LIKE "%'.$input['term'].'%" OR be.event_log_id LIKE "%'.$input['term'].'%") AND DATE(be.end_date_time) >= CURDATE() ORDER BY be.id ASC) as unsubscribed';*/

            /*$subscribed = $subscribed . ' AND ((be.event_category_id='.$input['categoryId'].' OR eb.event_category_id='.$input['categoryId'].') AND (be.name LIKE "%'.$input['term'].'%" or be.keywords LIKE "%'.$input['term'].'%" OR be.event_log_id LIKE "%'.$input['term'].'%")) AND be.is_blocked = 0 AND be.end_date_time >= "'.$currentDateTime.'" ORDER BY usp.transaction_date ASC, be.id ASC) as subscribed';*/
            $subscribed = $subscribed . ' AND be.is_blocked = 0 AND be.end_date_time >= "'.$currentDateTime.'" AND (be.event_category_id ='.$input['categoryId'].' OR eb.event_category_id='.$input['categoryId'].') AND (be.name LIKE "%'.$input['term'].'%" or be.keywords LIKE "%'.$input['term'].'%" OR be.event_log_id LIKE "%'.$input['term'].'%")  ORDER BY usp.transaction_date DESC) as subscribed';
            $unsubscribed = $unsubscribed . ' AND be.event_category_id='.$input['categoryId'].' AND be.is_blocked = 0 AND (be.name LIKE "%'.$input['term'].'%" or be.keywords LIKE "%'.$input['term'].'%" OR be.event_log_id LIKE "%'.$input['term'].'%") AND be.end_date_time >= "'.$currentDateTime.'" ORDER BY be.id ASC) as unsubscribed';
            $query = 'SELECT * FROM (' . $subscribed . ' UNION ' . $unsubscribed . ') as business_list GROUP BY user_id,id ORDER BY planPurchaseDate DESC LIMIT '.$input['index'].','.$input['limit'].'';
            //var_dump($query);dd();
            $response = DB::select($query);
            if(count($response)<=0)
            {
                $response = null;
            }

        } else {

            /*$subscribed = $subscribed . ' AND be.is_blocked = 0 AND be.country = "'.$input['country'].'" AND be.state = "'.$input['state'].'" AND be.city = "'.$input['city'].'" AND (be.name LIKE "%'.$input['term'].'%" or be.keywords LIKE "%'.$input['term'].'%" OR be.event_log_id LIKE "%'.$input['term'].'%") AND be.is_blocked=0 AND DATE(be.end_date_time) >= CURDATE() ORDER BY usp.transaction_date ASC, be.id ASC) as subscribed';
            $unsubscribed = $unsubscribed . ' AND be.is_blocked = 0 AND be.country = "'.$input['country'].'" AND be.state = "'.$input['state'].'" AND be.city = "'.$input['city'].'" AND (be.name LIKE "%'.$input['term'].'%" or be.keywords LIKE "%'.$input['term'].'%" OR be.event_log_id LIKE "%'.$input['term'].'%") AND be.is_blocked=0 AND DATE(be.end_date_time) >= CURDATE() ORDER BY be.id ASC) as unsubscribed';*/
            $subscribed = $subscribed . ' AND be.is_blocked = 0 AND (be.name LIKE "%'.$input['term'].'%" or be.keywords LIKE "%'.$input['term'].'%" OR be.event_log_id LIKE "%'.$input['term'].'%") AND be.is_blocked=0 AND be.end_date_time >= "'.$currentDateTime.'" ORDER BY usp.transaction_date ASC, be.id ASC) as subscribed';
            $unsubscribed = $unsubscribed . ' AND be.is_blocked = 0 AND (be.name LIKE "%'.$input['term'].'%" or be.keywords LIKE "%'.$input['term'].'%" OR be.event_log_id LIKE "%'.$input['term'].'%") AND be.is_blocked=0 AND be.end_date_time >= "'.$currentDateTime.'" ORDER BY be.id ASC) as unsubscribed';
            $query = 'SELECT * FROM (' . $subscribed . ' UNION ' . $unsubscribed . ') as event_list GROUP BY user_id,id ORDER BY planPurchaseDate ASC LIMIT '.$input['index'].','.$input['limit'].'';
            //var_dump($query);dd();
            $response = DB::select($query);
            if(count($response)<=0)
            {
                $response = null;
            }
        }

        if ($response != null && count($response))
        {
            $list = array();
            foreach ($response as $key => $value) {
                $value = (array)($value);
                if($value['total_seats']!=NULL and $value['total_seats']!="")
                {
                    $value['total_seats'] = $value['total_seats'];
                }else
                {
                    $value['total_seats'] = 0;
                }
                /*if($value['banner']!=NULL and $value['banner']="")
                {
                    $value['banner'] = $value['banner'];
                }else
                {
                    $value['banner'] = "";
                }*/
                /*$value['seating_plans'] = BusinessEventSeat::where('business_event_id',$value['id'])->get();*/
                $value['seating_plans']=array();
                $user = User::find($input['userId']);
                $temp = BusinessEventSeat::where('business_event_id',$value['id'])->get();
                if($temp->count()>0)
                {
                    $k=0;
                    foreach ($temp as $value1) {
                        $value['seating_plans'][$k]['id'] = $value1->id;
                        $value['seating_plans'][$k]['user_id'] = $value1->user_id;
                        $value['seating_plans'][$k]['business_id'] = $value1->business_id;
                        $value['seating_plans'][$k]['business_event_id'] = $value1->business_event_id;
                        $value['seating_plans'][$k]['event_seating_plan_id'] = $value1->event_seating_plan_id;
                        $value['seating_plans'][$k]['seating_plan_alias'] = $value1->seating_plan_alias;
                        $value['seating_plans'][$k]['total_seat_available'] = $value1->total_seat_available;
                        $value['seating_plans'][$k]['per_ticket_price'] = number_format($value1->per_ticket_price,2, '.', '');
                        $value['seating_plans'][$k]['user_per_ticket_price'] = (isset($user) && ($user->currency != null) && ($user->currency != 'NGN')) ? number_format(Helper::convertCurrency('NGN', $user->currency, number_format($value1->per_ticket_price,2, '.', '')),2,'.', '') : number_format($value1->per_ticket_price,2, '.', '');
                        $value['seating_plans'][$k]['user_currency'] = (isset($user) && ($user->currency != null)) ? $user->currency : 'NGN';
                        if($value1->seat_buyed!=NULL and $value1->seat_buyed!="")
                        {
                            $value['seating_plans'][$k]['seat_buyed'] = $value1->seat_buyed;
                        }else
                        {
                            $value['seating_plans'][$k]['seat_buyed'] = 0;
                        }
                        if($value1->seat_buyed!=null and $value1->seat_buyed!="")
                        {
                            $value['seating_plans'][$k]['seat_left'] = $value1->total_seat_available-$value1->seat_buyed;
                            $value['total_seats'] = $value['total_seats']-$value['seating_plans'][$k]['seat_buyed'];
                        }else
                        {
                           $value['seating_plans'][$k]['seat_left'] = $value1->total_seat_available;
                        }
                        $k++;
                    }
                }else
                {
                    $value['seating_plans']=array();
                }
                
                $list[] = $value;
            }
            return response()->json(['status' => 'success','response' =>$list]);
        }
        else
        {
            return response()->json(['status' => 'exception','response' => 'Could not found any events']);
        }
    }

    /**
     * Function: get cms pages
     * Url: api/get/cmsPages
     * Request type: Get
     *
     * @param  void
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCmsPages($slug)
    {  
        $response = $this->cmsPages->apiGetCmsPages($slug);
        if($response != NULL && $response->count()){
            $content = preg_split('/\n|\r\n?/', $response->content);
            $temp = array();
            $i=0;
            for ($j=0; $j<count($content); $j++) {
                if(strpos($content[$j], "<h")===false)
                {
                    if(isset($temp[$i]['content']) and $temp[$i]['content']!="")
                    {
                        $temp[$i]['content'] = $temp[$i]['content'] ."\r\n". strip_tags($content[$j]);
                    }else
                    {
                        $temp[$i]['content'] = strip_tags($content[$j]);
                    }
                    if(isset($content[$j+1]) and strpos($content[$j+1], "<h")!==false)
                    {
                        $i++;
                    }
                }else
                {
                    $temp[$i]['heading'] = strip_tags($content[$j]);
                }
            }
            $response->content = $temp;
            return response()->json(['status' => 'success','response' =>$response]);
        }
        else{
            return response()->json(['status' => 'exception','response' => 'Could not found any cms pages']);
        }
    }
    /**
     * Function: blocked/unblocked Notifications
     * Url: api/block/notification
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blockNotification(Request $request)
    {
        $input = $request->input();
        $user = User::find($input['userId']);
        $user->is_notify = !$user->is_notify;
        $user->save();

        if ($user->is_notify) {
            return response()->json(['status' => 'success','response' => 'User unblocked notification successfully']);
            
        } else {
            return response()->json(['status' => 'success','response' => 'User blocked notification successfully']);
        }
    }
    /**
     * Function: get app notification
     * Url: api/get/app/notification
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAppNotification(Request $request)
    {
        $input = $request->input();
        $businessIds = BusinessFollower::whereUserId($input['userId'])->pluck('business_id');
        if($businessIds)
        {
            $notifications = BusinessNotification::whereIn('business_id',$businessIds)->skip($input['index'])->take($input['limit'])->get();
            return response()->json(['status' => 'success','response' => $notifications]);
        } else {
            return response()->json(['status' => 'success','response' => 'There is no notification.']);
        }
    }
    /**
     * Function:save user conversation/message
     * Url: api/post/user/message
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserMessage(Request $request)
    {
        $input = $request->input();
        $response = $this->userConversation->apiPostUserMessage($input);

        if ($response != NULL && $response->count())
        {
            return response()->json(['status' => 'success','response' => $response]);
        } else {
            return response()->json(['status' => 'exception','response' => 'False']);
        }
    }
    /**
     * Function:get single user conversation/message
     * Url: api/get/user/message
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserMessage(Request $request)
    {
        $input = $request->input();
        $response = $this->userConversation->apiGetUserMessage($input);

        if ($response != NULL && $response->count())
        {
            return response()->json(['status' => 'success','response' => $response]);
        } else {
            return response()->json(['status' => 'exception','response' => 'could not find any message']);
        }
    }
    /**
     * Function:get single user conversation/message
     * Url: api/get/user/all/messages
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAllMessages(Request $request)
    {
        $input = $request->input();
        $response = $this->userConversation->apiGetUserAllMessages($input);

        if ($response != NULL && $response->count())
        {
            return response()->json(['status' => 'success','response' => $response]);
        } else {
            return response()->json(['status' => 'exception','response' => 'could not find any message']);
        }
    }

    /**
     * Function:to upload business banner
     * Url: api/upload/business/banner
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadBusinessBanner(Request $request)
    {
        $input = $request->input();
        $response = $this->userBusiness->apiUploadBusinessBanner($input);
        return $response;
    }

    /**
     * Function: save user basic details
     * Url: api/post/user/details
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function postUserDetails(Request $request)
    {
        $response = $this->user->apiPostUserDetails($request);
        return $response;
    }

    /**
     * Function: get user basic details
     * Url: api/get/user/details
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getUserDetails(Request $request)
    {
        $response = $this->user->apiGetUserDetails($request);
        if($response)
        {
            return response()->json(['status' => 'success','response' => $response]);
        } else {
            return response()->json(['status' => 'exception','response' => 'could not find user details.']);
        }
    }

     /**
     * Function: get all chat users of login user 
     * Url: api/get/chat/users
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChatUsers(Request $request)
    {
        $input = $request->input();

        $response = $this->userConversation->apiGetChatUsers($input);
        if ($response)
            return response()->json(['status' => 'success', 'response' => $response]);
        else
            return response()->json(['status' => 'exception', 'response' => 'Could not find any chat user.']);
    }

    /**
     * Function: to get previous messages 
     * Url: api/get/previous/messages
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPreviousMessages(Request $request)
    {
        $input = $request->input();

        $response = $this->userConversation->apiGetPreviousMessages($input);
        
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success', 'response' => $response]);
        else
            return response()->json(['status' => 'exception', 'response' => 'Could not find any messages.']);
    }

    /**
     * Function: To get user like/dislike and following status on particular business
     * Url: api/get/user/business/status
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBusinessStatus(Request $request)
    {
        $input = $request->input();
        $response['like'] = BusinessLike::whereUserId($input['userId'])->whereBusinessId($input['businessId'])->where('is_like', 1)->count();
        $response['dislike'] = BusinessLike::whereUserId($input['userId'])->whereBusinessId($input['businessId'])->where('is_dislike', 1)->count();
        $response['follower'] = BusinessFollower::whereUserId($input['userId'])->whereBusinessId($input['businessId'])->count();
        
        if ($response != NULL && count($response))
            return response()->json(['status' => 'success', 'response' => $response]);
        else
            return response()->json(['status' => 'exception', 'response' => 'Could not find any data for status.']);
    }

    /**
     * Function: To get attending event status of user on particular event 
     * Url: api/get/user/attending/event/status
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserEventAttendingStatus(Request $request)
    {
        $input = $request->input();
        $response = EventParticipant::whereUserId($input['userId'])->whereEventId($input['eventId'])->count();
        if ($response != NULL && count($response))
            return response()->json(['status' => 'success', 'response' => $response]);
        else
            return response()->json(['status' => 'success', 'response' => 0]);
    }

    /**
     * Function: To save product image in a temp folder 
     * Url: api/post/business/productImage
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessProductImage(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'image' => 'required|string',
            'id' => 'sometimes|required|integer'
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $data = $input['image'];

        $img = str_replace('data:image/jpeg;base64,', '', $data);
        $img = str_replace(' ', '+', $img);

        $data = base64_decode($img);

        $fileName = md5(uniqid(rand(), true));

        $image = $fileName.'.'.'png';

        $file = config('image.temp_image_path').$image;

        $success = file_put_contents($file, $data);

        if($success)
        {
            return response()->json(['status' => 'success','response' => asset(config('image.temp_image_url')).'/'.$image]);
        }else
        {
            return response()->json(['status' => 'failure','response' => 'System Error:Image cannot be saved .Please try later.']);
        }
    }

    /**
     * Function: create and update User Product Details.
     * Url: api/post/user/product
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserProduct(Request $request)
    {
        $response = $this->businessProduct->apiPostUserProduct($request);
        return $response;
    }

    /**
     * Function: delete product.
     * Url: api/post/user/delete/product
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteProduct(Request $request)
    {   
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $product = BusinessProduct::where('user_id',$input['userId'])->where('id',$input['productId'])->first();

        if ($product && $product->delete()) {
            return response()->json(['status' => 'success', 'response' => 'Product deleted successfully.']);
        } else {
            return response()->json(['status' => 'exception', 'response' => 'Product could not be deleted.Please try again.']);
        }
    }

    /**
     * Function: delete product Image.
     * Url: api/remove/product/image
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeBusinessProductImage(Request $request)
    {   
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        if(isset($input['deleteImage']) and !empty($input['deleteImage']) && !isset($input['productId']))
        {
            foreach (explode('|', $input['deleteImage']) as $value) {
                Helper::removeImages(config('image.temp_image_path'),$value);
            }

        } elseif (isset($input['deleteImage']) and !empty($input['deleteImage']) && isset($input['productId'])) {
            foreach (explode('|', $input['deleteImage']) as $value) {
                if ($value!="") {
                    if($input['productId'])
                    {
                        Helper::removeImages(config('image.product_image_path'),$value);
                    }else
                    {
                        Helper::removeImages(config('image.temp_image_path'),$value);    
                    }    
                }
            } 

            $images = BusinessProductImage::whereBusinessProductId($input['productId'])->pluck('image')->first();

            $imagesArray = explode("|",$images);
            $key = array_search($input['deleteImage'], $imagesArray);

            //Helper::removeImages(config('image.product_image_path'),$productImage->image);

            if ($key !== null) {
                unset($imagesArray[$key]);
                $images = implode('|',$imagesArray);

                if (!BusinessProductImage::whereBusinessProductId($input['productId'])->update(['image' => $images])) {
                    
                    return response()->json(['status' => 'exception','response' => 'Image not Deleted.']);
                }           
            }
            
        }
        return response()->json(['status' => 'success', 'response' => 'Product Images deleted successfully.']);
    }

    /**
     * Function: delete portfolio Image.
     * Url: api/v2/remove/portfolio/image
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeUserPortfolioImage(Request $request)
    {   
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        if(isset($input['deleteImage']) and !empty($input['deleteImage']) && !isset($input['portfolioId']))
        {
            foreach (explode('|', $input['deleteImage']) as $value) {
                Helper::removeImages(config('image.temp_image_path'),$value);
            }

        } elseif (isset($input['deleteImage']) and !empty($input['deleteImage'])) {
            foreach (explode('|', $input['deleteImage']) as $value) {
                if ($value!="") {
                    if($input['portfolioId'])
                    {
                        Helper::removeImages(config('image.portfolio_image_path'),$value);
                        Helper::removeImages(config('image.portfolio_image_path').'/thumbnails/large/',$value);
                        Helper::removeImages(config('image.portfolio_image_path').'/thumbnails/medium/',$value);
                        Helper::removeImages(config('image.portfolio_image_path').'/thumbnails/small/',$value);
                    }else
                    {
                        Helper::removeImages(config('image.temp_image_path'),$value);    
                    }    
                }
            } 

            $images = UserPortfolioImage::whereId($input['portfolioId'])->pluck('image')->first();

            $imagesArray = explode("|",$images);
            $key = array_search($input['deleteImage'], $imagesArray);

            //Helper::removeImages(config('image.product_image_path'),$productImage->image);

            if ($key !== null) {
                unset($imagesArray[$key]);
                $images = implode('|',$imagesArray);

                if (!UserPortfolioImage::whereId($input['portfolioId'])->update(['image' => $images])) {
                    
                    return response()->json(['status' => 'exception','response' => 'Image not Deleted.']);
                }           
            }
            
        }
        return response()->json(['status' => 'success', 'response' => 'Portfolio Images deleted successfully.']);
    }

    /**
     * Function: Get Business Products of user.
     * Url: api/get/user/business-products
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBusinessProducts(Request $request)
    {   
        $input = $request->input();

        $validator = Validator::make($input, [
            'userId' => 'required|integer',
            'index' => 'required|integer',
            'limit' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
        }

        $response = $this->businessProduct->apiGetUserBusinessProducts($input);
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Product.']);
    }

    /**
     * Function: Get Security Question list.
     * Url: api/get/business/securityQuestion
     * Request type: GET
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSecurityQuestion(Request $request)
    {
        $response = $this->securityQuestion->apiGetSecurityQuestions();
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Security Questions.']);
    }

    /**
     * Function: Get Seating Plans List.
     * Url: api/get/business/eventSeatingPlans
     * Request type: GET
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventSeatingPlans(Request $request)
    {
        $response = $this->eventSeatingPlan->apiGetEventSeatingPlans();
        if ($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Event Seating Plans.']);
    }

    /**
     * Function: Get Home Page Banner List.
     * Url: api/get/business/homeBanner
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHomePageBanners(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'userId' => 'required|integer',
            'country' => 'required',
            'state' => 'sometimes|required',
            'city' => 'sometimes|required',
            'index' => 'required|integer',
            'limit' => 'required|integer',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
        $last_day_this_month  = date('Y-m-t');
        $current_day_this_month  = date('Y-m-d');
        if(isset($input['state']) && isset($input['city']))
        {
            $query = "SELECT ub.bussiness_category_id,ub.bussiness_subcategory_id,hpb.user_id, hpb.business_id, hpb.user_subscription_plan_id, hpb.country, hpb.state, hpb.business_event_id,
            (CASE WHEN hpb.is_selected=0 THEN CONCAT('".asset(config('image.banner_image_url'))."/home/',hpb.image) WHEN hpb.is_selected=1 THEN CONCAT('".asset(config('image.banner_image_url'))."/business/',(SELECT banner FROM user_businesses WHERE user_businesses.id=hpb.business_id)) ELSE CONCAT('".asset(config('image.banner_image_url'))."/event/',(SELECT banner FROM business_events WHERE business_events.id=hpb.business_event_id)) END) as banner,(SELECT title FROM subscription_plans as sp WHERE sp.id=usp.subscription_plan_id) as plan FROM home_page_banners as hpb JOIN user_subscription_plans as usp ON hpb.user_subscription_plan_id = usp.id JOIN user_businesses as ub ON ub.id=hpb.business_id WHERE usp.is_expired=0 and hpb.is_blocked=0  AND (ub.deleted_at IS NULL OR ub.deleted_at = '') AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 and usp.subscription_date<='".$current_day_this_month."' and usp.expired_date>='".$current_day_this_month."' and ((hpb.country ='".$input['country']."' AND hpb.state ='".$input['state']."') OR (hpb.country ='".$input['country']."' AND (hpb.state = '' or hpb.state = NULL))) ORDER BY usp.created_at ASC LIMIT ".$input['index'].", ".$input['limit']."";
        } elseif(isset($input['state'])) {

            $query = "SELECT ub.bussiness_category_id,ub.bussiness_subcategory_id,hpb.user_id, hpb.business_id, hpb.user_subscription_plan_id, hpb.country, hpb.state, hpb.business_event_id,
            (CASE WHEN hpb.is_selected=0 THEN CONCAT('".asset(config('image.banner_image_url'))."/home/',hpb.image) WHEN hpb.is_selected=1 THEN CONCAT('".asset(config('image.banner_image_url'))."/business/',(SELECT banner FROM user_businesses WHERE user_businesses.id=hpb.business_id)) ELSE CONCAT('".asset(config('image.banner_image_url'))."/event/',(SELECT banner FROM business_events WHERE business_events.id=hpb.business_event_id)) END) as banner,(SELECT title FROM subscription_plans as sp WHERE sp.id=usp.subscription_plan_id) as plan FROM home_page_banners as hpb JOIN user_subscription_plans as usp ON hpb.user_subscription_plan_id = usp.id JOIN user_businesses as ub ON ub.id=hpb.business_id WHERE usp.is_expired=0 and hpb.is_blocked=0  AND (ub.deleted_at IS NULL OR ub.deleted_at = '') AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 and usp.subscription_date<='".$current_day_this_month."' and usp.expired_date>='".$current_day_this_month."' and ((hpb.country ='".$input['country']."' AND hpb.state ='".$input['state']."') OR (hpb.country ='".$input['country']."' AND (hpb.state = '' OR hpb.state = NULL))) ORDER BY usp.created_at ASC LIMIT ".$input['index'].", ".$input['limit']."";

        } else {
            $query = "SELECT ub.bussiness_category_id,ub.bussiness_subcategory_id,hpb.user_id, hpb.business_id, hpb.user_subscription_plan_id, hpb.country, hpb.state, hpb.business_event_id, 
            (CASE WHEN hpb.is_selected=0 THEN CONCAT('".asset(config('image.banner_image_url'))."/home/',hpb.image) WHEN hpb.is_selected=1 THEN CONCAT('".asset(config('image.banner_image_url'))."/business/',(SELECT banner FROM user_businesses WHERE user_businesses.id=hpb.business_id)) ELSE CONCAT('".asset(config('image.banner_image_url'))."/event/',(SELECT banner FROM business_events WHERE business_events.id=hpb.business_event_id)) END) as banner,(SELECT title FROM subscription_plans as sp WHERE sp.id=usp.subscription_plan_id) as plan FROM home_page_banners as hpb JOIN user_subscription_plans as usp ON hpb.user_subscription_plan_id = usp.id JOIN user_businesses as ub ON ub.id=hpb.business_id WHERE usp.is_expired=0 and hpb.is_blocked=0 AND (ub.deleted_at IS NULL OR ub.deleted_at = '') AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 and usp.subscription_date<='".$current_day_this_month."' and usp.expired_date>='".$current_day_this_month."' and hpb.country LIKE'".$input['country']."' ORDER BY usp.created_at ASC LIMIT ".$input['index'].", ".$input['limit']."";
        }
        $homeBanners = DB::select($query);

        $banner = array();
        foreach($homeBanners as $key => $data){
            $banner[$key]['user_id'] = $data->user_id;
            $banner[$key]['business_id'] = $data->business_id;
            $banner[$key]['user_subscription_plan_id'] = $data->user_subscription_plan_id;
            $banner[$key]['country'] = $data->country;
            $banner[$key]['state'] = isset($data->state) ? $data->state : '';
            $banner[$key]['business_event_id'] = $data->business_event_id;
            $banner[$key]['bussiness_category_id'] = isset($data->bussiness_category_id) ? $data->bussiness_category_id :'' ;
            //$banner[$key]['bussiness_subcategory_id'] = (isset($data->bussiness_subcategory_id) && $data->bussiness_subcategory_id != NULL && $data->bussiness_subcategory_id != "")  ? $data->business_subcategory_id : '';
            $banner[$key]['banner'] = $data->banner;
            $user = User::find($data->user_id);
            $banner[$key]['is_premium'] = (isset($user) && $user->user_role_id == 5) ? 1:0;

        }

        if (count($homeBanners))
            return response()->json(['status' => 'success','response' =>$banner]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any banner.']);
    }

    /**
     * Function: Get Business Banner List.
     * Url: api/get/business/businessBanner
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessBanners(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'userId' => 'required|integer',
            'country' => 'required',
            'state' => 'sometimes|required',
            'city' => 'sometimes|required',
            'categoryId' => 'sometimes|required',
            'subcategoryId' => 'sometimes|required',
            'index' => 'required|integer',
            'limit' => 'required|integer',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
        $last_day_this_month  = date('Y-m-t');
        $current_day_this_month  = date('Y-m-d');

        $query = "SELECT bb.user_id, bb.business_id, bb.user_subscription_plan_id, bb.country, bb.state, bb.city, bb.business_category_id, bb.business_subcategory_id,
        (CASE WHEN bb.is_selected=0 THEN CONCAT('".asset(config('image.banner_image_url'))."/business/',bb.image) WHEN bb.is_selected=1 THEN CONCAT('".asset(config('image.banner_image_url'))."/business/',(SELECT banner FROM user_businesses WHERE user_businesses.id=bb.business_id)) END) as banner,(SELECT title FROM subscription_plans as sp WHERE sp.id=usp.subscription_plan_id) as plan FROM business_banners as bb JOIN user_businesses AS ub ON bb.user_id=ub.user_id JOIN user_subscription_plans as usp ON bb.user_subscription_plan_id = usp.id WHERE usp.is_expired=0 AND usp.subscription_plan_id >= 3 AND usp.subscription_plan_id < 6 AND (ub.deleted_at IS NULL OR ub.deleted_at = '') AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 and usp.subscription_date<='".$current_day_this_month."' and usp.expired_date>='".$current_day_this_month."' and bb.is_blocked=0 ";

        if(isset($input['categoryId']))
        {
            if(isset($input['subcategoryId']))
            {
                $query = $query. " and bb.business_category_id='".$input['categoryId']."' and bb.business_subcategory_id='".$input['subcategoryId']."'";
            }else
            {
                $query = $query. " and bb.business_category_id='".$input['categoryId']."'";
            }
        }

        if (isset($input['city'])) {
            $query = $query." and ((bb.country ='".$input['country']."' and bb.state ='".$input['state']."' and (bb.city = '' or bb.city = NULL)) or (bb.country ='".$input['country']."' and bb.state = '' and (bb.city = '' or bb.city = NULL)) or (bb.country ='".$input['country']."' and bb.state ='".$input['state']."' and bb.city ='".$input['city']."'))";
        } else if(isset($input['state'])) {
            $query = $query."and ((bb.country ='".$input['country']."' and bb.state ='".$input['state']."' and (bb.city = '' or bb.city = NULL)) or (bb.country ='".$input['country']."' and bb.state = '' and (bb.city = '' or bb.city = NULL)) or (bb.country ='".$input['country']."' and bb.state ='".$input['state']."'))";
            
        } else {

            $query = $query."and bb.country ='".$input['country']."'";

        }

        $query = $query . " ORDER BY usp.created_at ASC LIMIT ".$input['index'].", ".$input['limit']."";
        $businessBanners = DB::select($query);

        $banner = array();
        foreach($businessBanners as $key => $data){
            $banner[$key]['user_id'] = $data->user_id;
            $banner[$key]['business_id'] = $data->business_id;
            $banner[$key]['user_subscription_plan_id'] = $data->user_subscription_plan_id;
            $banner[$key]['country'] = $data->country;
            $banner[$key]['state'] = isset($data->state) ? $data->state : '';
            $banner[$key]['city'] = isset($data->city) ? $data->city : '';
            $banner[$key]['business_category_id'] = isset($data->business_category_id) ? $data->business_category_id :'' ;
            $banner[$key]['business_subcategory_id'] = isset($data->business_subcategory_id) ? $data->business_subcategory_id : '';
            $banner[$key]['banner'] = $data->banner;
            $user = User::find($data->user_id);
            $banner[$key]['is_premium'] = (isset($user) && $user->user_role_id == 5) ? 1:0;

        }
        
        if (count($businessBanners))
            return response()->json(['status' => 'success','response' =>$banner]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any banner.']);
    }

    /**
     * Function: Get Event Banner List.
     * Url: api/get/business/eventBanner
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventBanners(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'userId' => 'required|integer',
            'country' => 'required',
            'state' => 'sometimes|required',
            'city' => 'sometimes|required',
            'categoryId' => 'sometimes|required',
            'index' => 'required|integer',
            'limit' => 'required|integer',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
        $last_day_this_month  = date('Y-m-t');
        $current_day_this_month  = date('Y-m-d');

        $query = "SELECT ub.bussiness_category_id,ub.bussiness_subcategory_id,eb.id, eb.user_id, eb.business_id, eb.user_subscription_plan_id, eb.country, eb.state, eb.city, eb.event_category_id, eb.business_event_id,(CASE WHEN eb.is_selected=0 THEN CONCAT('".asset(config('image.banner_image_url'))."/event/',eb.image) WHEN eb.is_selected=1 THEN CONCAT('".asset(config('image.banner_image_url'))."/event/',(SELECT banner FROM business_events WHERE business_events.id=eb.business_event_id)) END) as banner,(SELECT title FROM subscription_plans as sp WHERE sp.id=usp.subscription_plan_id) as plan FROM event_banners as eb JOIN user_subscription_plans as usp ON eb.user_subscription_plan_id = usp.id JOIN user_businesses as ub ON ub.id=eb.business_id LEFT JOIN business_events AS be ON be.id=eb.business_event_id WHERE usp.is_expired=0 AND (ub.deleted_at IS NULL OR ub.deleted_at = '') AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 and usp.subscription_date<='".$current_day_this_month."' and usp.expired_date>='".$current_day_this_month."' AND usp.subscription_plan_id >= 7 AND usp.subscription_plan_id < 10 AND (be.deleted_at = '' or be.deleted_at IS NULL) AND (ub.deleted_at IS NULL OR ub.deleted_at = '') AND ub.is_blocked=0  AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 AND usp.status='success' and eb.is_blocked=0 ";

        if(isset($input['categoryId']))
        {
            $query = $query. " and eb.event_category_id='".$input['categoryId']."'";
        }

        if (isset($input['city'])) {
            $query = $query."and ((eb.country ='".$input['country']."' and eb.state ='".$input['state']."' and (eb.city = '' or eb.city = NULL)) or (eb.country ='".$input['country']."' and eb.state = '' and (eb.city = '' or eb.city = NULL)) or (eb.country ='".$input['country']."' and eb.state ='".$input['state']."' and eb.city ='".$input['city']."'))";
        

        } else if(isset($input['state'])) {
            $query = $query." and ((eb.country ='".$input['country']."' and eb.state ='".$input['state']."' and (eb.city = '' or eb.city = NULL)) or (eb.country ='".$input['country']."' and eb.state = '' and (eb.city = '' or eb.city = NULL)) or (eb.country ='".$input['country']."' and eb.state ='".$input['state']."')) ";
            
        } else {

            $query = $query ."and eb.country ='".$input['country']."'";

        }
        
        $query = $query . " ORDER BY usp.created_at ASC LIMIT ".$input['index'].", ".$input['limit']."";
        $eventBanners = DB::select($query);
        $banner = array();
        $i=0;
        foreach($eventBanners as $key => $data){
            if(BusinessEvent::whereId($data->business_event_id)->whereDeletedAt(NULL)->first()) {
            $banner[$i]['user_id'] = $data->user_id;
            $banner[$i]['business_id'] = $data->business_id;
            $banner[$i]['user_subscription_plan_id'] = $data->user_subscription_plan_id;
            $banner[$i]['country'] = $data->country;
            $banner[$i]['state'] = isset($data->state) ? $data->state : '';
            $banner[$i]['business_event_id'] = $data->business_event_id;
            $banner[$i]['bussiness_category_id'] = isset($data->bussiness_category_id) ? $data->bussiness_category_id :'' ;
            $banner[$i]['bussiness_subcategory_id'] = isset($data->bussiness_subcategory_id) ? $data->bussiness_subcategory_id : '';
            $banner[$i]['banner'] = $data->banner;
            $user = User::find($data->user_id);
            $banner[$i]['is_premium'] = (isset($user) && $user->user_role_id == 5) ? 1:0;
            $i++;
            }

        }
        
        if (count($eventBanners))
            return response()->json(['status' => 'success','response' =>$banner]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any banner.']);
    }

    /**
     * Function: Book Event Tickets.
     * Url: api/post/event/bookingTickets
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEventBookTickets(Request $request)
    {
        $input = $request->input();

        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }

        $result = $this->payment->transactionVerify($input['reference_id']);
        if($result['status'] and $result['data']['status']=="success")
        {
            $event_transaction['user_id'] = $input['userId'];
            $event_transaction['business_event_id'] = $input['businessEventId'];
            $event_transaction['total_seats_buyed'] = $input['total_seats'];
            $event_transaction['amount'] = number_format($input['total_price'],2, '.', '');
            $event_transaction['currency'] = $result['data']['currency'];
            $event_transaction['user_amount'] = number_format($input['user_amount'],2, '.', '');
            $event_transaction['user_currency'] = $input['user_currency'];

            $event_transaction['reference_id'] = $input['reference_id'];
            $event_transaction['transaction_date'] = $result['data']['transaction_date'];   
            $event_transaction['status'] = $result['data']['status'];
            $event_transaction['ip_address'] = $result['data']['ip_address'];

            $event_transaction = array_intersect_key($event_transaction, EventTransaction::$updatable);
            $event_transaction = EventTransaction::create($event_transaction);

            $check = DB::table('event_participants')->where('user_id',$input['userId'])->where('event_id',$input['businessEventId'])->first();

            if(!$check)
            {
                $event = DB::table('event_participants')->insert(['user_id' => $input['userId'], 'event_id' => $input['businessEventId'] ]);
            }

            if($event_transaction->save())
            {
                $sold_event_ticket['user_id'] = $input['userId'];
                $sold_event_ticket['business_id'] = $input['businessId'];
                $sold_event_ticket['business_event_id'] = $input['businessEventId'];
                $sold_event_ticket['event_transaction_id'] = $event_transaction->id;

                foreach ($request->input('seatsBooked') as $key => $value) {

                    $sold_event_ticket['event_seating_plan_id'] = $value['event_seating_plan_id'];
                    $sold_event_ticket['per_ticket_price'] = $value['per_ticket_price'];
                    $sold_event_ticket['user_per_ticket_price'] = $value['user_per_ticket_price'];
                    $sold_event_ticket['total_tickets_buyed'] = $value['seating_plan_seats'];
                    $sold_event_ticket['total_tickets_price'] = $value['seating_plan_total'];
                    $sold_event_ticket['user_total_tickets_price'] = $value['user_seating_plan_total'];

                    $soldEventTicket = array_intersect_key($sold_event_ticket, SoldEventTicket::$updatable);
                    $soldEventTicket = SoldEventTicket::create($soldEventTicket);

                    if($soldEventTicket->save())
                    {
                        $businessEventSeat = BusinessEventSeat::where('business_id',$input['businessId'])->where('business_event_id',$input['businessEventId'])->where('event_seating_plan_id',$value['event_seating_plan_id'])->first();

                        if($businessEventSeat)
                        {
                            $seats_buyed = $businessEventSeat->seat_buyed + $value['seating_plan_seats'];
                            $businessES['business_id'] = $input['businessId'];
                            $businessES['business_event_id'] = $input['businessEventId'];
                            $businessES['event_seating_plan_id'] = $value['event_seating_plan_id'];
                            $businessES['seat_buyed'] = $businessEventSeat->seat_buyed + $value['seating_plan_seats'];

                            $businessES = array_intersect_key($businessES, BusinessEventSeat::$updatable);
                            $businessEventSeat->update($businessES);
                            
                        }else
                        {
                            return response()->json(['status' => 'exception','response' =>"System Error:Seats could not be booked. Please contact the Admin"]);
                        }
                    }else
                    {
                        return response()->json(['status' => 'exception','response' =>"System Error:Seats could not be booked. Please contact the Admin"]);
                    }
                }
                $eventTicket = EventTicket::orderBy('id', 'desc')->limit(1)->first();
                $eventTickets['user_id'] = $input['userId'];
                $eventTickets['event_id'] = $input['businessEventId'];
                $eventTickets['event_transaction_id'] = $event_transaction->id;
                $eventTickets['attended_status'] = 0;
                if($eventTicket)
                {
                    $subBook = substr($eventTicket->primary_booking_id, -8) + 1;
                    $eventTickets['primary_booking_id'] = 'WAP'. str_pad(substr($eventTicket->primary_booking_id, -8) + 1, 8, '0', STR_PAD_LEFT);
                }else
                {
                    $subBook = 1;
                    $eventTickets['primary_booking_id'] = 'WAP'. str_pad(1, 8, '0', STR_PAD_LEFT);
                }
                for($i=1;$i<=$input['total_seats'];$i++) {
                    $eventTickets['sub_booking_id'] = 'WAS'. str_pad($subBook.$i, 8, '0', STR_PAD_LEFT);
                    $eventTicket = array_intersect_key($eventTickets, EventTicket::$updatable);
                    $res = EventTicket::create($eventTicket);
                    $res->save();
                }

                Mail::to($event_transaction->user->email)->send(new SendBookingTickets($event_transaction));
                if( count(Mail::failures()) > 0 ) {
                    return response()->json(['status' => 'failure', 'response' => "Mail Cannot be sent! Please try again!!"]);
                }else
                {
                    return response()->json(['status' => 'success','response' =>"Your Transaction is successfully completed, mail has been sent to the registered email address."]);
                }
            }else
            {
                return response()->json(['status' => 'exception','response' =>"System Error:Transaction could not be save. Please contact the Admin"]);
            }
        }else
        {
            return response()->json(['status' => 'failure','response' =>"Your Transaction was failed. Please try after some time"]);
        }
    }

    /**
     * Function: Get Sponsor Plans details
     * Url: get/subscriptionPlans/sponsor
     * Request type: GET
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSponsorPlan()
    {
        $response = $this->subscriptionPlan->apiGetPlansByType('sponsor');
        if ($response != NULL && $response->count()){
            $temp = array();
            $k=0;
            foreach ($response as $key => $value) {
                $temp[$k]['id'] = $value->id;
                $temp[$k]['title'] = $value->title;
                $temp[$k]['slug'] = $value->slug;
                $temp[$k]['type'] = $value->type;
                $temp[$k]['coverage'] = $value->coverage;
                $temp[$k]['price'] = number_format($value->price,2, '.', '');
                $temp[$k]['validity_period'] = $value->validity_period;
                $temp[$k]['keywords_limit'] = $value->keywords_limit;
                $temp[$k]['is_blocked'] = $value->is_blocked;
                $k++;
            }
            return response()->json(['status' => 'success','response' =>$temp]);
        }
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Subscription Plan']);
    }

    /**
     * Function: Get Event Plans details
     * Url: get/subscriptionPlans/event
     * Request type: GET
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventPlan()
    {
        $response = $this->subscriptionPlan->apiGetPlansByType('event');
        if ($response != NULL && $response->count()){
            $temp = array();
            $k=0;
            foreach ($response as $key => $value) {
                $temp[$k]['id'] = $value->id;
                $temp[$k]['title'] = $value->title;
                $temp[$k]['slug'] = $value->slug;
                $temp[$k]['type'] = $value->type;
                $temp[$k]['coverage'] = $value->coverage;
                $temp[$k]['price'] = number_format($value->price,2, '.', '');
                $temp[$k]['validity_period'] = $value->validity_period;
                $temp[$k]['keywords_limit'] = $value->keywords_limit;
                $temp[$k]['is_blocked'] = $value->is_blocked;
                $k++;
            }
            return response()->json(['status' => 'success','response' =>$temp]);
        }
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Subscription Plan']);
    }

    /**
     * Function: Get Business Plans details
     * Url: get/subscriptionPlans/business
     * Request type: GET
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessPlan()
    {
        $response = $this->subscriptionPlan->apiGetPlansByType('business');
        if ($response != NULL && $response->count()){
            $temp = array();
            $k=0;
            foreach ($response as $key => $value) {
                $temp[$k]['id'] = $value->id;
                $temp[$k]['title'] = $value->title;
                $temp[$k]['slug'] = $value->slug;
                $temp[$k]['type'] = $value->type;
                $temp[$k]['coverage'] = $value->coverage;
                $temp[$k]['price'] = number_format($value->price,2, '.', '');
                $temp[$k]['validity_period'] = $value->validity_period;
                $temp[$k]['keywords_limit'] = $value->keywords_limit;
                $temp[$k]['is_blocked'] = $value->is_blocked;
                $k++;
            }
            return response()->json(['status' => 'success','response' =>$temp]);
        }
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Subscription Plan']);
    }

    /**
     * Function: Get End User Location Details
     * Url: post/user/location
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEndUserLocation(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'userId' => 'required|integer',
            'country' => 'sometimes|required',
            'state' => 'sometimes|required',
            'city' => 'sometimes|required',
            'latitude' => 'sometimes|required',
            'longitude' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $user = User::whereId($input['userId'])->first();
        if($user)
        {
            $user->country = $input['country'];
            $user->state = $input['state'];
            $user->city = $input['city'];
            $user->latitude = $input['latitude'];
            $user->longitude = $input['longitude'];
            if($user->save())
            {
                return response()->json(['status' => 'success','response' =>$user]);
            }else
            {
                return response()->json(['status' => 'exception','response' => 'User details cannot be updated.']); 
            }
        }else
        {
            return response()->json(['status' => 'failure','response' => 'User dose not exits.']);
        }
    }

    /**
     * Function: Get Subscription Plan Country List
     * Url: get/subscription/country
     * Request type: GET
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountryList()
    {
        $user = User::select('country')->distinct()->whereNotNull('country');
        $event = BusinessEvent::select('country')->distinct()->whereNotNull('country');
        $response = $user->union($event)->groupBy('country')->get();
        //var_dump($response);dd();
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any country']);
    }

    /**
     * Function: Get Subscription Plan State List based on selected country
     * Url: get/subscription/state
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStateList(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'country' => 'required|string',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $user = User::select('state')->distinct()->where('country',$input['country'])->whereNotNull('state');
        $event = BusinessEvent::select('state')->distinct()->where('country',$input['country'])->whereNotNull('state');
        $response = $user->union($event)->groupBy('state')->get();
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any State for this country']);
    }

    /**
     * Function: Get Subscription Plan City List based on selected State
     * Url: get/subscription/city
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCityList(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'country' => 'required|string',
            'state' => 'required|string',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $user = User::select('city')->distinct()->where('country',$input['country'])->where('state',$input['state'])->whereNotNull('city');
        $event = BusinessEvent::select('city')->distinct()->where('country',$input['country'])->where('state',$input['state'])->whereNotNull('city');
        $response = $user->union($event)->groupBy('city')->get();
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any City for this State']);
    }

    /**
     * Function: Get Business Banner List on the base of User Id
     * Url: get/subscription/businessBanner
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessBannerList(Request $request)
    {
        $input = $request->input();

        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        $response = DB::select('SELECT bb.id,bb.user_id,bb.business_id,bb.user_subscription_plan_id, sp.id as subscription_plan_id, sp.title as subscription_plan,bb.is_blocked,bb.business_category_id,(SELECT bc.title FROM bussiness_categories as bc WHERE bb.business_category_id = bc.id) as category,bb.business_subcategory_id, (SELECT bc.title FROM bussiness_categories as bc WHERE bb.business_subcategory_id = bc.id) as subcategory, bb.country, bb.state, bb.city,bb.latitude,bb.longitude,bb.created_at,bb.updated_at,bb.is_selected, CASE WHEN (bb.is_selected=0 AND (bb.image!="" OR bb.image IS NOT NULL )) THEN CONCAT("'.asset(config('image.banner_image_url')).'/business/thumbnails/small/",bb.image) ELSE CONCAT("'.asset(config('image.banner_image_url')).'/business/thumbnails/small/",(SELECT ub.banner FROM user_businesses as ub WHERE ub.id=bb.business_id)) END as img,usp.subscription_date,usp.expired_date, CASE WHEN (usp.is_expired=1 OR usp.expired_date <= "'.date('Y-m-d').'") THEN True ELSE False END as expired FROM business_banners as bb INNER JOIN user_subscription_plans as usp on usp.id=bb.user_subscription_plan_id INNER JOIN subscription_plans as sp ON sp.id=usp.subscription_plan_id where bb.deleted_at IS Null AND bb.user_id='.$input['userId'].' order by usp.created_at DESC');

        if($response != NULL && count($response)>0)
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any business banners']);

    }

    /**
     * Function: Get List of Upcoming Events by User Id
     * Url: get/subscription/eventList
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpcomingEventList(Request $request)
    {
        $input = $request->input();
        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        date_default_timezone_set ($input['timezone']);
        $currentDateTime = date("Y-m-d H:i:s");
        $response = BusinessEvent::where('user_id', $input['userId'])->where('end_date_time','>=',$currentDateTime)->where('is_blocked',0)->get();
        if($response != NULL && $response->count())
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any upcomming events.']);
    }

    /**
     * Function: Get Sponser Banner List on the base of User Id
     * Url: get/subscription/homePageBanners
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSponserBannerList(Request $request)
    {
        $input = $request->input();

        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        $response = DB::select('SELECT hpb.id,hpb.user_id,hpb.business_id,hpb.user_subscription_plan_id, sp.id as subscription_plan_id, sp.title as subscription_plan,hpb.is_blocked, hpb.country, hpb.state, hpb.city,hpb.latitude,hpb.longitude,hpb.created_at,hpb.updated_at,hpb.is_selected, hpb.business_event_id, usp.subscription_date, usp.expired_date, CASE WHEN hpb.is_selected=2 THEN CONCAT("'.asset(config('image.banner_image_url')).'/event/thumbnails/small/",(SELECT banner FROM business_events as be WHERE be.id=hpb.business_event_id)) WHEN hpb.is_selected=1 THEN CONCAT("'.asset(config('image.banner_image_url')).'/business/thumbnails/small/",(SELECT ub.banner FROM user_businesses as ub WHERE ub.id=hpb.business_id)) ELSE CONCAT("'.asset(config('image.banner_image_url')).'/home/thumbnails/small/",hpb.image) END as img, CASE WHEN (usp.is_expired=1 OR usp.expired_date <= "'.date('Y-m-d').'") THEN True ELSE False END as expired FROM home_page_banners as hpb INNER JOIN user_subscription_plans as usp on usp.id=hpb.user_subscription_plan_id INNER JOIN subscription_plans as sp ON sp.id=usp.subscription_plan_id where hpb.deleted_at IS Null AND hpb.user_id='.$input['userId'].' order by usp.created_at DESC');

        if($response != NULL && count($response)>0)
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any Sponsor banners']);

    }

    /**
     * Function: Get Event Banner List on the base of User Id
     * Url: get/subscription/eventBanners
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventBannerList(Request $request)
    {
        $input = $request->input();

        if ($input == NULL) {
            return response()->json(['status' => 'exception','response' => 'Input parameter is missing.']);
        }
        $response = DB::select('SELECT eb.id,eb.user_id,eb.business_id,eb.user_subscription_plan_id, sp.id as subscription_plan_id, sp.title as subscription_plan,eb.is_blocked,eb.event_category_id,(SELECT be.name FROM business_events as be WHERE eb.business_event_id = be.id) as event_name,(SELECT ec.title FROM event_categories as ec WHERE eb.event_category_id = ec.id) as category, eb.country, eb.state, eb.city,eb.latitude,eb.longitude,eb.created_at,eb.updated_at,eb.is_selected,eb.business_event_id, CASE WHEN (eb.is_selected=0 AND (eb.image!="" OR eb.image IS NOT NULL )) THEN CONCAT("'.asset(config('image.banner_image_url')).'/event/thumbnails/small/",eb.image) ELSE CONCAT("'.asset(config('image.banner_image_url')).'/event/thumbnails/small/",(SELECT be.banner FROM business_events as be WHERE be.id=eb.business_event_id)) END as img,usp.subscription_date,usp.expired_date, CASE WHEN (usp.is_expired=1 OR usp.expired_date <= "'.date('Y-m-d').'") THEN True ELSE False END as expired FROM event_banners as eb INNER JOIN user_subscription_plans as usp ON eb.user_subscription_plan_id=usp.id INNER JOIN subscription_plans as sp ON sp.id=usp.subscription_plan_id WHERE eb.deleted_at IS Null AND eb.user_id='.$input['userId'].' order by usp.created_at DESC');
        if($response != NULL && count($response)>0)
            return response()->json(['status' => 'success','response' =>$response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find any event banners']);
    }

    /**
     * Function: Buy Subscription Plans
     * Url: get/subscription/planPurchase
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buySubscriptionPlan(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'userId' => 'required',
            'businessId' => 'required',
            'amount' => 'required',
            'subscriptionPlanId' => 'required',
            'reference_id' => 'required',
            'userAmount' =>'required',
            'userCurrency' => 'required',
            'isPremium' => 'required',

        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $user = User::whereId($input['userId'])->first();
        $subscriptionPlan = SubscriptionPlan::whereId($input['subscriptionPlanId'])->first();
        $result = $this->payment->transactionVerify($input['reference_id']);

        $userSubscriptionPlan['user_id'] = $input['userId'];
        $userSubscriptionPlan['subscription_plan_id'] = $input['subscriptionPlanId'];
        $userSubscriptionPlan['first_name'] = $user->first_name;
        $userSubscriptionPlan['last_name'] = $user->last_name;
        $userSubscriptionPlan['email'] = $user->email;

        if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) 
        {
                $userSubscriptionPlan['amount'] =number_format($input['amount'],2, '.', '');
                $userSubscriptionPlan['currency'] = $result['data']['currency'];
                $userSubscriptionPlan['reference_id'] = $input['reference_id'];
                $userSubscriptionPlan['transaction_date'] = $result['data']['transaction_date'];
                $userSubscriptionPlan['status'] = $result['data']['status'];
                $userSubscriptionPlan['authorization_code'] = $result['data']['authorization']['authorization_code'];
                $userSubscriptionPlan['user_amount'] = $input['userAmount'];
                $userSubscriptionPlan['user_currency'] = $input['userCurrency'];

                $userSubscriptionPlan['is_premium'] = ($input['isPremium'] == 1) ? 1: '';
                $userSubscriptionPlan['is_auto_renew'] = ($input['isPremium'] == 1) ? 1: '';
                $userSubscriptionPlan['ip_address'] = $result['data']['ip_address'];
                $userSubscriptionPlan['subscription_date'] = date("Y-m-d");
                $userSubscriptionPlan['expired_date'] = date("Y-m-d", strtotime("+".$subscriptionPlan->validity_period." days"));
                $userSubscriptionPlan['is_expired'] = 0;
                $userSubscriptionPlan = array_intersect_key($userSubscriptionPlan, UserSubscriptionPlan::$updatable);
                $userSubscriptionPlan = UserSubscriptionPlan::create($userSubscriptionPlan);

                if($userSubscriptionPlan->save())
                {
                    $input = array(
                        'user_id' => $userSubscriptionPlan->user_id,
                        'business_id' => $userSubscriptionPlan->business->id,
                        'user_subscription_plan_id' => $userSubscriptionPlan->id,
                        'is_blocked' => 1,
                    );
                    switch ($subscriptionPlan->type) {
                        case 'business':
                            $input = array_intersect_key($input, BusinessBanner::$updatable);
                            $businessBanner = BusinessBanner::create($input);
                            if($businessBanner->save())
                            {
                                return response()->json(['status' => 'success', 'response' => array('message' => 'Your Business banner has been created successfully. Please add banner and unblock the banner to make it active.', 'type' => 'business', 'banner' => $businessBanner)]);
                            }else
                            {
                                return response()->json(['status' => 'exception','response' => 'Your Business banner could not be created. Please contact the Admin.']);
                            }
                            break;

                        case 'sponsor':
                            $input = array_intersect_key($input, HomePageBanner::$updatable);
                            $homePageBanner = HomePageBanner::create($input);
                            if($homePageBanner->save())
                            {
                                return response()->json(['status' => 'success', 'response' => array('message' => 'Your Sponsor banner has been created successfully. Please add banner and unblock the banner to make it active.', 'type' => 'sponsor', 'banner' => $homePageBanner)]);
                            }else
                            {
                                return response()->json(['status' => 'exception','response' => 'Your Sponsor banner could not be created. Please contact the Admin.']);
                            }
                            break;

                        case 'event':
                            $input = array_intersect_key($input, EventBanner::$updatable);
                            $eventBanner = EventBanner::create($input);
                            if($eventBanner->save())
                            {
                                return response()->json(['status' => 'success', 'response' => array('message' => 'Your Event banner has been created successfully. Please add banner and unblock the banner to make it active.', 'type' => 'event', 'banner' => $eventBanner)]);
                            }else
                            {
                                return response()->json(['status' => 'exception','response' => 'Your Event banner could not be created. Please contact the Admin.']);
                            }
                            break;
                        case 'premium':
                                $user = User::whereId($input['user_id'])->update(['user_role_id' => 5]);
                            
                                return response()->json(['status' => 'success', 'response' => array('message' => 'Your premium plan is activated successfully', 'type' => 'premium')]);
                            break;
                    }
                }else
                {
                    return response()->json(['status' => 'exception','response' => 'Subscription Plan could not be added. Please contact the Admin.']);
                }
        }else
        {
            return response()->json(['status' => 'failure','response' => 'Your transaction was unsuccessfull. Please try again.']);
        }
    }

    /**
     * Function: Post Business Banner
     * Url: post/subscription/businessBanner
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBusinessBanner(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'userId' => 'required',
            'bannerId' => 'required',
            'user_subscription_plan_id' => 'required',
            'is_selected' => 'required',
            'image' => 'sometimes|string|required_if:is_selected,==,0',
            'categoryId' => 'sometimes|required',
            'subcategoryId' => 'sometimes|required',
            'country' => 'sometimes|required',
            'state' => 'sometimes|required',
            'city' => 'sometimes|required',
            'is_blocked' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->businessBanner->updateBusinessBanner($input);

        return $response;
    }

    /**
     * Function: Post Event Banner
     * Url: post/subscription/eventBanner
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEventBanner(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'userId' => 'required',
            'bannerId' => 'required',
            'user_subscription_plan_id' => 'required',
            'is_selected' => 'required',
            'image' => 'sometimes|string|required_if:is_selected,==,0',
            'categoryId' => 'sometimes|required',
            'country' => 'sometimes|required',
            'state' => 'sometimes|required',
            'city' => 'sometimes|required',
            'businessEventId' => 'sometimes|required_if:is_selected,==,1',
            'is_blocked' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->eventBanner->updateEventBanner($input);

        return $response;
    }

    /**
     * Function: Post Sponsor Banner
     * Url: post/subscription/sponsorBanner
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSponsorBanner(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'userId' => 'required',
            'bannerId' => 'required',
            'user_subscription_plan_id' => 'required',
            'is_selected' => 'required',
            'image' => 'sometimes',
            'businessEventId' => 'sometimes|required_if:is_selected,==,2',
            'country' => 'sometimes|required',
            'state' => 'sometimes|required',
            'is_blocked' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->homePageBanner->updateHomePageBanner($input);

        return $response;
    }

    /**
     * Function: Signup/Login using Google/Facebook
     * Url: post/signup/google
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postGoogleFacebookSignup(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'token' => 'required',
            'type' => 'required',
            'image' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->user->socialLogin($request);

        return $response;
    }

    /**
     * Function: Block/Unblock Banner
     * Url: post/banner/block
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blockBanner(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'userId' => 'required',
            'bannerId' => 'required',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        switch ($input['type']) {
            case 'business':
                $response = $this->businessBanner->block($input);
                break;
            
            case 'event':
                $response = $this->eventBanner->block($input);
                break;

            case 'sponsor':
                $response = $this->homePageBanner->block($input);
                break;
        }

        return $response;
    }

    /**
     * Function: Get Transaction History
     * Url: get/transactionHistory
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transactionHistory(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'userId' => 'required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $user = $this->user->whereId($input['userId'])->first();
        if($user)
        {
            $subscriptionPlan = UserSubscriptionPlan::where('user_id', $input['userId'])
            ->whereNotNull('status')
            ->select('subscription_plans.title as Plan','user_subscription_plans.amount as plan_amount', 'user_subscription_plans.currency as plan_currency','user_subscription_plans.reference_id as reference_id','user_subscription_plans.transaction_date as purchase_date','user_subscription_plans.status as status','user_subscription_plans.user_amount', 'user_subscription_plans.user_currency', 'user_subscription_plans.expired_date as expired_date')
            ->join('subscription_plans','user_subscription_plans.subscription_plan_id', '=', 'subscription_plans.id')
            ->orderBy('user_subscription_plans.id', 'desc')
            ->get();
            $eventBooking = EventTransaction::whereNotNull('status')
            ->select('event_transactions.*', 'business_events.name', DB::raw('CONCAT(event_seating_plans.title,":",sold_event_tickets.total_tickets_buyed) tickets'))
            ->join('sold_event_tickets','sold_event_tickets.event_transaction_id', '=', 'event_transactions.id')
            ->join('event_seating_plans','sold_event_tickets.event_seating_plan_id', '=', 'event_seating_plans.id')
            ->join('business_events','event_transactions.business_event_id', '=', 'business_events.id')
            ->orderBy('event_transactions.id', 'desc')
            ->toSql();
            $eventBooking = DB::table(DB::raw('('.$eventBooking.') as booking'))
            ->where('booking.user_id', $input['userId'])
            ->select('id','user_id','business_event_id','name','total_seats_buyed','amount','currency','user_amount','user_currency','reference_id','transaction_date','status',DB::raw('GROUP_CONCAT(tickets SEPARATOR ", ") tickets_booked'))
            ->groupBy('reference_id')->orderBy('id', 'desc')->get();
            if(($subscriptionPlan != NULL && $subscriptionPlan->count()) || ($eventBooking != NULL && $eventBooking->count()))
            {
                return response()->json(['status' => 'success','response' => array('subscription_plans' => $subscriptionPlan, 'eventBookings' => $eventBooking)]);
            }else
            {
                return response()->json(['status' => 'exception','response' => "No record found"]);
            }
        }else
        {
            return response()->json(['status' => 'failure','response' => 'User Id is invalid!']);
        }
    }

    /**
     * Function: Get Business Banner
     * Url: get/subscription/businessBannerImage
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessBanner(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'businessId' => 'required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $business = $this->userBusiness->select('banner')->whereId($input['businessId'])->first();

        if($business)
        {
            return response()->json(['status' => 'success','response' => $business]);
        }else
        {
            return response()->json(['status' => 'failure','response' => 'Business Id is invalid!']);
        }
    }

    /**
     * Function: Get User Notification List
     * Url: get/user/notificationList
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserNotificationList(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'userId' => 'required',
            'index' => 'required',
            'limit' => 'required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $userNotification = UserNotification::where('user_id',$input['userId'])->first();
        if($userNotification)
        {
            $notifications = BusinessNotification::whereIn('business_notifications.id', explode(',', $userNotification->business_notification_id))
            ->select('business_notifications.id','business_notifications.user_id','business_notifications.business_id','business_notifications.source','business_notifications.message','business_notifications.is_read',DB::raw('CASE WHEN business_notifications.business_id!="" THEN (SELECT title FROM user_businesses WHERE user_businesses.id=business_notifications.business_id) ELSE "Admin" END as title'), DB::raw('(SELECT CONCAT("'.asset(config("image.logo_image_url")).'/",user_businesses.business_logo) FROM user_businesses WHERE user_id =business_notifications.user_id) as image'),DB::raw('(SELECT user_businesses.bussiness_category_id FROM user_businesses WHERE user_id =business_notifications.user_id) as bussiness_category_id'),DB::raw('(SELECT user_businesses.bussiness_subcategory_id FROM user_businesses WHERE user_id =business_notifications.user_id) as bussiness_subcategory_id'), 'business_notifications.created_at',DB::raw('CASE WHEN users.user_role_id=5 THEN 1 ELSE 0 END as is_premium'))
            ->join('users', 'business_notifications.user_id', '=', 'users.id')
            ->orderBy('business_notifications.id', 'DESC')
            ->skip($input['index'])
            ->take($input['limit'])
            ->get();
        
            if(count($notifications) > 0 )
            {
                return response()->json(['status' => 'success','response' => $notifications]);
            }else
            {
                return response()->json(['status' => 'exception','response' => 'No Notification found for this user!']);
            }
        }else
        {
            return response()->json(['status' => 'exception','response' => 'No Notification found for this user!']);
        }
    }

    /**
     * Function: Login Event User
     * Url: event/login
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventLogin(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'eventLogId' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->businessEvent->apiEventLogin($input);
        
        return $response;
    }

    /**
     * Function: Event Details by Event Id for Event Ticket App
     * Url: get/eventDetails
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventIdDetails(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'eventId' => 'required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $event = BusinessEvent::where('id', $input['eventId'])->first();
        if($event)
        {
            if($event->total_seats!=Null AND $event->total_seats>0)
            {
                $date1 = date_create($event->start_date_time);
                $date2 = date_create($event->end_date_time);
                $date3 = date_create(date("Y/m/d"));
                
                $diff=date_diff($date1,$date3);
                $diff2=date_diff($date3,$date2);
                
                $array =  $event->toArray();
                //$array['user'] = $event->user->toArray(); 
                $array['total_seats_buyed'] = $event->soldEventTickets->sum('total_tickets_buyed');
                $array['total_seats_left'] = intval($event->total_seats - $event->soldEventTickets->sum('total_tickets_buyed'));
                $eventSeatingPlans = EventSeatingPlan::where('is_blocked', 0)->get();
                $seatingPlan = array();
                $i=0;
                foreach ($eventSeatingPlans as $eventSeatingPlan) {
                    if($eventSeatingPlan->getEventPlanSeats($event->id, $eventSeatingPlan->id)>0)
                    {
                        $seatingPlan[$i]['seating_plan_title'] = $eventSeatingPlan->title;
                        $seatingPlan[$i]['seating_plan_seats'] = $eventSeatingPlan->getEventPlanSeats($event->id, $eventSeatingPlan->id);
                        $i++;
                    }
                }
                $array['seating_plans'] = $seatingPlan;
                $array['user_ckecked_in'] = EventTicket::where('event_id',$event->id)->where('attended_status',1)->count();
                $array['user_left'] = EventTicket::where('event_id',$event->id)->where('attended_status',0)->count();
                //var_dump($array);dd();
                return response()->json(['status' => 'success','response' => $array]);
            }else
            {
                return response()->json(['status' => 'exception','response' => 'Your Event dose not have any seating plan.']);
            }
        }else
        {
            return response()->json(['status' => 'failure','response' => 'These event id do not match with our records.']);
        }
    }

    /**
     * Function: Get Booked Ticket Lists for a event
     * Url: event/get/tickteList
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventTicktesList(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'eventId' => 'required',
            'referenceId' => 'sometimes|required_without:primaryBookingId',
            'primaryBookingId' => 'sometimes|required_without:referenceId'
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        if(isset($input['primaryBookingId']) or isset($input['referenceId']))
        {
            $response = $this->eventTickets->apiEventTicktes($input);

            return $response;

        }else
        {
            return response()->json(['status' => 'exception','response' => 'Primary Booking Id or QR code is required.']);
        }
    }

    /**
     * Function: Update Event Tickets Status
     * Url: event/booked/eventTicktes
     * Request type: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEventTickets(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'ticketId' => 'required',
            'eventId' => 'required',
            'referenceId' => 'sometimes|required_without:primaryBookingId',
            'primaryBookingId' => 'sometimes|required_without:referenceId'
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $response = $this->eventTickets->apiTickteUpdateStatus($input);

        return $response;
    }

    /**
     * Function: Delete FCM Token.
     * Url: api/removeFCM
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFCM(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'userId' => 'required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $userFCM = FcmUser::where('user_id', $input['userId'])->first();

        if($userFCM)
        {
            $deletedRows = FcmUser::where('user_id', $input['userId'])->delete();
            if($deletedRows)
            {
                return response()->json(['status' => 'success','response' => 'FCM Token deleted success fully.']);
            }else
            {
                return response()->json(['status' => 'exception','response' => 'User FCM token could not get deleted.']);
            }
        }else
        {
            return response()->json(['status' => 'failure','response' => 'User FCM Token is not registered.']);
        }
    }

    /**
     * Function: Get Business Event Details
     * Url: api/get/business/event/details
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonReseponse
     */
    public function getBusinessEventDetails(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'businessEventId' => 'required',
            'userId' => 'required'
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $event = BusinessEvent::where('id',$input['businessEventId'])
        ->select('*',DB::raw('(SELECT title FROM event_categories as ec where ec.id=business_events.event_category_id) as event_category'),DB::raw("(SELECT mobile_number FROM users WHERE business_events.user_id=users.id) as mobile_number"))
        ->where('is_blocked',0)
        ->where('deleted_at',NULL)
        ->first();

        if($event) {
            $user = User::find($input['userId']);
        }
        
        if($event)
        {   
            $event = $event->toArray();
            $temp = BusinessEventSeat::where('business_event_id',$input['businessEventId'])
            ->select('id','event_seating_plan_id','seating_plan_alias','total_seat_available','per_ticket_price', 'seat_buyed', 'business_event_id')
            ->get();
            $event['seating_plans']=array();
            if($temp)
            {
                $k=0;
                foreach ($temp as $value1) {
                    $event['seating_plans'][$k]['id'] = $value1->id;
                    $event['seating_plans'][$k]['event_seating_plan_id'] = $value1->event_seating_plan_id;
                    $event['seating_plans'][$k]['seating_plan_alias'] = $value1->seating_plan_alias;
                    $event['seating_plans'][$k]['per_ticket_price'] = number_format($value1->per_ticket_price,2, '.', '');
                    $event['seating_plans'][$k]['user_per_ticket_price'] = (isset($user) && ($user->currency != NULL ) && $user->currency != 'NGN') ? number_format(Helper::convertCurrency('NGN', $user->currency, number_format($value1->per_ticket_price,2, '.', '')),2,'.', '') : number_format($value1->per_ticket_price,2, '.', '');
                    $event['seating_plans'][$k]['user_currency'] = (isset($user) && ($user->currency != NULL )) ? $user->currency : 'NGN';
                    $event['seating_plans'][$k]['business_event_id'] = $value1->business_event_id;
                    $event['seating_plans'][$k]['total_seat_available'] = $value1->total_seat_available;
                    if($value1->seat_buyed!=NULL and $value1->seat_buyed!="")
                    {
                        $event['seating_plans'][$k]['seat_buyed'] = $value1->seat_buyed;
                    }else
                    {
                        $event['seating_plans'][$k]['seat_buyed'] = 0;
                    }
                    if($value1->seat_buyed!=null and $value1->seat_buyed!="")
                    {
                        $event['seating_plans'][$k]['seat_left'] = $value1->total_seat_available-$value1->seat_buyed;
                        $event['total_seats'] = $event['total_seats']-$value1->seat_buyed;
                    }else
                    {
                        $event['seating_plans'][$k]['seat_left'] = $value1->total_seat_available;
                    }
                    $k++;
                }
            }else
            {
                $event['seating_plans']=array();
            }
            return response()->json(['status' => 'success','response' => $event]);
        }else
        {
            return response()->json(['status' => 'failure','response' => "Event not found"]);
        }
    }

    /**
     * Function: Delete User Notifications
     * Url: api/delete/user/notification
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeUserNotification(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'notificationId' => 'required',
            'userId' => 'required'
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $userNotification = UserNotification::where('user_id', $input['userId'])->first();
        if($userNotification)
        {
            $result = array_diff(explode(',', $userNotification->business_notification_id),explode(',', $input['notificationId']));
            $userNotification->business_notification_id = implode(',', $result);
            if($userNotification->save())
            {
                $notifications = BusinessNotification::whereIn('business_notifications.id', explode(',', $userNotification->business_notification_id))
                ->select('business_notifications.id','business_notifications.business_id','business_notifications.source','business_notifications.message','business_notifications.is_read',DB::raw('CASE WHEN business_notifications.business_id!="" THEN (SELECT title FROM user_businesses WHERE user_businesses.id=business_notifications.business_id) ELSE "Admin" END as title'), DB::raw('(SELECT users.image FROM users WHERE id=business_notifications.user_id) as image'), 'business_notifications.created_at')
                ->orderBy('business_notifications.id', 'DESC')
                ->get();
                if($notifications)
                {
                    return response()->json(['status' => 'success','response' => $notifications]);
                }else
                {
                    return response()->json(['status' => 'exception','response' => 'No Notification found for this user!']);
                }
                /*return response()->json(['status' => 'success','response' => "Notifications deleted successfully"]);*/
            }else
            {
                return response()->json(['status' => 'exception','response' => "Notifications could not be deleted please try after sometime."]);
            }
        }else
        {
            return response()->json(['status' => 'failure','response' => "No Notifications found for this user"]);
        }
    }

    /**
     * Function: User Business Status
     * Url: api/get/business/status
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkBusinessStatus(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'businessId' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
        }

        $business = UserBusiness::whereId($input['businessId'])->first();
        $premium = UserSubscriptionPlan::whereUserId($business->user_id)->whereIsPremium(1)->first();
        if($business)
        {
            $res = array('is_blocked'=>$business->is_blocked);
            if($business->is_identity_proof_validate && $business->is_business_proof_validate)
            {
                $res['is_verified'] = 1;
            }else
            {
                $res['is_verified'] = 0;
            }
            $res['is_premium'] = ($business->user->user_role_id == 5) ? 1:0;
            $res['premium_status'] = (($business->user->user_role_id == 5) && isset($premium) && $premium->is_auto_renew) ? 1:0;
            $res['event_password_status'] = ($business->user->event_password != NUll && $business->user->event_password != "") ? 1:0;
            return response()->json(['status' => 'success','response' => $res]);
        }else
        {
            return response()->json(['status' => 'failure','response' => "Business Id is invalid"]);
        }
    }
}