<!DOCTYPE html>
<html>
    <head>
        <title>Login - Admin Panel</title>
        <link rel="stylesheet" href="{{asset('assets/css/plugins.css')}}" />
        <style>
  body{
    /* background:red; */
    background-image:linear-gradient(236deg, #000000bd 0%, #3e3f5fd6 42%, #0f0f0fd9 100%),
    /* linear-gradient(#4e73dfcc, #4e73dfb5), */
    url('../../public/admin/assets/img/abstract.jpg');
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    height:100vh;
    width:100vw;
    display:flex;
    justify-content:center;
    align-items:center;
  }
    .error{
        font-size:12px;
        width:100%;
       padding-left:18px;
       color:red;
    }
   
</style>
    </head>
<body>


 <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-12 col-lg-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                    
                                        <h1 class="h4 text-gray-900 mb-4">Welcome to the Trade Finance Guarantee Issusance System</h1>
                                    </div>
         

                                            
                                     
                                    @if ($message = Session::get('success'))
                                        <div id="alert_msg" class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ $message }}
                                        </div>
                                    @endif
                                        
                                        
                                    @if ($message = Session::get('error'))
                                        <div id="alert_msg" class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ $message }}
                                        </div>
                                    @endif


                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="email" aria-describedby="emailHelp" value="{{ old('email') }}"
                                                placeholder="{{ __('Email Address') }}" required autocomplete="on">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                                id="password" placeholder="{{ __('Password') }}" autocomplete="on" >
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group form-check ml-2 mb-3">
                                          <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id="showhide" value="" >Show Password
                                          </label>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script src="{{asset('admin/assets/vendor/jquery/jquery.min.js')}}"></script>
    <script>
        setInterval(() => {
        $("#alert_msg").addClass('d-none');    
    }, 3000);

        $("#showhide").change(function(){
    if($("#password").attr("type")=="password")
    {
       $("#password").attr("type","text");
    }else{
       $("#password").attr("type","password");
    }
   })
    </script>
</body>
</html>
