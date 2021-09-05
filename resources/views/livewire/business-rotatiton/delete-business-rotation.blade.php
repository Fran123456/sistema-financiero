<!-- Button trigger modal -->
<div  wire:ignore.self  class="modal fade" id="delete-business" tabindex="-1"  aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Elimina giro empresarial </h5>
        </div>
        <div class="modal-body">
          <input type="text" name="" hidden value="{{$idBussineRotation}}" wire:model="role_id">
          <h5>¿Desea eliminar el giro empresarial: <strong>{{$name}}</strong> ?</h5>
        </div>
        <div class="modal-footer">
          <button wire:click.prevent="destroy({{$idBussineRotation}})"  data-bs-dismiss="modal"  class="btn btn-danger"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    </div>
</div>
