<?php

namespace Solunes\Reservation\Database\Seeds;

use Illuminate\Database\Seeder;
use DB;

class TruncateSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Solunes\Reservation\App\ReservationUser::truncate();
        \Solunes\Reservation\App\Reservation::truncate();
        \Solunes\Reservation\App\AccommodationPick::truncate();
        \Solunes\Reservation\App\AccommodationSpace::truncate();
        \Solunes\Reservation\App\AccommodationRange::truncate();
        \Solunes\Reservation\App\Accommodation::truncate();

    }
}