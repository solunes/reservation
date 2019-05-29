@extends('layouts/master')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/reservation/reservation.css') }}">
@endsection

@section('content')
<div class="solunes-reservation">
  <div class="container">
    <div class="box-primary">

      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="padding-20">                        
              <h3 class="modal-title text-primary mb-4">{{ $item->name }}</h3>
              <div>
                <img width="90%" src="{{ asset(\Asset::get_image_path('accommodation-image', 'semi', $item->image)) }}" class="img-responsive">
              </div>                            
            </div>
          </div>

          <div class="col-md-6">
            <div class="padding-20">
              <h4 class="text-primary">Código #<span>{{ $item->id }}</span></h4>
              <!--<div class="rating">
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                (10 recomendaciones)
              </div>-->
              <p>{{ $item->summary }}</p>
              <form method="post" action="{{ url('reservations/start-reservation') }}">
                @if($item->total_max>1)
                <h3 class="cost"><span class="glyphicon glyphicon-usd"></span> Precio por Persona: Bs. {{ $item->price }}
                  <!--<small class="pre-cost"><span class="glyphicon glyphicon-usd"></span> Bs. 50.00 por persona</small>-->
                </h3>
                <div class="row pt-30">
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <select class="form-control" name="counts">
                      @foreach(range($item->total_min, $item->total_max) as $count)
                        <option value="{{ $count }}">{{ $count }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @else
                <h3 class="cost"><span class="glyphicon glyphicon-usd"></span> Precio: Bs. {{ $item->price }}
                  <!--<small class="pre-cost"><span class="glyphicon glyphicon-usd"></span> Bs. 50.00 por persona</small>-->
                </h3>
                  <input type="hidden" name="counts" value="1" />
                @endif
                <div class="space-ten"></div>
                <br>
                <div class="btn-ground pt-4">
                  <!--<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Anadir al carrito</button>-->
                  <!--<a href="{{ $item->reservation_link.'/'.$item->id }}">-->
                    <input type="hidden" name="accommodation_id" value="{{ $item->id }}" />
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-heart"></span> Reservar</button>
                  <!--</a>-->
                </div>
              </form>
            </div>
          </div>

        </div>
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