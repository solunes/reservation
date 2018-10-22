<?php
namespace Solunes\Reservation;

use Illuminate\Support\Facades\Facade;

class ReservationFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'reservation';
	}
}