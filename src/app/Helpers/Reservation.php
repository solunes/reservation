<?php 

namespace Solunes\Reservation\App\Helpers;

use Validator;

class Reservation {

    public static function getTimeDifference($time1, $time2) {
      $time1 = strtotime("1980-01-01 $time1");
      $time2 = strtotime("1980-01-01 $time2");

      if ($time2 < $time1) {
              $time2 += 86400;
      }
      
      return round(($time2 - $time1)/60);
    }

    public static function getAvailableHours($service, $date_start, $date_end) {
        $array = [];
        if($service->type=='open'){
          $items = $service->accommodation_ranges;
          $subarray = [];
          $minutes_interval = \Reservation::getMinutePeriods($service);
          foreach($items as $item){
            $subarray = \Reservation::getSeparateTimePeriods($subarray, $item->initial_day, $date_start, $item->initial_time, strtotime($item->end_time), $minutes_interval);
          }
          \Log::info('checking: '.$date_end);
          if($date_start==$date_end){
            $period = [$date_start];
          } else {
            $period = new \DatePeriod(
              new \DateTime($date_start),
              new \DateInterval('P1D'),
              new \DateTime($date_end)
            );
          }
          \Log::info('PERIOD: '.json_encode($period));
          foreach($period as $date){
            $date_val = $date->format('Y-m-d');
            $date_day = 'd_0'.($date->format('w')+1);
            if(isset($subarray[$date_day])){
              //\Log::info(json_encode($subarray[$date_day]));
              $array[$date_val] = $subarray[$date_day];
            }
          }
        } else if($service->type=='closed'){
          $items = $service->accommodation_spaces()->where('initial_date', '>=', $date_start)->where('end_date', '<=', $date_end)->get();
          if(count($items)==0){
            $items = $service->accommodation_spaces()->where('initial_date', '>=', date('Y-m-d'))->where('initial_time', '>=', date('H:i:s'))->get();
          }
          foreach($items as $item){
            $days_duration = strtotime($item->end_date.' '.$item->end_time) - strtotime($item->initial_date.' '.$item->initial_time);
            $days_duration = round($days_duration / (60 * 60 * 24));
            $array[$item->initial_date][] = ['time_in'=>$item->initial_time,'days_duration'=>$days_duration,'time_out'=>$item->end_time];
          }
        }
        return $array;
    }

    public static function getAvailableDays($service, $date_start, $date_end, $reservation = NULL) {
        $array = [];
        if($service->type=='open'){
          $items = $service->accommodation_ranges;
          $subarray = [];
          foreach($items as $item){
            $subarray = \Reservation::getSeparateTimePeriods($subarray, $item->initial_day, $date_start, $item->initial_time, strtotime($item->end_time), $minutes_interval);
          }
          if($date_start==$date_end){
            $period = [$date_start];
          } else {
            $period = new \DatePeriod(
              new \DateTime($date_start),
              new \DateInterval('P1D'),
              new \DateTime($date_end)
            );
          }
          foreach($period as $date){
            $date_val = $date->format('Y-m-d');
            $date_day = 'd_0'.($date->format('w')+1);
            if(isset($subarray[$date_day])){
              $array[$date_val] = $subarray[$date_day];
            }
          }
        } else if($service->type=='closed'){
          $items = $service->accommodation_spaces()->where('initial_date', '>=', $date_start)->where('end_date', '<=', $date_end)->get();
          foreach($items as $item){
            $array[$item->initial_date][] = ['time_in'=>$item->initial_time,'date_out'=>$item->end_date,'time_out'=>$item->end_time];
          }
        }
        return $array;
    }

    public static function getMinutePeriods($service) {
      $duration = $service->duration_number;
      if($service->duration_type=='minute'){
        return $duration;
      } else if($service->duration_type=='hour'){
        return $duration*60;
      } else if($service->duration_type=='day'){
        return $duration*60*24;
      }
      return $duration;
    }

