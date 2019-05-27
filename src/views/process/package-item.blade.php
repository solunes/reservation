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
          <div class="col-md-6 product_img">                        
            <h3 class="modal-title text-primary mb-4">{{ $item->name }}</h3>
            <div>
              <img width="90%" src="assets/images/1.jpg" class="img-responsive">
            </div>                            
          </div>
          <div class="col-md-6 product_content">
            <h4 class="text-primary">Código #<span>51526</span></h4>
            <div class="rating">
              <span class="glyphicon glyphicon-star"></span>
              <span class="glyphicon glyphicon-star"></span>
              <span class="glyphicon glyphicon-star"></span>
              <span class="glyphicon glyphicon-star"></span>
              <span class="glyphicon glyphicon-star"></span>
              (10 recomendaciones)
            </div>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <h3 class="cost"><span class="glyphicon glyphicon-usd"></span> US$ {{ $item->price }} <small class="pre-cost"><span class="glyphicon glyphicon-usd"></span> US$ 50.00 por persona</small></h3>
            <!--<div class="row pt-30">
              <div class="col-md-4 col-sm-6 col-xs-12">
                <select class="form-control" name="select">
                  <option value="" selected="">Hotel 4 Estrellas</option>
                  <option value="black">Sitio web</option>
                  <option value="white">Pasarela de pagos</option>
                  <option value="gold">Tienda online</option>
                  <option value="rose gold">Catálogo de productos</option>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <select class="form-control" name="select">
                  <option value="">Capacidad</option>
                  <option value="">16GB</option>
                  <option value="">32GB</option>
                  <option value="">64GB</option>
                  <option value="">128GB</option>
                </select>
              </div>
              <div class="col-md-4 col-sm-12">
                <select class="form-control" name="select">
                  <option value="" selected="">Paseo en Bote</option>
                  <option value="">1</option>
                  <option value="">2</option>
                  <option value="">3</option>
                </select>
              </div>
            -->
            </div>
            <div class="space-ten"></div>
            <br>
            <div class="btn-ground pt-4">
              <!--<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Anadir al carrito</button>-->
              <a href="{{ $item->reservation_link }}">
                <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-heart"></span> Reservar</button>
              </a>
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