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
                <form class="form-horizontal"  action="{{ route('admin.reset_link') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="email" placeholder="Enter email" value="{{ old('email') }}">
                            @error('email')
    						  <div id="error_message" class="text-danger">{{ $message }}</div>
    						 @enderror
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button  class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
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