    public static function getSeparateTimePeriods($subarray, $initial_day, $initial_date, $initial_time, $end_timestamp, $minutes_interval) {
      if(!$initial_date){
        $initial_date = date('Y-m-d');
      }
      $initial_timestamp = strtotime($initial_date.' '.$initial_time);
      $new_end_time_timestamp = strtotime('+'.$minutes_interval.' minutes', $initial_timestamp);
      $next_end_time_timestamp = strtotime('+'.$minutes_interval.' minutes', $new_end_time_timestamp);
      $real_end_date = date('Y-m-d', $new_end_time_timestamp);
      $real_end_time = date('H:i:s', $new_end_time_timestamp);
      $days_duration = $new_end_time_timestamp - $initial_timestamp;
      $days_duration = round($days_duration / (60 * 60 * 24));
      $subarray[$initial_day][] = ['time_in'=>$initial_time,'days_duration'=>$days_duration,'time_out'=>$real_end_time];
      if($next_end_time_timestamp<=$end_timestamp){
        $subarray = \Reservation::getSeparateTimePeriods($subarray, $initial_day, $initial_date, $real_end_time, $end_timestamp, $minutes_interval);
      }
      return $subarray;
    }

    public static function getTakenHours($service, $date_start, $date_end) {
        $array = [];
        if($service->type=='open'){
          $items = $service->accommodation_ranges;
          $subarray = [];
          foreach($items as $item){
            $subarray[$item->initial_day][] = ['time_in'=>$item->initial_time,'date_out'=>NULL,'time_out'=>$item->end_time];
          }
          if($date_start==$date_end){
            $period = [$date_start];
          } else {
            $period = new \DatePeriod(
              new \DateTime($date_start),
              new \DateInterval('P1D'),
              new \DateTime($date_end)
            );
          }
          foreach($period as $date){
            $date_val = $date->format('Y-m-d');
            $date_day = 'd_0'.($date->format('w')+1);
            if(isset($subarray[$date_day])){
              //\Log::info(json_encode($subarray[$date_day]));
              $array[$date_val][] = $subarray[$date_day];
            }
          }
        } else if($service->type=='closed'){
          $items = $service->accommodation_spaces()->where('initial_date', '>=', $date_start)->where('end_date', '<=', $date_end)->get();
          foreach($items as $item){
            $array[$item->initial_date][] = ['time_in'=>$item->initial_time,'date_out'=>NULL,'time_out'=>$item->end_time];
          }
        }
        return $array;
    }

    public static function getTakenItems($provider, $date_start, $date_end) {
        $array = [];
        $items = $provider->active_reservations()->where('initial_date', '>=', $date_start)->where('end_date', '<=', $date_end)->orderBy('initial_date','ASC')->orderBy('initial_time','ASC')->get();
        if(count($items)==0){
          $items = $provider->active_reservations()->where('initial_date', '>=', date('Y-m-d'))->where('initial_time', '>=', date('H:i:s'))->get();
        }
        foreach($items as $item){
          if(!isset($array[$item->initial_time][$item->initial_date])){
            $array[$item->initial_time][$item->initial_date] = ['time_in'=>$item->initial_time,'date_out'=>$item->end_date,'time_out'=>$item->end_time,'user_id'=>$item->user_id,'status'=>$item->status,'reservation_id'=>$item->id,'count'=>$item->counts];
          } else {
            $array[$item->initial_time][$item->initial_date]['count'] = $array[$item->initial_time][$item->initial_date]['count']+$item->counts;
          }
        }
        return $array;
    }

    public static function getOccupancyHours($service, $date_start, $date_end, $reservation = NULL) {
        $available_dates = \Reservation::getAvailableHours($service, $date_start, $date_end);
        $taken_dates = \Reservation::getTakenItems($service, $date_start, $date_end);
        $date_durations = [];
        foreach($available_dates as $available_date => $available_times){
          if(isset($taken_dates[$available_date])){
            $taken_date = $taken_dates[$available_date];
            $occupied_times = [];
            $occupied_times_detail = [];
            foreach($taken_date as $taken_subdate){
              $occupied_times[] = $taken_subdate['time_in'];
              $occupied_times_detail[$taken_subdate['time_in']] = $taken_subdate;
            }
            foreach($available_times as $key => $available_time){
              if($available_time['days_duration']>0){
                $new_end_date = date('Y-m-d', strtotime($available_date.' + '.$available_time['days_duration'].' days'));
              } else {
                $new_end_date = $available_date;
              }
              if(in_array($available_time['time_in'], $occupied_times)){
                if(auth()->check()&&$occupied_times_detail[$available_time['time_in']]['user_id']==auth()->user()->id){
                  $date_durations[$available_date][] = array_merge($available_time, ['status'=>$occupied_times_detail[$available_time['time_in']]['status'],'date_out'=>$new_end_date,'user_id'=>$occupied_times_detail[$available_time['time_in']]['user_id'],'reservation_id'=>$occupied_times_detail[$available_time['time_in']]['reservation_id'],'count'=>$occupied_times_detail[$available_time['time_in']]['count']]);
                } else if(($occupied_times_detail[$available_time['time_in']]['count'])>$service->capacity) {
                  $date_durations[$available_date][] = array_merge($available_time, ['status'=>'unavailable','date_out'=>$new_end_date,'user_id'=>NULL,'reservation_id'=>NULL,'count'=>$occupied_times_detail[$available_time['time_in']]['count']]);
                } else {
                  $date_durations[$available_date][] = array_merge($available_time, ['status'=>'free','date_out'=>$new_end_date,'user_id'=>NULL,'reservation_id'=>NULL,'count'=>$occupied_times_detail[$available_time['time_in']]['count']]);
                }
              } else {
                $date_durations[$available_date][] = array_merge($available_time, ['status'=>'free','date_out'=>$new_end_date,'user_id'=>NULL,'reservation_id'=>NULL,'count'=>0]);
              }
            }
          } else {
            foreach($available_times as $key => $available_time){
              if($available_time['days_duration']>0){
                $new_end_date = date('Y-m-d', strtotime($available_date.' + '.$available_time['days_duration'].' days'));
              } else {
                $new_end_date = $available_date;
              }
              $date_durations[$available_date][] = array_merge($available_time, ['status'=>'free','date_out'=>$new_end_date,'user_id'=>NULL,'reservation_id'=>NULL,'count'=>0]);
            }
          }
        }
        return $date_durations;
    }

