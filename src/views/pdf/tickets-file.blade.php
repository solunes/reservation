<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <style type="text/css">
      body { font-family: 'Montserrat', sans-serif; }
      h1, h2, h3 { font-family: 'Oswald', sans-serif; font-weight: normal; }
      .img-responsive { margin: 0; padding: 0; width: 100%; height: auto; }
      .page-break { display:block; clear:both; page-break-after: always;}
      .row { width: 100%; display: block; }
      .col { width: 49.8%; display: inline-block; margin: 0; padding: 0; position: relative; }
      .col img { width: 99.5%; height: auto; display: inline; margin: 0; padding: 0; }
      .overlay { position: absolute; top: 20%; left: 10%; width: 80%; display: block; text-align: center; }
      .bottom .col img {  -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -o-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); filter: progid:DXImageTransform.Microsoft.Matrix(M11=-1, M12=0, M21=0, M22=-1, DX=0, DY=0, SizingMethod='auto expand'); }
      table { width: 100%; text-align: center; }
      table thead, table tfoot { font-weight: bold; }
      .right { text-align: right; }
      .left { text-align: left; }
      tr { margin-bottom: 0; }
      td { width: 50%; }
      h2 { margin-bottom: 5px; margin-top: 10px; }
      h3 { margin-bottom: 2px; margin-top:  0; }
      .subtitle { color: #555; margin-top: 15px; margin-bottom: 20px; font-size: 20px; }
      h4 { margin-top: 0px; margin-bottom: 10px; font-weight: normal; }
    </style> 
</head>
<body style="margin:0; padding:0;" >
  @foreach($item->reservation_users as $reservation_user)
  <div class="page">
    <div class="row">
      <div class="col right">
        @if($item->accommodation->image_ad)
          <img class="img-responsive" src="{{ asset(\Asset::get_image_path('accommodation','thumb', $item->accommodation->image_ad)) }}" />
        @else
          <img class="img-responsive" src="{{ asset(config('reservation.reservation_image_ad')) }}" />
        @endif
      </div>
      <div class="col left">
        <div class="overlay">
          <h2 class="right">Boleto #50{{ $reservation_user->id }}</h2>
          <h2>{{ $reservation_user->name }}</h2>
          <h3 class="subtitle">{{ $item->accommodation->name }}</h3>
          <table>
            <tbody>
              <tr>
                <td class="left">
                  <h3>Fecha de Inicio:</h3>
                  <h4>{{ date('d/m/Y', strtotime($item->initial_date)) }}</h4>
                  <h3>Hora de Inicio:</h3>
                  <h4>{{ $item->initial_time }}</h4>
                  <h3>Precio:</h3>
                  <h4>{{ $item->currency->code.' '.$item->price }}</h4>
                </td>
                <td>
                  <img class="img-responsive" src="data:image/png;base64, {{ base64_encode(\QrCode::format('png')->margin(0)->size(500)->generate(\Crypt::encrypt($reservation_user->id))) }} ">
                  <h3>{{ \Reservation::hex_encode($reservation_user->id) }}</h3>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @if($item->accommodation->image_ticket)
          <img class="img-responsive" src="{{ asset(\Asset::get_image_path('accommodation','thumb', $item->accommodation->image_ticket)) }}" />
        @else
          <img class="img-responsive" src="{{ asset(config('reservation.reservation_image_ticket')) }}" />
        @endif
      </div>
    </div>
    <div class="row bottom">
      <div class="col right">
        @if($item->accommodation->image_terms)
          <img class="img-responsive" src="{{ asset(\Asset::get_image_path('accommodation','thumb', $item->accommodation->image_terms)) }}" />
        @else
          <img class="img-responsive" src="{{ asset(config('reservation.reservation_image_terms')) }}" />
        @endif
      </div>
      <div class="col left">
        @if($item->accommodation->image_schedule)
          <img class="img-responsive" src="{{ asset(\Asset::get_image_path('accommodation','thumb', $item->accommodation->image_schedule)) }}" />
        @else
          <img class="img-responsive" src="{{ asset(config('reservation.reservation_image_schedule')) }}" />
        @endif
      </div>
    </div>
  </div>
  @endforeach
</body>
</html>