@extends('layouts/master')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/reservation/reservation.css') }}">
@endsection

@section('content')
<div class="solunes-reservation">
  <div class="container">
    <div class="box-primary">  
      <div class="row">

        @foreach($items as $item)
          <div class="col-lg-3 col-sm-6">
            <div class="box">
              <img class="card-img-top" src="assets/images/1.jpg" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title text-primary">{{ $item->name }}</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <div class="row">
                  <div class="col-sm-8 text-muted">
                    <p>Información</p>
                  </div>
                  <div class="col-sm-4">
                    <h1 class="card-title pricing-card-title">Bs. {{ $item->price }}</h1>
                  </div>
                </div>
                <a href="{{ url('reservations/item/'.$item->id) }}" class="btn btn-primary btn-block">Reservar</a>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-6">
                    <a href="#" class="text-muted">Información</a>
                  </div>
                  <div class="col-sm-6">
                    <a href="#" class="text-muted">Detalles</a>
                  </div>
                </div>
              </div>
            </div>    
          </div>
        @endforeach

      </div>
    </div>            
  </div>
</div><!-- End container  -->
@endsection

@section('script')
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection