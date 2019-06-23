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
        <?php $finalitems = $item->getItemsAttr($reservation); ?>
        @if(count($finalitems)>0)
          <table class="table" id="customers">
            
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col">Hora de Inicio</th>
                <th scope="col">Hora de Salida</th>
                <th scope="col">Nombre</th>
                @if($item->capacity>1)
                <th scope="col">Cupos</th>
                @endif
                <th scope="col">Precio</th>
                <th scope="col"></th>
                <!--<th scope="col"></th>-->
              </tr>
            </thead>
            
            @foreach($finalitems as $subdate => $subitems)
            <thead class="bg-secondary">
              @if($item->capacity>1)
              <td class="center" colspan="7">{{ $subdate }}</td>
              @else
              <td class="center" colspan="6">{{ $subdate }}</td>
              @endif
            </thead>
            <tbody>
              @foreach($subitems as $key => $subitem)
                <?php $free = true; ?>
                @if(isset($subitem['status'])&&$subitem['status']!='free')
                  <?php $free = false; ?>
                @endif
                <tr class=" @if(!$free) taken-block @endif ">
                  <td>{{ $subitem['time_in'] }}</td>
                  <td>
                    @if($subitem['date_out']!=$subdate)
                    {{ $subitem['date_out'] }} 
                    @endif
                    {{ $subitem['time_out'] }}</td>
                  <td>{{ $item->name }}</td>
                  @if($item->capacity>1)
                  <td>{{ $item->capacity-$subitem['count'] }} / {{ $item->capacity }}</td>
                  @endif
                  <td>Bs. {{ $item->price }}</td>
                  <td>
                    @if($free)
                    <a href="{{ url('reservations/pick-schedule-reservation/'.$item->id.'/'.$reservation->id.'/'.$subdate.'/'.$subitem['date_out'].'/'.$subitem['time_in'].'/'.$subitem['time_out']) }}" class="btn">Reservar</a>
                    @elseif(auth()->check()&&$subitem['user_id']==auth()->user()->id)
                      @if($subitem['status']=='pre-reserve')
                        <a href="{{ url('reservations/pick-schedule-reservation/'.$item->id.'/'.$subitem['reservation_id'].'/'.$subdate.'/'.$subitem['date_out'].'/'.$subitem['time_in'].'/'.$subitem['time_out']) }}" class="btn">Finalizar Reserva</a>
                      @else
                        <button class="btn btn-primary btn-sm text-white" disabled="true">RESERVADO</button>
                      @endif
                      @if(in_array($subitem['status'], ['pre-reserve','sale']))
                        <a href="{{ url('reservations/cancel-reservation/'.$subitem['reservation_id']) }}" onclick="return confirm('¿Confirma que desea cancelar su reserva?')"><button class="btn btn-primary btn-sm text-white"><i class="fa fa-close"></i></button></a>
                      @endif
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
        @else
          <p>El evento se encuentra sin horarios disponibles.</p>
        @endif
      </div>
    </div>
    
  </div>
</div><!-- End container  -->
@endsection

@section('script')
@endsection