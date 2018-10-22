<?php

namespace Solunes\Reservation\App;

use Illuminate\Database\Eloquent\Model;

class AccommodationPick extends Model {
	
	protected $table = 'accommodation_picks';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'parent_id'=>'required',
		'customer_id'=>'required',
		'reservation_id'=>'required',
		'initial_date'=>'required',
		'end_date'=>'required',
		'initial_time'=>'required',
		'end_time'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'parent_id'=>'required',
		'customer_id'=>'required',
		'reservation_id'=>'required',
		'initial_date'=>'required',
		'end_date'=>'required',
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