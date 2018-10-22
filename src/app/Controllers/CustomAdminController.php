<?php

namespace Solunes\Reservation\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Asset;

class CustomAdminController extends Controller {

	protected $request;
	protected $url;

	public function __construct(UrlGenerator $url) {
	  $this->middleware('auth');
	  $this->middleware('permission:dashboard');
	  $this->prev = $url->previous();
	  $this->module = 'admin';
	}

	public function getIndex() {
		$user = auth()->user();
		//$array['tasks'] = $user->active_reservation_tasks;
		$array['tasks'] = \Solunes\Reservation\App\ReservationTask::limit(2)->get();
		$array['active_reservation_issues'] = \Solunes\Reservation\App\Reservation::has('active_reservation_issues')->with('active_reservation_issues')->get();
      	return view('reservation::list.dashboard', $array);
	}

	/* Módulo de Reservas */
    public function getAccommodations() {
	  	$array['items'] = \Solunes\Reservation\App\Accommodation::get();
	    return view('reservation::list.accommodations', $array);
    }


	public function findAccommodation($id) {
		if($item = \Solunes\Reservation\App\Accommodation::find($id)){
			if($item->interval=='hour'){
				$subitems = \Reservation::getOccupancyDays($item, date('Y-m-d'), date("Y-m-d", strtotime("+15 days")));
			} else {
				$subitems = \Reservation::getOccupancyHours($item, date('Y-m-d'), date("Y-m-d", strtotime("+7 days")));
			}
			$array = ['item'=>$item, 'subitems'=>$subitems];
      		return view('reservation::item.accommodation', $array);
		} else {
			return redirect($this->prev)->with('message_error', 'Item no encontrado');
		}
	}

	public function findReservationTask($id) {
		if($item = \Solunes\Reservation\App\ReservationTask::find($id)){
			$array = ['item'=>$item];
      		return view('reservation::item.reservation-task', $array);
		} else {
			return redirect($this->prev)->with('message_error', 'Item no encontrado');
		}
	}

	public function findProjecIssue($id) {
		if($item = \Solunes\Reservation\App\ReservationIssue::find($id)){
			$array = ['item'=>$item];
      		return view('reservation::item.reservation-issue', $array);
		} else {
			return redirect($this->prev)->with('message_error', 'Item no encontrado');
		}
	}

	public function allWikis($reservation_type_id = NULL, $wiki_type_id = NULL) {
		$array['reservation_type_id'] = $reservation_type_id;
		$array['wiki_type_id'] = $wiki_type_id;
		$array['filtered'] = false;
		if($reservation_type_id&&$wiki_type_id){
			$array['items'] = \Solunes\Reservation\App\Wiki::where('reservation_type_id',$reservation_type_id)->where('wiki_type_id',$wiki_type_id)->get();
			$array['filtered'] = true;
		} else if($reservation_type_id){
			$array['items'] = \Solunes\Reservation\App\WikiType::get();
		} else {
			$array['items'] = \Solunes\Reservation\App\ReservationType::get();
		}
      	return view('reservation::list.wikis', $array);
	}

	public function findWiki($id) {
		if($item = \Solunes\Reservation\App\Wiki::find($id)){
			$array = ['item'=>$item];
      		return view('reservation::item.wiki', $array);
		} else {
			return redirect($this->prev)->with('message_error', 'Item no encontrado');
		}
	}

}