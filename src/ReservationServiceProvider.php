<?php

namespace Solunes\Reservation;

use Illuminate\Support\ServiceProvider;

class ReservationServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot() {
        /* Publicar Elementos */
        $this->publishes([
            __DIR__ . '/config' => config_path()
        ], 'config');
        $this->publishes([
            __DIR__.'/assets' => public_path('assets/reservation'),
        ], 'assets');

        /* Cargar Traducciones */
        $this->loadTranslationsFrom(__DIR__.'/lang', 'reservation');

        /* Cargar Vistas */
        $this->loadViewsFrom(__DIR__ . '/views', 'reservation');
    }


    public function register() {
        /* Registrar ServiceProvider Internos */
        //$this->app->register('Collective\Html\HtmlServiceProvider');

        /* Registrar Alias */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        //$loader->alias('HTML', 'Collective\Html\HtmlFacade');

        $loader->alias('Reservation', '\Solunes\Reservation\App\Helpers\Reservation');
        $loader->alias('CustomReservation', '\Solunes\Reservation\App\Helpers\CustomReservation');

        /* Comandos de Consola */
        $this->commands([
            //\Solunes\Reservation\App\Console\AccountCheck::class,
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/config/reservation.php', 'reservation'
        );
    }
    
}
