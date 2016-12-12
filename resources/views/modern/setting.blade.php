@extends('modern.layouts.app')
@section('script')
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$(document).on('submit', 'form.ajax', function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $('#ajax').serialize(),
			success: function( data ) {
				$('#pesan').append('<div class="alert alert-success"><h4><i class="icon fa fa-check"></i> Sukses</h4>'+data+'</div>');
			},
			error: function(data) {
				$('#pesan').append('<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> Perhatian!</h4>Data gagal disimpan</div>');
			}
        })
    });
@endsection
@section('content')
	<div class="widget_1">
		<div class="col-md-12 widget_1_box2">
			<div id="pesan" role="alert">
			</div>
			<div class="wid_blog">
		   		<h1>Setting Gram CLient</h1>
		   	</div>
			<div class="wid_blog-desc">
				<div class="form-group">
					<form class="ajax" id="ajax" action="{{ URL('savesetting') }}" method="post">
					{{ csrf_field() }}
						<label for="selector1" class="col-sm-2 control-label">Template</label>
							<div class="col-sm-8"><select name="themes" id="themes" class="form-control1">
								@foreach($themes as $theme)
									@if(Auth::user()->theme_id == $theme->id)
									<?php $selected = "selected"; ?>
									@else
									<?php $selected = ""; ?>
									@endif
									<option value="{{ $theme->id }}" {{ $selected }}>{{ $theme->name }}</option>
								@endforeach
							</select></div>
					<div class="clearfix"> </div>
					<br /><br />
				
					<label for="radio" class="col-sm-2 control-label">Turn images</label>
					<div class="col-sm-8">
					@if(Auth::user()->images == "on")
						<div class="radio-inline"><label><input id="images" name="images" value="on" type="radio" checked> On</label></div>
						<div class="radio-inline"><label><input id="images" name="images" value="off" type="radio"> Off</label></div>
					@else
						<div class="radio-inline"><label><input id="images" name="images" value="on" type="radio"> On</label></div>
						<div class="radio-inline"><label><input id="images" name="images" value="off" type="radio" checked> Off</label></div>
					@endif
					</div>
				
					<br /><br />
					<div class="clearfix"> </div>
					@if(is_null($akun))
						Tambahkan Instagram Account<br />
					@else
						Hapus Akun Instagram dari Gram Client Klik <a href="{{ URL('delakun') }}">di sini<a/><br />
					@endif
					<br /><br />
					<div class="col-sm-8 col-sm-offset-2">
						<input type="submit" class="btn-success btn" name="simpan" id="setting" value="Simpan">
					</div>
					</form>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>
@endsection