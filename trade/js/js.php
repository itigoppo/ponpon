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
$tmp_file = "common/js.tpl";

// ページ用各変数初期化
$members = array();

/**
 * 処理開始
 */
// ヘッダ出力
header("Content-type: application/x-javascript");


$now_date = $Hanauta->time_info["year"]."-"
		.$Hanauta->time_info["mon"]."-"
		.$Hanauta->time_info["day"];

$event_option = array(
);
if($mode != "edit"){
	$event_option["now_date"] = $now_date;
}
$event_list = $Hanauta->obj_ext["event"]->get_list($event_option);


$unit_list = $Hanauta->obj_ext["masterdata"]->get_unit();
foreach($unit_list as $key => $val){
	foreach($val["members"] as $m_key => $m_val){
		$members[$m_key] = "【".$val["short"]."】".$m_val["val"];
	}
}

//$Hanauta->obj["ponpon"]->pr($unit_list);
//$Hanauta->obj["ponpon"]->pr($event_list);

/**
 *	テンプレート
 */
// テンプレート用変数設定
$smarty->assign("event_list",$event_list);
$smarty->assign("members",$members);


// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();
$smarty->assign("cpus",$Hanauta->obj["benchmark"]->score);

// テンプレート出力
$smarty->display($tmp_file);
