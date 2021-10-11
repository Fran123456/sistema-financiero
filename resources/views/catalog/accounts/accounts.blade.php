<x-app-layout>
  <div class="row card">
    <!--componente de usuarios-->
      <div class="card-header"> <strong>CATALOGO DE CUENTAS:  {{$catalog->catalog}} </strong>
      <br> <small>{{$catalog->company->company}}</small> </div>
      <div class="card-body">
        <p class="card-text">

            @if (count($accounts)>0)
              @livewire('catalog.account' ,['catalog_id'=> $catalog->id])
            @else
              <div class="container">
                <div class="row">
                  <div class="col-md-2">
                    <a class="btn btn-success" href="{{$help->url()}}docs/plantilla-cuentas-contables.xlsx"><i class="fas fa-2x fa-download"></i> Plantilla</a>
                  </div>
                  <div class="col-md-10">
                    <form method="post" enctype="multipart/form-data" action="{!! route('accounts-upload') !!}">
                       @csrf
                      <input type="hidden" name="catalogId" value="{{$catalog->id}}">
                      <input type="hidden" name="companyId" value="{{$catalog->company->id}}">
                      <div class="form-group">
                        <label for="exampleFormControlFile1">Ingresa el archivo excel con las cuentas contables</label>
                        <input name="excel" required type="file" accept=".xlsx"  class="form-control-file" >
                      </div>
                      <button type="submit" name="button" class="btn btn-info">SUBIR</button>
                    </form>
                  </div>
                </div>
              </div>
            @endif
        </p>
      </div>
    <!--componente de usuarios-->
  </div>

</x-app-layout>
