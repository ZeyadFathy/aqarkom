<!-- Basic Page Needs
================================================== -->
<title>@hasSection('PageTitle')@yield('PageTitle') | @endif{{ env('APP_NAME') }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- CSS
================================================== -->
<link rel="stylesheet" href="{{ url('frontend/') }}/css/style.css">
<link rel="stylesheet" href="{{ url('frontend/') }}/css/colors/green.css" id="colors">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/earlyaccess/droidarabickufi.css" />
<meta property="og:title" content="@yield('PageTitle')">
<meta property="og:image" content="{{isset($advertisement['images'][0])?url('uploads/'.$advertisement['images'][0]): url('uploads/logo-background.jpg')}}">
<meta property="og:description" content="{{isset($advertisement['details'])? $advertisement['details']: \App\Admin\Options\Option::where('key','about_us')->first()->value}}">
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-150731558-1"></script>
<script type="application/javascript">
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());
 gtag('config', 'UA-150731558-1');
</script>
