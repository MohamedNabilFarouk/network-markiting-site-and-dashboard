<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<style>
    body {
        font-family: "Lato", sans-serif;
    }
    
    
    
    .main-head{
        height: 150px;
        background: #FFF;
    
    }
    
    .sidenav {
        height: 100%;
        background-color: #000;
        overflow-x: hidden;
        padding-top: 20px;
    }
    
    
    .main {
        padding: 0px 10px;
    }
    
    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
    }
    
    @media screen and (max-width: 450px) {
        .login-form{
            margin-top: 10%;
        }
    
        .register-form{
            margin-top: 10%;
        }
    }
    
    @media screen and (min-width: 768px){
        .main{
            margin-left: 40%;
        }
    
        .sidenav{
            width: 40%;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
        }
    
        .login-form{
            margin-top: 80%;
        }
    
        .register-form{
            margin-top: 20%;
        }
    }
    
    
    .login-main-text{
        margin-top: 20%;
        padding: 60px;
        color: #fff;
    }
    
    .login-main-text h2{
        font-weight: 300;
    }
    
    .btn-black{
        background-color: #000 !important;
        color: #fff;
    }
    </style>
</head>
<body>
      <div class="container">

<div class="sidenav ">
         <div class="login-main-text">
           <img alt="Logo" class="d-block" style="margin: 0 auto; max-width: 100%; max-height: 100px" src="{{asset('site/img/shiiry-logo-white.png')}}" class=" logo" />

            {{-- <h2>Application<br> Registeration Page</h2> --}}
            <p>Login or register from here to access.</p>
         </div>
      </div>
      <div class="main">
         <div class="col-md-8 col-sm-12">

            <div class="login-form">
                {{-- @include('admin.includes.messages') --}}
            <form method="POST" action="{{ route('register') }}">
                        @csrf


                        <div class="form-group row">
                            <label for="email" class="col-md-6 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="identify" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-6 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="identify" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="identify" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="code" class="col-md-6 col-form-label text-md-right">{{ __('phone') }}</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="identify" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="code" class="col-md-6 col-form-label text-md-right">{{ __('Code') }}</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="identify" autofocus>

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password" class="col-md-6 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-6 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-12">
                                <input type="checkbox" class=" form-control-range" id="formControlRange" required>  <a href="{{route('terms')}}" target="_blank"> <p class=" col-form-label text-md-right">Agreement Terms and Conditions</p></a> 
                            </div>
                           
                           
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                                <a class="btn btn-link" href="{{ url('login') }}">
                                        {{ __('Already Have Account') }}
                                    </a>
                            </div>
                        </div>
                    </form>
            </div>
         </div>
      </div>
    </div>
</body>
</html>
