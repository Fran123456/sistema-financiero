<!-- Button trigger modal -->
<div  wire:ignore.self  class="modal fade" id="delete-company" tabindex="-1"  aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Elimina empresa </h5>
        </div>
        <div class="modal-body">
          <h5>¿Desea eliminar la empresa: <strong>{{$name}}</strong> ?</h5>
        </div>
        <div class="modal-footer">
          <button wire:click.prevent="destroy({{$idCompany}})"  data-bs-dismiss="modal"  class="btn btn-danger"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    </div>
</div>
