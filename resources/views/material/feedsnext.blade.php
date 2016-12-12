@foreach ($feeds->getItems() as $feed)
	<div id="{{ $feed->getId() }}div">
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
<br /><a id="max" href="#" onClick="nextfeed('{{ $maxid }}')">Load More</a><br /><br />