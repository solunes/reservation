@extends('layouts/master')
@include('helpers.meta')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/reservation/reservation.css') }}">
@endsection

@section('content')
<div class="solunes-reservation">
	<div class="container">

		<div class="row">			

			<div class="col-md-6">
				<div class=" box-primary">					

					<div class="col-md-12">
						<h3 class="title-section">Detalle de su Reserva</h3>
					</div>

					<div class="col-md-12 padding-20">
						<div class="row border-box">
							<div class="col-md-9">
								<h5>Detalle</h5>
								<p>{{ $item->name }} / {{ $reservation->initial_date.' - '.$reservation->initial_time.' a '.$reservation->end_time }}  <strong class="product-quantity">(x{{ $reservation->counts }})</strong></p>
							</div>
							<div class="col-md-3">
								<h5>Total</h5>
								<p><strong>Bs. {{ $reservation->price }}</strong></p>
							</div>
							<div class="col-md-9">
								<h5>Precio total</h5>
							</div>
							<div class="col-md-3">
								<p><strong>Bs. {{ $reservation->price }}</strong></p>
							</div>				
						</div>							
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class=" box-primary">					
					
					@if(!$customer)
					<div class="col-md-12">
						<h3 class="title-section">Vía Redes Sociales</h3>
					</div>

					<div class="col-md-12 padding-20">
						<div class="border-box">
							<div class="store-form center">
								<p>Si deseas, puedes registrar tu cuenta con las redes sociales:</p>
								<a href="{{ url('auth/google') }}" class="auth-btn auth-btn-google"><button class="btn btn-google"><i class="fa fa-google"></i> Google Plus</button></a>
								<a href="{{ url('auth/facebook') }}" class="auth-btn auth-btn-facebook"><button class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</button></a>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<h3 class="title-section">Iniciar Sesión</h3>
					</div>

					<div class="col-md-12 padding-20">
						<div class="border-box">
							
							<p>Si ya tiene una cuenta de usuario, inicie sesión con su usuario y contraseña. Si no recuerda su
								contraseña, puede <a href="{{ url('account/recover-password/1596858') }}">recuperarla aquí</a>.</p>

								<form class="form-horizontal" method="post" action="{{ url('auth/login') }}">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-12 control-label">Email o Celular</label>									
										<input name="user" type="email" class="form-control" id="inputEmail3" placeholder="Email o Celular de Registro">									
									</div>
									
									<div class="form-group">
										<label for="inputPassword3" class="col-sm-12 control-label">Contraseña</label>
										<input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Contraseña">
									</div>

									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox"> Recuérdame
											</label>
										</div>
									</div>

									<div class="form-group">
										<button type="submit" class="btn">Iniciar Sesión</button>
									</div>
								</form>
							
						</div>
						@else
						@endif
					</div>

					<div class="col-md-12">
						<h3 class="title-section">Confirmar Datos</h3>
					</div>

					<div class="col-md-12 padding-20">
						<div class="border-box">
							  <form method="post" action="{{ url('reservations/finish-reservation') }}" class="form-horizontal">
								  <div class="form-group">
									  <label for="inputPassword3" class="col-sm-12 control-label">Nombre</label>
									  <div class="col-sm-12">
										  <input name="first_name" type="text" class="form-control" @if($customer) value="{{ $customer->first_name }}" @endif placeholder="Nombre" />
									  </div>
								  </div>
								  <div class="form-group">
									  <label for="inputPassword3" class="col-sm-12 control-label">Apellido</label>
									  <div class="col-sm-12">
										  <input name="last_name" type="text" class="form-control" @if($customer) value="{{ $customer->last_name }}" @endif placeholder="Apellido" />
									  </div>
								  </div>
								  @if(!$customer)
								  <div class="form-group">
									  <label for="inputPassword3" class="col-sm-12 control-label">Email</label>
									  <div class="col-sm-12">
										  <input name="email" type="email" class="form-control" @if($customer) value="{{ $customer->email }}" @endif placeholder="Email" />
									  </div>
								  </div>
								  <div class="form-group">
									  <label for="inputPassword3" class="col-sm-12 control-label">Teléfono</label>
									  <div class="col-sm-12">
										  <input name="cellphone" type="text" class="form-control" @if($customer) value="{{ $customer->ci_number }}" @endif placeholder="Teléfono" />
									  </div>
								  </div>
								  <div class="form-group">
									  <label for="inputPassword3" class="col-sm-12 control-label">Carnet de Identidad</label>
									  <div class="col-sm-12">
										  <input name="username" type="text" class="form-control" @if($customer) value="{{ $customer->ci_number }}" @endif placeholder="Carnet de Identidad" />
									  </div>
								  </div>
								  @endif
								  <div class="form-group">
									  <label for="inputPassword3" class="col-sm-12 control-label">Número de NIT</label>
									  <div class="col-sm-12">
										  <input name="nit_number" type="text" class="form-control" @if($customer) value="{{ $customer->nit_number }}" @endif placeholder="Número de NIT" />
									  </div>
								  </div>
								  <div class="form-group">
									  <label for="inputPassword3" class="col-sm-12 control-label">Razón Social</label>
									  <div class="col-sm-12">
										  <input name="nit_social" type="text" class="form-control" @if($customer) value="{{ $customer->nit_name }}" @endif placeholder="Razón Social" />
									  </div>
								  </div>
								  <div class="form-group">
									  <label for="inputPassword3" class="col-sm-12 control-label">Método de Pago</label>
									  <div class="col-sm-12">
      									{!! Form::select('payment_method_id', $payment_options, NULL, ['id'=>'payment_id','class'=>'form-control']) !!}
									  </div>
								  </div>
								  @if(!$customer)
								  <div class="form-group">
									  <label for="inputPassword3" class="col-sm-12 control-label">Contraseña</label>
									  <div class="col-sm-12">
										  <input name="password" type="password" class="form-control" placeholder="Contraseña" />
									  </div>
								  </div>
								  @endif
								  <div class="form-group">
									  <div class="col-sm-12">
										  <input type="hidden" name="accommodation_id" value="{{ $item->id }}" />
										  <input type="hidden" name="reservation_id" value="{{ $reservation->id }}" />
										  <button type="submit" class="btn btn-primary">Confirmar Reserva e ir a Pago</button>
									  </div>
								  </div>
							  </form>
						  </div>
					</div>
				</div>
			</div>

			<!-- <div class="col-md-6">
				<div class="order-block box-primary">
				  @if(!$customer)
					<h4 class="center">Vía Redes Sociales</h4>
					<div class="border-box">
						<div class="store-form center">
							<p>Si deseas, puedes registrar tu cuenta con las redes sociales:</p>
							<a href="{{ url('auth/google') }}" class="auth-btn auth-btn-google"><button class="btn btn-primary"><i class="fa fa-google"></i> Google Plus</button></a>
							<a href="{{ url('auth/facebook') }}" class="auth-btn auth-btn-facebook"><button class="btn btn-primary"><i class="fa fa-facebook"></i> Facebook</button></a>
						</div>
					</div>
					<h4 class="center">Iniciar Sesión</h4>
					<div class="border-box">
						<div class="store-form">
							<p>Si ya tiene una cuenta de usuario, inicie sesión con su usuario y contraseña. Si no recuerda su
								contraseña, puede <a href="{{ url('account/recover-password/1596858') }}">recuperarla aquí</a>.</p>
							<form class="form-horizontal" method="post" action="{{ url('auth/login') }}">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-12 control-label">Email o Celular</label>
									<div class="col-sm-12">
										<input name="user" type="email" class="form-control" id="inputEmail3" placeholder="Email o Celular de Registro">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-12 control-label">Contraseña</label>
									<div class="col-sm-12">
										<input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Contraseña">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<div class="checkbox">
											<label>
												<input type="checkbox"> Recuérdame
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-primary">Iniciar Sesión</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<h4 class="center">Registro de Cliente</h4>
				  @else
					<h4 class="center">Confirmar Datos</h4>
				  @endif

					
				</div>
			</div> -->
		</div>

	</div>
</div><!-- End container  -->
@endsection

@section('script')
@endsection