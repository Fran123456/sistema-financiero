<x-app-layout>
<style media="screen">
.bg-primary {
    background-color: #5578b1!important;
}
.bg-success {
    background-color: #3e8b5d!important;
}
</style>
  <div class="row">
   <div class="col-md-12">
     <nav aria-label="breadcrumb">
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{!! route('company-index') !!}">Empresas</a></li>
         <li class="breadcrumb-item active" aria-current="page">Configuración y balances de {{$company->company}}</li>
       </ol>
     </nav>
   </div>
  </div>


  <div class="row card">
    <!--componente de usuarios-->
      <div class="card-header"> <strong>MENU Y CONFIGURACIÓN DE BALANCES PARA: {{$company->company}}</strong>  </div>
      <div class="card-body">

        <div class="row">
          <div class="col-md-4">
              <div class="card bg-primary text-white" >
                <div class="card-body">
                  <h5 class="card-title">Cuentas / Balance comprobacion</h5>
                  <p class="card-text">Configuración de cuentas contables para el balance de comprobación</p>
                  <a href="#" class="btn btn-info"><i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
          </div>

          <div class="col-md-4">
              <div class="card bg-success text-white" >
                <div class="card-body">
                  <h5 class="card-title">Cuentas / Balance general</h5>
                  <p class="card-text">Configuración de cuentas contables para el balance general</p>
                  <a href="#" class="btn btn-info"><i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
          </div>
        </div>

      </div>
    <!--componente de usuarios-->
  </div>
</x-app-layout>
