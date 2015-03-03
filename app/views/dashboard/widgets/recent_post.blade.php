		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Announcements</h2>
			</div>
			<div class="panel-body">
				<h3 class="no-top no-bottom">{{ $recent_post->title }}</h3>
				<small>{{ $recent_post->date }}</small>
				{{ $recent_post->content }}
			</div>
			<div class="panel-footer overflow-hidden">
				<div class="btn-group pull-right">
					<a class="btn btn-default" href="/posts/{{ $recent_post->url }}">Read More</a>
					<a class="btn btn-default" href="/posts">All Announcements</a>
				</div>
			</div>
		</div><!-- panel -->