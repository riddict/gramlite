@extends('modern.layouts.app')
@section('script')
@endsection
@section('content')
	<div class="col_3">
			<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <div class="stats">
						<div class="col-xs-3 activity-img"><img src='{{ $usernameinfo->getUser()->getProfilePicUrl() }}' class="img-responsive" alt=""/></div>
						<h5><strong>{{ $usernameinfo->getUser()->getUsername() }}</strong></h5>
						<span>{{ $usernameinfo->getUser()->getBiography() }}</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-users user1 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong>{{ $usernameinfo->getUser()->getFollowerCount() }}</strong></h5>
                      <span>Followers</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-users user1 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong>{{ $usernameinfo->getUser()->getFollowingCount() }}</strong></h5>
                      <span>Following</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-comment user2 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong>{{ $usernameinfo->getUser()->getMediaCount() }}</strong></h5>
                      <span>Media</span>
                    </div>
                </div>
        	</div>
        	<div class="clearfix"> </div>
    </div>
	<div class="col_1">
		<div class="col-md-4 stats-info">
            <div class="panel-heading">
                <h4 class="panel-title">Bookmark</h4>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
				@foreach($bookmark as $mark)
                    <li><a href=" {{ URL($mark->username.'/feed') }}">{{ $mark->username }}</a></li>
				@endforeach
                </ul>
            </div>
        </div>
        <div class="clearfix"> </div>
	</div>
@endsection
