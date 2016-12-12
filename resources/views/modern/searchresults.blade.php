@extends('modern.layouts.app')
@section('script')
@endsection
@section('content')
<div class="widget_1">
	<div class="col-md-12 widget_1_box2">
		<div class="wid_blog">
			<div class="form-group">
					@if($type == "user")
					<form action="{{ URL('search') }}" method="get">
						<input class="form-control1" type="text" name="uname" placeholder="Search" required="">
					@else
					<form action="{{ URL('searchht') }}" method="get">
						<input class="form-control1" type="text" name="hashtags" placeholder="Search" required="">
					@endif
					</form>		
			</div>
		</div>
		<div class="clear-fix"></div>
		<div class="scrollbar" id="style-2">
            <div class="activity-row">
				@if($type == "user")
					@foreach($users as $user)
					<div>
						<ul><li><a href=" {{ URL($user->getUsername().'/feed') }}" > {{ $user->getUsername() }}</a></li></ul>
					</div>
					@endforeach
				@else
					@foreach($results as $result)
					<div>
						<ul><li>#{{ $result['name'] }} | {{ $result['media_count'] }} media<br /></li></ul>
					</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
@endsection