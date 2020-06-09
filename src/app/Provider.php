<?php

namespace Solunes\Reservation\App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model {
	
	protected $table = 'providers';
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
    
    public function accommodations() {
        return $this->hasMany('Solunes\Reservation\App\Accommodation');
    }

}