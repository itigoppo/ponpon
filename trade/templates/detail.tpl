{include file="common/header.tpl"}

<div id="container">

	<section id="main_contents">

		<article class="row">
			<table class="striped rounded">
			<tbody>
			<tr>
			<th>取引番号</th>
			<td>
				{$trade.id}
			</td>
			</tr>
			<tr>
			<th>ステータス</th>
			<td>
				{if $trade.status == "1"}
				<div class="small success label">{$trade.v_status}</div>
				{elseif $trade.status == "2"}
				<div class="small warning label">{$trade.v_status}</div>
				{elseif $trade.status == "3"}
				<div class="small danger label">{$trade.v_status}</div>
				{/if}
			</td>
			</tr>
			<tr>
			<th>イベント</th>
			<td>
				{$trade.event}
			</td>
			</tr>
			<tr>
			<th>【出】</th>
			<td>
				<span class="primary badge">{$trade.de.part}部</span>
				{$trade.de.member.val}
			</td>
			</tr>
			<tr>
			<th>【求】</th>
			<td>
				<span class="secondary badge">{$trade.mo.part}部</span>
				{$trade.mo.member.val}
			</td>
			</tr>
			{if $trade.note}
			<tr>
			<th>一言</th>
			<td>
				{$trade.note}
			</td>
			</tr>
			{/if}
			</tbody>
			</table>


			{if $login_data.type == "obj"}

			<section id="trade" class="row">
				<p class="twelve columns">
					{if $user_id != $trade.user_id}
						{if $trade.deny}
							<div class="danger alert">
							<i class="icon-block"></i>
							この人拒否中ですももも。
							</div>
							<div class="small default btn icon-left icon-block"><a href="#trade" class="switch" gumby-trigger="#denywin">この出品者の拒否を解除する</a></div>
						{else}
							{if $trade.contact}
							<div class="warning alert">
							<i class="icon-attention"></i>
							連絡済み
							</div>
							{elseif $trade.status != "3"}

							<form action="#" method="post" id="contact">
							<div>
								<input type="hidden" id="id" name="id" value="" />
								<input type="hidden" id="pant" name="pant" value="" />
							</div>
							</form>

							<div class="medium info btn icon-left icon-twitter"><a href="#trade" id="send_contact" data-url="/trade/c{$trade.id}/" data-tid="{$trade.id}">連絡する</a></div>
							{/if}
							<div class="small default btn icon-left icon-block"><a href="#trade" class="switch" gumby-trigger="#denywin">この出品者を拒否する</a></div>
						{/if}
					{elseif $user_id == $trade.user_id}
					<div class="medium default btn icon-left icon-pencil"><a href="/trade/my/e{$trade.id}/">編集する</a></div>
					{/if}

					<div class="modal" id="denywin">
						<div class="content">
							<a class="close switch" gumby-trigger="|#denywin"><i class="icon-cancel" /></i></a>
							<div class="row">
								<div class="ten columns centered text-center">

									<form action="#" method="post" id="deny">
									<div>
										{if !$trade.deny}
											<ul>
												<li class="field">
												<label class="inline" for="reason">もしよければ理由をお願いします。</label>
												<input class="normal text input" type="text" id="reason" name="reason" placeholder="出品物詐欺だった等" value="{$input.reason}" />
												</li>
											</ul>

										{/if}
										<input type="hidden" id="id" name="id" value="" />
										<input type="hidden" id="pant" name="pant" value="" />
										<input type="hidden" id="mode" name="mode" value="" />
									</div>
									</form>

									{if $trade.deny}
										<p>この出品者の拒否を解除する。</p>
										<div class="medium danger btn icon-left icon-block">
											<a href="#trade" id="send_deny" data-url="/trade/deny{$trade.id}/" data-tid="{$trade.id}" data-mode="clear">解除する</a>
										</div>
									{else}
										<p>この出品者を拒否する。</p>
										<div class="medium danger btn icon-left icon-block">
											<a href="#trade" id="send_deny" data-url="/trade/deny{$trade.id}/" data-tid="{$trade.id}" data-mode="deny">拒否する</a>
										</div>
									{/if}
									<div class="btn primary medium">
										<a href="#" class="switch" gumby-trigger="|#denywin">Close Modal</a>
									</div>
								</div>
							</div>
						</div>
					</div>


				</p>
			</section>

			<section class="row">
				<div class="danger alert">
					<ul class="circle">
						<li>「連絡する」をクリックするとあなたのTwitterIDから相手のTwitterIDへ＠ポストを投稿します。</li>
						<li>そこから先は各自Twitter上で行って下さい。</li>
						<li>そっちでケンカになっても「とれぽん！」は責任負いません。</li>
						<li>責任負いませんがこの出品者とはもう取引したくないと思うのでそっと「拒否する」をクリックして下さい。</li>
						<li>該当の方の出品がブロックされます。</li>
						<li>Twitterの方は自分でなんとかしてください。ぶろっく！ぶろっく！</li>
						<li>＠出品者さんへ</li>
						<li>連絡するを1度でも押された取引はステータスが「取引中」に変わります。</li>
						<li>取引完了後はお手数ですが「終了」に変えに来てもらえると「連絡する」ボタン消えるので「とれぽん！」からの連絡は無くなると思います。</li>
						<li>交渉決裂したりした場合もちゃんと「募集中」に戻しにこないと他の人が声かけにくいですよ！</li>
					</ul>
				</div>
			</section>
			{/if}

		</article>

	</section><!--/ maincontents -->
</div><!--/ container -->

{include file="common/footer.tpl"}
