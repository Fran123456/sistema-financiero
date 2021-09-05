<!-- Button trigger modal -->
<div  wire:ignore.self  class="modal fade" id="exampleModal-edit" tabindex="-1"  aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__('Update role')}} </h5>
        </div>
        <div class="modal-body">
            {{--<div class="col-md-12">
              @if (session()->has('message-update-role-name-error'))
                  <div class="alert alert-warning" id="message-update">
                    {{ __(session('message-update-role-name-error')) }}
                  </div>
              @endif
            </div>--}}
          <input type="text" name="" hidden value="{{$role_id}}" wire:model="role_id">
          <!-- name input -->
            <div class="mb-4">
            <label for=""><strong>{{ucfirst(__("Role's name"))}}</strong></label>
              <input wire:model="role_name" value="{{$role_name}}" placeholder="{{strtolower(__('Role\'s name'))}}" type="text" class="form-control" />
              @error('role_name') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="modal-footer">
          <button wire:click.prevent="update()" data-bs-dismiss="modal"  class="btn btn-primary"><i class="fas fa-save"></i></button>
        </div>
      </div>
    </div>
  </div>
