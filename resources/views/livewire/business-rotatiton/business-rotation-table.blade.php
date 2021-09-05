<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Tipo de empresa</th>
            </tr>
        </thead>
        <tbody>
                @foreach ($business as $key => $data)
                    <tr>
                       <td>{{$key+1}}</td>
                        <td class="text-center">{{$data->name}}</td>
                    </tr>
                @endforeach

        </tbody>
    </table>
</div>

<div class="text-center">
  {{$business->links()}}
</div>
