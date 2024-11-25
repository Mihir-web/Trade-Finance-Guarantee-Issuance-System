@extends('layouts.app')

@section('internal_css')
<link rel="stylesheet" href="{{asset('admin/assets/css/dataTables.bootstrap4.min.css')}}"/>
@endsection

@section('content')
<div class="container">
<div class="card shadow mb-4">
<div class="card-body">
    <div class="d-flex justify-content-between my-4">
    <h2>Guarantees</h2>
    <div>
    <a href="{{route('guaranteeCreate')}}" class="btn btn-primary">Create +</a>
    <a href="{{route('guaranteeimportForm')}}" class="btn btn-primary">Import +</a>
    
    </div>
    </div>
    <div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Corporate Reference Number</th>
                <th>Guarantee Type</th>
                <th>Nominal Amount</th>
                <th>Expiry Date</th>
                <th>Applicant Name & Address</th>
                <th>Beneficiary Name & Address</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guarantees as $guarantee)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $guarantee->corporate_reference_number }}</td>
                <td>{{ $guarantee->guarantee_type }}</td>
                <td>{{ $guarantee->nominal_amount_currency }} {{ $guarantee->nominal_amount }}</td>
               
                <td>{{ $guarantee->expiry_date }}</td>
                <td><strong>Name:</strong> {{ $guarantee->applicant_name }}<br><strong>Address:</strong> {{$guarantee->applicant_address}}</td>
                <td><strong>Name:</strong>{{ $guarantee->beneficiary_name }}<br><strong>Address:</strong> {{$guarantee->beneficiary_name}}</td>
                <td>
                    <select class="form-control form_input publish_status" name="status" url="{{route('guaranteeStatusChange')}}" rid="{{base64_encode($guarantee->corporate_reference_number)}}">
                                        <option value="1" {{ $guarantee->status == 1? "selected":"" }} >Draft</option>
                                        <option value="2" {{ $guarantee->status == 2? "selected":"" }} >Under Review</option>
                                        <option value="3" {{ $guarantee->status == 3? "selected":"" }} >Approved</option>
                                        <option value="4" {{ $guarantee->status == 4? "selected":"" }} >Rejected</option>
                                        <option value="5" {{ $guarantee->status == 5? "selected":"" }}>Issued</option>
                                        <option value="6" {{ $guarantee->status == 6? "selected":"" }}>Expired</option>
                                        <option value="7" {{ $guarantee->status == 7? "selected":"" }}>Revoked</option>
                                        <option value="8" {{ $guarantee->status == 8? "selected":"" }}>Cancelled</option>
                                    </select></td>
                <td>
                    <a href="{{ route('guaranteeEdit', $guarantee->corporate_reference_number) }}" class="btn btn-warning">Edit</a>
                    
                    <a class="btn btn-danger delete_record" rid="{{base64_encode($guarantee->corporate_reference_number)}}"  href="{{ route('guaranteeDelete',base64_encode($guarantee->corporate_reference_number)) }}">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div></div>
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
