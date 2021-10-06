<x-app-layout>
  <div class="row card">
    <!--componente de usuarios-->
      <div class="card-header"> <strong>CATALOGOS DE CUENTAS - {{$company->company}}</strong>  </div>
      <div class="card-body">
        <p class="card-text">
          @livewire('catalog.catalog' ,['companyId'=> $company->id])
        </p>
      </div>
    <!--componente de usuarios-->
  </div>

</x-app-layout>
