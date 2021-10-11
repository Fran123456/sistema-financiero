<!-- Modal -->
<div wire:ignore.self  class="modal fade" id="create">
  <div class="modal-dialog " role='document'>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva cuenta contable</h5>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <input wire:model="account"  placeholder="Numero de la cuenta" type="number" class="form-control" />
            @error('account') <span class="text-danger">{{$message}}</span> @enderror
          </div>

          <div class="mb-4">
            <input wire:model="account_name"  placeholder="Nombre de la cuenta" type="text" class="form-control" />
            @error('account_name') <span class="text-danger">{{$message}}</span> @enderror
          </div>

          <div class="mb-4">
            <span class="text-success">Si no hay cuenta padre, agregue el valor de cero</span>
            <input wire:model="parent"  placeholder="Cuenta padre" type="text" class="form-control" />
            @error('parent') <span class="text-danger">{{$message}}</span> @enderror
          </div>
      </div>
      <div class="modal-footer">
      <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i></button>-->
        <button wire:click.prevent="store()"  data-bs-dismiss="modal"  class="btn btn-primary"><i class="fas fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
