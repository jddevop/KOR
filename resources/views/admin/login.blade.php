<!DOCTYPE html>
<html lang="en">

<head>
     @include('admin.layouts.partials.head')
</head>

<body class="mini-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box">
            
            <div class="white-box">
                @include('admin.layouts.partials.flash')
                <form class="form-horizontal form-material" id="loginform" action="{{ route('admin.login') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h3 class="box-title m-b-20">Sign In</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="email" placeholder="Enter Email" value="{{ old('email', Cookie::get('remember_email')) }}">
                            @error('email')
								<div id="error_message" class="text-danger">{{ $message }}</div>
							@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Enter Password" value="{{ Cookie::get('remember_password') }}">
                            @error('password')
    							<div id="error_message" class="text-danger">{{ $message }}</div>
    						@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox" name="remember" {{ Cookie::get('remember_email') ? 'checked' : '' }}>
                                <label for="checkbox-signup"> Remember me </label>
                            </div>
                            <a href="{{ route('admin.forgot_password') }}"  class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                    
                </form>
                
            </div>
        </div>
    </section>
    <!-- jQuery -->
    @include('admin.layouts.partials.scripts')
</body>

</html>
