<!-- Button trigger modal -->
<div  wire:ignore.self  class="modal fade" id="delete-catalog" tabindex="-1"  aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Elimina catalogo </h5>
        </div>
        <div class="modal-body">
          <h5>¿Desea eliminar el catalogo: <strong>{{$catalog}}</strong> ?</h5>
        </div>
        <div class="modal-footer">
          <button wire:click.prevent="destroy({{$idCatalog}})"  data-bs-dismiss="modal"  class="btn btn-danger"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    </div>
</div>
