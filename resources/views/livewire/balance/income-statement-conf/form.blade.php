
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!--<link href="{!! asset('chosen/chosen.min.css') !!}" rel="stylesheet" />
<script src="{!! asset('chosen/chosen.jquery.min.js') !!}"></script>
<script src="{!! asset('chosen/chosen.proto.min.js') !!}"></script>-->


<script type="text/javascript">
    /*  $(document).ready(function() {
          $('#select2-dropdown').select2();
      });*/




   jQuery.noConflict()(function ($) { // this was missing for me
      document.addEventListener('livewire.load', function(){
         $('#s2').select2();

      });
    });
  //  $(".chosen-select").chosen();
</script>

<label> <strong>Segmento</strong> </label>
<select class="form-control"  wire:model="group">
  @foreach ($incomeStatementConf as $key => $value)
    @if ($key==0)
        <option selected  value="0">Seleccione...</option>
    @endif
    <option value="{{$value->id}}">{{$value->title}}</option>
  @endforeach
 </select>
  @error('group') <span class="text-danger">{{$message}}</span> @enderror

  <br>
  <label> <strong>Cuenta contable</strong> </label>
  <select class="form-control chosen-select" id="s2"  data-placeholder="Seleccione una cuenta..."  wire:model="account_id"> <!--id="select2-dropdown"-->
    <option value="0">Seleccione una cuenta...</option>
    @foreach ($accounts as $key => $value)
      <option value="{{$value->id}}">{{$value->account}} {{$value->account_name}}</option>
    @endforeach
  </select>
  @error('account_id') <span class="text-danger">{{$message}}</span> @enderror
  <br>
  <button type="button" wire:click.prevent="store()" class="btn btn-success">Agregar</button>
