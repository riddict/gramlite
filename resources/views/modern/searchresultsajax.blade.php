@if($type == "user")
	<div class="widget_1">
	<div class="col-md-12 widget_1_box2">
		<div class="wid_blog">
		Search Results
		</div>
		<div class="clear-fix"></div>
		<div class="scrollbar" id="style-2">
            <div class="activity-row">
	@foreach($users as $user)
		<div>
			<ul><li><a href=" {{ URL($user->getUsername().'/feed') }}" > {{ $user->getUsername() }}</a></li></ul>
		</div>
	@endforeach
	</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
@else
	@foreach($results as $result)
		<div>
			<ul><li>#{{ $result->getName() }} | {{ $result->getMediaCount() }} media<br /></li></ul>
		</div>
	@endforeach
@endif