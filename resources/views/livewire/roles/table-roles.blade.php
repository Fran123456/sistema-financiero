<div class="table-responsive">
  <table class="table table-hover">
    <thead class="thead-dark">
      <tr>
        <th scope="col" class="text-center" width="30px">#</th>
        <th scope="col" class="text-center">{{strtoupper(__('role'))}}</th>
        <th scope="col" class="text-center">{{strtoupper(__('Assigned users'))}}</th>      
        <th scope="col" class="text-center">{{strtoupper(__('Permissions'))}}</th>      
        <th width="70px" scope="col" class="text-center"><i class="fas fa-edit"></i></th>
        <th width="70px" scope="col" class="text-center"><i class="fas fa-trash"></i></th>      
      </tr>
    </thead>
    <tbody>
      @if ($roles->count())
          @foreach ($roles as $key => $role)
          <tr>
              <td scope="row">{{$key+1}}</td>
              <td class="text-center">{{$role->name}}</td>
              <td class="text-center">{{$role->conteo}}</td>            
              <td class="text-center">              
                @if(auth()->user()->can('retrieve_permissions'))              
                  <button type="button" wire:click="getRoleForPermissions({{$role->id}})"  class="btn btn-info" data-mdb-toggle="modal" data-mdb-target="#Modal-retrieve-permissions">
                    <i class="fas fa-eye"></i>
                  </button>
                @else
                  <button type="button" disabled class="btn btn-info">
                    <i class="fas fa-eye"></i>
                  </button>
                @endif
              </td>            
              <td class="text-center" >
                @if(auth()->user()->can('edit_roles'))              
                  <button type="button" wire:click="getRole({{$role->id}})"  class="btn btn-warning" data-mdb-toggle="modal" data-mdb-target="#exampleModal-edit">
                    <i class="fas fa-edit"></i>
                  </button>
                @else
                  <button type="button" disabled  class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                  </button>
                @endif
              </td>
              <td class="text-center" >
                @if(auth()->user()->can('delete_roles'))
                  @if ($role->conteo > 0)
                    <button disabled type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                  @else
                    <button wire:click="getRole({{$role->id}})" data-mdb-toggle="modal" data-mdb-target="#exampleModal-delete" type="button" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                    </button>
                  @endif
                @else
                <button disabled type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                @endif                
              </td>
          </tr>
          @endforeach
      @else
          <p class="card-text"><strong>{{ucfirst(__('Not results found for :data', ['data' => $search]))}}
          @if ($page>1)
          {{mb_strtolower(__('on page :data', ['data' => $page]),'UTF-8')}}</strong></p>
          @else
              </strong></p>
          @endif
      @endif
    </tbody>
  </table>
</div>
