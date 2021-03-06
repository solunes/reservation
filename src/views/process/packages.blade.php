@extends('layouts/master')
@include('helpers.meta')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/reservation/reservation.css') }}">
@endsection

@section('content')
<div class="solunes-reservation">
	<div class="container">

		<div class="row">

			@foreach($items as $item)
			<div class="col-md-4">
				<div class="box-primary">

					<div class="box">
						<img class="card-img-top" src="{{ asset(\Asset::get_image_path('accommodation-image', 'thumb', $item->image)) }}" alt="Card image cap">
						<div class="card-body">
							<h3>{{ $item->name }}</h3>
							<p class="card-text">Some quick example text to build on the card title and make up the bulk
								of the card's
								content.</p>
							<div class="row">
								<div class="col-md-6 text-muted">
									<p>Información</p>
								</div>
								<div class="col-md-6">
									<h1 class="card-title pricing-card-title">Bs. {{ $item->price }}</h1>
								</div>
							</div>
							<a href="{{ url('reservations/item/'.$item->id) }}"
								class="btn">Reservar</a>
						</div>
						<!-- <div class="card-footer">
							<div class="row">
								<div class="col-sm-6">
									<a href="#" class="text-muted">Información</a>
								</div>
								<div class="col-sm-6">
									<a href="#" class="text-muted">Detalles</a>
								</div>
							</div>
						</div> -->
					</div>

				</div>
			</div>
			@endforeach

		</div>
	</div>
</div><!-- End container  -->
@endsection

@section('script')
<!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection