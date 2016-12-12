<div class="xs">
<h3>Recent Activities</h3>
	<div class="col-md-12 email-list1">
               <ul class="collection">
			   <span class="email-title">Berita Terbaru</span><br />
			   @foreach($newnotis as $newnoti)
                    <li class="collection-item avatar email-unread">
                      <div class="avatar_left">
                        <p class="truncate grey-text ultra-small">{{ $newnoti->args->text }}</p>
                      </div>
                      <a href="#!" class="secondary-content"><span class="blue-text ultra-small">{{ date('m/d/Y', $newnoti->args->timestamp) }}</span></a>
                      <div class="clearfix"> </div>
                    </li>
				@endforeach
              </ul>
    </div>
	<div class="clearfix"> </div>
	<div class="col-md-12 email-list1">
               <ul class="collection">
			   <span class="email-title">Berita Lebih Lama</span><br />
			   @foreach($notis as $noti)
                    <li class="collection-item avatar email-unread">
                      <div class="avatar_left">
                        <p class="truncate grey-text ultra-small">{{ $noti->args->text }}</p>
                      </div>
                      <a href="#!" class="secondary-content"><span class="blue-text ultra-small">{{ date('m/d/Y', $noti->args->timestamp) }}</span></a>
                      <div class="clearfix"> </div>
                    </li>
				@endforeach
              </ul>
    </div>
    <div class="clearfix"> </div>
</div>