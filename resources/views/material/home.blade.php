@extends('material.layouts.app')
@section('script')
@endsection
@section('title')
<div class="title-left">
	<img src="{{ $usernameinfo->getUser()->getProfilePicUrl() }}" alt=""/>
</div>
<div class="title-right">
	<h2>{{ $usernameinfo->getUser()->getUsername() }}</h2>
	<h6>{{ $usernameinfo->getUser()->getBiography() }}</h6>
</div>
@endsection
@section('content')
	<div class="banner-bottom">
		<div id="loading"></div>
		<div class="banner-bottom-left">
			<h3>{{ $usernameinfo->getUser()->getFollowerCount() }}</h3>
			<p>Follower </p>
		</div>
		<div class="banner-bottom-right">
			<h3>{{ $usernameinfo->getUser()->getFollowingCount() }}</h3>
			<p>Following</p>
		</div>
		<div class="clear"> </div>
	</div>
	<div class="work-text">
		<h3>BOOKMARK</h3>
		<section class="ac-container">
		@foreach($bookmark as $mark)
			<li><a href=" {{ URL($mark->username.'/feed') }}">{{ $mark->username }}</a></li>
		@endforeach
		</section>
	</div>
@endsection
