<x-app-layout>
  <div class="row card">
    <!--componente de roles y permisosS-->
      <div class="card-header"><strong>{{strtoupper(__('Manage roles and permissions'))}}</strong></div>
      <div class="card-body">
        <p class="card-text">
          <livewire:roles.roles/>                
        </p>        
      </div>
    <!--componente de roles y permisosS-->
  </div>
</x-app-layout>
