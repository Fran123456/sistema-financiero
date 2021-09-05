<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('New role')}}</h5>
      </div>
      <div class="modal-body">        
      {{--<div class="col-md-12">
              @if (session()->has('message-create-role-name-error'))
                  <div class="alert alert-warning" id="message-update">
                    {{ __(session('message-create-role-name-error')) }}
                  </div>
              @endif
      </div>--}}
        <!-- name input -->
          <div class="mb-4">
            <input wire:model="role_name"  placeholder="{{strtolower(__('Role\'s name'))}}" type="text" class="form-control" />
            @error('role_name') <span class="text-danger">{{$message}}</span> @enderror
          </div>                    
      </div>
      <div class="modal-footer">
      <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i></button>-->
        <button wire:click.prevent="store()"  data-bs-dismiss="modal"  class="btn btn-primary"><i class="fas fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
