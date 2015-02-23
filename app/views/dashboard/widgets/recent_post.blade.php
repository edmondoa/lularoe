		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Company Announcements</h2>
			</div>
			<div class="panel-body">
				@if (count($recent_post) > 0)
					<h3 class="no-top no-bottom">{{ $recent_post->title }}</h3>
					<small>{{ $recent_post->date }}</small>
					{{ $recent_post->content }}
				@endif
			</div>
			@if (count($recent_post) > 0)
				<div class="panel-footer overflow-hidden">
					<a class="btn btn-primary pull-right" href="/posts/{{ $recent_post->url }}">Read More</a>
					<a class="btn btn-primary pull-right margin-right-1" href="/posts">All Announcements</a>&nbsp;&nbsp;
				</div>
			@endif
		</div><!-- panel -->