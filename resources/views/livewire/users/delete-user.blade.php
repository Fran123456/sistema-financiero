<!-- Button trigger modal -->


  <div  wire:ignore.self  class="modal fade" id="exampleModal-delete" tabindex="-1"  aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__('Delete user')}} </h5>

        </div>
        <div class="modal-body">
          <input type="text" name="" hidden value="{{$idUser}}" wire:model="idUser">
          <h5>{{__('Do you want to remove user :data from the system?', ['data'=>$name])}}</h5>

        </div>
        <div class="modal-footer">
          <button wire:click.prevent="destroy({{$idUser}})"  data-bs-dismiss="modal"  class="btn btn-danger"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    </div>
  </div>
