<?php
/**
 * login.php
 *
 * @author	HisatoS.
 * @package Pantter
 * @version 13/08/23 last update
 * @copyright http://www.nono150.com/
 */

/**
 * ログイン関連クラス
 *
 * @author HisatoS.
 * @access public
 * @package Pantter
 */

class login{

	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	/**
	 * twitter認証
	 *
	 * @access public
	 * @param bool		$regist		未登録時に登録するか
	 * @return array	エラーメッセージ、認証キー
	 */
	function twitter($regist = false){
		global $Hanauta;

		$rtn = array();
		$consumer = NULL;
		$token = array(
				"auth_flg" => false,
				"access_token" => NULL,
				"access_token_secret" => NULL
		);
		$auth_data = array(
				"db" => false,
				"user" => array()
		);

		if(isset($Hanauta->_svars["token"]["access_token"]) && isset($Hanauta->_svars["token"]["access_token_secret"])){
			$token = false;
			// session内トークン取得
			if(isset($Hanauta->_svars["token"]["flg"]) && $Hanauta->_svars["token"]["flg"] == "callback"){
				$token = array(
						"auth_flg" => true,
						"access_token" => $Hanauta->_svars["token"]["access_token"],
						"access_token_secret" => $Hanauta->_svars["token"]["access_token_secret"]
				);
			}
		}

		$consumer = $Hanauta->obj["twitter"]->twitter_auth($token);

		if($token["auth_flg"]){
			// 認証済み
			$rtn_arr = array(
					"type" => "obj",
					"consumer" => $consumer,
					"regist" => false
			);

			if(!isset($Hanauta->_svars["token"]["screen_name"])){
				$options = array(
				);
				$tw_setting = $Hanauta->obj["twitter"]->getSettings($rtn_arr,$options);
				$options = array(
						"screen_name" => $tw_setting["status"]["screen_name"]
				);
				$tw_user = $Hanauta->obj["twitter"]->getUsersShow($rtn_arr,$options);

				$s_token = $Hanauta->_svars["token"];
				$s_token["screen_name"] = $tw_setting["status"]["screen_name"];
				$s_token["user_id"] = $tw_user["status"]["id_str"];
				$s_token["protected"] = $tw_user["status"]["protected"];

				$Hanauta->obj["request"]->vars2ses("token",$s_token);
			}
		}else{
			// 登録用URL返却
			$rtn_arr = array(
					"type" => "url",
					"consumer" => $consumer,
					"regist" => false
			);
		}

		$rtn = $rtn_arr;
		return $rtn;
	}

	/**
	 * ブラックリストかチェック
	 * @return boolean
	 */
	function checkBlacklist(){
		global $Hanauta;

		$rtn = false;

		if(isset($Hanauta->_svars["token"]["user_id"]) && $Hanauta->_svars["token"]["user_id"]){
			$my_id = $Hanauta->_svars["token"]["user_id"];
		}else{
			return true;
		}

		$tb_name = $Hanauta->site_info["db_prefix"]."blacklist";
		$fldname = NULL;
		$where = "user_id='".$my_id."'";
		$db_param = array(
		);
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tb_name,$fldname,$where,$db_param);
		if($db_rtn){
			$entry = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
			$status = false;
			if($entry["status"] != 1){
				$status = $entry["status"];
			}
			$rtn = $status;
		}

		return $rtn;
	}

}
