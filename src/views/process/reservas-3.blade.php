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
                <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70" style="display: none;">
                        <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#eed307" stroke-width="2" stroke-linecap="round" fill="transparent"></circle>
                        <polyline id="successAnimationCheck" stroke="#eed307" stroke-width="2" points="23 36 32 44 47 27" fill="transparent"></polyline>
                    </svg>
            </a>
        </li>
        <li role="presentation" class="visited">
            <a href="#">
                <i class="icon-building"></i><span>Proveedor </span>
                <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70" style="display: none;">
                        <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#eed307" stroke-width="2" stroke-linecap="round" fill="transparent"></circle>
                        <polyline id="successAnimationCheck" stroke="#eed307" stroke-width="2" points="23 36 32 44 47 27" fill="transparent"></polyline>
                    </svg>
            </a>
        </li>
        <li role="presentation" class="active">
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

      <div class="time-content"><strong>Nuestra hora:</strong> {{ date('H:i') }} America/La Paz</div>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab3">

          <div>
            <div class="row">
                <div class="col-md-3 col-sm-0  col-xs-0">
                    <div class="card">
                        <div class="card-title">
                            {{ $item->name }}
                        </div>
                        <div class="card-content">
                            <p>{{ $item->summary }}</p>
                        </div>
                        <div class="cart-footer">
                            <i class="icon-time"></i> {{ $item->duration_number }} {{ trans('reservation::admin.'.$item->duration_type) }}s
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            {{ $provider->name }}
                        </div>
                        <div class="card-content">
                            <p>{{ $provider->summary }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row content_date-x">
                                        <div class="col-md-4 col-sm-4 col-xs-4 center items_date-1">
                                          @if($past_week)
                                            <a href="{{ url('reservas/seleccionar-horarios/'.$reservation->id.'/'.$past_week_date) }}" class="btn-options-date">
                                                <h5>SEMANA ANTERIOR</h5>
                                            </a>
                                          @endif
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 center items_date-2">
                                            <a href="#" class="btn-date">{{ $date_start.' - '.$date_end }}</a>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 center items_date-3">
                                          @if($next_week)
                                            <a href="{{ url('reservas/seleccionar-horarios/'.$reservation->id.'/'.$next_week_date) }}" class="btn-options-date">
                                                <h5>SIGUIENTE SEMANA</h5>
                                            </a>
                                          @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card swipe-content" id="app_responsive">
                                <div class="control_swipe left">
                                    <button id="left-button" class="bnt-swipe" @click="swipeLeft">
                                      <i class="fa fa-angle-left"></i>
                                    </button>
                                    </div>
                        <div class="col-sm-12">
                            <div class="card swipe-content" id="app_responsive">
                                <div class="control_swipe left">
                                    <button id="left-button" class="bnt-swipe" @click="swipeLeft">
                                      <i class="fa fa-angle-left"></i>
                                    </button>
                                    </div>
                                <div id="content" class="card-content resp_scroll" ref="content">
                                    <div class="row type_3 row-item-7">
                                        @foreach($available_dates as $date_day => $subday)
                                            <div class="col-items">
                                                <div class="date">{{ $subday }}</div>
                                                <div class="border"></div>
                                                <div class="day">{{ $date_day }}</div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @foreach($available_times as $time => $time_item)
                                        <div class="row type_3 row-item-7">
                                            @foreach($available_dates as $date_day => $subday)
                                                    <div class="col-items">
                                                        @if($finalitems[$time][$subday]['status']=='free')
                                                            <a href="{{ url('reservations/pick-schedule-reservation/'.$item->id.'/'.$reservation->id.'/'.$subday.'/'.$subday.'/'.$time.'/'.$finalitems[$time][$subday]['end_time']) }}">
                                                                <div class="item-date">
                                                                    {{ substr($time,0,5) }}
                                                                </div>
                                                            </a>
                                                        @else
                                                            <a href="#">
                                                                <div class="item-date disabled">
                                                                    {{ substr($time,0,5) }}
                                                                </div>
                                                            </a>
                                                        @endif
                                                    </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                                <div class="control_swipe right">
                                    <button id="right-button" class="bnt-swipe" @click="swipeRight">
                                    <i class="fa fa-angle-right"></i>
                                    </button>
                                    </div>
                            </div>
                        </div>
                                <div class="control_swipe right">
                                    <button id="right-button" class="bnt-swipe" @click="swipeRight">
                                    <i class="fa fa-angle-right"></i>
                                    </button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

@endsection

@section('script')
@endsection