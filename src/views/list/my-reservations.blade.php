@extends('layouts/master')
@include('helpers.meta')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/reservation/reservation.css') }}">
@endsection

@section('content')
<div class="solunes-reservation">
  <div class="container">     


        <div class="box-primary">

          <h3 class="title-page center">Tabla de Reservaciones</h3>

          <div class="item-reservation row">
            <div class="col-md-2">
              <img src="https://cdn.galaxy.tf/unit-media/tc-default/uploads/images/room_photo/001/543/253/main-club-executive-king-standard.jpg" alt="">
            </div>
            <div class="col-md-8">
              <h4 class="title-section">Habitación doble</h4>
              <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatum alias deserunt harum optio nemo sed veniam nisi culpa, nihil distinctio animi a, pariatur beatae.</p>
              <h5 class="title-information">Más información</h5>
              <small>Lorem ipsum dolor sit amet consectetur.</small>
              <p>Lorem, ipsum dolor.</p>
            </div>
            <div class="col-md-2">
              <small>Precio total</small>
              <p>Bs. 456</p>
              <button type="submit" class="btn btn-primary">Pagar</button>
            </div>
          </div>

          <div class="item-reservation row">
              <div class="col-md-2">
                <img src="https://cdn.galaxy.tf/unit-media/tc-default/uploads/images/room_photo/001/543/551/executive-king-standard.jpg" alt="">
              </div>
              <div class="col-md-8">
                <h4 class="title-section">Habitación doble</h4>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatum alias deserunt harum optio nemo sed veniam nisi culpa, nihil distinctio animi a, pariatur beatae.</p>
                <h5 class="title-information">Más información</h5>
                <small>Lorem ipsum dolor sit amet consectetur.</small>
                <p>Lorem, ipsum dolor.</p>
              </div>
              <div class="col-md-2">
                <small>Precio total</small>
                <p>Bs. 456</p>
                <button type="submit" class="btn btn-primary">Pagar</button>
              </div>
            </div>

            <div class="item-reservation row">
                <div class="col-md-2">
                    <img src="https://cdn.galaxy.tf/unit-media/tc-default/uploads/images/room_photo/001/543/253/main-club-executive-queen-standard.jpg" alt="">
                </div>
                <div class="col-md-8">
                  <h4 class="title-section">Habitación doble</h4>
                  <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatum alias deserunt harum optio nemo sed veniam nisi culpa, nihil distinctio animi a, pariatur beatae.</p>
                  <h5 class="title-information">Más información</h5>
                  <small>Lorem ipsum dolor sit amet consectetur.</small>
                  <p>Lorem, ipsum dolor.</p>
                </div>
                <div class="col-md-2">
                  <small>Precio total</small>
                  <p>Bs. 456</p>
                  <button type="submit" class="btn btn-primary">Pagar</button>
                </div>
              </div>

        </div>


</div><!-- End container  -->
@endsection

@section('script')
@endsection