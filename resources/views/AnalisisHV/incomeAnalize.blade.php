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
 .hrclass {
     margin-top: 0rem;
     margin-bottom: 0.3rem;
 }
 
 .pclass {
     /* margin-top: 0; */
     margin-bottom: 0.5rem;
 }
  </style>
 
 <script type="text/javascript">
 let ventas = [];
 let costos = [];
 let gastos = [];
 </script>

<div class="row card">
  <div class="col-md-20">

    <h5>Análisis para la Compañia: {{$company->company}} @if ($type == 1)( Análisis Horizontal )@endif @if ($type == 2)( Análisis Vertical )@endif</h5>
    
    <div>
      @if ($error == 1)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="text"> {{$msj}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
         </div>
      @endif

      <form class="form-inline ml-3" >
          <div class="col-md-50 form-group input-group-sm">
            <div class="col-md-50 label-ti">
              <label class="">Tipo de Análisis </label>
            </div>&nbsp; 
            <select class="form-control"  name="type" >
              <option value="0">------------</option>
              <option value="1" @if($request->type == 1) selected @endif>Horizontal</option>
              <option value="2" @if($request->type == 2) selected @endif>Vertical</option>
            </select>
          </div>
          <br>&nbsp;
          <div class="col-md-50 form-group input-group-sm">
            <div class="col-md-50 label-ti">
              <label class="">Año 1</label>
            </div>&nbsp; 
            <select class="form-control"  name="yearOne">
              <option value="0">-----------</option>
              @foreach ($periods1 as $p)
                <option value="{{$p->id}}" @if($p->id == $request->yearOne) selected @endif>{{$p->year}}</option>
              @endforeach
            </select>
          </div>
          &nbsp; 
          <div class="col-md-50 form-group input-group-sm">
            <div class="col-md-50 label-ti">
              <label class="">Año 2</label>
            </div>&nbsp; 
            <select class="form-control"  name="yearTwo" >
              <option value="0">-----------</option>
              @foreach ($periods2 as $p)
                <option value="{{$p->id}}" @if($p->id == $request->yearTwo) selected @endif>{{$p->year}}</option>
              @endforeach
            </select>
          </div>
          &nbsp; 
          <div class="col-md-50 form-group input-group-sm">
            <div class="col-md-50 label-ti">
              <label class="">Año 3</label>
            </div>&nbsp; 
            <select class="form-control"  name="yearThree">
              <option value="0">-----------</option>
              @foreach ($periods3 as $p)
                <option value="{{$p->id}}" @if($p->id == $request->yearThree) selected @endif>{{$p->year}}</option>
              @endforeach
            </select>
          </div>
          &nbsp;
        <div class="col-md-6 form-group input-group-sm">
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">
                  <i class="fas fa-play"></i> Iniciar
              </button>
            </div>&nbsp;
            <a href="{!! route('balances-menu', $company->id) !!}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Regresar</a>
        </div>
      </form>
    </div>
@if ($error == 0)
  {{-- Tabla de resultados --}}
    <table class="table table-sm">
      <thead class="thead-dark">
        <tr>
          @if ($type == 1) {{-- Cabeceras de Analisis Horizontal --}}
            <th>Cuenta</th>
            <th>{{$yearHeader1}}</th>
            <th>{{$yearHeader2}}</th>
            @if ($desiredYears > 2)
              <th>{{$yearHeader3}}</th>
            @endif
            @if ($desiredYears == 2)
              <th>Variación Absoluta</th>
              <th>Variación Relativa</th> 
            @else
              <th>Variación Absoluta ({{$yearHeader4}})</th>
              <th>Variación Relativa ({{$yearHeader4}})</th> 
              <th>Variación Absoluta ({{$yearHeader5}})</th>
              <th>Variación Relativa ({{$yearHeader5}})</th> 
            @endif
          @endif
          @if ($type == 2) {{-- Cabeceras de Analisis Vertical --}}
            <th>Cuenta</th>
            <th>{{$yearHeader1}}</th>
            @if ($desiredYears > 1)
              <th>{{$yearHeader2}}</th>
              @if ($desiredYears > 2)
                <th>{{$yearHeader3}}</th>
              @endif
            @endif
            <th>{{$yearHeader1}}</th>
            @if ($desiredYears > 1)
              <th>{{$yearHeader2}}</th>
              @if ($desiredYears > 2)
                <th>{{$yearHeader3}}</th>
              @endif
            @endif
        
          @endif   
        </tr>
      </thead>
      <tbody>
        @if ($type == 1) {{-- Cuerpo de Analisis Horizontal --}}
          @foreach ($horizontalResults as $r)
              <tr>
                <td>{{$r["title"]}}</td>
                <td>{{$r["data1"]}}</td>
                <td>{{$r["data2"]}}</td>
                @if ($desiredYears > 2)
                  <th>{{$r["data3"]}}</th>
                @endif
                @if ($desiredYears == 2)
                  <td>{{$r["abs"]}}</td>
                  <td>{{$r["rel"]}}</td>
                @endif
                @if ($desiredYears > 2)
                  <td>{{$r["abs1"]}}</td>
                  <td>{{$r["rel1"]}}</td>
                  <td>{{$r["abs2"]}}</td>
                  <td>{{$r["rel2"]}}</td>
                @endif
              </tr>
          @endforeach
        @endif   
        @if ($type == 2) {{-- Cuaerpo de Analisis Vertical --}}
          @foreach ($verticalResults as $r)
              <tr>
                <td>{{$r["title"]}}</td>
                <td>{{$r["data1"]}}</td>
                @if ($desiredYears > 1)
                  <td>{{$r["data2"]}}</td>
                  @if ($desiredYears > 2)
                    <td>{{$r["data3"]}}</td>
                  @endif
                @endif
                <td>{{$r["v1"]}}</td>
                @if ($desiredYears > 1)
                  <td>{{$r["v2"]}}</td>
                  @if ($desiredYears > 2)
                    <td>{{$r["v3"]}}</td>
                  @endif
                @endif
              </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
@endif
</div>

</x-app-layout>