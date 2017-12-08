<?php

namespace App\Http\Controllers\EventAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

use App\BusinessEvent;
use App\User;
use Auth;
use Session;

class LoginController extends Controller
{
    public function getLogin()
    { 
        if(Session::get('eventId')) {
            return redirect('event/dashboard');
        }
    	return view('event-auth.login');
    }

    public function postLogin(Request $request)
    {
        $event = BusinessEvent::where('event_log_id', $request->eventId)->first();
        if($event)
        {
            if($event->is_blocked==0)
            {
                if (Hash::check($request->password, $event->user->event_password)) {
                    if($event->business->is_identity_proof_validate && $event->business->is_business_proof_validate)
                    {
                        if($event->total_seats!=Null AND $event->total_seats>0)
                        {
                            $d1 = strtotime(date("Y/m/d",strtotime($event->start_date_time)));
                            $d2 = strtotime(date("Y/m/d",strtotime($event->end_date_time)));
                            $d3 = strtotime(date("Y/m/d"));
                            $st = (int)(($d3 - $d1)/86400);
                            $et = (int)(($d2 - $d3)/86400);
                            
                            if(($st>0 OR $st==-1) AND $et>=0)
                            {
                                Session::put('eventId', $event->id);

                                return redirect()->intended('event/dashboard');
                            }elseif($st<-1)
                            {
                                return back()->with('warning', 'Your Event will be start on '.date("d-M-Y", strtotime($event->start_date_time)).'. And you will be able to log in this section one day before your event start date.'); 
                            }elseif($et<=0)
                            {
                                return back()->with('error', 'Your event has been expired.');
                            }else
                            {
                                return back()->with('error', 'Event is not in our records');
                            }
                        }else
                        {
                            return back()->with('error', 'Your Event dose not have any seating plan.'); 
                        }
                    }else
                    {
                        return back()->with('error', 'Your business is not verified by the admin.'); 
                    }
                }else
                {
                    $errors = new MessageBag(['password' => ['Please Enter a valid password to login.']]);
                    return back()->withErrors($errors)->withInput(Input::except('password'));
                }
            }else
            {
                return back()->with('error', 'Your Event has been blocked.');
            }
        }else
        {
            $errors = new MessageBag(['eventId' => ['These event id do not match with our records.']]);
            return back()->withErrors($errors)->withInput(Input::except('eventId'));
        }
    	return view('event-auth.login');
    }

    public function logout()
    {
    	Auth::logout();
    	Session::flush();
    	return redirect()->intended('/');
    }
}
