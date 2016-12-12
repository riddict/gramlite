@extends('modern.layouts.app')
@section('script')
<script type="text/javascript">

function addbookmark(username, type)
{
	$.ajax({
		headers : {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type: 'POST',
		url: '{{ URL('bookmark') }}',
		data:'username='+username+'&type='+type,
		success:function(msg){
			if(type == 0){
				$('#bookmark').removeClass("btn btn-sm btn-primary").addClass("btn btn-sm btn-default").attr("onclick", "addbookmark('"+username+"',1)").html('Add Bookmark');
			}else{
				$('#bookmark').removeClass("btn btn-sm btn-default").addClass("btn btn-sm btn-primary").attr("onclick", "addbookmark('"+username+"',0)").html('Delete Bookmark');
			}			
        }
	});
}

function cwRating(id,type,target){
	if(type == 0){
		$('#like'+id).removeClass("fa fa-heart text-info icon_13").addClass("fa fa-thumbs-down").attr("onclick", "cwRating('"+id+"',1,'like_count"+id+"')");
		}else{
		$('#like'+id).removeClass("fa fa-heart-o text-info icon_13").addClass("fa fa-thumbs-up").attr("onclick", "cwRating('"+id+"',0,'like_count"+id+"')");
	}	
    $.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
        type:'POST',
        url:'{{ URL('likemedia') }}',
        data:'id='+id+'&type='+type,
        success:function(msg){
			if(type == 0){
				$('#'+target).html(msg);
				$('#like'+id).removeClass("fa fa-thumbs-down").addClass("fa fa-heart-o text-info icon_13").attr("onclick", "cwRating('"+id+"',1,'like_count"+id+"')");
			}else{
				$('#'+target).html(msg);
				$('#like'+id).removeClass("fa fa-thumbs-up").addClass("fa fa-heart text-info icon_13").attr("onclick", "cwRating('"+id+"',0,'like_count"+id+"')");
			}			
        }
    });
}
</script>
@endsection
@section('content')
<div class="clear"> </div>
<div class="col_1">
	<div class="col-md-4 span_8">
		<div class="activity_box">
			<h4>{{ $user }}</h4>
				@if(is_null($ada))
				<button id="bookmark" type="button" class="btn btn-sm btn-default" onClick="addbookmark('{{ $user }}', 1)">Add Bookmark</button>
				@else
				<button id="bookmark" type="button" class="btn btn-sm btn-primary" onClick="addbookmark('{{ $user }}', 0)">Delete Bookmark</button>
				@endif
			<a href="{{ URL($user.'/feed/'.$feeds->getNextMaxId()) }}">Next Feeds</a>
		    <div class="scrollbar" id="style-2">
                <div class="activity-row">
					@foreach ($feeds->getItems() as $feed)
						<div id="{{ $feed->getMediaId() }}div">
							@if(is_null($feed->getCaption()))
								No caption<br />
							@else
								<p>
									<?php $text = $feed->getCaption()->getText();
										$text = preg_replace('/(^|\s)@([a-z0-9_.]+)/i',
										'$1<a href="'.URL('$2/feed').'">@$2</a>', $text);
										echo $text.'<br />';
									?>
								</p>
							@endif
							@if($feed->hasLiked() == true)
								<span id="like{{ $feed->getMediaId() }}" class="fa fa-heart" onClick="cwRating('{{ $feed->getMediaId() }}',0,'like_count{{ $feed->getMediaId() }}')"></span>
							@else
								<span id="like{{ $feed->getMediaId() }}" class="fa fa-heart-o" onClick="cwRating('{{ $feed->getMediaId() }}',1,'like_count{{ $feed->getMediaId() }}')"></span>
							@endif
							<span class="counter" id="like_count{{ $feed->getMediaId() }}">{{ $feed->getLikeCount() }}</span> likes
						</div>
						<div class="clearfix"> </div>
						<br />
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"> </div>
</div>
@endsection