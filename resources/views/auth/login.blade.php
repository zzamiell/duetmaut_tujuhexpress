@extends('layouts.app', [
    'namePage' => 'Login page',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'login',
    'backgroundImage' => asset('assets') . "/img/bg14.jpg",
])

@section('content')
<style>
     body {
        background-image: url('bg.jpg');
        background-size: 100%;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: top;
        background-color: #ffffff;
    }
</style>
    <div class="content">
        <div class="container">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="header bg-gradient-primary py-10 py-lg-2 pt-lg-12">
                <div class="container">
                    <div class="header-body text-center mb-7">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-9">
                                <p class="text-lead text-light mt-3 mb-0">
                                    @include('alerts.migrations_check')
                                </p>
                            </div>
                            <div class="col-lg-5 col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 ml-auto mr-auto">
            <form id="loginForm" novalidate="novalidate">
            {{ csrf_field() }}
            <div class="card card-login card-plain">
                <div class="card-header ">
                    <div class="p-3 mb-2 bg-gradient-primary text-white">
                    <h1> {{ 'Tujuh Express Dashboard' }} </h1>
                </div>
                </div>
                <div class="card-body ">
                <div class="input-group no-border form-control-lg {{ $errors->has('email') ? ' has-danger' : '' }}">
                    <span class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="now-ui-icons users_circle-08"></i>
                    </div>
                    </span>
                    <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" id="email" required autofocus>
                </div>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <div class="input-group no-border form-control-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="now-ui-icons objects_key-25"></i></i>
                    </div>
                    </div>
                    <input placeholder="Password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" id="password" value="secret" required>
                </div>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                </div>
                </form>
                <div class="card-footer ">
                <button onclick="loginThroughBackend()" class="btn btn-primary btn-round btn-lg btn-block mb-3">{{ __('Sign In') }}</button>

                <!--<div class="pull-left">
                    <h6>
                    <a href="{{ route('register') }}" class="link footer-link">{{ __('Create Account') }}</a>
                    </h6>
                </div>-->
                <div class="pull-right">
                    <h6>
                    <a href="{{ route('password.request') }}" class="link footer-link">{{ __('Forgot Password?') }}</a>
                    </h6>
                </div>
                </div>
            </div>

        </div>
        </div>
    </div>


@endsection
@push('js')
<script type="text/javascript">
        // $(document).ready(function() {
        //     demo.checkFullPageBackgroundImage();
        // });


        function loginThroughBackend() {
            event.preventDefault();

            // var formData = document.getElementById("loginForm");
            var objData = new FormData();
            objData.append('username', $('#email').val());
            objData.append('password', $('#password').val());


            console.log("============LOGIN");
            console.log($('#email').val());
            console.log($('#token').val());
            // console.log(objData);
			// console.log($("#password").val());

            console.log("smpe sini 1");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            console.log("smpe sini 2");
            console.log('{{ route('login1') }}');



            $.ajax({
                type: 'POST',
                url: '{{ route('login1') }}',
                data: objData,
                processData: false,
                contentType: false,
                success: function (data) {
                    var data=$.parseJSON(data);
                    console.log("THIS IS FROM AJAX : ");
					console.log(data);
                    console.log("================");

                    if(data.statusCode!=200) {
                        $("#username").val('');
						$("#password").val('');
                        console.log("===========LOGIN ERROR");
                        console.log(data.message);
                    } else {

                        var objData2 = new FormData();
                        objData2.append('email', $('#email').val());
                        objData2.append('password', $('#password').val());

                        // login laravel
                        $.ajax({
                        type: 'POST',
                        url: '{{ route('login') }}',
                        data: objData2,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            window.location.href = '{{ route('home') }}';
                        }
                    }).fail(function (msg) {
                        console.log("===== LOG FROM ERROR");
                        console.log(msg);
                    });

                        // window.location.href = '{{ route('home') }}';
                    }
                }
            }).fail(function (msg) {
                console.log("===== LOG FROM ERROR");
                console.log(msg);
            });
        }

    </script>
@endpush
