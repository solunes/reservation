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
        <table class="table" id="customers">
          
          <thead class="bg-primary text-white">
            <tr>
              <th scope="col">Hora de Inicio</th>
              <th scope="col">Hora de Salida</th>
              <th scope="col">Nombre</th>
              <th scope="col">Cupos</th>
              <th scope="col">Total</th>
              <th scope="col"></th>
              <!--<th scope="col"></th>-->
            </tr>
          </thead>
          
          @foreach($item->items as $subdate => $subitems)
          <thead class="bg-secondary">
            <td class="center" colspan="7">{{ $subdate }}</td>
          </thead>
          <tbody>
            @foreach($subitems as $key => $subitem)
              <?php $free = true; ?>
              @if(isset($subitem['status'])&&$subitem['status']=='taken')
                <?php $free = false; ?>
              @endif
              <tr class=" @if(!$free) taken-block @endif ">
                <td>{{ $subitem['time_in'] }}</td>
                <td>{{ $subitem['time_out'] }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->capicity }}</td>
                <td>Bs. {{ $item->price }}</td>
                <td>
                  @if($free)
                  <a href="{{ url('reservations/pick-schedule-reservation/'.$item->id.'/'.$reservation->id.'/'.$subdate.'/'.$subdate.'/'.$subitem['time_in'].'/'.$subitem['time_out']) }}" class="btn">Reservar</a>
                  @else
                  <button class="btn btn-primary btn-sm text-white" disabled="true">NO DISPONIBLE</button>
                  @endif
                </td>
                <!--<td><a class="btn btn-secondary btn-sm  text-white">Info</a></td>-->
              </tr>
            @endforeach
          </tbody>
          @endforeach
        </table>                        
      </div>
    </div>
    
  </div>
</div><!-- End container  -->
@endsection

@section('script')
@endsection