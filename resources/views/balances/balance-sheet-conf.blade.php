<x-app-layout>


  <div class="row">
   <div class="col-md-12">
     <nav aria-label="breadcrumb">
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{!! route('company-index') !!}">Empresas</a></li>
         <li class="breadcrumb-item"><a href="{!! route('balances-menu', $company->id) !!}">Configuración de balances {{$company->company}}</a></li>
         <li class="breadcrumb-item active" aria-current="page">Balance general para:  {{$company->company}}</li>
       </ol>
     </nav>
   </div>
  </div>


  <div class="row card">
    <!--componente de usuarios-->
      <div class="card-header"> <strong>CONFIGURACIÓN</strong>  </div>
      <div class="card-body">
        <p class="card-text">
         @livewire('balance.balance-sheet-conf' ,['company_id'=> $company->id])
        </p>
      </div>
    <!--componente de usuarios-->
  </div>

</x-app-layout>
