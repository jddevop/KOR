<!-- Essential Meta Tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Theme Color for Mobile Browsers -->
<meta name="theme-color" content="#4076BF">
<meta name="msapplication-navbutton-color" content="#4076BF">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="KOR">

<!-- SEO Meta Tags -->
<title>@yield('title', '') | KOR</title>
<meta name="title" content="KOR">
<meta name="description" content="KOR">
<meta name="author" content="">
<link rel="canonical" href="https://yourdomain.com"> <!-- Update this with actual URL -->

<!-- Social Meta Tags -->
<!-- Facebook Open Graph -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://yourdomain.com">
<meta property="og:title" content="KOR">
<meta property="og:description" content="">
<meta property="og:image" content="">
<meta name="facebook-domain-verification" content="KOR" />

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://yourdomain.com">
<meta name="twitter:title" content="KOR">
<meta name="twitter:description" content="">
<meta name="twitter:image" content="">

<!-- Favicon and App Icons -->
<link rel="icon" href="{{ asset('asset/images/favicon.ico') }}">
<link rel="apple-touch-icon" href="{{ asset('asset/images/apple-touch-icon.png') }}">

<!-- Stylesheets -->
<!-- 1. Core framework -->
<link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}" crossorigin="anonymous">

<!-- 2. Icon libraries -->
<link rel="stylesheet" href="{{ asset('asset/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/brands.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/solid.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/regular.css') }}">

<!-- 3. Base styles and typography -->
<link rel="stylesheet" media="screen" href="{{ asset('asset/css/font.css') }}">

<!-- 4. Custom styles -->
<link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">

<!-- 5. Responsive-specific styles -->
<link rel="stylesheet" media="screen" href="{{ asset('asset/css/mobile.css') }}">



<script type="text/javascript">
var jquery_url='<?php echo $baseUrl = URL::to('/'); ?>';
</script>

<link rel="manifest" href="{{ asset('manifest.json') }}">
