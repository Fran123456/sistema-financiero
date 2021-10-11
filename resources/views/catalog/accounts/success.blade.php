<x-app-layout>
  <div class="row card">

      <div class="card-header"> <strong>CATALOGO DE CUENTAS:  {{$catalog->catalog}} </strong>
      <br> <small>{{$catalog->company->company}}</small> </div>
      <div class="card-body">
        <p class="card-text">
          <strong><h4>Detalle de la exportación de cuentas contables</h4></strong>
          <h6>Cantidad de registros: {{$rows}}</h6>
          <h6>Cantidad de registros agregados correctamente: {{$succesfull}}</h6>
          <h6>Cantidad de registros con error: {{$error}}</h6>
          <a class="btn btn-success" href="{!! route('accounts-index', $catalog->id) !!}"><i class="fas fa-2x fa-hand-point-left"></i></a>
        </p>
      </div>
    <!--componente de usuarios-->
  </div>

</x-app-layout>
