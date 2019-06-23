<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <style>
      body { font-family: 'Montserrat', sans-serif; }
      h1 { font-family: 'Oswald', sans-serif; }
      table { width: 100%; text-align: center; border-top: 1px solid #ddd; border-left: 1px solid #ddd; }
      table thead, table tfoot { font-weight: bold; }
      table td { border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 10px; }
      .col-sm-6 { width: 49%; display: inline-block; }
      .block { display: inline-block; margin-left: 1%; margin-right: 1%; width: auto; margin-bottom: 30px; text-align: center; width: 30%; }
      .block img { margin-bottom: 10px; }
    </style>
</head>
<body style="margin:0; padding:0;">
  <h1>DETALLES DE LA RESERVA</h1>
  <p><strong>Titular de la Reserva: </strong> {{ $item->customer->name }}</p>
  <p><strong>Número de Reserva: </strong> #{{ $item->id }}</p>
  <p><strong>Monto Total: </strong> {{ $item->currency->name }} {{ $item->amount }}</p>
  <div class="row">
    <div class="col-sm-6">
      <p><strong>Ingreso: </strong> {{ $item->initial_date }} {{ $item->initial_time }}</p>
      <p><strong>Salida: </strong> {{ $item->end_date }} {{ $item->end_time }}</p>
    </div>
    <div class="col-sm-6">
      @if($item->invoice_number)
        <p><strong>NIT: </strong> {{ $item->invoice_number }}</p>
      @endif
      @if($item->invoice_number)
        <p><strong>Razón Social: </strong> {{ $item->invoice_name }}</p>
      @endif
    </div>
  </div>
  <p><strong>Personas:</strong> </p>
  <table>
    <thead>
      <tr>
        <td>#</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>Precio</td>
      </tr>
    </thead>
    <tbody>
      @foreach($item->reservation_users as $key => $reservation_user)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $reservation_user->first_name }}</td>
        <td>{{ $reservation_user->last_name }}</td>
        <td>{{ $item->currency->name }} {{ $item->price }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td></td>
        <td>TOTAL</td>
        <td>{{ $item->currency->name }} {{ $item->amount }}</td>
      </tr>
    </tfoot>
  </table>
  <br>
</body>
</html>