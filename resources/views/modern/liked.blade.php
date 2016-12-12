@extends('modern.layouts.app')
@section('script')
@endsection
@section('content')
<div class="md">
<div class="row">
		@foreach($medias['items'] as $media)
		<div class="col-md-2 grid_box1">
		{{ $media['user']['username'] }}
			<!--<img class="media-object" style="width: 128px; height: 128px;" src=" media['image_versions2']['candidates'][0]['url'] " ><br />-->
		</div>
		@endforeach
</div>
</div>
@endsection