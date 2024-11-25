@extends('layouts.app')


@section('content')

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-lg-5 p-4">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Edit Bills</h1>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger" id="alert_msg">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <form class="user" id="guranteeUpdate" method="POST" enctype="multipart/form-data" action="{{ route('guaranteeUpdate') }}">
                        @csrf
                            
                              
                                
                                <div class="form-group row">
                                <div class="col-sm-12 mb-3 ">
                                    <label for="guarantee_type " class="text-dark">Guarantee Type <span class="text-danger">*</span></label>
                                    <select class="form-control form_input" name="guarantee_type" id="guarantee_type">
                                        <option selected disabled>Select Guarantee Type</option>
                                        <option value="Bank" {{$guarantee->guarantee_type == 'Bank'?'selected':''}}>Bank</option>
                                        <option value="Bid Bond" {{$guarantee->guarantee_type == 'Bid Bond'?'selected':''}}>Bid Bond</option>
                                        <option value="Insurance" {{$guarantee->guarantee_type == 'Insurance'?'selected':''}}>Insurance</option>
                                        <option value="Surety" {{$guarantee->guarantee_type == 'Surety'?'selected':''}}>Surety</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 mb-3 ">
                                    <label for="nominal_amount" class="text-dark">Nominal Amount <span class="text-danger">*</span></label>
                                    <input type="number" name="nominal_amount" class="form-control form_input" id="nominal_amount" value="{{$guarantee->nominal_amount}}" placeholder="Nominal Amount">
                                </div>

                                <div class="col-sm-12 mb-3 ">
                                    <label for="nominal_amount_currency" class="text-dark">Nominal Amount Currency <span class="text-danger">*</span></label>
                                    <input type="text" name="nominal_amount_currency" class="form-control form_input" id="nominal_amount_currency " value="{{$guarantee->nominal_amount_currency}}" placeholder="Nominal Amount Currency">
                                </div>

                                <div class="col-sm-12 mb-3 ">
                                    <label for="expiry_date" class="text-dark">Expiry Date <span class="text-danger">*</span></label>
                                    <input type="date" name="expiry_date" class="form-control form_input" id="expiry_date" placeholder="Expiry Date" value="{{$guarantee->expiry_date}}">
                                </div>

                                <div class="col-sm-12 mb-3 ">
                                    <label for="applicant_name" class="text-dark">Applicant Name <span class="text-danger">*</span></label>
                                    <input type="text" name="applicant_name" class="form-control form_input" id="applicant_name" placeholder="Applicant Name" value="{{$guarantee->applicant_name}}">
                                </div>

                                <div class="col-sm-12 mb-3 ">
                                    <label for="applicant_address" class="text-dark">Applicant Address <span class="text-danger">*</span></label>
                                    <input type="text" name="applicant_address" class="form-control form_input" id="applicant_address" placeholder="Applicant Address" value="{{$guarantee->applicant_address}}">
                                </div>

                                <div class="col-sm-12 mb-3 ">
                                    <label for="beneficiary_name" class="text-dark">Beneficiary Name <span class="text-danger">*</span></label>
                                    <input type="text" name="beneficiary_name" class="form-control form_input" id="beneficiary_name" placeholder="Beneficiary Name" value="{{$guarantee->beneficiary_name}}">
                                </div>
                                <input type="hidden" name="bid" value="{{$guarantee->corporate_reference_number}}">
                                <div class="col-sm-12 mb-3 ">
                                    <label for="beneficiary_address" class="text-dark">Beneficiary Address <span class="text-danger">*</span></label>
                                    <input type="text" name="beneficiary_address" class="form-control form_input" id="beneficiary_address" placeholder="Beneficiary Name" value="{{$guarantee->beneficiary_address}}">
                                </div>
                                <div class="float-right mb-4">
                                    <a href="{{ route('guarantees') }}" class="btn btn-user btn-outline btn-outline-secondary">
                                        <i class="fa-solid fa-xmark"></i> Cancel
                                    </a>
                                    <button name="add_bill" type="submit" value="1" class="btn btn-success btn-user">
                                        <i class="fa-solid fa-up-right-from-square"></i> Submit
                                    </button>
                                </div>

                                <input type="hidden" name="author_id" value="{{Auth::user()->id}}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')

<script src="{{asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\UpdateGuranteeRequest','#guranteeUpdate') !!}

<script>
    // Get today's date in YYYY-MM-DD format
    const today = new Date().toISOString().split('T')[0];
    // Set the min attribute of the date input
    document.getElementById('expiry_date').setAttribute('min', today);
</script>
@endsection