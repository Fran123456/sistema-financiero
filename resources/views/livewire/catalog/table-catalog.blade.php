<style media="screen">
  .bgnew{
    background-color: #f3e1be!important;
  }
</style>
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
              <th width="40px" class="text-center"></th>
            </tr>
        </thead>
        <tbody>
                @foreach ($catalogs as $key => $data)
                    <tr @if ($data->status)
                      class="bgnew"
                    @endif>
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
                      <td>
                        @if ($data->status)
                          <a class="btn btn-danger" href="{!! route('catalog-change', $data->id) !!}" class=""><i class="fas fa-times"></i></a>
                        @else
                          <a class="btn btn-success" href="{!! route('catalog-change', $data->id) !!}" class=""><i class="fas fa-check"></i></a>
                        @endif


                      </td>
                    </tr>
                @endforeach

        </tbody>
    </table>
</div>



<div class="text-center">
  {{$catalogs->links()}}
</div>
