<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NodesReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Módulo de Reservas
        Schema::create('accommodations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->string('name')->nullable();
            $table->enum('type', ['open','closed'])->default('open');
            $table->enum('interval', ['hour','day'])->default('hour');
            $table->enum('pricing', ['free','pay-in-place','parcial','total'])->default('free');
            $table->enum('pricing_type', ['per-person','total-amount'])->default('per-person');
            $table->integer('currency_id')->nullable()->default(1);
            $table->integer('price')->nullable()->default(1);
            $table->integer('capacity')->nullable()->default(1);
            $table->integer('ticket')->nullable()->default(0);
            $table->integer('duration_number')->nullable();
            $table->enum('duration_type', ['minute','hour','day'])->default('minute');
            $table->string('image')->nullable();
            $table->string('image_ticket')->nullable();
            $table->string('image_terms')->nullable();
            $table->string('image_schedule')->nullable();
            $table->string('image_ad')->nullable();
            $table->text('summary')->nullable();
            if(config('reservation.accommodation_sold_content')){
                $table->text('sold_content')->nullable();
            }
            $table->text('content')->nullable();
            $table->integer('total_min')->nullable();
            $table->integer('total_max')->nullable();
            $table->integer('min_advance_number')->nullable();
            $table->enum('min_advance_type', ['hour','day','week','month'])->default('hour');
            $table->integer('max_advance_number')->nullable();
            $table->enum('max_advance_type', ['hour','day','week','month'])->default('hour');
            $table->boolean('active')->nullable()->default(0);
            $table->timestamps();
        });
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->integer('capacity')->nullable(); // Toma por defecto de evento
            $table->timestamps();
        });
        Schema::create('accommodation_ranges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('provider_id')->nullable();
            $table->enum('initial_day', ['d_01','d_02','d_03','d_04','d_05','d_06','d_07'])->default('d_01');
            $table->integer('duration_nights')->nullable()->default(0);
            $table->integer('max_reservation_days')->nullable()->default(90);
            $table->time('initial_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Toma por defecto de evento
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('accommodations')->onDelete('cascade');
        });
        Schema::create('accommodation_spaces', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('provider_id')->nullable();
            $table->string('name')->nullable();
            $table->date('initial_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('initial_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Toma por defecto de evento
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('accommodations')->onDelete('cascade');
        });
        Schema::create('accommodation_picks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('reservation_id')->nullable();
            $table->integer('users_count')->nullable();
            $table->date('initial_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('initial_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('accommodations')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_id')->unsigned();
            $table->integer('provider_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('sale_id')->nullable();
            $table->integer('currency_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('counts')->default(1);
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->date('initial_date')->nullable();
            $table->time('initial_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamp('reservation_deadline')->nullable();
            $table->boolean('invoice')->nullable();
            $table->integer('invoice_number')->nullable();
            $table->string('invoice_name')->nullable();
            $table->enum('status', ['holding','pre-reserve','sale','paid','finished','cancelled'])->default('holding');
            $table->string('reservation_file')->nullable();
            $table->string('tickets_file')->nullable();
            $table->timestamps();
            $table->foreign('accommodation_id')->references('id')->on('accommodations')->onDelete('cascade');
        });
        Schema::create('reservation_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('ticket_code')->nullable();
            $table->string('manual_ticket_code')->nullable();
            $table->string('first_name')->nullable();
            if(config('reservation.reservation_subuser_name')){
                $table->string('last_name')->nullable();
            }
            if(config('reservation.reservation_subuser_username')){
                $table->string('ci_number')->nullable();
            }
            if(config('reservation.reservation_subuser_cellphone')){
                $table->string('cellphone')->nullable();
            }
            if(config('reservation.reservation_subuser_email')){
                $table->integer('email')->nullable();
            }
            if(config('reservation.reservation_subuser_age')){
                $table->integer('age')->nullable();
            }
            $table->enum('status', ['holding','paid','used','cancelled'])->default('holding');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Módulo General de Tareas
        Schema::dropIfExists('reservation_users');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('providers');
        // Módulo General de Tareas
        Schema::dropIfExists('accommodation_picks');
        Schema::dropIfExists('accommodation_spaces');
        Schema::dropIfExists('accommodation_ranges');
        Schema::dropIfExists('accommodations');
    }
}
