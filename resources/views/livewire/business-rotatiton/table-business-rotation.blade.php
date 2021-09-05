<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
              <th width="30px" class="text-center">#</th>
              <th >Tipo de empresa</th>
              <th width="50px" class="text-center"><i class="fas fa-edit"></i></th>
              <th width="50px" class="text-center"><i class="fas fa-trash"></i></th>
            </tr>
        </thead>
        <tbody>
                @foreach ($business as $key => $data)
                    <tr>
                       <td>{{$key+1}}</td>
                        <td >{{$data->name}}</td>

                        <td>
                          <button type="button" wire:click="get({{$data->id}})"  class="btn btn-warning" data-mdb-toggle="modal" data-mdb-target="#edit-business">
                            <i class="fas fa-edit"></i>
                          </button>
                        </td>

                        <td>
                          <button wire:click="get({{$data->id}})" data-mdb-toggle="modal" data-mdb-target="#delete-business" type="button" class="btn btn-danger">
                        <i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                @endforeach

        </tbody>
    </table>
</div>

<div class="text-center">
  {{$business->links()}}
</div>
