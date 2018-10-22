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

}