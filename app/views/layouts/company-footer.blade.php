</div>
</section>

<footer id="bottomBar">
	<div>

		<div class="social-accounts" data-content-field="connected-accounts">
			<a href="http://instagram.com/lularoe" target="_blank" class="social-instagram"></a><a href="http://pinterest.com/lularoe" target="_blank" class="social-pinterest"></a><a href="https://www.facebook.com/LuLaRoe" target="_blank" class="social-facebook"></a>
		</div>

		<div class="sqs-layout sqs-grid-12 columns-12 footer-block" data-layout-label="Footer Content" data-type="block-field" data-updated-on="1357849584630" id="footerBlock">
			<div class="row sqs-row">
				<div class="col sqs-col-12 span-12">
					<div class="sqs-block html-block sqs-block-html" data-block-type="2" id="block-ad4281e24d901418cbf8">
						<div class="sqs-block-content">
		                    <?php
		                    	if (Auth::check()) {
									if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
			                    		$pages = Page::where('Reps', 1)->orWhere('Customers', 1)->orWhere('Public', 1)->where('public_footer', 1)->get();
									}
									elseif (Auth::user()->hasRole(['Customer'])) {
			                    		$pages = Page::where('Customers', 1)->orWhere('Public', 1)->where('public_footer', 1)->get();
									}
									elseif (Auth::user()->hasRole(['Rep'])) {
			                    		$pages = Page::where('Reps', 1)->orWhere('Public', 1)->where('public_footer', 1)->get();
									}
								}
								else $pages = Page::where('public_footer', 1)->where('Public', 1)->get();
		                    ?>
		                    @if (isset($pages))
			                    <ul class="footer-menu">
									<li><a href="/privacy-policy">Privacy Policy</a></li>
									<li><a href="/terms-conditions">Terms and Conditions</a></li>
									@foreach ($pages as $page)
										<li><a href="//{{ Config::get('site.domain') }}/pages/{{ $page->url }}">{{ $page->short_title }}</a></li>
									@endforeach
								</ul>
							@endif
							<br>
                            <div id="copyright-text">&copy; {{ date('Y') }} {{ Config::get('site.company_name') }} an LLR INC company
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

</div>
<script>
	Y.use('squarespace-ui-base', function(Y) {
		Y.one(".project-item .meta h1") && Y.one(".project-item .meta h1").plug(Y.Squarespace.TextShrink);
	}); 
</script>
<script type="text/javascript" src="https://static1.squarespace.com/static/ta/4fba5732e4b0935259821a4a/1769/scripts/combo/?site.js&dynamic-data.js&lazy-loader.js"></script>

<script type="text/javascript">
	var _mfq = _mfq || [];
	(function() {
		var mf = document.createElement("script");
		mf.type = "text/javascript";
		mf.async = true;
		mf.src = "//cdn.mouseflow.com/projects/16e40a9e-dcd9-44f6-a367-6e5d06dca6bb.js";
		document.getElementsByTagName("head")[0].appendChild(mf);
	})(); 
</script>
<script type="text/javascript" data-sqs-type="imageloader-bootstraper">
	(function() {
		if (window.ImageLoader) {
			window.ImageLoader.bootstrap();
		}
	})(); 
</script>
<script>Squarespace.afterBodyLoad(Y);</script>

</body>
</html>