<?php
/**
 * contact.php
 *
 * @author	HisatoS.
 * @package mbcms_trade
 * @version 14/01/08 last update
 * @copyright http://www.nono150.com/
 */

// 設定ファイル
require_once("../config.php");

// 共通処理ファイル
require_once("../common.php");

/**
 * 変数設定
 */
// テンプレートファイル名
$tmp_file = "my/contact.tpl";

// ページ用各変数初期化

/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);

$contact_option = array(
		"user_id" => $Hanauta->_svars["token"]["user_id"],
		"end" => false,
		"pager" => true,
		"page" => $page,
		"limit" => 10
);
$contacts = $Hanauta->obj_ext["contact"]->get_list($contact_option);

//$Hanauta->obj["ponpon"]->pr($contact_list);
$this_pg = "?page=";
$pg_navi = $Hanauta->obj["navigation"]->page_navi($contact_option["page"],$contacts["total_cnt"],$contact_option["limit"],5,$this_pg);
unset($contacts["total_cnt"]);

// トレリスに置き換え
$trade_list = array();
if(is_array($contacts)){
	foreach($contacts as $key => $val){
		$trade_option = array(
				"id" => $val["trade_id"]
		);
		$trade = $Hanauta->obj_ext["trade"]->get_list($trade_option);
		$trade_list[$val["trade_id"]] = $trade;
	}
}

/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("trade_list",$trade_list);
$smarty->assign("navi",$pg_navi);

// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();
$smarty->assign("cpus",$Hanauta->obj["benchmark"]->score);

// テンプレート出力
$smarty->display($tmp_file);

// 解析タグ
if($Hanauta->site_info["server"] == "sakura"){
	include("/home/itigoppo/www/ponpon/cgi/ana/lunalys/analyzer/write.php");
}
