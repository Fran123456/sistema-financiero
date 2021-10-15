
@if (session()->has('message'))
    <div class="alert alert-success" id="message">
      {{ __(session('message') , ['data'=> ucfirst(__('role'))]) }}
    </div>
@endif

@if (session()->has('message-destroy'))
    <div class="alert alert-danger" id="message-destroy">
      {{ __(session('message-destroy') , ['data'=> ucfirst(__('role'))]) }}
    </div>
@endif

@if (session()->has('message-update'))
    <div class="alert alert-warning" id="message-update">
      {{ __(session('message-update') , ['data'=> ucfirst(__('role')) ]) }}
    </div>
@endif

@if (session()->has('permissions-update'))
    <div class="alert alert-warning" id="message-update">
      {{ __(session('permissions-update') , ['data'=> ucfirst(__('Permissions')) ]) }}
    </div>
@endif

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success')  }}
</div>
@endif
