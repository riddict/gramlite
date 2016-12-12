@extends('material.layouts.app')
@section('script')
$(document).on('submit', 'form.comments', function (event) {
    event.preventDefault();
	var mediaid = $('#mediaid').val();
	$('#commentload_'+mediaid).after('<center><i class="fa fa-gear fa-spin" style="font-size:24px"></i> posting comment</center>');
    $.ajax({
        type: "get",
        url: $(this).attr('action'),
        data: $('#comments').serialize(),
		success: function( data ) {
			$('#commentload_'+mediaid).append(data);
		},
		error: function(data) {
			$('#pesan').append('<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> Perhatian!</h4>Terjadi kesalahan. Coba lagi!</div>');
		}
    })
});

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

function follow(userid, type)
{
	$.ajax({
		headers : {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type: 'GET',
		url: '{{ URL('follow') }}',
		data:'userid='+userid+'&type='+type,
		success:function(msg){
			if(type == 0){
				$('#follow').removeClass("btn btn-sm btn-primary").addClass("btn btn-sm btn-default").attr("onclick", "follow('"+userid+"',1)").html('Follow');
			}else{
				$('#follow').removeClass("btn btn-sm btn-default").addClass("btn btn-sm btn-primary").attr("onclick", "follow('"+userid+"',0)").html('Unfollow');
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
				$('#like'+id).removeClass("fa fa-thumbs-down").addClass("fa fa-thumbs-o-down text-info icon_13").attr("onclick", "cwRating('"+id+"',1,'like_count"+id+"')");
			}else{
				$('#'+target).html(msg);
				$('#like'+id).removeClass("fa fa-thumbs-up").addClass("fa fa-thumbs-o-up text-info icon_13").attr("onclick", "cwRating('"+id+"',0,'like_count"+id+"')");
			}			
        },
		error: function(msg) {
			$('#pesan').append('<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> Perhatian!</h4>Gagal ngelike</div>');
			$('#like'+id).removeClass("fa fa-thumbs-up").addClass("fa fa-heart-o").attr("onclick", "cwRating('"+id+"',0,'like_count"+id+"')");
		}
    });
}

function nextfeed(maxid){
	var url = "{{ URL($user.'/feed/') }}";
	$.ajax({
        type:'GET',
        url: url+'/'+maxid,
        success: function( data ) {
			$('#feeds').append(data);
		},
		error: function(data) {
			$('#pesan').append('<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> Perhatian!</h4>Tidak ada media lagi</div>');
		}
    });
}

function loadcm(id){
	event.preventDefault();
	$('#commentload_'+id).html('<center><i class="fa fa-gear fa-spin" style="font-size:24px"></i></center>');
	var url = "{{ URL('viewcomment') }}/"+id;
	$.ajax({
		type:'GET',
		url: url,
		success: function( data ) {
			$('#commentload_'+id).html(data);
		},
		error: function(data) {
		$('#pesan').after('<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> Perhatian!</h4>Gagal memuat komentar</div>');
		}
	});
}
@endsection
@section('title')
<div class="title-right">
	<h2>{{ $user }}</h2>
</div>
@endsection
@section('content')
<div class="banner-bottom">
		<div id="loading"></div>
		<div class="banner-bottom-left">
			@if(is_null($ada))
				<a href="#" class="bookmark" id="bookmark" onClick="addbookmark('{{ $user }}', 1)">Add Bookmark</a>
			@else
				<a href="#" class="bookmark" id="bookmark" onClick="addbookmark('{{ $user }}', 0)">Delete Bookmark</a>
			@endif
		</div>
		<div class="banner-bottom-right">
			@if($friend == false)
				<a href="#" class="bookmark" id="follow" onClick="follow('{{ $userid }}', 1)">Follow</a>
			@else
				<a href="#" class="bookmark" id="follow" onClick="follow('{{ $userid }}', 0)">Unfollow</a>
			@endif
		</div>
		<div class="clear"> </div>
	</div>
	<div class="work-text" id="feeds">
		<h3>FEEDS</h3>
		@if($friend == true | $private == false)
			@foreach ($feeds->getItems() as $feed)
				<div id="{{ $feed->getId() }}div">
					@if(is_null($feed->getCaption()))
						No caption<br />
					@else
					<p>
						<?php $text = $feed->getCaption()->getText();
							$text = preg_replace('/(^|)@([a-z0-9_.]+)/i',
							'$1<a href="'.URL('$2/feed').'">@$2</a>', $text);
							$newtext = preg_replace('/\r?\n|\r/','<br/>', $text);
							echo $newtext.'<br />';
						?>
					</p>
					@endif
					@if($feed->getHasLiked() == 1)
						<span id="like{{ $feed->getId() }}" class="fa fa-heart" onClick="cwRating('{{ $feed->getId() }}',0,'like_count{{ $feed->getId() }}')"></span>
					@else
						<span id="like{{ $feed->getId() }}" class="fa fa-heart-o" onClick="cwRating('{{ $feed->getId() }}',1,'like_count{{ $feed->getId() }}')"></span>
					@endif
					<span class="counter" id="like_count{{ $feed->getId() }}">{{ $feed->getLikeCount() }}</span> likes  |  
					@if($feed->getCommentCount() > 0)
						<span class="fa fa-comment" onClick="loadcm('{{ $feed->getId() }}')"></span> {{ $feed->getCommentCount() }} comments
					@else
						<span class="fa fa-comment-o" onClick="loadcm('{{ $feed->getId() }}')"></span> {{ $feed->getCommentCount() }} comment
					@endif
					<div id="commentload_{{ $feed->getId() }}"></div>
				</div>
				<div class="clearfix"> </div>
				<br />
			@endforeach
			<br /><a id="max" href="#" onClick="nextfeed('{{ $feeds->getNextMaxId() }}')">Load More</a>
		@else
			Account Instagram ini dalam keadaan tergembok. Follow dulu kalau mau ngintip.
		@endif
	</div>
@endsection