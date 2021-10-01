<!-- Modal -->
<div wire:ignore.self  class="modal fade" id="create-company">
  <div class="modal-dialog " role='document'>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Empresa</h5>
      </div>
      <div class="modal-body">
          <div class="mb-4">
            <input wire:model="name"  placeholder="Nombre de la empresa" type="text" class="form-control" />
            @error('name') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="mb-4">
            <label>Giro</label>
            <select  wire:model="bussinesId" class="form-control">
              <option value="" disabled selected>Seleccione...</option>
              @foreach ($business as $key => $value)
                  <option @if ($bussinesId ==null && $key==0)  selected @endif value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
              @error('bussinesId') <span class="text-danger">{{$message}}</span> @enderror
          </div>
      </div>
      <div class="modal-footer">
      <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i></button>-->
        <button wire:click.prevent="store()"  data-bs-dismiss="modal"  class="btn btn-primary"><i class="fas fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
