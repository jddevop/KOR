<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('asset/admin/plugins/images/favicon.png') }}">
<title>@yield('title', '') | KOR</title>
<!-- ===== Bootstrap CSS ===== -->
<link href="{{ asset('asset/admin/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- ===== Plugin CSS ===== -->
<link href="{{ asset('asset/admin/plugins/components/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
<link href="{{ asset('asset/admin/plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
<!-- ===== Animation CSS ===== -->
<link href="{{ asset('asset/admin/css/animate.css') }}" rel="stylesheet">
<!-- ===== Custom CSS ===== -->
<link href="{{ asset('asset/admin/css/style.css') }}" rel="stylesheet">
<!-- ===== Color CSS ===== -->
<link href="{{ asset('asset/admin/css/colors/default.css') }}" id="theme" rel="stylesheet">