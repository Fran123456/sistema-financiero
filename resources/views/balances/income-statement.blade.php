<x-app-layout>
 <style media="screen">
}

.label-ti {
    display: inline-block;
    margin-bottom: 0.1rem;
}
 hr {
  margin: 0.5rem 0, 0.4rem, 0;
  color: inherit;
  background-color: currentColor;
  border: 0;
  opacity: .25;
}
 </style>

<script type="text/javascript">
let ventas = [];
let costos = [];
let gastos = [];
</script>


  <div class="row">
   <div class="col-md-12">
     <nav aria-label="breadcrumb">
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{!! route('company-index') !!}">Empresas</a></li>
         <li class="breadcrumb-item"><a href="{!! route('balances-menu', $company->id) !!}">Menu de configuración</a></li>
         <li class="breadcrumb-item active" aria-current="page">Estados de resultado de: {{$company->company}}</li>
       </ol>
     </nav>
   </div>
  </div>

  <div class="row card">
    <!--componente de usuarios-->
      <div class="card-header"> <strong>ESTADOS DE RESULTADO - {{$company->company}}</strong>  </div>
      <div class="card-body">
        <div class="row">


          @if (session()->has('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error')  }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          <div class="col-md-6">
           <form class="" action="{!! route('incomestatement-save') !!}" method="get">
             <input type="hidden" name="company_id" value="{{$company->id}}">
             <input type="hidden" name="catalog_id" value="{{$catalog->id}}">
             <div class="row">
               <div class="col-md-6 label-ti">
                 <label class="">Periodo</label>
               </div>
               <div class="col-md-6 form-group input-group-sm">
                 <select class="form-control"  name="year">
                   @foreach ($periods as $key => $value)
                     <option value="{{$value->id}}">{{$value->year}}</option>
                   @endforeach
                 </select>
               </div>
                @foreach ($incomeConf  as $key => $data)
                  <div class="col-md-8">
                  <p style="margin-bottom:-15px;margin-top:10px;"> <strong>{{$data->title}}</strong> </p>
                  </div>
                  <div class="col-md-4 text-right">
                    <p id="total{{$data->id}}" style="margin-bottom:-15px;margin-top:10px;">0.00</p>
                    <input type="hidden" step="0.01"  id="title-total{{$data->id}}"  name="title-total{{$data->id}}" value="0">
                  </div>
                  <div class="col-md-12">
                    <hr>
                  </div>
                  @foreach ($data->getIncomentStatementConfByCompany($company->id,$data->id, $catalog->id) as $key => $d)
                   <div class="col-md-6 form-group input-group-sm">
                     <small>{{$d->title}}</small>
                   </div>
                   <div class="col-md-6 form-group input-group-sm">
                     <input type="number" step="0.01" id="inp{{$data->id}}-{{$d->id}}" name="inp{{$data->id}}-{{$d->id}}" value="0" class="form-control class{{$data->id}}">
                     <input type="hidden"  name="val{{$data->id}}-{{$d->id}}" value="{{$d->account_id}}">
                   </div>

                  <script type="text/javascript">
                    if({{$data->id}}==1){
                      ventas.push({{$d->id}});
                    }
                    if({{$data->id}}==2){
                      costos.push({{$d->id}});
                    }
                    if({{$data->id}}==3){
                      gastos.push({{$d->id}});
                    }
                  </script>

                  @endforeach

                  <!--intermediarios-->
                  @if ($data->id==2)
                    <div class="col-md-6 form-group input-group-sm">
                      <small>  <strong>UTILIDAD BRUTA</strong> </small>
                    </div>
                    <div class="col-md-6 form-group input-group-sm">
                      <input step="0.01" name="utilidadBruta" id="utilidadBruta" type="number" readonly value="0" class="form-control">
                    </div>
                  @endif


                  <br><br>
                @endforeach

                <hr>
                <div class="col-md-6 form-group input-group-sm">
                  <small> UTILIDAD ANTES DEL IMPUESTO </small>
                </div>
                <div class="col-md-6 form-group input-group-sm">
                  <input step="0.01" id="antes" name="antes" type="number" readonly value="0" class="form-control">
                </div>

                <div class="col-md-6 form-group input-group-sm">
                  <small>  IMPUESTO A LA UTILIDAD </small>
                </div>
                <div class="col-md-6 form-group input-group-sm">
                  <input step="0.01" id="impuesto" name="impuesto" type="number" value="0" class="form-control">
                </div>

                <hr>
                <div class="col-md-6 form-group input-group-sm">
                  <small>  <strong>UTILIDAD NETA</strong> </small>
                </div>
                <div class="col-md-6 form-group input-group-sm">
                  <input step="0.01" id="total" name="total" type="number" readonly value="0" class="form-control">
                </div>
                <div class="col-md-12 text-right form-group">
                  <button type="submit" class="btn btn-success" name="button">GUARDAR</button>
                </div>
             </div>
           </form>

          </div>

          <div class="col-md-6">

          </div>
        </div>


      </div>
    <!--componente de usuarios-->


    <script type="text/javascript">

    function calculosExtra(){
      //utilidad bruta
      var utilidadBruta = parseFloat($("#total1").text()) - parseFloat($("#total2").text());
      $('#utilidadBruta').val(utilidadBruta);

      //utilidada antes de impuesto
      var utilidadAntes = parseFloat($("#utilidadBruta").val()) - parseFloat($("#total3").text());
      $('#antes').val(utilidadAntes);

      //total
      var total= parseFloat($('#antes').val()) - parseFloat($('#impuesto').val());
      $('#total').val(total);
    }


    $('#impuesto').keyup(function() {
      calculosExtra();
    });


    $('.class1').keyup(function() {
    	var id = this.id;
      var total=0;
      ventas.forEach(function(elemento, indice, array) {
         total=total+ parseFloat($("#inp1-"+elemento).val());
          //console.log(elemento, indice);
      })
      $("#total1").text(total);
      $("#title-total1").val(total);
      console.log(total);

      calculosExtra();
    });

    $('.class2').keyup(function() {
      var id = this.id;
      var total=0;
      costos.forEach(function(elemento, indice, array) {
         total=total+ parseFloat($("#inp2-"+elemento).val());
          //console.log(elemento, indice);
      })
      $("#total2").text(total);
      $("#title-total2").val(total);
      console.log(total);

      calculosExtra();
    });

    $('.class3').keyup(function() {
      var id = this.id;
      var total=0;
      gastos.forEach(function(elemento, indice, array) {
         total=total+ parseFloat($("#inp3-"+elemento).val());
          //console.log(elemento, indice);
      })
      $("#total3").text(total);
      $("#title-total3").val(total);
      console.log(total);
      calculosExtra();
    });

    console.log(ventas);
    console.log(costos);
    console.log(gastos);
    </script>
  </div>

</x-app-layout>
