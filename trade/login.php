<?php
/**
 * login.php
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
$tmp_file = "login.tpl";

// ページ用各変数初期化
$error = false;
$status = false;

/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);

if($login_data["type"] == "obj"){
	// セッション有効にするのにリロード
	if(isset($Hanauta->_gvars["cb"]) && $Hanauta->_gvars["cb"]){
		header("Location: ./login.php");
		exit;
	}
	if($Hanauta->_svars["token"]["protected"]){
		// プロテクトチェック
		$error = "protect";
	}else{
		// ブラックリストチェック
		$bl = $Hanauta->obj_ext["login"]->checkBlacklist();
		if($bl){
			$status_list = $Hanauta->obj_ext["masterdata"]->get_blstatus();
			$status = $status_list[$bl];
			$error = $Hanauta->obj["twitter"]->regist_ng;
		}else{
			header("Location: ./index.php");
			exit;
		}
	}
}


//$Hanauta->obj["ponpon"]->pr($login_data);

/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("error",$error);
$smarty->assign("status",$status);


// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();
$smarty->assign("cpus",$Hanauta->obj["benchmark"]->score);

// テンプレート出力
$smarty->display($tmp_file);

// 解析タグ
if($Hanauta->site_info["server"] == "sakura"){
	include("/home/itigoppo/www/ponpon/cgi/ana/lunalys/analyzer/write.php");
}
