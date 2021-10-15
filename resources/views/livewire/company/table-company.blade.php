<div class="table-responsive ">
    <table class="table table-hover ">
        <thead class="thead-dark">
            <tr>
              <th width="30px" class="text-center">#</th>
              <th >Empresa</th>
              <th width="300">Giro</th>
              <th width="50px" class="text-center">BALANCES</th>
              <th width="50px" class="text-center">CATALOGOS</th>
              <th width="40px" class="text-center"><i class="fas fa-edit"></i></th>
              <th width="40px" class="text-center"><i class="fas fa-trash"></i></th>
            </tr>
        </thead>
        <tbody>
                @foreach ($companies as $key => $data)
                    <tr>
                       <td>{{$key+1}}</td>
                        <td >{{$data->company}}</td>
                        <td >{{$data->BusinessRotation->name}}</td>
                        <td>
                          <a href="{!! route('balances-menu', $data->id) !!}" class="btn btn-secondary"><i class="fas fa-file-invoice"></i></a>
                        </td>
                        <td>
                          <a href="{!! route('catalog-index', $data->id) !!}" class="btn btn-success"><i class="fas fa-file-invoice"></i></a>
                       </td>
                        <td>
                          <button type="button" wire:click="get({{$data->id}})"  class="btn btn-warning" data-mdb-toggle="modal" data-mdb-target="#edit-company">
                            <i class="fas fa-edit"></i>
                          </button>
                        </td>

                        <td>
                          <button wire:click="get({{$data->id}})" data-mdb-toggle="modal" data-mdb-target="#delete-company" type="button" class="btn btn-danger">
                        <i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                @endforeach

        </tbody>
    </table>
</div>



<div class="text-center">
  {{$companies->links()}}
</div>
