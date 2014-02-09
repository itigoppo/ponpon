		<footer id="footer" class="row">
			<section id="copyright" class="twelve columns">
			<p>
			Copyright(c) 2002-{$time_info.year} <a href="http://www.nono150.com/" title="A JACK IN THE BOX">A JACK IN THE BOX</a>. All rights reserved.
			</p>
			</section>
		</footer>

	</div>

	{*
	Grab Google CDN's jQuery, fall back to local if offline
	2.0 for modern browsers, 1.10 for .oldie
	*}
	{literal}
	<script>
	var oldieCheck = Boolean(document.getElementsByTagName('html')[0].className.match(/\soldie\s/g));
	if(!oldieCheck) {
		document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"><\/script>');
	} else {
		document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"><\/script>');
	}
	</script>
	<script>
	if(!window.jQuery) {
		if(!oldieCheck) {
			document.write('<script src="/css/gumby/js/libs/jquery-2.0.2.min.js"><\/script>');
		} else {
			document.write('<script src="/css/gumby/js/libs/jquery-1.10.1.min.js"><\/script>');
		}
	}
	</script>
	{/literal}


	{*
	Include gumby.js followed by UI modules followed by gumby.init.js
	Or concatenate and minify into a single file
	*}
	<script gumby-touch="/css/gumby/js/libs" src="/css/gumby/js/libs/gumby.min.js"></script>
	{*
	<script src="/css/gumby/js/libs/ui/gumby.retina.js"></script>
	<script src="/css/gumby/js/libs/ui/gumby.fixed.js"></script>
	<script src="/css/gumby/js/libs/ui/gumby.skiplink.js"></script>
	<script src="/css/gumby/js/libs/ui/gumby.toggleswitch.js"></script>
	<script src="/css/gumby/js/libs/ui/gumby.checkbox.js"></script>
	<script src="/css/gumby/js/libs/ui/gumby.radiobtn.js"></script>
	<script src="/css/gumby/js/libs/ui/gumby.tabs.js"></script>
	<script src="/css/gumby/js/libs/ui/gumby.navbar.js"></script>
	<script src="/css/gumby/js/libs/ui/jquery.validation.js"></script>
	<script src="/css/gumby/js/libs/gumby.init.js"></script>
	<script src="/css/gumby/js/plugins.js"></script>
	<script src="/css/gumby/js/main.js"></script>
	*}


	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="/js/plugins/jquery.disable.submit.js"></script>

	{if $script_file != "/trade/login.php"}
	<script src="/trade/js/js.php{if $trade_edit}?mode=edit{/if}"></script>
	<script src="/trade/js/trade.js"></script>
	{/if}

	{if $server != "local"}
	<script src="/cgi/ana/lunalys/analyzer/add.js"></script>
	{literal}
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-21055479-2', 'nono150.com');
	ga('send', 'pageview');
	</script>{/literal}
	{/if}


	{literal}
	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
		 chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
	{/literal}


</body>
</html>
