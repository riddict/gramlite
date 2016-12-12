<div class="xs">
<h3>Inbox</h3>
	<div class="col-md-12 inbox_right">
            <div class="mailbox-content">
               <div class="mail-toolbar clearfix">
               </div>
                <table class="table">
                    <tbody>
					@foreach($threads['thread']['items'] as $thread)
                        <tr class="unread checked">
                            <td>
                                <?php echo $i->getUsernameInfo($thread['user_id'])->getUser()->getUsername(); ?>
                            </td>
                            <td>
							@if($thread['item_type'] == "text")
								{{ $thread['text'] }}
							@elseif ($thread['item_type'] == "media_share")
								{{ $thread['media_share']['caption']['text'] }} <br /> 
							@elseif ($thread['item_type'] == "like")
								<span class="fa fa-heart"></span><br /> 
							@else
								{{ $thread['item_type'] }}<br />
							@endif
                            </td>
                        </tr>
					@endforeach
                    </tbody>
                </table>
				
					@if($threads['thread']['pending'] == true)
						<a href="" onClick="show('terima', '{{ $threads['thread']['thread_id'] }}')">Terima</a>  |  <a href="" onClick="show('tolak')">Tolak</a><br />
					@else
						<br />
					@endif
            </div>
			   
    </div>
	<br />
	<div class="clearfix"> </div>
	<div class="col-md-12 inbox_right">
        	<div class="Compose-Message">               
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Reply 
                    </div>
                    <div class="panel-body">
                        <!--<div class="alert alert-info">
                            Please fill details to send a new message
                        </div>-->
						<form  class="ajax" id="ajax" action="{{ URL('sendmsg') }}" method="post">
						{{ csrf_field() }}
                        <label>Enter Message : </label>
						<input type="hidden" name="userid" value="{{ $threads['thread']['users'][0]['pk'] }}">
						<input type="hidden" name="threadid" value="{{ $threads['thread']['thread_id'] }}">
                        <textarea rows="6" class="form-control1 control2" name="text"></textarea>
                        <hr>
						<input type="submit" class="btn-success btn" name="reply" id="sendmsg" value="Balas Pesan">
						</form>
                    </div>
                 </div>
              </div>
         </div>
    <div class="clearfix"> </div>
</div>