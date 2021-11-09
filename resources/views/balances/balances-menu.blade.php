<x-app-layout>
<style media="screen">
.bg-primary {
    background-color: #5578b1!important;
}
.bg-success {
    background-color: #3e8b5d!important;
}
.bg-red {
    background-color: #8b4c42!important;
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


    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error')  }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif


    <!--componente de usuarios-->
      <div class="card-header"> <strong>MENU Y CONFIGURACIÓN DE BALANCES PARA: {{$company->company}}</strong>  </div>
      <div class="card-body">

        <div class="row">
          <div class="col-md-4">
              <div class="card bg-primary text-white" >
                <div class="card-body">
                  <h5 class="card-title">Cuentas / Estado de resultado</h5>
                  <p class="card-text">Configuración de cuentas contables para el estado de resultado</p>
                  <a href="{!! route('incomestatement-conf', $company->id) !!}" class="btn btn-info"><i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
          </div>


            <div class="col-md-4">
                <div class="card bg-red text-white" >
                  <div class="card-body">
                    <h5 class="card-title">Estados de resultado</h5>
                    <p class="card-text">Generar estados de resultado para peridos anuales, y visualizarlos</p>
                    <a href="{!! route('incomestatement', $company->id) !!}" class="btn btn-info"><i class="fas fa-arrow-right"></i></a>
                    <br><br>
                    <a href="{!! route('incomeAnalize', $company->id) !!}" class="btn btn-danger"><i class="fas fa-file-right"></i> Analisis H y V</a>
                  </div>
                </div>
            </div>

          <div class="col-md-4">
              <div class="card bg-success text-white" >
                <div class="card-body">
                  <h5 class="card-title">Cuentas / Balance general</h5>
                  <p class="card-text">Configuración de cuentas contables para el balance general</p>
                  <a href="{!! route('balanceSheet-conf', $company->id) !!}" class="btn btn-info"><i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
          </div>


          <div class="col-md-4">
              <div class="card bg-red text-white" >
                <div class="card-body">
                  <h5 class="card-title">Balance General</h5>
                  <p class="card-text">Generar balances generales para peridos anuales, y visualizarlos</p>
                  <a href="{!! route('balanceSheet', $company->id) !!}" class="btn btn-info"><i class="fas fa-arrow-right"></i></a>
                  <br><br>
                  <a href="{!! route('balanceAnalize', $company->id) !!}" class="btn btn-danger"><i class="fas fa-file-right"></i> Analisis H y V</a>
                </div>
              </div>
          </div>
        </div>

      </div>
    <!--componente de usuarios-->
  </div>
</x-app-layout>
