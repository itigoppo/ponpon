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
$tmp_file = "my/regist.tpl";

// ページ用各変数初期化
$input = array();
$error = false;
$complete = false;
$trade_id = false;

/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);


if(isset($Hanauta->_pvars["pant"])){
	$regist = $Hanauta->obj_ext["trade"]->regist();
	$error = $regist["error"];
	$input = $Hanauta->_pvars;
	if($regist["regist"]){
		// 登録完了
		$input = array();
		$complete = true;
		$trade_id = $regist["trade_id"];
	}
//$Hanauta->obj["ponpon"]->pr($regist);
}

/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("input",$input);
$smarty->assign("error",$error);
$smarty->assign("complete",$complete);
$smarty->assign("trade_id",$trade_id);


// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();
$smarty->assign("cpus",$Hanauta->obj["benchmark"]->score);

// テンプレート出力
$smarty->display($tmp_file);

// 解析タグ
if($Hanauta->site_info["server"] == "sakura"){
	include("/home/itigoppo/www/ponpon/cgi/ana/lunalys/analyzer/write.php");
}
