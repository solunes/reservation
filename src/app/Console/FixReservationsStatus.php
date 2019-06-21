<?php

namespace Solunes\Reservation\App\Console;

use Illuminate\Console\Command;

class FixReservationsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix-reservations-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa el estado de las reservas.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $this->info('Comenzando la revision de estado de reservas pendientes.');
        $datetime = date("Y-m-d H:i:s");
        $items = \Solunes\Reservation\App\Reservation::whereIn('status',['sale','pre-reserve'])->where('reservation_deadline','<',$datetime)->get();
        $count = 0;
        if(count($items)>0){
            foreach($items as $item){
                $item->status = 'cancelled';
                $item->save();
                if($item->sale_id){
                    $sale = $item->sale;
                    $sale->status = 'cancelled';
                    $sale->save();
               }
                $this->info('Reserva correctamente anulada y revertida: #'.$item->id);
                $count++;
            }
        }
        $this->info('Finalizando la revision de estado de reservas pendientes. Se revirtieron '.$count.' reservas.');
    }
}
