<?php

namespace Solunes\Reservation\App;

use Illuminate\Database\Eloquent\Model;

class AccommodationRange extends Model {
	
	protected $table = 'accommodation_ranges';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'parent_id'=>'required',
		'initial_day'=>'required',
		'duration_nights'=>'required',
		'initial_time'=>'required',
		'end_time'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'parent_id'=>'required',
		'initial_day'=>'required',
		'duration_nights'=>'required',
		'initial_time'=>'required',
		'end_time'=>'required',
	);
    
    public function accommodation() {
        return $this->belongsTo('Solunes\Reservation\App\Accommodation','parent_id');
    }
    
    public function parent() {
        return $this->belongsTo('Solunes\Reservation\App\Accommodation');
    }

}