<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Weafricans</title>
    <style type="text/css">
      body{margin: 0;}
      .header_container{text-align: center;background: #2d3e50;padding: 15px;}
      .image-container img{max-width: 100%;}
      .social-icon ul{
      padding: 0;
      margin: 0;
      display: inline-block; 
      }
      .social-icon li a{
      display: inline-block;
      margin: 10px;
      margin-top: 10px;}
      .social-icon li {
      list-style: none;
      float: left;
      }
      .content-section ul li{color: #999999;font-size: 14px;margin-bottom: 5px; }
      .content-section p{color: #999999;font-size: 14px;}
      .detail-contact ul{display: inline-block;padding: 0;}
      .detail-contact ul li{float: left;list-style: none;font-weight: 500;font-size: 18px;color: #999999;}
      .detail-contact ul li:first-child{border-right: 2px solid #999999;padding-right: 10px;
      margin-right: 10px;}
      .detail-contact p{margin-bottom: 0px;color: #999999;font-weight: 500;font-size: 18px;}
      .name-address p{margin-bottom: 0px;}
    </style>
  </head>
  <body>
    <div class="wrap_body" style="background: #efefef;    display: inline-block;width: 100%;padding: 60px 0px;">
      <div class="wrap_container" style="background: #fff; margin: 0 auto; width: 80%;display: block;box-shadow: 1px 1px 15px -3px;">
        <div class="header_container">
          <img src="{{ env('APP_URL').'images/mail/logo.png' }}" alt="Logo">
        </div>
        <div class="image-container">
          <img src="{{ env('APP_URL').'images/mail/email-banner.png' }}" alt="Banner">
        </div>
        <div class="content-section" style="padding:45px 45px 10px 45px">
          <h4 style="color: #33c0c9;font-weight: bold;font-size: 22px;margin-bottom: 5px;">Hello {{ $eventTransaction->user->first_name.' '.$eventTransaction->user->last_name }},</h4>
          <p style="padding-top: 10px;margin-bottom: 0px;"> Event Ticket Booking</p>
          <p style="line-height: 26px;text-align: justify;">You have booked {{ $eventTransaction->total_seats_buyed }} seats for the Event {{ $eventTransaction->event->name }}. 
         <h4 style="font-weight: bold;color: #999999;padding-top: 10px;">QR Code</h4>
          <img src="http://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ $eventTransaction->reference_id }}">
          <br>
          @php $primary = $eventTransaction->eventTickets->first(); @endphp
          <p>Primary Booking Id: <strong> {{ $primary->primary_booking_id }} </strong></p>
          <p>Booked Tickets Ids</p>
          <table class="table">
            <thead>
              <tr>
                <td>Id</td>
                <td>Booking Id</td>
              </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
              @foreach($eventTransaction->eventTickets as $value)
                <tr><td>{{ $i }}</td><td>{{ $value->sub_booking_id }}</td></tr>
                @php $i++; @endphp
              @endforeach
            </tbody>
          </table></p>
          <div class="name-address" style="margin-top: 30px;">
            <h4 style="color: #33c0c9;font-weight: bold;font-size: 22px;margin-bottom: 5px;">Sincerely,</h4>
            <p style="font-weight: 600;font-size: 18px;">weafricans</p>
          </div>
        </div>
      <div class="footer" style="padding-top: 20px;">
          <div class="social-icon" style="text-align: center;">
            <ul >
              <li><a href="https://www.facebook.com/weafricansapp/" target="_blank" class="fb"><img src="{{ asset('images/mail/facebook.png') }}" alt="facebook icon"></a></li>
              <li><a href="https://twitter.com/Weafricansapp" target="_blank" class="twt"><img src="{{ asset('images/mail/twitter.png') }}" alt="twitter icon"></a></li>
              <li><a href="#" class="pin"><img src="{{ asset('images/mail/instagram.png') }}" alt="instagram icon"></a></li>
              <li><a href="https://plus.google.com/107943245633477453175" target="_blank" class="gplus"><img src="{{ asset('images/mail/google-plus.png') }}" alt="google-plus icon"></a></li>
              <li><a href="https://www.instagram.com/weafricansapp/" target="_blank" class="insta"><img src="{{ asset('images/mail/linkedin.png') }}" alt="instagram icon"></a></li>
            </ul>
          </div>
          <div class="detail-contact" style="text-align: center;padding: 20px;">
            <p>Join Weafricans today, lets promote a unify and strong mutual African business community within the globe.</p><br>
            <div class="sent-detail" style="margin-top: 20px;">
              <p>sent by</p>
              <img src="{{ asset('images/mail/logo.png') }}" alt="Logo" style="background:#2d3e50;">
              <p>5th Floor, Mulliner Towers 39 Alfred Rewane Road Ikoyi Lagos Tel: +234 1 2719190</p>
            </div>
          </div>
          <div class="copyright-section" style="text-align: center;display: inline-block;width: 100%;background: #2d3e50;color: #fff;padding: 20px 0px;">
            <p style="margin-bottom: 0px;font-size: 16px;">Copyright @ Weafricans Digital Technologies Limited. All Rights Reserved.</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>