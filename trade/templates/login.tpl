{include file="common/header.tpl"}

<div id="container">

	<section id="main_contents">

		<article>
			<section class="row">
				<div class="danger alert">
					<ul class="circle">
						<li>TwitterIDでログインになります。</li>
						<li>なのでTwitterIDさえあればだれでも使えますが、BL入りしてたら使えません。</li>
						<li>募集主のIDはわざと秘匿してありますのでこのサイトからトレの直接やりとりは出来ません。</li>
						<li>ただTwitter検索されて出てきたとかは責任持ちませんのでTwitterでのポストは気をつけるといいと思います。</li>
						<li>あとは鍵垢の方は想定していませんので鍵垢の方も使えません。ご了承ください。</li>
						<li>鍵垢からポストしても許可してる人以外の相手だと見えないのTwitterの仕様やで。</li>
					</ul>
				</div>
			</section>

			<section class="row">
				{if $login_data.type == "url"}
					<div class="medium primary btn"><a href="{$login_data.consumer}">twitter認証</a></div>
				{else}
					{if $error == "protect"}
						<div class="warning alert">プロテクトユーザーさんはシステムの性質上使えません。</div>
						<div class="small default btn"><a href="?logout=1">別のアカウントでログインする or 鍵解除してからもう一度</a></div>
					{elseif $error}
						<div class="warning alert">{$error}</div>
						<div>
							凍結解除は<a href="http://twitter.com/itigoppo">@itigoppo</a>までご相談ください。<br />
							解除要望に答えられるかどうかは分かりませんが不正凍結かどうかはお調べします。<br />
							対応にお時間かかる場合もございます。
						</div>
					{/if}
				{/if}
			</section>

		</article>

	</section><!--/ maincontents -->
</div><!--/ container -->

{include file="common/footer.tpl"}
