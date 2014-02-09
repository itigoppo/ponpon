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
$tmp_file = "detail.tpl";

// ページ用各変数初期化
$error = false;
$trade_list = false;

/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);

if(!isset($Hanauta->_gvars["id"])){
	$error = true;
}else{
	$trade_option = array(
			"id" => $Hanauta->_gvars["id"]
	);
	$trade_list = $Hanauta->obj_ext["trade"]->get_list($trade_option);

	if(!$trade_list){
		$error = true;
	}
}

if($error){
	header("Location: /trade/");
	exit;
}

//$event_list = $Hanauta->obj_ext["event"]->get_event();

//$Hanauta->obj["ponpon"]->pr($trade_list);

/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("trade",$trade_list);



// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();
$smarty->assign("cpus",$Hanauta->obj["benchmark"]->score);

// テンプレート出力
$smarty->display($tmp_file);

// 解析タグ
if($Hanauta->site_info["server"] == "sakura"){
	include("/home/itigoppo/www/ponpon/cgi/ana/lunalys/analyzer/tracker.php");
}
