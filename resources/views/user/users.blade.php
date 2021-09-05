<x-app-layout>
  <div class="row card">
    <!--componente de usuarios-->
      <div class="card-header"> <strong>{{strtoupper(__('manage users'))}}</strong>  </div>
      <div class="card-body">
        <p class="card-text">
          <livewire:users.users/>
        </p>
      </div>
    <!--componente de usuarios-->
  </div>

</x-app-layout>
