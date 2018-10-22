@extends('master::layouts/admin')

@section('content')
  <h1>Wikis</h1>
  @if($filtered)
    <table class="table">
      <thead>
        <tr class="title">
          <td>Tipo de proyecto </td>
          <td>Contenido</td>
          <td>VER</td>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $item)
          <tr>
            <td>{{ $item->wiki_type->name }}</td>
            <td>{{ $item->name }}</td>
            <td class="edit"><a href="{{ url('admin/wiki/'.$item->id) }}">VER</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
  <table class="table">
      <thead>
        <tr class="title">
          <td>Nombre</td>
          <td>VER</td>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $item)
          <tr>
            <td>{{ $item->name }}</td>
            @if($reservation_type_id)
            <td class="edit"><a href="{{ url('admin/wikis/'.$reservation_type_id.'/'.$item->id) }}">VER</a></td>
            @else
            <td class="edit"><a href="{{ url('admin/wikis/'.$item->id) }}">VER</a></td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
 <button type="button" class="btn btn-default"><a href= "{{ url('admin/model/default-task-howto/create?parameters={"f_created_at_from":null,"f_created_at_to":null}') }}"> Crear Wiki</a> </button>
@endsection