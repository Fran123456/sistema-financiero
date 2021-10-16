<style media="screen">
.table>:not(caption)>*>* {
  padding: 0.5rem 0.4rem;
  -webkit-transition: background-color .2s ease-in;
  transition: background-color .2s ease-in;
  background-image: none;
  background-color: var(--bs-table-accent-bg);
}
</style>
@foreach ($incomeStatementConf as $key => $value)
  <h5>{{$value->title}}</h5>
  <div class="table table-sm">
      <table class="table table-hover ">
          <thead class="thead-dark">
              <tr>
                <th width="30px" class="text-center">#</th>
                <th >Cuenta</th>
                <th >Nombre cuenta</th>
                <th width="50px" class="text-center"><i class="fas fa-trash"></i></th>
              </tr>
          </thead>
          <tbody>
                  @foreach ($value->getIncomentStatementConfByCompany($company_id,$value->id, $catalog_id) as $key => $data)
                      <tr>
                         <td>{{$key+1}}</td>
                         <td >{{$data->account->account}}</td>
                         <td >{{$data->title}}</td>
                          <td>
                            <button wire:click="destroy({{$data->id}})" data-mdb-toggle="modal" data-mdb-target="#delete-business" type="button" class="btn btn-danger">
                          <i class="fas fa-trash"></i></button>
                        </td>
                      </tr>
                  @endforeach

          </tbody>
      </table>
  </div>

@endforeach
