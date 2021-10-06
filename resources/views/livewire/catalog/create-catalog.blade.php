<!-- Modal -->
<div wire:ignore.self  class="modal fade" id="create-catalog">
  <div class="modal-dialog " role='document'>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo catalogo</h5>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <input wire:model="catalog"  placeholder="Nombre del catalogo" type="text" class="form-control" />
            @error('catalog') <span class="text-danger">{{$message}}</span> @enderror
          </div>
      </div>
      <div class="modal-footer">
      <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i></button>-->
        <button wire:click.prevent="store()"  data-bs-dismiss="modal"  class="btn btn-primary"><i class="fas fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
