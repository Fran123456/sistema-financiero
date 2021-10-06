<!-- Button trigger modal -->
<div  wire:ignore.self  class="modal fade" id="edit-catalog" tabindex="-1"  aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Actualiza el catalogo </h5>
        </div>
        <div class="modal-body">

          <input type="text" name="" hidden value="{{$idCatalog}}" wire:model="idCompany">
          <!-- name input -->
            <div class="mb-4">
            <label for=""><strong>Nombre del catalogo</strong></label>
              <input wire:model="catalog" value="{{$catalog}}"  type="text" class="form-control" />
              @error('catalog') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="modal-footer">
          <button wire:click.prevent="update()" data-bs-dismiss="modal"  class="btn btn-primary"><i class="fas fa-save"></i></button>
        </div>
      </div>
    </div>
  </div>
