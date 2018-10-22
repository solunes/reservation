<?php

namespace Solunes\Reservation\Database\Seeds;

use Illuminate\Database\Seeder;
use DB;

class MasterSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Módulo General de Empresa ERP
        $node_accommodation = \Solunes\Master\App\Node::create(['name'=>'accommodation', 'location'=>'reservation', 'folder'=>'reservation']);
        $node_accommodation_range = \Solunes\Master\App\Node::create(['name'=>'accommodation-range', 'location'=>'reservation', 'folder'=>'reservation', 'type'=>'child', 'parent_id'=>$node_accommodation->id]);
        $node_accommodation_space = \Solunes\Master\App\Node::create(['name'=>'accommodation-space', 'location'=>'reservation', 'folder'=>'reservation', 'type'=>'child', 'parent_id'=>$node_accommodation->id]);
        $node_accommodation_pick = \Solunes\Master\App\Node::create(['name'=>'accommodation-pick', 'location'=>'reservation', 'folder'=>'reservation', 'type'=>'child', 'parent_id'=>$node_accommodation->id]);
        $node_reservation = \Solunes\Master\App\Node::create(['name'=>'reservation', 'location'=>'reservation', 'folder'=>'reservation']);
        $node_reservaton_user = \Solunes\Master\App\Node::create(['name'=>'reservation-user', 'location'=>'reservation', 'folder'=>'reservation', 'type'=>'child', 'parent_id'=>$node_reservation->id]);

        // Usuarios
        $admin = \Solunes\Master\App\Role::where('name', 'admin')->first();
        $member = \Solunes\Master\App\Role::where('name', 'member')->first();
        $reservation_perm = \Solunes\Master\App\Permission::create(['name'=>'reservation', 'display_name'=>'Reservas']);
        $admin->permission_role()->attach([$reservation_perm->id]);

    }
}