<?php

namespace Solunes\Reservation\App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
	
	protected $table = 'reservations';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'accommodation_id'=>'required',
		'customer_id'=>'required',
		'sale_id'=>'required',
		'name'=>'required',
		'initial_date'=>'required',
		'end_date'=>'required',
		'initial_time'=>'required',
		'end_time'=>'required',
		'status'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'accommodation_id'=>'required',
		'customer_id'=>'required',
		'sale_id'=>'required',
		'name'=>'required',
		'initial_date'=>'required',
		'end_date'=>'required',
		'initial_time'=>'required',
		'end_time'=>'required',
		'status'=>'required',
	);
    
    public function reservation_users() {
        return $this->hasMany('Solunes\Reservation\App\ReservationUser');
    }

}