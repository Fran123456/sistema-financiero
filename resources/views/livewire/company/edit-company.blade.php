<!-- Button trigger modal -->
<div  wire:ignore.self  class="modal fade" id="edit-company" tabindex="-1"  aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Actualiza empresa </h5>
        </div>
        <div class="modal-body">

          <input type="text" name="" hidden value="{{$idCompany}}" wire:model="idCompany">
          <!-- name input -->
            <div class="mb-4">
            <label for=""><strong>Nombre de la empresa</strong></label>
              <input wire:model="name" value="{{$name}}"  type="text" class="form-control" />
              @error('name') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="mb-4">
              <label> <strong>Giro {{$bussinesId}}</strong> </label>
              <select  wire:model="bussinesId" class="form-control">
                @foreach ($business as $key => $value)
                    <option @if (!$value->id==$bussinesId) selected  @endif  value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>



            </div>
        </div>
        <div class="modal-footer">
          <button wire:click.prevent="update()" data-bs-dismiss="modal"  class="btn btn-primary"><i class="fas fa-save"></i></button>
        </div>
      </div>
    </div>
  </div>
