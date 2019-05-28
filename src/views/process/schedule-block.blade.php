@extends('layouts/master')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/reservation/reservation.css') }}">
@endsection

@section('content')
<div class="solunes-reservation">
  <div class="container">
    <div class="box-primary">
      <div class="row card-deck">

        @foreach($item->items as $subdate => $subitems)
          <div class="col-xs-5">
            <div class="rounded text-white bg-primary">
              <div class="card-header-week">{{ $subdate }}</div>
            </div>

            @foreach($subitems as $key => $subitem)
              <?php $free = true; ?>
              @if(isset($subitem['status'])&&$subitem['status']=='taken')
                <?php $free = false; ?>
              @endif
              @if($free)
              <a href="{{ url('reservations/pick-schedule-reservation/'.$item->id.'/'.$reservation->id.'/'.$subdate.'/'.$subdate.'/'.$subitem['time_in'].'/'.$subitem['time_out']) }}" class="select">
              @endif
                <div class="rounded text-white center bg-secondary mb-3 @if(!$free) taken-block @endif ">
                  <div class="card-header">{{ $subitem['time_in'] }} - {{ $subitem['time_out'] }}</div>
                  <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">Bs. {{ $item->price }}</p>
                  </div>
                  @if($free)
                  <div class="card-footer bg-transparent border-light">RESERVAR</div>
                  @else
                  <div class="card-footer bg-transparent border-light">NO DISPONIBLE</div>
                  @endif
                </div>
              @if($free)
              </a>       
              @endif
            @endforeach

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