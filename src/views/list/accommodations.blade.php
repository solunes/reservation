@extends('master::layouts/admin')

@section('content')
  <h1>Reservas</h1>

  <table class="table">
    <thead>
      <tr class="title">
        <td>Nombre</td>
        <td>Tipo de proyecto</td>
        <td>Prioridad</td>
        <td>Presentacion</td>
        <td>Estado</td>
        <td>VER</td>
      </tr>
    </thead>
    <tbody>
      @foreach($items as $item)
        <tr>
          <td>{{ $item->name }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->priority }}</td>
          <td>{{ $item->presentation_date }} </td>
          <td> {{ $item->status }} </td>
          <td class="edit"><a href="{{ url('admin/accommodation/'.$item->id) }}">VER</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <button type="button" class="btn"><a href= "{{ url('admin/model/reservation/create?parameters={"f_created_at_from":null,"f_created_at_to":null}') }}"> Crear Proyecto</a> </button>

@endsection