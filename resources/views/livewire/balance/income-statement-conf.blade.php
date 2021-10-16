<div>
    <!--ARCHIVO BLADE QUE MANEJA LOS MENSAJES DE AGREGADO, ELIMINADO, EDITADO-->
    <div class="col-md-12">
      @include('livewire.business-rotatiton.messages')
    </div>
    <!--ARCHIVO BLADE QUE MANEJA LOS MENSAJES DE AGREGADO, ELIMINADO, EDITADO-->

    <div class="row">
      <div class="col-md-4">
        @include('livewire.balance.income-statement-conf.form')
      </div>
      <div class="col-md-8">
          @include('livewire.balance.income-statement-conf.table')
      </div>
    </div>
        <script type="text/javascript">
            Livewire.on('send',() => {
                setTimeout(function(){$("#message").fadeOut('slow');}, 2000);
            })

            Livewire.on('destroy',() => {
              setTimeout(function(){$("#message-destroy").fadeOut('slow');}, 2000);
            })

            Livewire.on('update',() => {
              setTimeout(function(){$("#message-update").fadeOut('slow');}, 2000);
            })
        </script>
  </div>
