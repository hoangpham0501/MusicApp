<!-- resources/views/auth/login.blade.php -->

@extends('master')

@section('title', 'Blocked song list')


@section('content')
@if (Auth::check() and (Auth::user()->role=="admin"))
<center><h3 class="page-header">Blocked Songs</h3></center>
<div class="row">
    <div class="small-10 small-centered columns">
    @if(isset($message) and $message != "")
       	<div class="success callout" data-closable>
	  		<h5>Message:</h5>
	  		<p>{!! $message !!}</p>
			  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
			    <span aria-hidden="true">&times;</span>
			  </button>
		</div>
    @endif
    </div>
</div>
    
<div class="row blocked-song">
	<div class="small-10 small-centered columns">
	@if($listBlockedByLink != null)
		<h5>List of blocked songs by direct link:</h5>
		<table>
        <thead>
        	<th width="80%">Link to the song</th>
        	<th>Action</th>
        </thead>

        <tbody>
            @foreach($listBlockedByLink as $key => $value)
            <tr>
                <td>{{ $value->link_mp3 }}</td>    
                <td>
                	<a class="button expand user_button unblock-btn" data-id="{{ $value->id }}"><i class="fa fa-unlock"></i> Unblock</a>
                </td>            
            </tr>
            @endforeach
        </tbody>
    </table>
	@endif
	@if($listBlockedBySongName != null)
		<h5>List of blocked song by name:</h5>
		<table>
        <thead>
        	<th width="80%">Name of the song</th>
        	<th>Action</th>
        </thead>

        <tbody>
            @foreach($listBlockedBySongName as $key => $value)
            <tr>
                <td>{{ $value->title }}</td>    
                <td>
                	<a class="button expand user_button unblock-btn" data-id="{{ $value->id }}"><i class="fa fa-unlock"></i> Unblock</a>
                </td>            
            </tr>
            @endforeach
        </tbody>
    </table>
	@endif
	@if($listBlockedByWord != null)
		<h5>Blocked words:</h5>
		<table>
        <thead>
        	<th width="80%">Word to block</th>
        	<th>Action</th>
        </thead>

        <tbody>
            @foreach($listBlockedByWord as $key => $value)
            <tr>
                <td>{{ $value->word }}</td>    
                <td>
                	<a class="button expand user_button unblock-btn" data-id="{{ $value->id }}"><i class="fa fa-unlock"></i> Unblock</a>
                </td>            
            </tr>
            @endforeach
        </tbody>
    </table>
	@endif
	</div>
</div>
   <center><a class="button user_button block-song-btn" href="{{ URL::to('blocksong') }}">Block Song</a></center>

    <script>
        $(document).ready(function() {
        	$(document).foundation();
            $('.unblock-btn').click(function(e){                
                id = $(this).data('id');
                swal({
                  title: '',
                  text: "Are you sure you want to unblock this song?",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'OK'
                }).then(function() {
                    $.ajax({
                        url: "{{ URL::to('/unblocksong') }}",
                        type: 'GET',
                        data: {
                            'id': id
                        },
                        success: function (data) {
                            if(data != "success"){
                                //some exception thrown as string, not bool
                                alert(data);
                            };
                            location.reload();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Status: " + textStatus); alert("Error: " + errorThrown);
                        }
                    });
                }, function(dismiss) {
                    if (dismiss === 'cancel') {
                    swal(
                      'Cancelled',
                      '',
                      'error'
                      );
                    }
                })
            });
        });
    </script>
@else
    <h1 style="text-align:center;color: red; font-size: 70px; margin-top: 100px;">Oops!!! Login to continue</h1>
@endif
@endsection
