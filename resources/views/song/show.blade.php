<tr id="{{ $song->id }}">
    <td data-pos="{{ $song->position }}" class="up-down">
      @if(Auth::check())
         @if(Auth::user()->vote_counter > 0)
         <a class="up" data-id="{{ $song->id }}"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
         <span>{{ $song->position }}</span> 
         <a class="down" data-id="{{ $song->id }}"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
         @else
         <a><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
         <span>{{ $song->position }}</span> 
         <a><i class="fa fa-chevron-down" aria-hidden="true"></i></a> 
         @endif
      @else
         <a><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
         <span>{{ $song->position }}</span> 
         <a><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
      @endif  
      
     </td>
    <td>{{ $song->title }}</td>
    <td>{{ $song->artist }}</td>
    <td>
        <a class="btn btn-small btn-success control-btn"  data-url="{{ explode(" ", $song->link_download)[0] }}"><i class="fa fa-play" aria-hidden="true"></i></i></a>
    </td>
                 

    <td>
       @if(Auth::check())
         @if($song->user_id == Auth::id() || Auth::user()->role == 'admin')
             <a class="btn btn-small btn-success remove-btn" data-id="{{$song->id}}"><i class="fa fa-trash" aria-hidden="true"></i></i></a>
         @endif
       @endif
   </td>
   <td>
       @if($song->name != null)
           {{$song->name}}
       @endif
   </td>
</tr>
