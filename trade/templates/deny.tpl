{include file="common/header.tpl"}

<div id="container">

	<section id="main_contents">
		<article class="row">
			<table class="striped rounded">
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

			</table>

			{if $contact}
				<section id="trade" class="row">
					<p class="twelve columns success alert">
					この出品者を「拒否/拒否解除」しました。
					</p>
				</section>
			{else}
				<section id="trade" class="row">
					<p class="twelve columns danger alert">
					この出品者の「拒否/拒否解除」に失敗しました。<br />
					お手数ですが<a href="http://twitter.com/itigoppo">@itigoppo</a>まで取引IDを＠してきてください。
					</p>
				</section>
			{/if}

		</article>

	</section><!--/ maincontents -->
</div><!--/ container -->

{include file="common/footer.tpl"}