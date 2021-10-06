<div class="table-responsive ">
    <table class="table table-hover ">
        <thead class="thead-dark">
            <tr>
              <th width="30px" class="text-center">#</th>
              <th >Catalogo</th>
              <th width="300px">Usuario</th>
              <th width="50px" class="text-center">Cargar</th>
              <th width="40px" class="text-center"><i class="fas fa-edit"></i></th>
              <th width="40px" class="text-center"><i class="fas fa-trash"></i></th>
            </tr>
        </thead>
        <tbody>
                @foreach ($catalogs as $key => $data)
                    <tr>
                       <td>{{$key+1}}</td>
                        <td >{{$data->catalog}}</td>
                        <td >{{$data->user->name}}</td>
                        <td>
                          <a href="{!! route('accounts-index', $data->id) !!}" class="btn btn-success"><i class="fas fa-upload"></i></a>
                       </td>
                        <td>
                          <button type="button" wire:click="get({{$data->id}})"  class="btn btn-warning" data-mdb-toggle="modal" data-mdb-target="#edit-catalog">
                            <i class="fas fa-edit"></i>
                          </button>
                        </td>
                        <td>
                          <button wire:click="get({{$data->id}})" data-mdb-toggle="modal" data-mdb-target="#delete-catalog" type="button" class="btn btn-danger">
                        <i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                @endforeach

        </tbody>
    </table>
</div>



<div class="text-center">
  {{$catalogs->links()}}
</div>
