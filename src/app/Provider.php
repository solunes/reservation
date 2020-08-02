<?php

namespace Solunes\Reservation\App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model {
	
	protected $table = 'providers';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'name'=>'required',
		'image'=>'required',
		'capacity'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'name'=>'required',
		'image'=>'required',
		'capacity'=>'required',
	);
    
    public function agency() {
        return $this->belongsTo('Solunes\Business\App\Agency');
    }
    
    public function accommodations() {
        return $this->hasMany('Solunes\Reservation\App\Accommodation');
    }

    public function active_reservations() {
        return $this->hasMany('Solunes\Reservation\App\Reservation')->whereIn('status', ['pre-reserve','sale','paid','finished']);
    }
    
}