{include file="common/header.tpl"}

<div id="container">

	<section id="main_contents">

		<article class="row">
			<form action="/trade/search.php" method="get" id="search" class="row search">
			<ul>
				<li class="field">
					<label class="inline" for="trd">ID</label>
					<input class="normal text input" type="text" id="trd" name="trd" value="{$input.trd}" />
				</li>
				<li class="field">
					<label class="inline" for="event">イベント</label>
					<div class="picker">
					<select id="event" name="evt" data-select="{$input.evt}">
					<option value="-1">--お選びください--</option>
					</select>
					</div>
				</li>
				<li class="field">
					<label class="inline" for="de_part">出品</label>
					<div class="picker">
					<select id="de_part" name="dep" class="part" data-select="{$input.dep}">
					<option value="-1">--部--</option>
					</select>
					</div>
					<div class="picker">
					<select id="de_member" name="dem" class="member" data-select="{$input.dem}">
					<option value="-1">--メンバー--</option>
					</select>
					</div>
				</li>
				<li class="field">
					<label class="inline" for="mo_part">求む</label>
					<div class="picker">
					<select id="mo_part" name="mop" class="part" data-select="{$input.mop}">
					<option value="-1">--部--</option>
					</select>
					</div>
					<div class="picker">
					<select id="mo_member" name="mom" class="member" data-select="{$input.mom}">
					<option value="-1">--メンバー--</option>
					</select>
					</div>
				</li>
			</ul>
			<div class="medium primary btn">
				<input type="submit" value="Search" />
			</div>
			</form>
		</article>

		{if !$trade_list && $input}
			<article class="row">
				<section id="trade" class="row">
					<p class="twelve columns danger alert">
					検索結果がありませんでした。
					</p>
				</section>
			</article>

		{elseif $trade_list}
			<article class="row">

				<table class="striped rounded">
				{foreach name="trade" from=$trade_list key=t_key item=t_val}
				<tr>
				<td id="trade{$t_key}" class="trade status{$t_val.status}">
					<div class="row">
						<div class="twelve columns">
							{if $t_val.status == "1"}
							<div class="small success label">{$t_val.v_status}</div>
							{elseif $t_val.status == "2"}
							<div class="small warning label">{$t_val.v_status}</div>
							{elseif $t_val.status == "3"}
							<div class="small danger label">{$t_val.v_status}</div>
							{/if}
							<span class="info badge">ID:{$t_key}</span>
							<a href="/trade/d{$t_val.id}/">{$t_val.event}</a>
						</div>
					</div>
					<div class="row">
						<div class="two columns">
							<span class="primary badge">{$t_val.de.part}部</span>
							{$t_val.de.member.val}
						</div>
						<div class="one columns">
							<i class="icon-arrows-ccw"></i>
						</div>
						<div class="two columns">
							<span class="secondary badge">{$t_val.mo.part}部</span>
							{$t_val.mo.member.val}
						</div>
					</div>
					{if $t_val.note}
					<div class="row">
						<div class="twelve columns default alert">
						<i class="icon-chat"></i>
						{$t_val.note}
						</div>
					</div>
					{/if}
					{if $login_data.type == "obj"}
					<div class="row">
						<div class="twelve columns">
							{if $user_id != $t_val.user_id}
								{if $t_val.deny}
									<div class="danger alert">
									<i class="icon-block"></i>
									この人拒否中ですももも。
									</div>
								{elseif $t_val.contact}
									<div class="warning alert">
									<i class="icon-attention"></i>
									連絡済み
									</div>
								{else}
									<div class="medium info btn icon-left icon-twitter"><a href="/trade/d{$t_key}/">連絡する</a></div>
									{*<div class="medium info btn icon-left icon-twitter"><a href="#trade{$t_key}" class="send_contact" data-url="/trade/c{$t_key}/" data-tid="{$t_key}">連絡する</a></div>*}
								{/if}
							{elseif $user_id == $t_val.user_id}
								<div class="medium default btn icon-left icon-pencil"><a href="/trade/my/e{$t_key}/">編集する</a></div>
							{/if}
						</div>
					</div>
					{/if}
				</td>
				</tr><!--/ trade{$t_key} -->

				{/foreach}
				</table>

				<footer class="row">
					<nav>
					{$navi}
					</nav>

					<form action="#" method="post" id="contact">
					<div>
						<input type="hidden" id="id" name="id" value="" />
						<input type="hidden" id="pant" name="pant" value="" />
					</div>
					</form>
				</footer>
			</article>
		{/if}

	</section><!--/ maincontents -->
</div><!--/ container -->

{include file="common/footer.tpl"}
