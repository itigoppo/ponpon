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
$tmp_file = "my/edit.tpl";

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

if(!isset($Hanauta->_gvars["id"])){
	$error = true;
}else{
	$trade_option = array(
			"id" => $Hanauta->_gvars["id"]
	);
	$trade_list = $Hanauta->obj_ext["trade"]->get_list($trade_option);

	if(!$trade_list){
		$error = true;
	}else{
		$input = array(
				"id" => $trade_list["id"],
				"event" => $trade_list["event_id"],
				"de_part" => $trade_list["de"]["id"],
				"de_member" => $trade_list["de"]["member_id"],
				"mo_part" => $trade_list["mo"]["id"],
				"mo_member" => $trade_list["mo"]["member_id"],
				"note" => $trade_list["note"],
				"status" => $trade_list["status"],
		);

	}
}

if($error){
	header("Location: /trade/");
	exit;
}

//$Hanauta->obj["ponpon"]->pr($input);
$status_list = $Hanauta->obj_ext["masterdata"]->get_status();
$contact_option = array(
		"trade_id" => $trade_option["id"]
);
$contact_list = $Hanauta->obj_ext["contact"]->get_list($contact_option);
$contact = false;
if($contact_list){
	$contact = true;
}

if(isset($Hanauta->_pvars["pant"])){
	$regist = $Hanauta->obj_ext["trade"]->edit($contact);
	$error = $regist["error"];
	$input = $Hanauta->_pvars;
	if($regist["regist"]){
		// 登録完了
		$input = array();
		$complete = true;
	}
}

/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("input",$input);
$smarty->assign("error",$error);
$smarty->assign("complete",$complete);
$smarty->assign("trade",$trade_list);
$smarty->assign("status_list",$status_list);
$smarty->assign("contact",$contact);
$smarty->assign("trade_edit",true);


// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();
$smarty->assign("cpus",$Hanauta->obj["benchmark"]->score);

// テンプレート出力
$smarty->display($tmp_file);

// 解析タグ
if($Hanauta->site_info["server"] == "sakura"){
	include("/home/itigoppo/www/ponpon/cgi/ana/lunalys/analyzer/write.php");
}
