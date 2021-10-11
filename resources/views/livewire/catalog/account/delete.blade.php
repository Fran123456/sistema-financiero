<!-- Button trigger modal -->
<div  wire:ignore.self  class="modal fade" id="delete" tabindex="-1"  aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Elimina cuenta contable </h5>
        </div>
        <div class="modal-body">
          <h6>¿Desea eliminar la cuenta contable: <strong>{{$account}}</strong> ( {{$account_name}} )?</h6>
        </div>
        <div class="modal-footer">
          <button wire:click.prevent="destroy({{$id_account}})"  data-bs-dismiss="modal"  class="btn btn-danger"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    </div>
</div>
