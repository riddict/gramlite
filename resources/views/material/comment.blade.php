<div class="but_list">
@foreach($comments as $comment)
<div class="well">
<b>{{ $comment->getUser()->getUsername() }}</b>
	<?php $text = $comment->getText();
	$text = preg_replace('/(^|\s)@([a-z0-9_.]+)/i',
										'$1<a href="'.URL('$2/feed').'">@$2</a>', $text);
										$newtext = preg_replace('/\r?\n|\r/','<br/>', $text);
										echo $newtext.'<br />';
	?>


</div>
@endforeach
</div>
<form action="{{ URL('commenting') }}" method="get" class="comments" id="comments">

<input type="hidden" name="mediaid" value=" {{ $mediaid }}">
<div class="input-group">
<input disabled="" type="text" name="text" class="form-control1" placeholder="belum berfugsi komennya">
<div class="input-group-addon"><input type="submit" value="Go"></div>
</div>
</form>