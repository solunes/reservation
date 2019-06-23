<?php

namespace Solunes\Reservation\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

use Validator;
use Asset;
use AdminList;
use AdminItem;
use PDF;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller {

	protected $request;
	protected $url;

	public function __construct(UrlGenerator $url) {
	  $this->prev = $url->previous();
	  $this->module = 'test';
	}

	public function getPreivewReservation() {
        if(\App::environment('local')){
            $array = [];
            $array['item'] = \Solunes\Reservation\App\Reservation::first();
            $pdf = \PDF::loadView('reservation::pdf.reservation-file', $array);
            $pdf = \Asset::apply_pdf_template($pdf, 'RESERVA REALIZADA Y CONFIRMADA');
            return $pdf->stream();
        }
    }

}