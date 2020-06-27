@extends('layouts/master')

@section('content')

<section class="content_reservations">
    <div class="bd-title">
        <div class="container">
            <h3 class="title-reservations">Proceso de Reserva</h3>
        </div>
    </div>
    <div class="container">
        <ul class="nav process-model content-tabs" style="margin-top: 50px;">
        <li role="presentation" class="visited">
            <a href="#">
                <i class="icon-cog"></i><span>Servicio </span>
                <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70">
                        <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#eed307" stroke-width="2" stroke-linecap="round" fill="transparent"></circle>
                        <polyline id="successAnimationCheck" stroke="#eed307" stroke-width="2" points="23 36 32 44 47 27" fill="transparent"></polyline>
                    </svg>
            </a>
        </li>
        <li role="presentation" class="active">
            <a href="#">
                <i class="icon-building"></i><span>Proveedor </span>
                <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70" style="display: none;">
                        <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#eed307" stroke-width="2" stroke-linecap="round" fill="transparent"></circle>
                        <polyline id="successAnimationCheck" stroke="#eed307" stroke-width="2" points="23 36 32 44 47 27" fill="transparent"></polyline>
                    </svg>
            </a>
        </li>
        <li role="presentation">
            <a href="#">
                <i class="icon-time"></i><span>Hora </span>
                <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70" style="display: none;">
                        <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#eed307" stroke-width="2" stroke-linecap="round" fill="transparent"></circle>
                        <polyline id="successAnimationCheck" stroke="#eed307" stroke-width="2" points="23 36 32 44 47 27" fill="transparent"></polyline>
                    </svg>
            </a>
        </li>
        <li role="presentation">
            <a href="#">
                <i class="icon-cart"></i><span>Cliente </span>
                <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70" style="display: none;">
                        <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#eed307" stroke-width="2" stroke-linecap="round" fill="transparent"></circle>
                        <polyline id="successAnimationCheck" stroke="#eed307" stroke-width="2" points="23 36 32 44 47 27" fill="transparent"></polyline>
                    </svg>
            </a>
        </li>
      </ul>

      <div class="time-content"><strong>Nuestra hora:</strong> <input type="time" value="10:10" disabled> America/La Paz</div>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab2">
            
            <div class="content-types row">
              @foreach($providers as $subitem)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                  <div class="card center">
                      <div class="card-title">
                          {{ $subitem->name }}
                      </div>
                      <div class="cart-footer">
                          <a href="{{ url('reservas/proceso/3/'.$item->id.'/'.$subitem->id) }}" class="btn btn-primary">Seleccionar</a>
                      </div>
                  </div>
                </div>
              @endforeach
          </div>
        </div>
      </div>
    </div>
</section>

@endsection

@section('script')
@endsection