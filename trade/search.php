<?php
/**
 * deny.php
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
$tmp_file = "search.tpl";

// ページ用各変数初期化
$input = array();
$trade_list = false;
$search = false;
$pg_prm = array();
$pg_navi = false;

/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);

//$Hanauta->obj["ponpon"]->pr($events);

// トレードリスト
$trade_option = array(
		"end" => false,
		"pager" => true,
		"page" => $page,
		"limit" => 10
);

if(isset($Hanauta->_gvars["trd"]) && $Hanauta->_gvars["trd"]){
	$search = true;
	$trade_option["id"] = $Hanauta->_gvars["trd"];
	$pg_prm[] = "trd=".$Hanauta->_gvars["trd"];
}

if(isset($Hanauta->_gvars["twt"]) && $Hanauta->_gvars["twt"]){
	$search = true;
	$trade_option["user_id"] = $Hanauta->_gvars["twt"];
	$pg_prm[] = "twt=".$Hanauta->_gvars["twt"];
}

if(isset($Hanauta->_gvars["evt"]) && $Hanauta->_gvars["evt"] != -1){
	$search = true;
	$trade_option["event_id"] = $Hanauta->_gvars["evt"];
	$pg_prm[] = "evt=".$Hanauta->_gvars["evt"];
}

if(isset($Hanauta->_gvars["dep"]) && $Hanauta->_gvars["dep"] != -1){
	$search = true;
	$trade_option["de_part"] = $Hanauta->_gvars["dep"];
	$pg_prm[] = "dep=".$Hanauta->_gvars["dep"];
}

if(isset($Hanauta->_gvars["dem"]) && $Hanauta->_gvars["dem"] != -1){
	$search = true;
	$trade_option["de_member"] = $Hanauta->_gvars["dem"];
	$pg_prm[] = "dem=".$Hanauta->_gvars["dem"];
}

if(isset($Hanauta->_gvars["mop"]) && $Hanauta->_gvars["mop"] != -1){
	$search = true;
	$trade_option["mo_part"] = $Hanauta->_gvars["mop"];
	$pg_prm[] = "mop=".$Hanauta->_gvars["mop"];
}

if(isset($Hanauta->_gvars["mom"]) && $Hanauta->_gvars["mom"] != -1){
	$search = true;
	$trade_option["mo_member"] = $Hanauta->_gvars["mom"];
	$pg_prm[] = "mom=".$Hanauta->_gvars["mom"];
}

if($search){
	$input = $Hanauta->_gvars;
	$trade_option["search"] = true;
	$trade_list = $Hanauta->obj_ext["trade"]->get_list($trade_option);

	$this_pg = "?";
	if(isset($pg_prm[0])){
		$this_pg .= implode("&", $pg_prm);
		$this_pg .= "&";
	}
	$this_pg .= "page=";
	$pg_navi = $Hanauta->obj["navigation"]->page_navi($trade_option["page"],$trade_list["total_cnt"],$trade_option["limit"],5,$this_pg);
	unset($trade_list["total_cnt"]);
}

//$event_list = $Hanauta->obj_ext["event"]->get_event();

//$Hanauta->obj["ponpon"]->pr($trade_list);

/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("input",$input);
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
