@extends('layouts/master')
@include('helpers.meta')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/reservation/reservation.css') }}">
@endsection

@section('content')
<div class="solunes-reservation">
  <div class="container">

    <div class="box-primary">

      <h3 class="title-page center">Detalle de la Reserva</h3>

      <div class="row detail">
        <div class="col-md-6">
            <p><strong>Titular de la Reserva:</strong> Eduardo Mejía</p> 
            
            <p><strong>Número de Reserva:</strong> #6</p>

            <p><strong>Monto Total:</strong> Bs. 200.00</p>            

        </div>
        <div class="col-md-6">

            <p><strong>Ingreso:</strong> 2019-06-24 08:00:00</p>

            <p><strong>Salida:</strong> 2019-06-24 08:30:00</p>

            <p><strong>NIT:</strong> 45645678</p>

            <p><strong>Razón Social:</strong> Mejía</p>

        </div>
      </div>          

      <h4 class="title-page center">Personas:</h4>

      <table class="table" id="customers">

        <thead class="bg-primary text-white">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Precio</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>1</td>
            <td>Eduardo</td>
            <td>Mejía</td>
            <td>Bs. 200.00</td>
          </tr>
        </tbody>

        <thead class="bg-secondary">
          <td class="center">Total:</td>

          <td class="center">Bs. 200.00</td>

        </thead>

      </table>
        
      <div style="text-align: right">
        <button type="submit" class="btn btn-primary center">Pagar</button>
      </div>

    </div>    
  </div>
</div>
<!-- End container  -->
@endsection

@section('script')
@endsection