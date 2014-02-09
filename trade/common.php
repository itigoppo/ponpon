<?php
/**
 * common.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 11/12/06 last update
 * @copyright http://www.nono150.com/
 */

/**
 * ライブラリ関連
 */
// フレームワーク起動
$dir_fw = constant("DIR_FW");
require_once($dir_fw."Hanauta.php");
$Hanauta = new Hanauta($dir_fw);
// 処理時間計測開始
$Hanauta->obj["benchmark"]->start();

// Smarty起動
$dir_smarty = constant("DIR_SMARTY");
require_once($dir_smarty."Smarty.class.php");
$smarty = new Smarty();
//$smarty->template_dir = constant("DIR_SMARTY_TMPL")."/".$Hanauta->carrier;
$smarty->template_dir = constant("DIR_SMARTY_TMPL");
$smarty->compile_dir = constant("DIR_SMARTY_COMPILE");
$smarty->cache_dir = constant("DIR_SMARTY_CACHE");

/**
 * エラー出力
 */
$dir_lib = constant("DIR_LIB");
require_once($dir_lib."etc/ErrorHandler.php");
$error_handle = ErrorHandler::singleton();
$error_handle->addIgnoreError(array("errfile" => "#/PEAR/PEAR.php$#i", "errno" => E_STRICT));

/**
 * 外部ライブラリ読み込み
 */


/**
 * 変数設定
 */
// リクエストデータ取得
if(isset($Hanauta->_gvars["mode"])) $mode = $Hanauta->_gvars["mode"];
elseif(isset($Hanauta->_pvars["mode"])) $mode = $Hanauta->_pvars["mode"];
if(!isset($mode)) $mode = NULL;
if(isset($Hanauta->_gvars["func"])) $func = $Hanauta->_gvars["func"];
elseif(isset($Hanauta->_pvars["func"])) $func = $Hanauta->_pvars["func"];
if(!isset($func)) $func = NULL;
if(isset($Hanauta->_gvars["view"])) $view = $Hanauta->_gvars["view"];
elseif(isset($Hanauta->_pvars["view"])) $view = $Hanauta->_pvars["view"];
if(!isset($view)) $view = NULL;
if(isset($Hanauta->_gvars["page"])) $page = $Hanauta->_gvars["page"];
elseif(isset($Hanauta->_pvars["page"])) $page = $Hanauta->_pvars["page"];
if(!isset($page)) $page = 1;

// 共通変数
$sid = htmlspecialchars(SID);
$sid = session_name()."=".session_id();


/**
 * 共通処理
 */
// セッション削除
$Hanauta->obj["request"]->del_ses($Hanauta->_svars,array("token"));
if(isset($Hanauta->_gvars["logout"])){
	$Hanauta->obj["request"]->del_ses($Hanauta->_svars,array());
	header("Location: /trade/");
	exit;
}

$redirect = true;
$auth_flg = false;
$protected = false;
$login_data = false;
$screen_name = false;
$user_id = false;
$deny_list = false;
// Twitter認証
$login_data = $Hanauta->obj_ext["login"]->twitter();

// ブラックリスト確認
$bl = $Hanauta->obj_ext["login"]->checkBlacklist();

// 鍵垢チェック
if(isset($Hanauta->_svars["token"]["protected"]) && $Hanauta->_svars["token"]["protected"]){
	$protected = true;
}

if($login_data["type"] == "obj"){
	if(isset($Hanauta->_svars["token"]["screen_name"])){
		$screen_name = $Hanauta->_svars["token"]["screen_name"];
		$user_id = $Hanauta->_svars["token"]["user_id"];
		$deny_option = array(
				"user_id" => $user_id
		);
		$deny_list = $Hanauta->obj_ext["deny"]->get_list($deny_option);

		$contact_option = array(
				"user_id" => $user_id
		);
		$contact_list = $Hanauta->obj_ext["contact"]->get_list_ids($contact_option);
	}
	$auth_flg = true;
}

if($bl || $protected){
	$auth_flg = false;
}

// 許可ページ設定
if(preg_match("/trade\/index.php/",$Hanauta->script["name"])){
	$redirect = false;
}
if(preg_match("/trade\/login.php/",$Hanauta->script["name"])){
	$redirect = false;
}
if(preg_match("/trade\/about.php/",$Hanauta->script["name"])){
	$redirect = false;
}
if(preg_match("/trade\/detail.php/",$Hanauta->script["name"])){
	$redirect = false;
}
if(preg_match("/trade\/search.php/",$Hanauta->script["name"])){
	$redirect = false;
}
if(preg_match("/trade\/js\/js.php/",$Hanauta->script["name"])){
	$redirect = false;
}
if(preg_match("/trade\/admin/",$Hanauta->script["name"])){
	$redirect = false;
}

if(!$auth_flg && $redirect){
	$Hanauta->obj["request"]->del_ses($Hanauta->_svars,array());
	header("Location: /trade/");
	exit;
}

/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("site_title",$Hanauta->site_info["title"]);
$smarty->assign("site_url",$Hanauta->site_info["url"]);
$smarty->assign("script_file",$Hanauta->script["name"]);
$smarty->assign("script_dir",$Hanauta->script["dir"]);
$smarty->assign("server",$Hanauta->site_info["server"]);
$smarty->assign("time_info",$Hanauta->time_info);

$smarty->assign("fw_name",$Hanauta->version["FW_NAME"]);
$smarty->assign("fw_ver",$Hanauta->version["FW_VER"]);
$smarty->assign("fw_url",$Hanauta->version["FW_URL"]);
$smarty->assign("script_name",$Hanauta->version["SCR_NAME"]);
$smarty->assign("script_ver",$Hanauta->version["SCR_VER"]);
$smarty->assign("script_url",$Hanauta->version["SCR_URL"]);
if(isset($Hanauta->version["SCR_NAME_ORG"])){
	$smarty->assign("script_name_org",$Hanauta->version["SCR_NAME_ORG"]);
	$smarty->assign("script_ver_org",$Hanauta->version["SCR_VER_ORG"]);
	$smarty->assign("script_url_org",$Hanauta->version["SCR_URL_ORG"]);
}

$smarty->assign("login_data",$login_data);
$smarty->assign("bl",$bl);
$smarty->assign("screen_name",$screen_name);
$smarty->assign("user_id",$user_id);

?>