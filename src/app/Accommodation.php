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

    public function getReservationLinkAttribute() {
    	if($this->type=='closed'){
        	return url('reservations/schedule-list/3846134');
    	} else {
        	return url('reservations/schedule-group/9421457');
    	}
    }

    public function getItemsAttribute() {
    	$date_start = date('Y-m-d');
		$date_end = strtotime($date_start);
		$date_end = strtotime("+7 days", $date_end);
    	if($this->type=='day'){
        	return \Reservation::getAvailableDays($this, $date_start, $date_end);
    	} else {
        	return \Reservation::getAvailableHours($this, $date_start, $date_end);
    	}
    }

}