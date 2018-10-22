@extends('master::layouts/admin')

@section('content')

  <h1>Gestión de Proyectos</h1>

  <div class="row">
    <div class="col-sm-6">
    	<h2>Tareas de proyecto</h2>
    	
	       @foreach($tasks as $item)
	       <div class="row">
		       	<div class="col-sm-12">
			        <h3>Proyecto :{{ $item->reservation->name }}</h3>
			        <ul>
				        <li>Tarea de Proyecto : {{ $item->name }}</li>
				        <li>Detalle de tarea :{{ $item->observations }}</li>
					</ul> 
					<button type="button" class="btn btn-default"><a href="#"> Iniciar</a></button> 
					<button type="button" class="btn btn-default"><a href="#">Pausear</a></button>  
					<button type="button" class="btn btn-default"><a href="#">Concluido</a></button>
				</div>
			</div> 
	      @endforeach
  		
    </div>
    <div class="col-sm-6">
    	<h2>Problemas</h2>
    	<table class="table">
		    <thead>
		      <tr class="title">
		        <td>Problema</td>
		        <td>VER</td> 
		      </tr>
		    </thead>
		    <tbody>
	    		@foreach($active_reservation_issues as $item)
		      	<tr>
		          <td colspan="2">{{ $item->name }}</td>
		        </tr>
		    		@foreach($item->active_reservation_issues as $subitem)
			      	<tr>
			          <td>{{ $subitem->name }}</td>		          
			          <td class="edit"><a href="{{ url('admin/reservation-issue/'.$subitem->id) }}">VER</a></td>
			        </tr>
			      	@endforeach
	      		@endforeach
      		</tbody>
		  </table>
		     
    </div>
  </div>

@endsection