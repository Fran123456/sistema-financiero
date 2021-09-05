<!-- Button trigger modal -->
<div  wire:ignore.self  class="modal fade" id="exampleModal-delete" tabindex="-1"  aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__('Delete role')}} </h5>
        </div>
        <div class="modal-body">
          <input type="text" name="" hidden value="{{$role_id}}" wire:model="role_id">
          <h5>{{__('Do you want to remove role :data from the system?', ['data'=>$role_name])}}</h5>
        </div>
        <div class="modal-footer">
          <button wire:click.prevent="destroy({{$role_id}})"  data-bs-dismiss="modal"  class="btn btn-danger"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    </div>
</div>
