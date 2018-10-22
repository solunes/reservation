@extends('master::layouts/admin')

@section('content')
  <h1>Nombre del problema: {{ $item->name }}</h1>
  	<table class="table">
			<tr class="title">
				 <td>Fecha</td>
				 <td>Estado</td>
				 <td>Contenido</td>
		  	</tr>
		  	@foreach( $item->reservation_issue_updates as $subitem )
		  	<tr>
		  		<td>{{ $subitem->created_at }}</td>
		  		<td>{{ $subitem->status }}</td>
		  		<td>{{ $subitem->content }}</td>
		  	</tr>
		  	@endforeach
		  	
		</table>
		<div class="col-sm-12">
			<div class="title">
				<h2>Observación</h2>
			</div>
			<div class="content">

			<p>Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una distribución más o menos normal de las letras, al contrario de usar textos como por ejemplo "Contenido aquí, contenido aquí". Estos textos hacen parecerlo un español que se puede leer. Muchos paquetes de autoedición y editores de páginas web usan el Lorem Ipsum como su texto por defecto, y al hacer una búsqueda de "Lorem Ipsum" va a dar por resultado muchos sitios web que usan este texto si se encuentran en estado de desarrollo. </p>

			</div>	

		</div>
		<p>Botón de iniciar, pausear, concluyes.</p>
		<button type="button" class="btn btn-default">Iniciar </button>
		<button type="button" class="btn btn-default">Pausear</button>
		<button type="button" class="btn btn-default">Concluido</button>
@endsection