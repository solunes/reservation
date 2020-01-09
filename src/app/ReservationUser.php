<?php

namespace Solunes\Reservation\App;

use Illuminate\Database\Eloquent\Model;

class ReservationUser extends Model {
	
	protected $table = 'reservation_users';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'first_name'=>'required',
		'last_name'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'first_name'=>'required',
		'last_name'=>'required',
	);
    
    public function reservation() {
        return $this->belongsTo('Solunes\Reservation\App\Reservation','parent_id');
    }
    
    public function parent() {
        return $this->belongsTo('Solunes\Reservation\App\Reservation');
    }
      
    public function unique_check() {
        return $this->belongsTo('Solunes\Master\App\UniqueCkeck')->where('key','reservation-code');
    }
      
    public function manual_unique_check() {
        return $this->belongsTo('Solunes\Master\App\UniqueCkeck')->where('key','manual-reservation-code');
    }

    public function getNameAttribute() {
        return $this->first_name.' '.$this->last_n;
    }

}