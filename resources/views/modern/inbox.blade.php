<div class="xs">
<h3>Inbox</h3>
	<div class="col-md-12 inbox_right">
            <div class="mailbox-content">
               <div class="mail-toolbar clearfix">
               </div>
                <table class="table">
                    <tbody>
						@foreach($inboxs as $inbox)
                        <tr class="unread checked" onClick="show('thread', '{{ $inbox->thread_id }}')">
                            <td>
							@if($inbox->has_newer == true)
							<b>{{ $inbox->thread_title }}</b>
							@else
								{{ $inbox->thread_title }}
							@endif
                            </td>
                            <td class="hidden-xs">
								@if(isset($inbox->items[0]->text))
								{{ $inbox->items[0]->text }}
								@else
								No Text
								@endif
                            </td>
                        </tr>
						@endforeach
                    </tbody>
                </table>
               </div>
    </div>
    <div class="clearfix"> </div>
</div>