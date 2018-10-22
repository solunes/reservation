
<div class="col-sm-12">
	<table class="table">
		<tr class="title">
			<td>Nombre</td>
			<td>Detalle</td>
			<td>VER</td>
		</tr>	
		@foreach($item->reservation_issues as $subitem)	

		<tr>
			<td>{{$subitem->name}}</td>
			<td>{{ $subitem->content }}</td>
			<td class="edit"><a href=" {{ url('admin/reservation-issue/'.$subitem->id) }} ">VER</td>

		</tr>
		@endforeach
	</table>
	<button type="button" class="btn btn-default"><a href= "{{ url('admin/model/default-task-howto/create?parameters={"f_created_at_from":null,"f_created_at_to":null}') }}">Crear Problema</a> </button>



</div>