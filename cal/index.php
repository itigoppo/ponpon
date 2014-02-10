<?php
/**
 * index.php
 *
 * @author	HisatoS.
 * @package MorningPorker
 * @version 11/12/06 last update
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
$year = false;
$month = false;

/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);

$search = array(
		"year" => date("Y"),
		"mon" => date("m"),
);
if(isset($_gvars["y"])) $search["year"] = $_gvars["y"];
if(isset($_gvars["m"])) $search["mon"] = $_gvars["m"];

$next = array(
		"year" => $search["year"],
		"mon" => $search["mon"] + 1,
);
$prev = array(
		"year" => $search["year"],
		"mon" => $search["mon"] - 1,
);
if($next["mon"] > 12){
	$next["year"]++;
	$next["mon"] = 1;
}
if($prev["mon"] < 1){
	$next["year"]--;
	$prev["mon"] = 12;
}


$event_list = $Hanauta->obj_ext["cal"]->get_ical();
$day_list = $Hanauta->obj_ext["cal"]->get_calendar($event_list,$search["year"],$search["mon"]);

//$Hanauta->obj["ponpon"]->pr($Hanauta->time_info);

/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("search",$search);
$smarty->assign("next",$next);
$smarty->assign("prev",$prev);
$smarty->assign("day_list",$day_list);

// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();
$smarty->assign("cpus",$Hanauta->obj["benchmark"]->score);

// テンプレート出力
$smarty->display($tmp_file);

// 解析タグ
if($Hanauta->site_info["server"] == "sakura"){
	include("/home/itigoppo/www/ponpon/cgi/ana/lunalys/analyzer/write.php");
}

?>