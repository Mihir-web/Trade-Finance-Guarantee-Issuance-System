@extends('layouts.app')

@section('internal_css')
<link rel="stylesheet" href="{{asset('admin/assets/css/dataTables.bootstrap4.min.css')}}"/>
@endsection

@section('content')
 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Report</h1>
   

            <form method="get" class="d-none d-sm-inline-block" action="{{route('billreportsexport')}}">
            @csrf
            
            <button type="submit" class="btn btn-success">Export &nbsp;<i class="fas fa-regular fa-file-excel"></i></button>
        </form>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Under Review</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$under_review_count}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Voting ongoing</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$voting_ongoing}}</div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Approved
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$approved}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-regular fa-thumbs-up fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Rejected</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$rejected}}</div>
                    </div>
                    <div class="col-auto">
                    <i class="fa fa-regular fa-thumbs-down fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Bills</h6>
                
            </div>
            <!-- Card Body -->
            <div class="card-body">
            @if($bills->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="background:#eef2ffcf;">
                            <th data-orderable="true">No</th>
                            <th data-orderable="true">Title</th>
                            <th data-orderable="false">Description</th>
                            
                            
                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                <th data-orderable="false">Voting</th>
                            @endif
                            <th data-orderable="false">Status</th>
                            @if(Auth::user()->role_id > 1 )
                            <th data-orderable="false">Amandment</th>
                           @endif

                            @if(Auth::user()->role_id < 3)
                            
                            @if(Auth::user()->role_id == 2)
                            <th data-orderable="false">Actions</th>
                            @endif
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($bills as $bill_data)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td width="15%">
                                @if(($bill_data->status == 1 || $bill_data->status == 2) && $bill_data->author_id == Auth::user()->id) 
                                    <a href="{{ route('billEdit',base64_encode($bill_data->id)) }}">{{ $bill_data->title }}</a>
                                @else
                                    {{ $bill_data->title }}
                                @endif
                                </span>
                                </td>
                                <td class="text-center">
                                    <a data-toggle="modal" class="btn btn-success" data-target="#other_detail_model{{$bill_data->id}}"><i class="fas fa-solid fa-eye"></i></a>
                                    <!-- Modal -->
                                    <div id="other_detail_model{{$bill_data->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> Description of <strong class="text-dark">{{ $bill_data->title }}</strong></h5>
                                                </div>
                                                <div class="modal-body text-left">
                                                    <p>
                                                        {{$bill_data->description}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary " data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                               
                                @if(Auth::user()->role_id == 2)
                                <td>
                                @if($bill_data->status == 5)
                                    @php
                                        $voted = App\Models\votes::where('user_id',Auth::user()->id)->where('bill_id',$bill_data->id)->get();
                                    @endphp
                                    @if($voted->count() == 0)
                                    <input type="radio" name="vote{{$bill_data->id}}" value="1" url="{{route('billVote')}}" id="Abstaint{{$bill_data->id}}" rid="{{base64_encode($bill_data->id)}}" user_id="{{Auth::user()->id}}" class="vote_radio"> <label for="Abstaint{{$bill_data->id}}">Abstaint</label>
                                    <br>
                                    <input type="radio" name="vote{{$bill_data->id}}" value="2" url="{{route('billVote')}}" id="Against{{$bill_data->id}}" rid="{{base64_encode($bill_data->id)}}" user_id="{{Auth::user()->id}}" class="vote_radio"> <label for="Against{{$bill_data->id}}">Against</label>
                                    @else
                                    Voted! <b>({{$bill_data->status == 1?'Abstaint':'Against'}})</b>
                                    @endif
                                @endif
                            </td>
                            @endif
                            @if(Auth::user()->role_id == 1)

                                @php
                                   $Abstainted_votes_count = App\Models\votes::where('bill_id',$bill_data->id)->where('vote',1)->count(); 
                                   $Against_votes_count = App\Models\votes::where('bill_id',$bill_data->id)->where('vote',2)->count(); 
                                @endphp
                            <td>
                                <p class="text-success">Abstain (<b>{{$Abstainted_votes_count}}</b>)</p>
                                <p class="text-danger">Against (<b>{{$Against_votes_count}}</b>)</p>
                            </td>
                            @endif
                            <td>
                                @if($bill_data->status  == 1)
                                    Initial Draft Created
                                @elseif($bill_data->status  == 2)
                                    Under Review
                                @elseif($bill_data->status  == 3)
                                    Approved
                                @elseif($bill_data->status  == 4)
                                    Rejected
                                @elseif($bill_data->status  == 5)
                                    Voting Ongoing
                                @else
                                    Passed
                                @endif
                            </td>
                            @if(Auth::user()->role_id == 2)
                            <td>
                            @php
                                        
                                        $amendments = App\Models\amendments::where('bill_id', '=',$bill_data->id)->get();
                                        @endphp
                            <p><a href="#commentsbox{{$bill_data->id}}"  data-backdrop="static" data-keyboard="false" class="commentsbox" data-toggle="modal" data-target="#commentsbox{{$bill_data->id}}">Comment <span id="view_comment{{$bill_data->id}}">({{ count($amendments) }})</span></a></p>

<div class="modal fade" id="commentsbox{{$bill_data->id}}" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Comments for {{ ucwords($bill_data->title) }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" >
                <div id="comment_{{ $bill_data->id }}" style="overflow-y:auto; height:450px;">

                    @if(count($amendments) > 0)

                    @foreach($amendments as $amendment_data)
                    <div class="comments-wrap">
                        <div class="comments-header">
                            <div class="comment-by"><i class="fa fa-user-circle"></i>{{ $amendment_data->user->name }}</div>
                            <div class="comment-time">{{ $amendment_data->created_at->diffForHumans() }}</div>                                       
                        </div>
                        <div class="comments-content">
                            <p>{{ $amendment_data->comment }}</p>
                        </div> 
                    </div>
                    @endforeach
                    @else
                    <div class="comments-wrap">
                        <div class="comments-content mt-0">
                            <p>There are no comments yet.</p>
                        </div>
                    </div>
                    @endif

                </div>
                <form id="commentForm_{{ $bill_data->id }}">
                    <input type="hidden" value="{{ $bill_data->id }}" name="bill_id">
                    <div class="row"> 
                        <div class="col-md-6">
                            <input type="text" name="commenttext" id="commenttext{{ $bill_data->id }}" data-id="{{ $bill_data->id }}" class="form-control commenttext" placeholder="Write a Comment...">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary submitComment mr-1" action="{{route('billWriteComment')}}" action_get_comment="{{route('billGetComment')}}" value="{{ $bill_data->id }}"><i class="fa fa-comment"></i> Submit</button>

                         
                        </div> 
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
                            </td>
                            @endif
                            
                               
                                @if(Auth::user()->role_id < 3)

                            @if(Auth::user()->role_id == 2)
                                <td>
                                @if(($bill_data->status == 1 || $bill_data->status == 2) && $bill_data->author_id == Auth::user()->id)
                                    <a class="btn btn-success" href="{{ route('billEdit',base64_encode($bill_data->id)) }}">Edit</a>
                                @endif    
                                @if($bill_data->author_id == Auth::user()->id)
                                    <a class="btn btn-danger delete_record" rid="{{base64_encode($bill_data->id)}}"  href="{{ route('billDelete',base64_encode($bill_data->id)) }}">Delete</a>
                                @else
                                    -
                                @endif
                                </td>
                            @endif
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            @else
            <div class="w-100 text-center">
                <h4>No Record Found!</h4>
            </div>
            @endif
            </div>
        </div>
    </div>

    
</div>



</div>
<!-- /.container-fluid -->


<!-- End of Main Content -->
@endsection

@section('script')

<script src="{{asset('admin/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    
$(document).ready(function() {
  $('#dataTable').DataTable();
});


$('.fancybox').fancybox({
  clickContent: 'close',
  buttons: ['close']
})
</script>
@endsection
