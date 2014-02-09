<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]><html class="no-js ie6 oldie" lang="ja"><![endif]-->
<!--[if IE 7]><html class="no-js ie7 oldie" lang="ja"><![endif]-->
<!--[if IE 8]><html class="no-js ie8 oldie" lang="ja"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="ja"><![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="ja" itemscope itemtype="http://schema.org/Product">
<!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta name="description" content="H!P個別トレ募集「とれぽん！」" />
	<meta name="author" content="HisatoS." />
	{*
	<meta property="og:site_name" content="A JACK IN THE BOX" />
	<meta property="fb:app_id" content="132755693507641" />
	<meta property="fb:admins" content="1260139042" />
	<meta property="og:locale" content="ja_JP" />
	<meta property="og:image" content="http://pantter.nono150.com/img/icon/PAf.png" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Pantter!!" />
	<meta property="og:description" content="ぱんだ特製オレオレクライアントぱんつ！" />
	<meta property="og:url" content="http://pantter.nono150.com/" />
	*}

	<link rel="stylesheet" href="/css/gumby/css/gumby.css">

	<script src="/css/gumby/js/libs/modernizr-2.6.2.min.js"></script>


	<link rel="stylesheet" href="/trade/css/style.css">

	<title>とれぽん！ - H!P acs ticket trade site</title>

</head>

<body>
	{*
	{literal}<div id="fb-root"></div>
	<script>
		( function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id))
					return;
				js = d.createElement(s);
				js.id = id;
				/*js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=132755693507641";*/
				js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=132755693507641";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
	</script>
	<script>
		! function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (!d.getElementById(id)) {
				js = d.createElement(s);
				js.id = id;
				js.src = "//platform.twitter.com/widgets.js";
				fjs.parentNode.insertBefore(js, fjs);
			}
		}(document, "script", "twitter-wjs");
	</script>
	<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
	<script type="text/javascript">
		window.___gcfg = {
			lang : 'ja'
		};

		(function() {
			var po = document.createElement('script');
			po.type = 'text/javascript';
			po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(po, s);
		})();
	</script>{/literal}
	*}

	<div id="wrapper">

		<section id="menu" class="navbar">
			<div class="row">
				<a class="toggle" gumby-trigger="#menu > .row > ul" href="#"><i class="icon-menu"></i></a>
				<h1 id="tops" class="four columns logo">
				<a href="/trade/"><img src="/trade/img/torepon.png" alt="とれぽす！" border="0"></a>
				</h1>
				<ul class="eight columns">
					<li><a href="/trade/about.php"><i class="icon-info"></i>せつめい！</a></li>
					<li><a href="/trade/search.php"><i class="icon-search"></i>みつける！</a></li>
					{if $login_data.type == "url"}
						<li><a href="/trade/login.php"><i class="icon-twitter"></i>つかう！</a></li>
					{elseif $bl}
						<li><a href="/trade/login.php"><i class="icon-twitter"></i>つかう！</a></li>
					{else}
					<li>
					<a href="#"><i class="icon-twitter"></i>@{$screen_name}</a>
					<div class="dropdown">
						<ul>
							<li><a href="/trade/my/regist.php">登録する</a></li>
							<li><a href="/trade/my/exhibit.php">出品リスト</a></li>
							<li><a href="/trade/my/contact.php">取引リスト</a></li>
							<li><a href="?logout=1">logout</a></li>
						</ul>
					</div>
					</li>
					{/if}
				</ul>
			</div>
		</section>


