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
        <li role="presentation" class="visited">
            <a href="#">
                <i class="icon-time"></i><span>Hora </span>
                <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70" style="display: none;">
                        <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#eed307" stroke-width="2" stroke-linecap="round" fill="transparent"></circle>
                        <polyline id="successAnimationCheck" stroke="#eed307" stroke-width="2" points="23 36 32 44 47 27" fill="transparent"></polyline>
                    </svg>
            </a>
        </li>
        <li role="presentation" class="active">
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
        <div role="tabpanel" class="tab-pane active" id="tab4">

          <div class="content-types row">
              <div class="col-sm-12">
                <div class="card">
                    <div class="card-title center">
                        <h3>POR FAVOR, CONFIRME SUS DATOS</h3>
                    </div>
                    <hr class="margin-nis">
                    <div class="card-content border-middle-type">
                        <div class="row margin-0">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <form class="form-brd">
                                    <div class="item-form">
                                        <label>Nombre: <span class="required">*</span></label>
                                        <input type="" name="" placeholder="Introduzca su nombre">
                                    </div>
                                    <div class="item-form">
                                        <label>Email: <span class="required">*</span></label>
                                        <input type="" name="" placeholder="Introduzca dirección email">
                                    </div>
                                    <div class="item-form">
                                        <label>Teléfono <span class="required">*</span></label>
                                        <input type="" name="" placeholder="Introducir número de teléfono">
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="content_max">
                                    <div class="title_brd content-items_brd">
                                        {{ $item->name }}
                                    </div>
                                    <table class="content-items_brd">
                                        <tr>
                                            <td class="item-brd">Fecha:</td>
                                            <td class="item-brd"><strong>{{ $reservation->initial_date }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="item-brd">Empieza a las:</td>
                                            <td class="item-brd"><strong>{{ $reservation->initial_time }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="item-brd">Proveedor / Lugar:</td>
                                            <td class="item-brd"><strong>{{ $provider->name }}</strong></td>
                                        </tr>
                                    </table>
                                    <div class="content-items_brd">
                                        <div class="check-content">
                                            <div class="check-type_2">
                                                <input type="checkbox" name="accept_terms">
                                                <label class="check-btn"></label>
                                            </div>
                                            <label class="label-check"><a href="#">Acepto los Términos y condiciones de uso</a> <span class="required">*</span></label>
                                        </div>
                                    </div>
                                    <div class="content-items_brd">
                                        <div class="check-content">
                                            <input type="checkbox" name="send_newsletter" id="other-options">
                                            <label class="check-btn"></label>
                                            <label for="other-options" class="label-check">¿Podemos enviarle promociones e información?</label>
                                        </div>
                                    </div>
                                    <div class="content-items_brd">
                                        <a href="#" class="btn_reservations">Reservar</a>
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
    </div>
</section>

@endsection

@section('script')
@endsection