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
					このトレードの問い合わせを出品者あてにTwitterにてポストしました。<br />
					この先は出品者とTwitterにて直接取引してください！<br />
					アディオス。
					</p>
				</section>
			{else}
				<section id="trade" class="row">
					<p class="twelve columns danger alert">
					問い合わせに失敗しました。<br />
					TwitterのAPI上限が切れてるとかシステムがなんかおかしいとかエラーにも色々ありますが15分ぐらい経ってからもう1度お試しください。
					</p>
				</section>
			{/if}

		</article>

	</section><!--/ maincontents -->
</div><!--/ container -->

{include file="common/footer.tpl"}