    public static function getNewAvailableDays($accommodation, $date_start, $date_end) {
      $period = new \DatePeriod(
        new \DateTime($date_start),
        new \DateInterval('P1D'),
        new \DateTime($date_end)
      );
      $dates_array = [];
      foreach($period as $date){
        $date_val = $date->format('Y-m-d');
        $date_day = 'd_0'.($date->format('N'));
        $dates_array[trans('reservation::admin.'.$date_day)] = $date->format('Y-m-d');
      }
      return $dates_array;
    }

    public static function getAccommodationRange($accommodation) {
      if(count($accommodation->accommodation_ranges)>0){
        return $accommodation;
      } else {
        $parent_accommodation = $accommodation->parent;
        if($parent_accommodation){
          return \Reservation::getAccommodationRange($parent_accommodation);
        }
      }
      return $accommodation;
    }

    public static function getFinalAvailableTimes($accommodation, $date_start, $date_end) {
      $period = new \DatePeriod(
        new \DateTime($date_start),
        new \DateInterval('P1D'),
        new \DateTime($date_end)
      );
      $dates_array = [];
      $real_accommodation = \Reservation::getAccommodationRange($accommodation);
      foreach($period as $date){
        $date_val = $date->format('Y-m-d');
        $date_day = 'd_0'.($date->format('w'));
        $accommodation_ranges = $real_accommodation->accommodation_ranges()->where('initial_day', $date_day)->get();
        foreach($accommodation_ranges as $accommodation_range){
          if(isset($dates_array[$accommodation_range->initial_time][$date_val])){
            $quantity = $dates_array[$accommodation_range->initial_time][$date_val]['quantity'] + 1;
            $dates_array[$accommodation_range->initial_time][$date_val] = ['initial_time'=>$accommodation_range->initial_time, 'end_time'=>$accommodation_range->end_time, 'quantity'=>$quantity];
          } else {
            $dates_array[$accommodation_range->initial_time][$date_val] = ['initial_time'=>$accommodation_range->initial_time, 'end_time'=>$accommodation_range->end_time, 'quantity'=>1];
          }
        }
      }
      return $dates_array;
    }

    public static function getNewOccupancyHours($accommodation, $provider, $available_dates, $available_times, $taken_dates, $reservation = NULL) {
      /*\Log::info('available_times: '.json_encode($available_times));*/
      //\Log::info('taken_dates: '.json_encode($taken_dates));
      $date_durations = [];
      foreach($available_times as $time => $time_item){
        foreach($available_dates as $date_day => $subday){
          if(($subday>date('Y-m-d')||($subday==date('Y-m-d')&&$time>date('H:i:s')))&&isset($available_times[$time][$subday])){
            if(isset($taken_dates[$time][$subday])&&$taken_dates[$time][$subday]['count']>=$provider->capacity){
              $date_durations[$time][$subday] = ['status'=>'disabled', 'end_time'=>$time_item[$subday]['end_time']];
            } else {
              $date_durations[$time][$subday] = ['status'=>'free', 'end_time'=>$time_item[$subday]['end_time']];
            }
          } else {
            $date_durations[$time][$subday] = ['status'=>'disabled', 'end_time'=>null];
          }
          //$date_durations[$available_time][] = array_merge($available_date, ['status'=>'free','date_out'=>$new_end_date,'user_id'=>NULL,'reservation_id'=>NULL,'count'=>0]);
        }
      }
      return $date_durations;
    }

