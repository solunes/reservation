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
          foreach($items as $item){
            $subarray[$item->initial_day][] = ['time_in'=>$item->initial_time,'date_out'=>NULL,'time_out'=>$item->end_time];
          }
          $period = new \DatePeriod(
            new \DateTime($date_start),
            new \DateInterval('P1D'),
            new \DateTime($date_end)
          );
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

    public static function getAvailableDays($service, $date_start, $date_end) {
        $array = [];
        if($service->type=='open'){
          $items = $service->accommodation_ranges;
          $subarray = [];
          foreach($items as $item){
            $subarray[$item->initial_day][] = ['time_in'=>$item->initial_time,'date_out'=>NULL,'time_out'=>$item->end_time];
          }
          $period = new \DatePeriod(
            new \DateTime($date_start),
            new \DateInterval('P1D'),
            new \DateTime($date_end)
          );
          foreach($period as $date){
            $date_val = $date->format('Y-m-d');
            $date_day = 'd_0'.($date->format('w')+1);
            if(isset($subarray[$date_day])){
              $array[$date_val][] = $subarray[$date_day];
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


    public static function getTakenHours($service, $date_start, $date_end) {
        $array = [];
        if($service->type=='open'){
          $items = $service->accommodation_ranges;
          $subarray = [];
          foreach($items as $item){
            $subarray[$item->initial_day][] = ['time_in'=>$item->initial_time,'date_out'=>NULL,'time_out'=>$item->end_time];
          }
          $period = new \DatePeriod(
            new \DateTime($date_start),
            new \DateInterval('P1D'),
            new \DateTime($date_end)
          );
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
        $items = $service->accommodation_picks()->where('initial_date', '>=', $date_start)->where('end_date', '<=', $date_end)->orderBy('initial_date','ASC')->orderBy('initial_time','ASC')->get();
        foreach($items as $item){
            $array[$item->initial_date][] = ['time_in'=>$item->initial_time,'date_out'=>$item->end_date,'time_out'=>$item->end_time];
        }
        return $array;
    }

    public static function getOccupancyHours($service, $date_start, $date_end) {
        $available_dates = \Reservation::getAvailableHours($service, $date_start, $date_end);
        $taken_dates = ['2018-10-20'=>[
          ['time_in'=>'08:30:00','time_out'=>'09:30:00'],
          ['time_in'=>'10:30:00','time_out'=>'11:30:00'],
          ['time_in'=>'14:00:00','time_out'=>'18:00:00']
        ],'2018-10-21'=>[
        ]];
        $time_durations = [];
        foreach($available_dates as $available_date => $available_times){
          $taken_date = $taken_dates[$available_date];
          if(count($taken_date)==0){
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
          }
        }
        foreach($date_durations as $date => $time_durations){
          foreach($time_durations as $time_duration){
              echo 'Fecha: '.$date.' ('.$time_duration.' minutos)<br>';
          }
        }
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