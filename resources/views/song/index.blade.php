<div class="row">
    <div class="small-10  small-centered columns playlist ">
      <div class="">  
        <table >
          <thead>
            <td>#</td>
            <td>Title</td>
            <td>Artist</td>
            @if(Auth::check())
            <td></td>
            @endif
            <td></td>
            <td>Added by</td>
          </thead>
          <tbody id="list">
           @foreach($songs as $key => $value)
           <tr id="{{ $value->id }}">
              <td data-pos="{{ $value->position }}" class="up-down">
                @if(Auth::check())
                   @if(Auth::user()->vote_counter > 0)
                   <a class="up" data-id="{{ $value->id }}"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
                   <span>{{ $value->position }}</span> 
                   <a class="down" data-id="{{ $value->id }}"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                   @else
                   <a><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
                   <span>{{ $value->position }}</span> 
                   <a><i class="fa fa-chevron-down" aria-hidden="true"></i></a> 
                   @endif
                @else
                   <a><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
                   <span>{{ $value->position }}</span> 
                   <a><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                @endif  
                
               </td>
               <td class="title">{{ $value->title }}</td>
               <td class="artist">{{ $value->artist }}</td>
               <td>
                   <a class="btn btn-small btn-success control-btn" data-title='{{ $value->title }}' data-artist='{{ $value->artist }}'
                   data-url="{{ explode(" ", $value->link_download)[0] }}">
                        <i class="fa fa-play" aria-hidden="true"></i></i>
                  </a>
               </td>
               @if(Auth::check())

               <td>
                  @if($value->user_id == Auth::id() || Auth::user()->role == 'admin')
                      <a class="btn btn-small btn-success remove-btn" data-id="{{$value->id}}"><i class="fa fa-trash" aria-hidden="true"></i></i></a>
                  @endif
              </td>
                @endif
              <td>
                  @if($value->name != null)
                      {{$value->name}}
                  @endif
              </td>
           </tr>
           @endforeach
       </tbody>
        </table>
      </div>
      

  </div>

</div>
