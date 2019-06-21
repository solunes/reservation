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
            $subarray = \Reservation::getSeparateTimePeriods($subarray, $item->initial_day, NULL, $item->initial_time, strtotime($item->end_time), $minutes_interval);
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
          foreach($items as $item){
            $array[$item->initial_date][] = ['time_in'=>$item->initial_time,'date_out'=>$item->end_time,'time_out'=>$item->end_time];
          }
        }
        return $array;
    }

    public static function getAvailableDays($service, $date_start, $date_end) {
        $array = [];
        if($service->type=='open'){
          $items = $service->accommodation_ranges;
          $subarray = [];
          foreach($items as $item){
            $subarray = \Reservation::getSeparateTimePeriods($subarray, $item->initial_day, NULL, $item->initial_time, strtotime($item->end_time), $minutes_interval);
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

    public static function getSeparateTimePeriods($subarray, $initial_day, $date_out, $initial_time, $end_timestamp, $minutes_interval) {
      $initial_timestamp = strtotime(date('Y-m-d').' '.$initial_time);
      $new_end_time_timestamp = strtotime('+'.$minutes_interval.' minutes', $initial_timestamp);
      $next_end_time_timestamp = strtotime('+'.$minutes_interval.' minutes', $new_end_time_timestamp);
      $real_end_time = date('H:i:s', $new_end_time_timestamp);
      $subarray[$initial_day][] = ['time_in'=>$initial_time,'date_out'=>$date_out,'time_out'=>$real_end_time];
      if($next_end_time_timestamp<=$end_timestamp){
        $subarray = \Reservation::getSeparateTimePeriods($subarray, $initial_day, $date_out, $real_end_time, $end_timestamp, $minutes_interval);
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
            $array[$item->initial_date][] = ['time_in'=>$item->initial_time,'date_out'=>$item->end_time,'time_out'=>$item->end_time];
          }
        }
        return $array;
    }

    public static function getTakenItems($service, $date_start, $date_end) {
        $array = [];
        $items = $service->active_reservations()->where('initial_date', '>=', $date_start)->where('end_date', '<=', $date_end)->orderBy('initial_date','ASC')->orderBy('initial_time','ASC')->get();
        foreach($items as $item){
            $array[$item->initial_date][] = ['time_in'=>$item->initial_time,'date_out'=>$item->end_date,'time_out'=>$item->end_time];
        }
        return $array;
    }

    public static function getOccupancyHours($service, $date_start, $date_end) {
        $available_dates = \Reservation::getAvailableHours($service, $date_start, $date_end);
        $taken_dates = \Reservation::getTakenItems($service, $date_start, $date_end);
        $date_durations = [];
        foreach($available_dates as $available_date => $available_times){
          if(isset($taken_dates[$available_date])){
            $taken_date = $taken_dates[$available_date];
            /*if(count($taken_date)==0){
              foreach($available_times as $available_time){
                $date_durations[$available_date][] = Reservation::getTimeDifference($available_time['time_in'], $available_time['time_out']);
              }
            } else {
              foreach($available_times as $available_time){
                $last_time = NULL;
                foreach($taken_date as $key => $taken_time){
                  if(!$last_time&&$taken_time['time_in']!=$available_time['time_in']){
                    $intial_time = $available_time['time_in'];
                    $date_durations[$available_date][] = Reservation::getTimeDifference($available_time['time_in'], $taken_time['time_in']);
                    if($taken_time['time_out']!=$available_time['time_out']){
                      $date_durations[$available_date][] = Reservation::getTimeDifference($taken_time['time_out'], $available_time['time_out']);
                    }
                  } else if($last_time&&$taken_time['time_in']!=$available_time['time_in']) {
                    $intial_time = $available_time['time_in'];
                    $date_durations[$available_date][] = Reservation::getTimeDifference($available_time['time_in'], $taken_time['time_in']);
                    if($taken_time['time_out']!=$available_time['time_out']){
                      $date_durations[$available_date][] = Reservation::getTimeDifference($taken_time['time_out'], $available_time['time_out']);
                    }
                  }
                  $last_time = $taken_time['time_out'];
                  unset($taken_date[$key]);
                }
              }
            }*/
            $occupied_times = [];
            foreach($taken_date as $taken_subdate){
              $occupied_times[] = $taken_subdate['time_in'];
            }
            foreach($available_times as $key => $available_time){
              if(in_array($available_time['time_in'], $occupied_times)){
                $date_durations[$available_date][] = array_merge($available_time, ['status'=>'taken']);
              } else {
                $date_durations[$available_date][] = array_merge($available_time, ['status'=>'free']);
              }
            }
          } else {
            $date_durations[$available_date] = $available_times;
          }
        }
        return $date_durations;
        /*foreach($date_durations as $date => $time_durations){
          foreach($time_durations as $time_duration){
              echo 'Fecha: '.$date.' ('.$time_duration.' minutos)<br>';
          }
        }*/
    }

    public static function checkOccupancyDays($service, $quantity, $date_in, $date_out) {
        if('asd'=='sd'){
            
        }
    }
    
    public static function checkOccupancyHours($service, $quantity, $date, $time_in, $time_out) {

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