    public static function generateReservationPdf($reservation) {
      $array['item'] = $reservation;
      $pdf = \PDF::loadView('reservation::pdf.reservation-file', $array);
      $pdf = \Asset::apply_pdf_template($pdf, 'SOLICITUD DE RESERVA');
      $reservation->reservation_file = \Asset::upload_pdf_template($pdf, 'reservation', 'reservation_file');
      return $reservation;
    }
    
    public static function generateVoucherPdf($reservation) {
      $array['item'] = $reservation;
      $pdf = \PDF::loadView('reservation::pdf.tickets-file', $array);
      $pdf = \Asset::apply_pdf_template($pdf, 'VOUCHER DE RESERVA', ['margin-top'=>0,'margin-bottom'=>0,'margin-right'=>0,'margin-left'=>0]);
      $reservation->tickets_file = \Asset::upload_pdf_template($pdf, 'reservation', 'tickets_file');
      return $reservation;
    }

    public static function hex_encode($input) {
      return bin2hex($input.'JSBDXZ');
    }

    public static function hex_decode($input) {
      $subresponse = pack("H*", $input);
      return str_replace('JSBDXZ','',$subresponse);
    }

    public static function generateTicketCode() {
        $digits = config('reservation.code_length');
        return \FuncNode::generateUniqueCode('reservation-qr-code', $digits);
    }

    public static function generateManualTicketCode() {
        $digits = config('reservation.manual_code_length');
        return \FuncNode::generateUniqueCode('reservation-manual-code', $digits);
    }

    public static function validate_qr_reservation_user($ticket_qr_code) {
      $reservation_user = \App\ReservationUser::where('ticket_code', $ticket_qr_code)->first();
      $response = \Reservation::validate_reservation_user($reservation_user);
      return $response;
    }
    
    public static function validate_manual_reservation_user($manual_ticket_code) {
      $reservation_user = \App\ReservationUser::where('manual_ticket_code', $manual_ticket_code)->first();
      $response = \Reservation::validate_reservation_user($reservation_user);
      return $response;
    }
    
    public static function validate_reservation_user($reservation_user) {
      if($reservation_user&&$reservation_user->status=='paid'){
        $reservation = $reservation_user->reservation;
        $timestamp = date('Y-m-d H:i:s');
        $reservation_timestamp_end = $reservation->end_date.' '.$reservation->end_time;
        if($timestamp<$reservation_timestamp_end&&$reservation->status=='paid'){
          $reservation_user->status = 'used';
          $reservation_user->save();
          $reservation->load('reservation_users');
          if($reservation->reservation_users()->where('status','used')->count()==$reservation->counts){
            $reservation->status = 'finished';
            $reservation->save();
          }
          $response = ['status'=>'success','message'=>'Su ticket fue validado correctamente.'];
        } else if($reservation->status=='paid') {
          $response = ['status'=>'warning','message'=>'El ticket aún está válido, sin embargo la fecha de uso debía ser antes del '.$reservation->end_date.' '.$reservation->end_time.'.'];
        } else {
          $response = ['status'=>'error','message'=>'Su ticket fue encontrado, sin embargo su reserva se encuentra invalida.'];
        }
      } else if($reservation_user&&$reservation_user->status=='used') {
        $response = ['status'=>'error','message'=>'Su ticket fue encontrado, sin embargo ya fue utilizado.'];
      } else if($reservation_user) {
        $response = ['status'=>'error','message'=>'Su ticket fue encontrado, sin embargo no se encuentra habilitado.'];
      } else {
        $response = ['status'=>'error','message'=>'Su ticket no fue encontrado en la base de datos.'];
      }
      return $response;
    }

    public static function process_reservation() {
      if($cart = \Solunes\Reservation\App\Cart::checkOwner()->checkCart()->status('holding')->with('cart_items','cart_items.product')->first()){
        $cart->touch();
      } else {
        $cart = new \Solunes\Reservation\App\Cart;
        if(\Auth::check()){
          $cart->user_id = \Auth::user()->id;
        }
        $cart->session_id = \Session::getId();
        $cart->save();
      }
      return $cart;
    }
    
}