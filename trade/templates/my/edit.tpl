{include file="common/header.tpl"}

<div id="container">

	<section id="main_contents">

		<article>
			{if $complete}
			<section class="row">
				<div class="success alert">
					<ul>
						<li>取引番号：<span><a href="/trade/d{$trade.id}/">{$trade.id}</a></span> の情報を変更しました。</li>
						<li class="field">
						<input class="normal text input" type="text" id="note" name="note" value="{$site_url}d{$trade.id}/" />
						</li>
						<li>が取引URLになります。</li>
					</ul>
				</div>
			</section>

			{else}

				<form action="/trade/my/e{$input.id}/" method="post" id="edit" data-contact="{$contact}" class="row trade">
				<ul>
					<li class="field">
						<label class="inline" for="event">イベント</label>
						<div class="picker">
						<select id="event" name="event" data-select="{$input.event}">
						<option value="-1">--お選びください--</option>
						</select>
						</div>
					</li>
					<li class="field">
						<label class="inline" for="status">ステータス</label>
						<div class="picker">
						{html_options id=status name=status options=$status_list selected=$input.status}
						</div>
					</li>
					<li class="field">
						<label class="inline" for="de_part">出品</label>
						<div class="picker">
						<select id="de_part" name="de_part" class="part" data-select="{$input.de_part}">
						<option value="-1">--部--</option>
						</select>
						</div>
						<div class="picker">
						<select id="de_member" name="de_member" class="member" data-select="{$input.de_member}">
						<option value="-1">--メンバー--</option>
						</select>
						</div>
					</li>
					{if $error.de_part}
					<li class="alert danger">{$error.de_part}</li>
					{/if}
					{if $error.de_member}
					<li class="alert danger">{$error.de_member}</li>
					{/if}
					<li class="field">
						<label class="inline" for="mo_part">求む</label>
						<div class="picker">
						<select id="mo_part" name="mo_part" class="part" data-select="{$input.mo_part}">
						<option value="-1">--部--</option>
						</select>
						</div>
						<div class="picker">
						<select id="mo_member" name="mo_member" class="member" data-select="{$input.mo_member}">
						<option value="-1">--メンバー--</option>
						</select>
						</div>
					</li>
					{if $error.mo_part}
					<li class="alert danger">{$error.mo_part}</li>
					{/if}
					{if $error.mo_member}
					<li class="alert danger">{$error.mo_member}</li>
					{/if}
					<li class="field">
						<label class="inline" for="note">備考一言</label>
						<input class="normal text input" type="text" id="note" name="note" placeholder="例：○○であれば何部でもOKです" value="{$input.note}" />
					</li>
					{if $error.note}
					<li class="alert danger">{$error.note}</li>
					{/if}
				</ul>
				<div class="medium primary btn">
					<input type="hidden" id="pant" name="pant" value="1" />
					<input type="hidden" id="id" name="id" value="{$input.id}" />
					<input type="submit" value="Submit" />
				</div>
				</form>
			{/if}

		</article>

	</section><!--/ maincontents -->
</div><!--/ container -->

{include file="common/footer.tpl"}
