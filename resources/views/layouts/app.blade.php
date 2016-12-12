<!DOCTYPE html>
<html>
<head>
	<title>Gram Client</title>
	<link href="{{ URL('css/style.css') }}" rel='stylesheet' type='text/css'/>
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<script src="{{ URL('js/jquery.min.js') }}"></script>
	<script src="{{ URL('js/skycons.js') }}"></script>
	<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
	<h1>Gram Client</h1>
<div class="main-agileits">
    @yield('content')
</div>
<div class="footer-agileits-w3layouts">
<!-- Authentication Links -->
    @if (Auth::guest())
    
    @else
	<p class="agileinfo">
	<a href="{{ url('/logout') }}"
		onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout</a>
	<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
	</p>
	@endif

</div>
</body>
</html>
