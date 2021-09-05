<div>
  <div class="col-md-12">

    @if (session()->has('message'))
        <div class="alert alert-success" id="message">
          {{ __(session('message') , ['data'=> 'Usuario']) }}
        </div>
    @endif

    @if (session()->has('message-destroy'))
        <div class="alert alert-danger" id="message-destroy">
          {{ __(session('message-destroy') , ['data'=> 'Usuario']) }}
        </div>
    @endif

    @if (session()->has('message-update'))
        <div class="alert alert-warning" id="message-update">
          {{ __(session('message-update') , ['data'=> 'Usuario']) }}
        </div>
    @endif
  </div>
  <!--form add users-->
  <div class="col-md-12 text-right">
    @include('livewire.users.create-user')
  </div>
  <!--form add users-->
  <!--table-->
  <div class="col-md-12">
    @include('livewire.users.table-users')
  </div>

    <div class="text-center">
      {{$users->links()}}
    </div>


  <div class="col-md-12">
    @include('livewire.users.edit-user')
    @include('livewire.users.delete-user')
  </div>
  <!--table-->


  <script type="text/javascript">
    Livewire.on('send',() => {
        removeModal("#exampleModal");
        setTimeout(function(){$("#message").fadeOut('slow');}, 2000);
    })

    Livewire.on('destroy',() => {
      removeModal('#exampleModal-destroy');
      setTimeout(function(){$("#message-destroy").fadeOut('slow');}, 2000);
    })

    Livewire.on('update',() => {
      removeModal('#exampleModal-update');
      setTimeout(function(){$("#message-update").fadeOut('slow');}, 2000);
    })

     function removeModal(id){
      $(id).modal('hide');
      $('.modal-backdrop').removeClass('show');
      $('.modal-backdrop').addClass('hide');
      $('.modal').removeClass('show');
      $('.modal').addClass('hide');
    }
  </script>



</div>
