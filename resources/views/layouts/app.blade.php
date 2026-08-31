<!doctype html>
<html lang="en">
<head>
	@include('layouts.partials.head')
	@stack('custom-style')
</head>
<body class="<?php echo $page; ?>" > 	
	<section class="<?php if($page=='change-password'){ ?>rp-box <?php }?>">
		<div class="container">
			@include('layouts.partials.navbar') 
			@yield('content')
			@include('layouts.partials.footer')
		</div>
	</section>
	@include('layouts.partials.scripts')
	{{-- custom scripts --}}
    @stack('custom-scripts')
</body>
</html>