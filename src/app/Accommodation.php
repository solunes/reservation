<?php

namespace Solunes\Reservation\App;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model {
	
	protected $table = 'accommodations';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'type'=>'required',
		'interval'=>'required',
		'pricing'=>'required',
		'pricing_type'=>'required',
		'min_advance_type'=>'required',
		'max_advance_type'=>'required',
		'active'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'type'=>'required',
		'interval'=>'required',
		'pricing'=>'required',
		'pricing_type'=>'required',
		'min_advance_type'=>'required',
		'max_advance_type'=>'required',
		'active'=>'required',
	);
    

    public function accommodation_items($initial_date = NULL, $end_date = NULL) {
    	if($this->type=='closed'){
        	return $this->hasMany('Solunes\Reservation\App\AccommodationSpace', 'parent_id');
    	} else {
        	return $this->hasMany('Solunes\Reservation\App\AccommodationRange', 'parent_id');
    	}
    }
    
    public function accommodation_ranges() {
        return $this->hasMany('Solunes\Reservation\App\AccommodationRange', 'parent_id');
    }
    
    public function accommodation_spaces() {
        return $this->hasMany('Solunes\Reservation\App\AccommodationSpace', 'parent_id');
    }   

    public function accommodation_picks() {
        return $this->hasMany('Solunes\Reservation\App\AccommodationPick', 'parent_id');
    }

    public function reservations() {
        return $this->hasMany('Solunes\Reservation\App\Reservation');
    }

    public function active_reservations() {
        return $this->hasMany('Solunes\Reservation\App\Reservation')->whereIn('status', ['pre-reserve','sale','paid','finished']);
    }

    public function accommodation() {
        return $this->belongsTo('Solunes\Reservation\App\Accommodation','parent_id');
    }

    public function parent() {
        return $this->belongsTo('Solunes\Reservation\App\Accommodation');
    }

    public function accommodation_childs() {
        return $this->hasMany('Solunes\Reservation\App\Accommodation','parent_id');
    }

    public function provider() {
        return $this->belongsTo('Solunes\Reservation\App\Provider');
    }

    public function childs() {
        return $this->hasMany('Solunes\Reservation\App\Accommodation','parent_id');
    }

    public function currency() {
        return $this->belongsTo('Solunes\Business\App\Currency');
    }

    public function product_bridge() {
        return $this->hasOne('Solunes\Business\App\ProductBridge','product_id')->where('product_type', 'accommodation');
    }

    public function getReservationLinkAttribute() {
    	if(config('reservation.type')=='list'){
        	return url('reservations/schedule-list');
    	} else {
        	return url('reservations/schedule-group');
    	}
    }

    public function getRealCapacityAttribute() {
        return '10';
    }

    public function getItemsAttr($reservation) {
    	$date_start = date('Y-m-d');
		$date_end = strtotime($date_start);
		$date_end = strtotime("+14 days", $date_end);
        $date_end = date('Y-m-d', $date_end);
    	if($this->type=='day'){
        	return \Reservation::getAvailableDays($this, $date_start, $date_end, $reservation); // Mezclar con occupancy
    	} else {
        	return \Reservation::getOccupancyHours($this, $date_start, $date_end, $reservation);
    	}
    }

}