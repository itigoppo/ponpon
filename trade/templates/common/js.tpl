/**
 *
 * 設定
 *
 */

// イベントリスト
{literal}
var event_list = {
{/literal}
{foreach from=$event_list item="val" key="key" name="js"}
	"{$key}" :{literal}{{/literal}
		// イベント情報
		"val" : "【{$val.v_pref}】{$val.v_day} {$val.v_unit.short} {$val.v_type}",

		// メンバー
		"members" : {literal}{{/literal}
			{foreach from=$val.v_unit.members item="m_val" key="m_key" name="js2"}
			"{$m_key}" : "{$m_val.val}"{if !$smarty.foreach.js2.last},{/if}

			{/foreach}
		{literal}}{/literal},

		// 部
		"times" : {literal}{{/literal}
			{foreach from=$val.times item="m_val" key="m_key" name="js2"}
			"{$m_key}" : "{$m_val.part}部({$m_val.v_time}～)"{if !$smarty.foreach.js2.last},{/if}

			{/foreach}
		{literal}}{/literal}


	}{if !$smarty.foreach.js.last},{/if}

{/foreach}
{literal}}{/literal}


// メンバー
{literal}
var member_list = {
{/literal}
{foreach from=$members item="val" key="key" name="js"}
	"{$key}" : "{$val}"{if !$smarty.foreach.js.last},{/if}

{/foreach}
{literal}}{/literal}


