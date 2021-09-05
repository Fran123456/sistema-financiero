<div  wire:ignore.self  class="modal fade" id="Modal-retrieve-permissions" tabindex="-1" aria-labelledby="Modal-retrieve-permissions" aria-hidden="true">    
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">            
            <div class="modal-header">                                
                    @if ($selected_role != null)
                    <h5 class="modal-title" id="exampleModalLabel">{{ucfirst(__('Permissions for role :data',['data'=>$selected_role->name]))}}</h5>
                    @endif
                    <button wire:click="closingModal" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">            
                <div class="d-flex justify-content-center">
                    <div wire:loading>
                        <div class="spinner-border m-5 p-3" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>                    
                    </div>
                </div>                
                <div wire:loading.remove>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">{{__("Permissions' name")}}</th>
                                    <th class="text-center">{{__('Assigned')}}</th>
                                </tr>
                            </thead>                    
                            <tbody>
                                @if ($selected_role != null)
                                    @foreach ($permissions as $key => $permission)
                                        <tr>
                                            <td class="text-center">{{$permission->name}}</td>
                                            <td class="text-center">
                                            @if(auth()->user()->can('assign_permissions'))
                                                <input wire:model.defer="checkboxes.{{$key}}" type="checkbox" value="{{json_encode($permission)}}" id="{{$key}}">
                                            @else
                                                <input disabled wire:model.defer="checkboxes.{{$key}}" type="checkbox" value="{{json_encode($permission)}}" id="{{$key}}">
                                            @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                  
                <div wire:loading.remove>
                    <button wire:click="closingModal" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-arrow-left"></i></button>                
                </div>                
                <div wire:target="updateCheckbox">
                    <button wire:loading.remove wire:click="updateCheckbox" data-bs-dismiss="modal" class="btn btn-primary"><i class="fas fa-save"></i></button>
                </div>                
                <div wire:loading wire:target="updateCheckbox">
                    <button data-bs-dismiss="modal" class="btn btn-primary" disabled><i class="fas fa-save"></i></button>
                </div>
            </div>
        </div>
    </div>    
</div>
