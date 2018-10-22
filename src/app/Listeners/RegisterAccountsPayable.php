<?php

namespace Solunes\Reservation\App\Listeners;

class RegisterAccountsPayable {

    public function handle($event) {
    	// Revisar que tenga una sesión y sea un modelo del sitio web.
    	if($event){

            /* Crear cuentas de ventas */
            $liability_ctp = \Solunes\Reservation\App\Account::getCode('liability_ctp')->id;
            $name = $event->name;
            $arr[] = \Reservation::register_account($event->place_id, 'debit', $event->account_id, $event->currency_id, $event->amount, $name);
            $arr[] = \Reservation::register_account($event->place_id, 'credit', $liability_ctp, $event->currency_id, $event->amount, $name);
            \Reservation::register_account_array($arr);
            return $event;
    	}

    }

}
