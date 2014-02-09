<?php
/**
 * regist.php
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
$tmp_file = "admin/regist.tpl";

// ページ用各変数初期化
$input = array();


/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);

// セッション削除
$Hanauta->obj["request"]->del_ses($Hanauta->_svars,array("auth"));
if(isset($Hanauta->_gvars["logout"])){
	$Hanauta->obj["request"]->del_ses($Hanauta->_svars,array());
}

// 都道府県リスト
$pref_list = $Hanauta->obj["address"]->get_pref("key");
$unit_list = $Hanauta->obj_ext["masterdata"]->get_unit();
$type_list = $Hanauta->obj_ext["masterdata"]->get_type();

$unit = array();
foreach($unit_list as $key => $val){
	$unit[$key] = $val["unit"];
}

if(isset($Hanauta->_pvars["pant"])){
	$regist = $Hanauta->obj_ext["event"]->regist();
	$input = $Hanauta->_pvars;
}



/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("time_info",$Hanauta->time_info);
$smarty->assign("pref_list",$pref_list);
$smarty->assign("unit_list",$unit);
$smarty->assign("type_list",$type_list);
$smarty->assign("input",$input);


// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();
$smarty->assign("cpus",$Hanauta->obj["benchmark"]->score);

// テンプレート出力
$smarty->display($tmp_file);

// 解析タグ
if($Hanauta->site_info["server"] == "sakura"){
	include("/home/itigoppo/www/ponpon/cgi/ana/lunalys/analyzer/write.php");
}
