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

class ProcessController extends Controller {

	protected $request;
	protected $url;

	public function __construct(UrlGenerator $url) {
	  $this->prev = $url->previous();
	}

    public function getPackages($token) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['items'] = \Solunes\Reservation\App\Accommodation::get();
      return view('reservation::process.packages', $array);
    }

    public function getPackage($item_id) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['item'] = \Solunes\Reservation\App\Accommodation::find($item_id);
      return view('reservation::process.package-item', $array);
    }

    public function getScheduleList($token) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      return view('reservation::process.schedule-list', $array);
    }

    public function getScheduleBlock($token) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      return view('reservation::process.schedule-block', $array);
    }

}