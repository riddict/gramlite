<!DOCTYPE html>
<html>
<head>
<title>Gram Client</title>
	<!--Custom Theme files-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- Custom Theme files -->
	<link href="{{ URL('material/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
	<!--web-fonts-->
	<link href='//fonts.googleapis.com/css?family=Jura:400,300,500,600' rel='stylesheet' type='text/css'>
	<link href="{{ URL('modern/css/font-awesome.css') }}" rel="stylesheet"> 
	<link type="text/css" rel="stylesheet" href="{{ URL('material/css/jquery.mmenu.all.css?v=5.4.4') }}" />
	<!--//web-fonts-->
	<!-- js -->
	<script src="{{ URL('material/js/jquery-1.11.1.min.js') }}"></script> 
	<script type="text/javascript" src="{{ URL('material/js/jquery.mmenu.min.all.js?v=5.4.4') }}"></script>
	<!-- //js -->
	<script type="text/javascript">
	function show(type, id){
		event.preventDefault();
		$('.content').html('<center><i class="fa fa-gear fa-spin" style="font-size:24px"></i></center>');
		if(type == "inbox") {
			var url = "{{ URL('inbox') }}";
		} else if(type == "thread") {
			var url = "{{ URL('thread') }}/"+id;
		} else if(type == "pending") {
			var url = "{{ URL('pending') }}";
		} else if(type == "terima") {
			var url = "{{ URL('threadaction') }}/approve/id/"+id;
		} else if(type == "tolak") {
			var url = "{{ URL('threadaction') }}/decline/id/"+id;
		} else {
			var url = "{{ URL('noti') }}";
		}
		$.ajax({
			type:'GET',
			url: url,
			success: function( data ) {
				$('.content').html(data);
			},
			error: function(data) {
				$('#pesan').append('<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> Perhatian!</h4>Data gagal disimpan</div>');
			}
		});
	}
	@yield('script')
	</script>
</head>
<body>
<?php
	$account = App\instagramAccount::where('user_id', '=', Auth::user()->id)->first();
	$username = $account->username;
	$password = $account->password;
	$debug = false;
	$i = new \InstagramAPI\Instagram($debug);
	$i->setUser($username, $password);
	$pending = $i->getv2Inbox()->getPendingRequestsTotal();
	$inbox = $i->getv2Inbox()->getInbox()->getUnseenCount();
?>
		<div class=" mm-wrapper"  id="page">
			<div class="push-menu ">
				<div class="banner">
					
					<div class="header-top">
					@if($pending > 0 | $inbox > 0)
						<ul>
							<li>Anda memiliki {{ $pending }} pesan yang masih belum diterima. Klik <a href="" onClick="show('pending')">di sini</a> untuk melihat pesan.</li>
							<li>Anda memiliki {{ $inbox }} pesan yang belum dibaca.</li>
						</ul>
					@else
						<div></div>
					@endif
					</div>
					<div class="banner-text">
						<div class="menu">
							<a href="#menu"><img src="{{ URL('material/images/menu-icon.png') }}" alt=""/></a>
							<nav id="menu">
								<ul class="">
									<li class="menu-title">MENU</li>
									<li><a href="{{ URL('home') }}">Home</a></li>
									<li><a href="" onClick="show('inbox', 0)">Inbox</a></li>
									<li><a href="{{ URL('liked') }}">Post You Liked</a></li>
									<li><a href="{{ URL('search/tags/') }}">Search Hashtags</a></li>
									<li><a href="{{ URL('setting') }}">Settings</a></li>
								</ul> 	
							</nav>
							<script type="text/javascript">
									$(function() {
										$("#menu")
											.mmenu({
								extensions 	: [ "theme-dark", "effect-listitems-slide" ],
								iconPanels	: {
									add 		: true,
									visible		: 1
								},
								navbar		: {
									add 		: false
								},
								counters	: true
											}).on( 'click',
												'a[href^="#/"]',
												function() {
													alert( "Thank you for clicking, but that's a demo link." );
													return false;
												}
											);
									});
								</script>
							<!-- /script-for-menu -->
						</div>
						<div id="pesan"></div>
						<div class="title">
							@yield('title');
							<div class="clear"> </div>
						</div>
					</div>
				</div>
				<div class="clear"> </div>
				<div class="content">
					@yield('content')
				</div>
			</div>
		</div>
		<div class="copyright">
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
		<p> &copy; 2016 Mobile material . All rights reserved | Template by <a href="http://w3layouts.com/" target="_blank" >W3layouts</a></p>
		</div>
</body>
</html>