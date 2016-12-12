@extends('modern.layouts.app')
@section('script')
<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$(document).on('submit', 'form.form-horizontal', function (event) {
        event.preventDefault();
		$('.wid_blog-desc').html('<center><i class="fa fa-gear fa-spin" style="font-size:24px"></i></center>');
        $.ajax({
            type: "GET",
            url: $(this).attr('action'),
            data: $('#search').serialize(),
			success: function( data ) {
				$('.wid_blog-desc').html(data);
			},
			error: function(data) {
				$('#pesan').append('<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> Perhatian!</h4>Gagal mencari hashtags</div>');
			}
        })
    });
</script>
@endsection
@section('content')
<div id="pesan"></div>
<div class="xs">
	<div class="tab-content">
		<div class="tab-pane active" id="horizontal-form">
			<form id="search" class="form-horizontal" action="{{ URL('searchht') }}" method="get">
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label">Search Hashtags</label>
					<div class="col-sm-8">
						<input class="form-control1" id="hashtags" type="text" name="hashtags" placeholder="Masukkan hashtags" required="">
						<input type="submit" class="btn-success btn" name="search" id="searchtags" value="Search">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="clearfix"> </div>
<div class="widget_1">
	<div class="col-md-12 widget_1_box2">
		<div class="wid_blog-desc">
		</div>
	</div>
	<div class="clearfix"></div>
</div>
@endsection
