<?php
/**
 * 11panda.php
 *
 * @author	HisatoS.
 * @package mbcms_trade
 * @version 14/01/08 last update
 * @copyright http://www.nono150.com/
 */

// 設定ファイル
require_once("./config.php");

// 共通処理ファイル
require_once("./common.php");

/**
 * 変数設定
 */
// テンプレートファイル名
$tmp_file = "index.tpl";

// ページ用各変数初期化

/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);

// トレードリスト
$trade_option = array(
		"end" => true,
		"pager" => true,
		"page" => $page,
		"limit" => 10
);
$trade_list = $Hanauta->obj_ext["trade"]->get_list($trade_option);

$this_pg = "?page=";
$pg_navi = $Hanauta->obj["navigation"]->page_navi($trade_option["page"],$trade_list["total_cnt"],$trade_option["limit"],5,$this_pg);
unset($trade_list["total_cnt"]);
//$Hanauta->obj["ponpon"]->pr($tw_user);

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
	print 1;
	include("/home/itigoppo/www/ponpon/cgi/ana/lunalys/analyzer/write.php");
}
