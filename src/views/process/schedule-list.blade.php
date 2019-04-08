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
          
          <thead class="bg-secondary text-white">
            <td>Lunes</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </thead>
          
          <tbody>
            <tr>
              <th scope="row">7:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Eduardo Galeano</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm  text-white">Info</a></td>
            </tr>
            <tr>
              <th scope="row">8:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Eduardo Galeano</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">9:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Eduardo Galeano</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">10:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Eduardo Galeano</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">11:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Eduardo Galeano</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">12:00 PM</th>
              <td>Yoga - Beginners</td>
              <td>Eduardo Galeano</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
          </tbody>
          
          <thead class="bg-secondary text-white">
            <td>Martes</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </thead>
          
          <tbody>
            <tr>
              <th scope="row">7:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Camila Egger</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">8:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Camila Egger</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">9:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Camila Egger</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">10:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Camila Egger</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
          </tbody>

          <thead class="bg-secondary text-white">
            <td>Jueves</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </thead>
          
          <tbody>
            <tr>
              <th scope="row">7:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Camila Egger</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">8:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Camila Egger</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">9:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Camila Egger</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
            <tr>
              <th scope="row">10:00 AM</th>
              <td>Yoga - Beginners</td>
              <td>Camila Egger</td>
              <td>15</td>
              <td>$20</td>
              <td><a class="btn btn-primary btn-sm text-white">Reservar</a></td>
              <td><a class="btn btn-secondary btn-sm text-white">Info</a></td>
            </tr>
            
          </tbody>
          
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