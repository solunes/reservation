@extends('master::layouts/admin')

@section('content')
	
  <h1>Wiki: {{ $item->name }}</h1>
 	<div class="col-sm-12">
 		<div class="col-sm-12"> 
	 	 {!! $item->content !!}
	  	</div>
	  <button type="button" class="btn btn-default"><a href= "{{ url('admin/model/default-task-howto/create?parameters={"f_created_at_from":null,"f_created_at_to":null}') }}"> Crear Wiki</a> </button>
  	</div>
@endsection