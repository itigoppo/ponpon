{include file="common/header.tpl"}

<div id="container">
	<section id="main_contents">
	<article class="row">
	<div class="medium btn pill-left default"><a href="?y={$prev.year}&m={$prev.mon}">前の月へ</a></div>
	<div class="medium squared btn default"><a href="?y={$time_info.year}&m={$time_info.mon}#e{$time_info.year}{$time_info.mon}{$time_info.day}0">今日にｼﾞｬﾝﾌﾟ</a></div>
	<div class="medium btn pill-right default"><a href="?y={$next.year}&m={$next.mon}">次の月へ</a></div>

	<h1>{$search.year}/{$search.mon}のイベントを表示中</h1>
	<div>
	各ユニットごとにGoogleカレンダーでまとめてあります。必要なのどうぞ。<br />
	<div class="small primary btn icon-left icon-calendar">
	<a href="https://www.google.com/calendar/embed?src=hf7qiq23gbltmnj3lg1pcifafk%40group.calendar.google.com&ctz=Asia/Tokyo">モーニング娘。'14</a>
	</div>
	<div class="small primary btn icon-left icon-calendar">
	<a href="https://www.google.com/calendar/embed?src=fpj0s3ks3icufc6eqnamua377k%40group.calendar.google.com&ctz=Asia/Tokyo">Berryz工房</a>
	</div>
	<div class="small primary btn icon-left icon-calendar">
	<a href="https://www.google.com/calendar/embed?src=ne57drdrbl4cn2q96ntk71sp9o%40group.calendar.google.com&ctz=Asia/Tokyo">℃-ute</a>
	</div>
	<div class="small primary btn icon-left icon-calendar">
	<a href="https://www.google.com/calendar/embed?src=njo79u6jenijqemk0jag4nfmh8%40group.calendar.google.com&ctz=Asia/Tokyo">スマイレージ</a>
	</div>
	<div class="small primary btn icon-left icon-calendar">
	<a href="https://www.google.com/calendar/embed?src=4jsukm5es9kpuf4c24hcm96og4%40group.calendar.google.com&ctz=Asia/Tokyo">光井愛佳</a>
	</div>
	<div class="small primary btn icon-left icon-calendar">
	<a href="https://www.google.com/calendar/embed?src=65sc2583tqhbh4rtnhvmvmjd18%40group.calendar.google.com&ctz=Asia/Tokyo">Juice=Juice</a>
	</div>
	<div class="small primary btn icon-left icon-calendar">
	<a href="https://www.google.com/calendar/embed?src=lst616hv95ljpc49ht5u3o68ho%40group.calendar.google.com&ctz=Asia/Tokyo">ハロプロ研修生</a>
	</div>
	<div class="small primary btn icon-left icon-calendar">
	<a href="https://www.google.com/calendar/embed?src=roc4rsqp4usngbti5kmokfm8m4%40group.calendar.google.com&ctz=Asia/Tokyo">OG</a>
	</div>
	<div class="small primary btn icon-left icon-calendar">
	<a href="https://www.google.com/calendar/embed?src=7bbr1qed7fe7jiuldvd5nb3gno%40group.calendar.google.com&ctz=Asia/Tokyo">LoVendoЯ</a>
	</div>

	</div>

	</article>

	<article class="row">

		<table class="striped rounded">
		{foreach name="event" from=$day_list key=d_key item=d_val}
		{if $d_val.event}
			{foreach from=$d_val.event item=e_val key=e_key}
			<tr>
			<td>
			<div id="e{$d_key}{$e_key}" class="events">
			{$d_val.day}({$d_val.week}) [
			{if $e_val.start_time == "00:00" && $e_val.end_time == "24:00"}
				終日
			{elseif $e_val.start_time == "00:00" && $e_val.end_time != "24:00"}
				〜{$e_val.end_time}
			{elseif $e_val.end_time == "-"}
				{$e_val.start_time}〜
			{else}
				{$e_val.start_time}〜{$e_val.end_time}
			{/if}
			]
			<br />
			{foreach from=$e_val.unit item=u_val key=u_key}
			{if $u_val != "dl"}
			<img src="./img/cal/{$u_val}.png" alt="{$e_val.unit_name[u_key]}" />
			{/if}
			{/foreach}
			{$e_val.name}
			</div>
			<div id="d{$d_key}{$e_key}" class="detail">
				開催地：{$e_val.location}
				{if $e_val.member.0}<br />
				参加メンバー：{$e_val.member|@implode:"、"}
				{/if}
			</div>
			</td>
			</tr>
			{/foreach}
		{/if}
		{/foreach}
		</table>
	</article>

	<article class="row">
	<div class="medium btn pill-left default"><a href="?y={$prev.year}&m={$prev.mon}">前の月へ</a></div>
	<div class="medium squared btn default"><a href="?y={$time_info.year}&m={$time_info.mon}#e{$time_info.year}{$time_info.mon}{$time_info.day}0">今日にｼﾞｬﾝﾌﾟ</a></div>
	<div class="medium btn pill-right default"><a href="?y={$next.year}&m={$next.mon}">次の月へ</a></div>
	</article>

	</section><!--/ maincontents -->
</div><!--/ container -->

{include file="common/footer.tpl"}