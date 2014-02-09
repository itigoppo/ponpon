{include file="common/header.tpl"}

<div id="container">

	<section id="main_contents">

	<article>

	<form action="./regist.php" method="post" id="regist" class="row">
	<ul>
		<li class="prepend field">
			<label class="inline" for="day">開催日</label>
			<span class="adjoined"><i class="icon-clock"></i></span>
			<input class="xwide text input" type="text" id="day" name="day" placeholder="{$time_info.year}/{$time_info.mon}/{$time_info.day}" value="{$input.day}" />
		</li>
		<li class="field">
			<label class="inline" for="unit">ユニット</label>
			<div class="picker">
			{html_options id=unit name=unit options=$unit_list selected=$input.unit}
			</div>
		</li>
		<li class="field">
			<label class="inline" for="type">タイプ</label>
			<div class="picker">
			{html_options id=type name=type options=$type_list selected=$input.type}
			</div>
		</li>
		<li class="field">
			<label class="inline" for="pref">開催地域</label>
			<div class="picker">
			{html_options id=pref name=pref options=$pref_list selected=$input.pref}
			</div>
		</li>
		<li class="field">
			<label class="inline" for="place">開催場所</label>
			<input class="normal text input" type="text" id="place" name="place" placeholder="開催場所" value="{$input.place}" />
		</li>
		<li class="field">
			<label class="inline" for="part1">1部</label>
			<input class="normal text input" type="text" id="part1" name="part1" placeholder="1部時間" value="{$input.part1}" />
		</li>
		<li class="field">
			<label class="inline" for="part2">2部</label>
			<input class="normal text input" type="text" id="part2" name="part2" placeholder="2部時間" value="{$input.part2}" />
		</li>
		<li class="field">
			<label class="inline" for="part3">3部</label>
			<input class="normal text input" type="text" id="part3" name="part3" placeholder="3部時間" value="{$input.part3}" />
		</li>
		<li class="field">
			<label class="inline" for="part4">4部</label>
			<input class="normal text input" type="text" id="part4" name="part4" placeholder="4部時間" value="{$input.part4}" />
		</li>
		<li class="field">
			<label class="inline" for="part5">5部</label>
			<input class="normal text input" type="text" id="part5" name="part5" placeholder="5部時間" value="{$input.part5}" />
		</li>
		<li class="field">
			<label class="inline" for="part6">6部</label>
			<input class="normal text input" type="text" id="part6" name="part6" placeholder="6部時間" value="{$input.part6}" />
		</li>
		<li class="field">
			<label class="inline" for="part7">7部</label>
			<input class="normal text input" type="text" id="part7" name="part7" placeholder="7部時間" value="{$input.part7}" />
		</li>
		<li class="field">
			<label class="inline" for="part8">8部</label>
			<input class="normal text input" type="text" id="part8" name="part8" placeholder="8部時間" value="{$input.part8}" />
		</li>
		<li class="field">
			<label class="inline" for="part9">9部</label>
			<input class="normal text input" type="text" id="part9" name="part9" placeholder="9部時間" value="{$input.part9}" />
		</li>
		<li class="field">
			<label class="inline" for="part10">10部</label>
			<input class="normal text input" type="text" id="part10" name="part10" placeholder="10部時間" value="{$input.part10}" />
		</li>
	</ul>
	<div class="medium default btn">
		<input type="hidden" id="pant" name="pant" value="1" />
		<input type="submit" value="Submit" />
	</div>
	</form>

	</article>

	</section><!--/ maincontents -->
</div><!--/ container -->

{include file="common/footer.tpl"}


