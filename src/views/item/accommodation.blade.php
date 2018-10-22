@extends('master::layouts/admin')

@section('content')
  <h1>Proyecto: {{ $item->name }}</h1>
  <p>Menu de proyecto con 4 tabs</p>

  @if($item->interval=='hour')
	  <table class="table">
	    <thead>
	      <tr class="title">
	        <td>Hora</td>
	        <td>Detalle</td>
	        <td>Costo</td>
	        <td>Cupos</td>
	        <td>VER</td>
	      </tr>
	    </thead>
	    <tbody>
	      @foreach($item->accommodation_items as $subitem)
	        <tr>
	          <td class="center" colspan="5">asdasdtd</td>
	        </tr>
	      	@foreach($item->accommodation_items as $subitem)
		        <tr>
		          <td>{{ $subitemsubitem->name }}</td>
		          <td>{{ $subitem->name }}</td>
		          <td>{{ $subitem->priority }}</td>
		          <td>{{ $subitem->presentation_date }} </td>
		          <td class="edit"><a href="{{ url('admin/accommodation/'.$subitem->id) }}">VER</a></td>
		        </tr>
	      	@endforeach
	      @endforeach
	    </tbody>
	  </table>
  @else
	  <table class="table">
	    <thead>
	      <tr class="title">
	        <td>Hora</td>
	        <td>Detalle</td>
	        <td>Costo</td>
	        <td>Cupos</td>
	        <td>VER</td>
	      </tr>
	    </thead>
	    <tbody>
	      @foreach($subitems as $item)
	        <tr>
	          <td>{{ $item->name }}</td>
	          <td>{{ $item->name }}</td>
	          <td>{{ $item->priority }}</td>
	          <td>{{ $item->presentation_date }} </td>
	          <td class="edit"><a href="{{ url('admin/accommodation/'.$item->id) }}">VER</a></td>
	        </tr>
	      @endforeach
	    </tbody>
	  </table>
  @endif
@endsection