<div class="table-responsive ">
    <table class="table table-hover ">
        <thead class="thead-dark">
            <tr>
              <th width="30px" class="text-center">#</th>
              <th >Cuenta</th>
              <th width="300px">Nombre</th>
              <th width="50px" class="text-center">Padre</th>
              <th width="40px" class="text-center"><i class="fas fa-edit"></i></th>
              <th width="40px" class="text-center"><i class="fas fa-trash"></i></th>
            </tr>
        </thead>
        <tbody>
                @foreach ($data as $key => $value)
                    <tr>
                       <td>{{$key+1}}</td>
                        <td >{{$value->account}}</td>
                        <td >{{$value->account_name}}</td>
                        <td>{{$value->parent}}</td>
                        <td>
                          <button type="button" wire:click="get({{$value->id}})"  class="btn btn-warning" data-mdb-toggle="modal" data-mdb-target="#edit-catalog">
                            <i class="fas fa-edit"></i>
                          </button>
                        </td>
                        <td>
                          <button wire:click="get({{$value->id}})" data-mdb-toggle="modal" data-mdb-target="#delete-catalog" type="button" class="btn btn-danger">
                        <i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                @endforeach

        </tbody>
    </table>
</div>



<div class="text-center">
  {{$data->links()}}
</div>
