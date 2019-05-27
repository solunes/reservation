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
        <table class="table">
          
          <thead class="bg-primary text-white">
            <tr>
              <th scope="col">Hora</th>
              <th scope="col">Clase</th>
              <th scope="col">Instructor</th>
              <th scope="col">Disponible</th>
              <th scope="col">Total</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          
          @foreach($item->items as $subdate => $subitems)
          <?php \Log::info($subdate.' - '.json_encode($subitems)); ?>
          <thead class="bg-secondary text-white">
            <td colspan="7">{{ $subdate }}</td>
          </thead>
          <tbody>
            @foreach($subitems as $key => $subitem)
            <tr>
              <th scope="row">{{ json_encode($subitem) }}</th>
              <td>Yoga - Beginners</td>
              <td>Eduardo Galeano</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm  text-white">Info</a></td>
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
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection