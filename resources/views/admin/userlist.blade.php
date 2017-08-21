@extends('master')
@section('title','User List')
@section('content')


<div class="container">
@if (Auth::check() and (Auth::user()->role=="admin"))
<center><h1 class="page-header">User List</h1></center>
<form class="form-horizontal" action="{{ URL::to('admin/searchuser') }}" method="GET">
    <div class="row">
        <div class="small-3 columns search">
            <button type="submit" class="button">
                <i class="fa fa-search"></i>
            </button>
            <div class="search__input">
               <input type="text" style="width: 100%;" placeholder="Search for everything" name="keyword">
            </div>​
        </div>
            @if(!isset($page) || (isset($page) and $page == "1"))
              @if((isset($message) and $message != null and $message != ""))

                  <div class="small-4 columns">
                      <div class="success callout" data-closable>
                          <p>{!! $message !!}</p>
                            <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                              <span aria-hidden="true">&times;</span>
                            </button>
                      </div>
                  </div>
            
              @endif
          @endif
    </div>
</form>

      {!! csrf_field() !!}

<center>

    <div class="row">
         <table class="table user-list">
                            <thead>
                                <tr>
                                <th><span>User Name</span></th>
                                <th><span>Email</span></th>
                                <th><span>Created</span></th>
       
                                <th>
                                    <form class="form-horizontal" method="GET" action="{{ URL::to('admin/filter') }}">
                              <span>
                                  <select id="filter" onchange="this.form.submit()" name="filter">
                                    <option value="all">All</option>
                                    <optgroup label="Status">
                                    <option value="blocked">blocked</option>
                                    <option value="unblock">unblocked</option>
                                    </optgroup>
                                    <optgroup label="Role">
                                    <option value="admin">admin</option>
                                    <option value="user">user</option>
                                    </optgroup>
                                  </select>
                              </span>
                            </form>
                                </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            ?> 
                                <?php 
                                foreach ($user as $item){ ?>
                                <tr>
                                
                                <td style="display:none;"><?php $id=$item->id;?></td>
                                <td style="display:none;"><?php $role=$item->role;?></td>
                                <td style="display:none;"><?php $status=$item->status;?></td>
                                <td><?php echo $item->name; ?></td>
                                <td><?php echo $item->email; ?></td>
                                <td><?php echo $item->created_at; ?></td>   
                         
                                     <td style="width: 20%;">
                                     <?php
                                        if ($role=='admin') $iconRole="fa fa-user-secret fa-stack-1x fa-inverse";
                                        if ($role=='user') $iconRole="fa fa-user fa-stack-1x fa-inverse";
                                        if ($status=="unblock") $iconStatus="fa fa-unlock fa-stack-1x fa-inverse";
                                        if ($status=="blocked") $iconStatus="fa fa-lock fa-stack-1x fa-inverse";
                                    ?>    
                                    <script>
                                        var changeRole= <?php echo json_encode($iconRole); ?>;
                                        var changeStt= <?php echo json_encode($iconStatus); ?>;
                                    </script>
                                    
                                    
                                        <span>
                                        <a>
                                              <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>    
                                                <i class="{{$iconStatus}} status" data-id="{{$item->id}}"  ></i>
                                                </span>
                                        </a>
                                        <a>
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                
                                                <i class="{{$iconRole}} role" data-id="{{$item->id}}" ></i>
                                            </span>
                                        </a>
                                        <a>
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse delete" data-id="{{$item->id}}"></i>
                                            </span>
                                        </a>
                                        </span>
                                     </td>
                                </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        {!! $user->appends(Input::except('page'))->render() !!}
    </div>
    </center>
</div>

<script>

    $(document).ready(function(){
        var select="<?php echo $option; ?>";
         $("#filter").val(select);
        $('.status').click(function(){
            id = $(this).data('id');
            var thisObj = $(this);
            //goi ajax thay doi trang thai
            $.ajax({
                url: 'changeStatus',
                type: 'POST',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id
                },
                success: function(data){
                     swal(
                          'Completed','',
                          'success'
                        );
                    if(thisObj.attr('class').search('fa-lock') != -1){
                        thisObj.removeClass('fa-lock');
                        thisObj.addClass('fa-unlock');
                    }else{
                        thisObj.addClass('fa-lock');
                        thisObj.removeClass('fa-unlock');
                    }
                }
            });
            

        });
        $('.role').click(function(){
            id = $(this).data('id');
            var thisObj = $(this);
            //goi ajax thay doi trang thai
            $.ajax({
                url:'changeRole',
                type:'POST',
                dataType:'json',
                data:{
                     "_token": "{{ csrf_token() }}",
                    'id': id
                },
                success:function(data){
                    swal(
                          'Completed','',
                          'success'
                        );
                    if(thisObj.attr('class').search('fa-user-secret') != -1){
                          thisObj.removeClass('fa-user-secret');
                            thisObj.addClass('fa-user');
                        }else{
                           thisObj.addClass('fa-user-secret');
                           thisObj.removeClass('fa-user');
                        }
                }
            });
            
            
        });

          $('.delete').click(function(){
            id = $(this).data('id');
            var thisObj = $(this);
            swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then(function() {
                        $.ajax({
                url:'deleteUser',
                type:'POST',
                dataType:'json',
                data:{
                     "_token": "{{ csrf_token() }}",
                    'id': id
                },
                success:function(data){
                    swal(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  );
                  location.reload();
                },
                error:function(data){
                  alert("error");
                }
            }
            );  
              
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
