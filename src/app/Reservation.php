<?php

namespace Solunes\Reservation\App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
	
	protected $table = 'reservations';
	public $timestamps = true;


    /* Sending rules */
    public static $rules_send = array(
        'first_name'=>'required',
        'last_name'=>'required',
        'email'=>'required',
        'cellphone'=>'required',
        'username'=>'required',
        'nit_number'=>'required',
        'nit_social'=>'required',
        'password'=>'required',
    );

    /* Sending auth rules */
    public static $rules_auth_send = array(
        'nit_number'=>'required',
        'nit_social'=>'required',
    );

	/* Creating rules */
	public static $rules_create = array(
		'accommodation_id'=>'required',
		'user_id'=>'required',
		'customer_id'=>'required',
		'sale_id'=>'required',
		'currency_id'=>'required',
		'name'=>'required',
		'price'=>'required',
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
		'user_id'=>'required',
		'customer_id'=>'required',
		'sale_id'=>'required',
		'currency_id'=>'required',
		'name'=>'required',
		'price'=>'required',
		'initial_date'=>'required',
		'end_date'=>'required',
		'initial_time'=>'required',
		'end_time'=>'required',
		'status'=>'required',
	);
    
    public function accommodation() {
        return $this->belongsTo('Solunes\Reservation\App\Accommodation');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }

    public function currency() {
        return $this->belongsTo('Solunes\Business\App\Currency');
    }

    public function sale() {
        return $this->belongsTo('Solunes\Sales\App\Sale');
    }

    public function reservation_users() {
        return $this->hasMany('Solunes\Reservation\App\ReservationUser','parent_id');
    }

    public function product_bridge() {
        return $this->hasOne('Solunes\Business\App\ProductBridge')->where('product_type', 'ticket');
    }

}