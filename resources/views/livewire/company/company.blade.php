<div>

    <!--ARCHIVO BLADE QUE MANEJA LOS MENSAJES DE AGREGADO, ELIMINADO, EDITADO-->
    <div class="col-md-12">
      @include('livewire.business-rotatiton.messages')
    </div>
    <!--ARCHIVO BLADE QUE MANEJA LOS MENSAJES DE AGREGADO, ELIMINADO, EDITADO-->

      <div class="col-md-12">
        <div class="row mb-2">
          <!--BARRA PARA BUSQUEDA-->
          <div class="col-md-11">
            <input type="text"  class="form-control" placeholder="Buscar" wire:model.debounce.150ms="search" />
          </div>
          <!--BARRA PARA BUSQUEDA-->
          <!--BOTON PARA AGREGAR CONTENIDO-->
          <div class="col-md-1">
            <button type="button" wire:click="clean" class="btn btn-primary mb-2" data-toggle="modal" data-target="#create-company">
              <i class="fas fa-plus"></i>
            </button>
          </div>
          <!--BOTON PARA AGREGAR CONTENIDO-->
        </div>
      </div>


        <div class="col-md-12">
          <!--SE IMPRIME LA TABLA DE CONTENIDO-->
           @include('livewire.company.table-company')
           <!--SE IMPRIME LA TABLA DE CONTENIDO-->
        </div>

        <!--SE INCLUYE LOS ARCHIVOS BLADE ADICIONALES PARA MOSTRAR MODALES COMO AGREGAR, ELIMINAR, EDITAR-->
        <div class="col-md-12">
             @include('livewire.company.create-company')
             @include('livewire.company.delete-company')
             @include('livewire.company.edit-company')
        </div>
        <!--SE INCLUYE LOS ARCHIVOS BLADE ADICIONALES PARA MOSTRAR MODALES COMO AGREGAR, ELIMINAR, EDITAR-->


        <script type="text/javascript">
            Livewire.on('send',() => {
                removeModal("#create-company");
                setTimeout(function(){$("#message").fadeOut('slow');}, 2000);
            })

            Livewire.on('destroy',() => {
              removeModal('#delete-company');
              setTimeout(function(){$("#message-destroy").fadeOut('slow');}, 2000);
            })

            Livewire.on('update',() => {
              removeModal('#edit-company');
              setTimeout(function(){$("#message-update").fadeOut('slow');}, 2000);
            })
        </script>
  </div>
