<?php

namespace Solunes\Reservation\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

use Validator;
use Asset;
use AdminList;
use AdminItem;
use PDF;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProcessController extends Controller {

	protected $request;
	protected $url;

	public function __construct(UrlGenerator $url) {
	  $this->prev = $url->previous();
	}

  // Mostrar Mis Reservas
  public function getMyReservations($token = 'asdasdasd') {
    $array['page'] = \Solunes\Master\App\Page::find(1);
    $array['items'] = \Solunes\Reservation\App\Accommodation::get();
    return view('reservation::list.my-reservations', $array);
  }

  // Mostrar Mis Reservas
  public function getReservation($id) {
    $array['page'] = \Solunes\Master\App\Page::find(1);
    $array['items'] = \Solunes\Reservation\App\Accommodation::get();
    return view('reservation::list.reservation', $array);
  }

  // Mostrar Paquetes
  public function getPackages($token = 'asdasdasd') {
    $array['page'] = \Solunes\Master\App\Page::find(1);
    $array['items'] = \Solunes\Reservation\App\Accommodation::get();
    return view('reservation::process.packages', $array);
  }

  public function getPackage($item_id) {
    $array['page'] = \Solunes\Master\App\Page::find(1);
    $array['item'] = \Solunes\Reservation\App\Accommodation::find($item_id);
    return view('reservation::process.package-item', $array);
  }

  public function findReservas($step = 1, $accommodation_id = NULL, $provider_id = NULL) {
    if($accommodation_id){
      $array['items'] = \Solunes\Reservation\App\Accommodation::where('parent_id', $accommodation_id)->get();
      $item = \Solunes\Reservation\App\Accommodation::find($accommodation_id);
      $array['item'] = $item; 
    } else {
      $array['items'] = \Solunes\Reservation\App\Accommodation::whereNull('parent_id')->get();
    }
    $array['step'] = $step;
    $array['accommodation_id'] = $accommodation_id;
    if($step==2){
      $array['providers'] = \Solunes\Reservation\App\Provider::where('id', $item->provider_id)->get();
    }
    if($step==3){
      $array['provider'] = \Solunes\Reservation\App\Provider::find($provider_id);
      $reservation = new \Solunes\Reservation\App\Reservation;
      $reservation->accommodation_id = $accommodation_id;
      $reservation->provider_id = $provider_id;
      $reservation->currency_id = $item->currency_id;
      $reservation->counts = 1;
      $reservation->name = $item->name;
      $reservation->price = $item->price;
      $reservation->amount = $item->price;
      $reservation->save();
      return redirect('reservas/seleccionar-horarios/'.$reservation->id);
    }
    return view('reservation::process.reservas-'.$step, $array);
  }

  public function findSelectSchedule($reservation_id, $date_today = NULL) {
    if(!$date_today){
      $date_today = date('Y-m-d');
    }
    $reservation = \Solunes\Reservation\App\Reservation::find($reservation_id);
    $accommodation = $reservation->accommodation;
    $provider = $reservation->provider;
    $array['item'] = $accommodation;  
    $array['provider'] = $provider; 
    $array['reservation'] = $reservation; 
    $strtotime_today = strtotime($date_today);
    $today = date('N', $strtotime_today);
    $next_week = true;
    if($today==1){
      $date_start = date('Y-m-d', $strtotime_today);
      $next_week_date = date('Y-m-d', strtotime("+7 days", $strtotime_today));
    } else {
      $date_start = date('Y-m-d', strtotime("last Monday", $strtotime_today));
      $next_week_date = date('Y-m-d', strtotime("next Monday", $strtotime_today));
    }
    if($date_start<=date('Y-m-d')){
    $past_week = false;
    $past_week_date = NULL;
    } else {
      $past_week = true;
    $past_week_date = date('Y-m-d', strtotime("-7 days", $strtotime_today));
    }
  $date_end = strtotime($date_start);
  $date_end = strtotime("+7 days", $date_end);
      $date_end = date('Y-m-d', $date_end);
    $array['past_week_date'] = $past_week_date; 
    $array['next_week_date'] = $next_week_date; 
    $array['past_week'] = $past_week; 
    $array['next_week'] = $next_week; 
    $array['date_start'] = $date_start; 
    $array['date_end'] = $date_end; 
    $array['reservation'] = $reservation; 
      $array['available_dates'] = \Reservation::getNewAvailableDays($accommodation, $date_start, $date_end);
      $array['available_times'] = \Reservation::getFinalAvailableTimes($accommodation, $date_start, $date_end);
      $taken_dates = \Reservation::getTakenItems($provider, $date_start, $date_end);
      $array['finalitems'] = \Reservation::getNewOccupancyHours($accommodation, $provider, $array['available_dates'], $array['available_times'], $taken_dates, $reservation);
    return view('reservation::process.reservas-3', $array);
  }

  public function findReserva($reservation_id) {
    $reservation = \Solunes\Reservation\App\Reservation::find($reservation_id);
    $accommodation = $reservation->accommodation;
    $provider = $reservation->provider;
    $array['item'] = $accommodation;  
    $array['provider'] = $provider; 
    $array['reservation'] = $reservation; 
    $array['accommodation'] = $reservation->accommodation;
    return view('reservation::process.reservas-4', $array);
  }

  /* Ruta POST para iniciar un proceso de reserva */
  public function postStartReservation(Request $request) {
    $accommodation = \Solunes\Reservation\App\Accommodation::find($request->input('accommodation_id'));
    if($accommodation&&$request->input('counts')>0){
      $reservation = new \Solunes\Reservation\App\Reservation;
      $reservation->accommodation_id = $accommodation->id;
      $reservation->currency_id = $accommodation->currency_id;
      $reservation->counts = $request->input('counts');
      $reservation->name = $accommodation->name;
      $reservation->price = $accommodation->price;
      $reservation->amount = $reservation->price * $reservation->counts;
      $reservation->save();
      return redirect($accommodation->reservation_link.'/'.$accommodation->id.'/'.$reservation->id)->with('message_success', 'Su proceso de reserva fue iniciado exitosamente, ahora debe seleccionar una fecha/hora.');
    } else {
      return redirect($this->prev)->with('message_error', 'Hubo un error al iniciar su proceso de reserva.');
    }
  }

  /* Ruta POST para confirmar su compra */
  public function postFinalizarReserva(Request $request) {
    $accommodation = \Solunes\Reservation\App\Accommodation::find($request->input('accommodation_id'));
    $reservation = \Solunes\Reservation\App\Reservation::find($request->input('reservation_id'));
    if($accommodation&&$reservation&&in_array($reservation->status,['holding','pre-reserve','sale'])){
      if($reservation->user_id&&$reservation->customer_id){
        if(!auth()->check()){
          return redirect($this->prev)->with('message_error', 'Debe tener una cuenta para tomar esta reserva, inicie nuevamente.');
        } else if(auth()->user()->id!=$reservation->user_id){
          return redirect($this->prev)->with('message_error', 'Su usuario no es igual al de la reserva seleccionada.');
        }
      }
    } else {
      return redirect($this->prev)->with('message_error', 'Hubo un error para realizar esta reserva.');
    }
    if(auth()->check()){
      $rules = \Solunes\Reservation\App\Reservation::$rules_reservation_send;
    } else {
      $rules = \Solunes\Reservation\App\Reservation::$rules_reservation_send;
    }
    if(!config('sales.ask_invoice')){
      unset($rules['nit_number']);
      unset($rules['nit_social']);
    }
    $validator = \Validator::make($request->all(), $rules);
    if(!$reservation||!$accommodation||!$validator->passes()){
      return redirect($this->prev)->with('message_error', 'Debe llenar todos los campos obligatorios.')->withErrors($validator)->withInput();
    } else {

      // User
      if(config('solunes.customer')){
        $customer = \Sales::customerRegistration($request);
        $user = $customer->user;
      } else {
        $customer = NULL;
        $user = \Sales::userRegistration($request);
      }
      if(is_string($user)){
        return redirect($this->prev)->with('message_error', 'Hubo un error al finalizar su registro: '.$user);
      }

      // Sale
      $reservation->user_id = $user->id;
      if($customer){
        $reservation->customer_id = $customer->id;
      }
      if(config('sales.ask_invoice')){
        $reservation->invoice = true;
        $reservation->invoice_number = $request->input('nit_number');
        $reservation->invoice_name = $request->input('nit_social');
      } else {
        $reservation->invoice = false;
      }
      $reservation->amount = $reservation->price * $reservation->counts;
      $reservation->status = 'sale';
      $datetime = date("Y-m-d H:i:s", strtotime(config('reservation.sale_deadline')));
      $reservation->reservation_deadline = $datetime;
      $reservation->save();

      $sale_details = [];
      $reservation_user = new \Solunes\Reservation\App\ReservationUser;
      $reservation_user->parent_id = $reservation->id;
      $reservation_user->first_name = $customer->name;
      if(config('reservation.reservation_subuser_name')){
        $reservation_user->last_name = $request->input('last_name');
      }
      if(config('reservation.reservation_subuser_username')){
        $reservation_user->ci_number = $request->input('ci_number');
      }
      if(config('reservation.reservation_subuser_email')){
        $reservation_user->email = $request->input('email');
      }
      if(config('reservation.reservation_subuser_cellphone')){
        $reservation_user->cellphone = $request->input('cellphone');
      }
      $reservation_user->save();
      $detail = $reservation->name.' ('.$reservation->initial_date.' '.$reservation->initial_time.' - ';
      if($reservation->initial_date!=$reservation->end_date){
        $detail .= $reservation->end_date.' ';
      }
      $detail .= $reservation->end_time.')';
      $sale_details[] = ['product_bridge_id'=>$accommodation->product_bridge->id, 'quantity'=>$reservation->counts, 'amount'=>$reservation->price, 'detail'=>$detail];

      if($reservation->counts>1){
        foreach(range(2, $reservation->counts) as $subcount){
          $reservation_user = new \Solunes\Reservation\App\ReservationUser;
          $reservation_user->parent_id = $reservation->id;
          if(config('reservation.reservation_subuser_name')){
            $reservation_user->first_name = $request->input('first_name');
            $reservation_user->last_name = $request->input('last_name');
          } else {
            $reservation_user->first_name = 'Subcliente #'.$subcount;
          }
          if(config('reservation.reservation_subuser_username')){
            $reservation_user->ci_number = $request->input('ci_number');
          }
          if(config('reservation.reservation_subuser_cellphone')){
            $reservation_user->cellphone = $request->input('cellphone');
          }
          if(config('reservation.reservation_subuser_email')){
            $reservation_user->email = $request->input('email');
          }
          if(config('reservation.reservation_subuser_age')){
            $reservation_user->age = $request->input('age');
          }
          $reservation_user->save();
          //$sale_details[] = ['product_bridge_id'=>$accommodation->product_bridge->id, 'quantity'=>1, 'amount'=>$reservation->price, 'detail'=>$reservation->name.' - '.$reservation->initial_date.' '.$reservation->initial_time.' a '.$reservation->end_date.' '.$reservation->end_time];
        }
      }
      $reservation->load('reservation_users');
      $payment_method = \Solunes\Payments\App\PaymentMethod::where('code', config('payments.default_payment_method_code'))->first();
      $sale = \Sales::generateSale($reservation->user_id, $reservation->customer_id, $reservation->currency_id, $payment_method->id, $reservation->invoice, $reservation->invoice_name, $reservation->invoice_number, $sale_details);
      $reservation->sale_id = $sale->id;
      $reservation->save();

      // Send Email
      $vars = ['@name@'=>$user->name, '@total_cost@'=>$sale->total_cost, '@sale_link@'=>url('process/sale/'.$sale->id)];
      \FuncNode::make_email('new-sale', [$user->email], $vars);

      $redirect = 'process/sale/'.$sale->id;

      // Revisar redirección a método de pago antes.
      if(config('sales.redirect_to_payment')){
        $sale_payment = $sale->sale_payment;
        $model = '\\'.$sale_payment->payment_method->model;
        return \Payments::generateSalePayment($sale, $model, $redirect, NULL);
      }

      return redirect($redirect)->with('message_success', 'Su compra fue confirmada correctamente, ahora debe proceder al pago para finalizarla.');
    }
  }

  public function getScheduleList($accommodation_id, $reservation_id) {
    $array['page'] = \Solunes\Master\App\Page::find(1);
    $array['item'] = \Solunes\Reservation\App\Accommodation::find($accommodation_id);
    $array['reservation'] = \Solunes\Reservation\App\Reservation::find($reservation_id);
    if(!$array['reservation']||($array['reservation']->status!='holding'&&$array['reservation']->status!='pre-reserve')){
      return redirect('reservations/item/'.$accommodation_id)->with('message_success', 'Su reserva ya fue marcada como preventa, por lo tanto debe iniciar una nueva reserva.');
    }
    return view('reservation::process.schedule-list', $array);
  }

  public function getScheduleBlock($accommodation_id, $reservation_id) {
    $array['page'] = \Solunes\Master\App\Page::find(1);
    $array['item'] = \Solunes\Reservation\App\Accommodation::find($accommodation_id);
    $array['reservation'] = \Solunes\Reservation\App\Reservation::find($reservation_id);
    if($array['reservation']->status!='holding'&&$array['reservation']->status!='pre-reserve'){
      return redirect('reservations/item/'.$accommodation_id)->with('message_success', 'Su reserva ya fue marcada como preventa, por lo tanto debe iniciar una nueva reserva.');
    }
    return view('reservation::process.schedule-block', $array);
  }

  /* Ruta POST para seleccionar fecha y hora en un proceso de reserva */
  public function getPickScheduleReservation($accommodation_id, $reservation_id, $initial_date, $end_date, $initial_time, $end_time) {
    $accommodation = \Solunes\Reservation\App\Accommodation::find($accommodation_id);
    $reservation = \Solunes\Reservation\App\Reservation::find($reservation_id);
    if($accommodation&&$reservation&&in_array($reservation->status,['holding','pre-reserve','sale'])){
      if($reservation->user_id&&$reservation->customer_id){
        if(!auth()->check()){
          return redirect($this->prev)->with('message_error', 'Debe tener una cuenta para tomar esta reserva, inicie nuevamente.');
        } else if(auth()->user()->id!=$reservation->user_id){
          return redirect($this->prev)->with('message_error', 'Su usuario no es igual al de la reserva seleccionada.');
        }
      } else {
        if(auth()->check()){
          $user = auth()->user();
          $reservation->user_id = $user->id;
          $reservation->customer_id = $user->customer->id;
        }
      }
      $reservation->initial_date = $initial_date;
      $reservation->end_date = $end_date;
      $reservation->initial_time = $initial_time;
      $reservation->end_time = $end_time;
      $datetime = date("Y-m-d H:i:s", strtotime(config('reservation.prereserve_deadline')));
      $reservation->reservation_deadline = $datetime;
      $reservation->status = 'pre-reserve';
      if($reservation->sale){
        $sale = $reservation->sale;
        $sale->status = 'cancelled';
        $sale->save();
        $reservation->sale_id = NULL;
      }
      $reservation->save();
      // Marcar como preseleccionado para que otro no pueda comprar basandose en cupo y dar plazo para finalizar la reserva.
      return redirect('reservas/finalizar-reserva/'.$reservation->id)->with('message_success', 'Su proceso de reserva fue realizado correctamente, ahora puede registrar sus datos y finalizarla.');
      //return redirect('reservations/finish-reservation/'.$accommodation->id.'/'.$reservation->id)->with('message_success', 'Su proceso de reserva fue realizado correctamente, ahora puede registrar sus datos y finalizarla.');
    } else {
      return redirect($this->prev)->with('message_error', 'Hubo un error al seleccionar su reserva.');
    }
  }

  // Cancelar mi reserva pendiente
  public function getCancelReservation($reservation_id) {
    $reservation = \Solunes\Reservation\App\Reservation::find($reservation_id);
    if(auth()->check()&&$reservation&&in_array($reservation->status, ['pre-reserve','sale'])&&$reservation->user_id==auth()->user()->id){
      $reservation->status = 'cancelled';
      if($reservation->sale){
        $sale = $reservation->sale;
        $sale->status = 'cancelled';
        $sale->save();
        $reservation->sale_id = NULL;
      }
      $reservation->save();
      return redirect($this->prev)->with('message_success', 'Su reserva fue cancelada correctamente.');
    } else {
      return redirect($this->prev)->with('message_error', 'No tiene todas las condiciones para cancelar su reserva.');
    }
  }

  public function getFinishReservation($accommodation_id, $reservation_id) {
    $array['page'] = \Solunes\Master\App\Page::find(1);
    $array['item'] = \Solunes\Reservation\App\Accommodation::find($accommodation_id);
    $array['reservation'] = \Solunes\Reservation\App\Reservation::find($reservation_id);
    if($array['item']&&$array['reservation']&&in_array($array['reservation']->status,['holding','pre-reserve','sale'])){
      if($array['reservation']->user_id&&$array['reservation']->customer_id){
        if(!auth()->check()){
          return redirect($this->prev)->with('message_error', 'Debe tener una cuenta para tomar esta reserva, inicie nuevamente.');
        } else if(auth()->user()->id!=$array['reservation']->user_id){
          return redirect($this->prev)->with('message_error', 'Su usuario no es igual al de la reserva seleccionada.');
        }
      }
    } else {
      return redirect($this->prev)->with('message_error', 'Hubo un error para realizar esta reserva.');
    }
    if(auth()->check()){
      $user = auth()->user();
      $customer = $user->customer;
    } else {
      $user = NULL;
      $customer = NULL;
    }
    $array['user'] = $user;
    $array['customer'] = $customer;
    $array['payment_options'] = \Solunes\Payments\App\PaymentMethod::active()->order()->lists('name','id');
    return view('reservation::process.finish-reservation', $array);
  }

  /* Ruta POST para confirmar su compra */
  public function postFinishReservation(Request $request) {
    $accommodation = \Solunes\Reservation\App\Accommodation::find($request->input('accommodation_id'));
    $reservation = \Solunes\Reservation\App\Reservation::find($request->input('reservation_id'));
    if($accommodation&&$reservation&&in_array($reservation->status,['holding','pre-reserve','sale'])){
      if($reservation->user_id&&$reservation->customer_id){
        if(!auth()->check()){
          return redirect($this->prev)->with('message_error', 'Debe tener una cuenta para tomar esta reserva, inicie nuevamente.');
        } else if(auth()->user()->id!=$reservation->user_id){
          return redirect($this->prev)->with('message_error', 'Su usuario no es igual al de la reserva seleccionada.');
        }
      }
    } else {
      return redirect($this->prev)->with('message_error', 'Hubo un error para realizar esta reserva.');
    }
    if(auth()->check()){
      $rules = \Solunes\Reservation\App\Reservation::$rules_auth_send;
    } else {
      $rules = \Solunes\Reservation\App\Reservation::$rules_send;
    }
    if(!config('sales.ask_invoice')){
      unset($rules['nit_number']);
      unset($rules['nit_social']);
    }
    $validator = \Validator::make($request->all(), $rules);
    if(!$reservation||!$accommodation||!$validator->passes()){
      return redirect($this->prev)->with('message_error', 'Debe llenar todos los campos obligatorios.')->withErrors($validator)->withInput();
    } else {

      // User
      if(config('solunes.customer')){
        $customer = \Sales::customerRegistration($request);
        $user = $customer->user;
      } else {
        $customer = NULL;
        $user = \Sales::userRegistration($request);
      }
      if(is_string($user)){
        return redirect($this->prev)->with('message_error', 'Hubo un error al finalizar su registro: '.$user);
      }

      // Sale
      $reservation->user_id = $user->id;
      if($customer){
        $reservation->customer_id = $customer->id;
      }
      if(config('sales.ask_invoice')){
        $reservation->invoice = true;
        $reservation->invoice_number = $request->input('nit_number');
        $reservation->invoice_name = $request->input('nit_social');
      } else {
        $reservation->invoice = false;
      }
      $reservation->amount = $reservation->price * $reservation->counts;
      $reservation->status = 'sale';
      $datetime = date("Y-m-d H:i:s", strtotime(config('reservation.sale_deadline')));
      $reservation->reservation_deadline = $datetime;
      $reservation->save();

      $sale_details = [];
      $reservation_user = new \Solunes\Reservation\App\ReservationUser;
      $reservation_user->parent_id = $reservation->id;
      $reservation_user->first_name = $customer->name;
      if(config('reservation.reservation_subuser_name')){
        $reservation_user->last_name = $request->input('last_name');
      }
      if(config('reservation.reservation_subuser_username')){
        $reservation_user->ci_number = $request->input('ci_number');
      }
      if(config('reservation.reservation_subuser_email')){
        $reservation_user->email = $request->input('email');
      }
      if(config('reservation.reservation_subuser_cellphone')){
        $reservation_user->cellphone = $request->input('cellphone');
      }
      $reservation_user->save();
      $detail = $reservation->name.' ('.$reservation->initial_date.' '.$reservation->initial_time.' - ';
      if($reservation->initial_date!=$reservation->end_date){
        $detail .= $reservation->end_date.' ';
      }
      $detail .= $reservation->end_time.')';
      $sale_details[] = ['product_bridge_id'=>$accommodation->product_bridge->id, 'quantity'=>$reservation->counts, 'amount'=>$reservation->price, 'detail'=>$detail];

      if($reservation->counts>1){
        foreach(range(2, $reservation->counts) as $subcount){
          $reservation_user = new \Solunes\Reservation\App\ReservationUser;
          $reservation_user->parent_id = $reservation->id;
          if(config('reservation.reservation_subuser_name')){
            $reservation_user->first_name = $request->input('first_name');
            $reservation_user->last_name = $request->input('last_name');
          } else {
            $reservation_user->first_name = 'Subcliente #'.$subcount;
          }
          if(config('reservation.reservation_subuser_username')){
            $reservation_user->ci_number = $request->input('ci_number');
          }
          if(config('reservation.reservation_subuser_cellphone')){
            $reservation_user->cellphone = $request->input('cellphone');
          }
          if(config('reservation.reservation_subuser_email')){
            $reservation_user->email = $request->input('email');
          }
          if(config('reservation.reservation_subuser_age')){
            $reservation_user->age = $request->input('age');
          }
          $reservation_user->save();
          //$sale_details[] = ['product_bridge_id'=>$accommodation->product_bridge->id, 'quantity'=>1, 'amount'=>$reservation->price, 'detail'=>$reservation->name.' - '.$reservation->initial_date.' '.$reservation->initial_time.' a '.$reservation->end_date.' '.$reservation->end_time];
        }
      }
      $reservation->load('reservation_users');

      $sale = \Sales::generateSale($reservation->user_id, $reservation->customer_id, $reservation->currency_id, $request->input('payment_method_id'), $reservation->invoice, $reservation->invoice_name, $reservation->invoice_number, $sale_details);
      $reservation->sale_id = $sale->id;
      $reservation->save();

      // Send Email
      $vars = ['@name@'=>$user->name, '@total_cost@'=>$sale->total_cost, '@sale_link@'=>url('process/sale/'.$sale->id)];
      \FuncNode::make_email('new-sale', [$user->email], $vars);

      $redirect = 'process/sale/'.$sale->id;

      // Revisar redirección a método de pago antes.
      if(config('sales.redirect_to_payment')){
        $model = '\\'.$sale_payment->payment_method->model;
        return \Payments::generateSalePayment($sale, $model, $redirect);
      }

      return redirect($redirect)->with('message_success', 'Su compra fue confirmada correctamente, ahora debe proceder al pago para finalizarla.');
    }
  }

}