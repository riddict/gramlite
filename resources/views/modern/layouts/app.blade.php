<!DOCTYPE HTML>
<html>
<head>
<title>Gram CLient</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="{{ URL('modern/css/bootstrap.min.css') }}" rel='stylesheet' type='text/css' />

<link href="{{ URL('modern/css/style.css') }}" rel='stylesheet' type='text/css' />
<link href="{{ URL('modern/css/font-awesome.css') }}" rel="stylesheet"> 

<script src="{{ URL('modern/js/jquery.min.js') }}"></script>

<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>

<script src="{{ URL('modern/js/bootstrap.min.js') }}"></script>
<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$(document).on('submit', 'form.navbar-form', function (event) {
		$('.graphs').html('<center><i class="fa fa-gear fa-spin" style="font-size:24px"></i></center>');
        event.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).attr('action'),
            data: $('#searchuser').serialize(),
			success: function( data ) {
				$('.graphs').html(data);
			},
			error: function(data) {
				$('#pesan').append('<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> Perhatian!</h4>Username tidak ditemukan</div>');
			}
        })
    });
	$(document).on('submit', 'form.ajax', function (event) {
        event.preventDefault();
		$('#loading').append('<center><i class="fa fa-gear fa-spin" style="font-size:24px"></i></center>');
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $('#ajax').serialize(),
			success: function( data ) {
				$('.graphs').html(data);
			},
			error: function(data) {
				$('#pesan').append('<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> Perhatian!</h4>Terjadi kesalahan. Coba lagi!</div>');
			}
        })
    });
	function show(type, id){
		event.preventDefault();
		$('.graphs').html('<center><i class="fa fa-gear fa-spin" style="font-size:24px"></i></center>');
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
				$('.graphs').html(data);
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
<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL('home') }}">Gram Client</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-nav navbar-right">
				
			    <li class="dropdown">
	        		<a href="#" class="dropdown-toggle avatar" data-toggle="dropdown"><img src="{{ $usernameinfo->getUser()->getProfilePicUrl() }}" alt=""/></a>
	        		<ul class="dropdown-menu">
						<li class="dropdown-menu-header text-center">
							<strong>Account</strong>
						</li>
						
						<li class="m_2"><a href="#"><i class="fa fa-envelope-o"></i> Messages <span class="label label-success">{{ $inbox }}</span></a></li>
						
						<li class="dropdown-menu-header text-center">
							<strong>Settings</strong>
						</li>
						<li class="m_2"><a href="{{ URL('profile') }}"><i class="fa fa-user"></i> Profile</a></li>
						<li class="m_2"><a href="{{ URL('setting') }}"><i class="fa fa-wrench"></i> Settings</a></li>
						<li class="m_2">
							<a href="{{ url('/logout') }}"
								onclick="event.preventDefault();
									document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> LOGOUT</a>
							<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>	
	        		</ul>
	      		</li>
			</ul>
			<form id="searchuser" class="navbar-form navbar-right" action="{{ URL('search') }}">
              <input type="text" name="uname" class="form-control" value="Search Username" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search...';}">
            </form>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="{{ URL('home') }}"><i class="fa fa-dashboard fa-fw nav_icon"></i>HOME</a>
                        </li>
                        <li>
                            <a href="{{ URL('liked') }}"><i class="fa fa-dashboard fa-fw nav_icon"></i>POST YOU LIKED</a>
                        </li>
						<li>
                            <a href="{{ URL('search/tags') }}"><i class="fa fa-dashboard fa-fw nav_icon"></i>SEARCH HASGTAGS</a>
                        </li>
						<li>
							<a href="{{ URL('setting') }}"><i class="fa fa-dashboard fa-fw nav_icon"></i>SETTINGS</a>
						</li>
						<li>
							<a href="#" onClick="show('inbox', 0)"><i class="fa fa-dashboard fa-fw nav_icon"></i>INBOX 
							<?php 
								
							?>
							</a>
						</li>
						<li>
							<a href="" onClick="show('noti', 0)"><i class="fa fa-dashboard fa-fw nav_icon"></i>NOTIFICATION</a>
						</li>
						<li>
						<a href="{{ url('/logout') }}"
								onclick="event.preventDefault();
									document.getElementById('logout-form').submit();"><i class="fa fa-lock fa-fw nav_icon"></i> LOGOUT</a>
						<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
						</li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
			<div id="loading"></div>
			
			@if($pending > 0 | $inbox > 0)
			<div class="alert alert-success">
				<h4><i class="icon fa fa-warning"></i> Notifikasi!</h4>
				Anda memiliki {{ $pending }} pesan yang masih belum diterima. Klik <a href="" onClick="show('pending')">di sini</a> untuk melihat pesan.<br />
				Anda memiliki {{ $inbox }} pesan yang belum dibaca.
			</div>
			@else
			<div></div>
			@endif
			@yield('content')
		   <div class="copy_layout">
            <p>Copyright © 2015 Modern. All Rights Reserved | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
           </div>
	  </div>
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
<link href="{{ URL('modern/css/custom.css') }}" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="{{ URL('modern/js/metisMenu.min.js') }}"></script>
<script src="{{ URL('modern/js/custom.js') }}"></script>
</body>
</html>
