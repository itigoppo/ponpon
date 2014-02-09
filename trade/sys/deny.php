<?php
/**
 * deny.php
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

class deny{

	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	/**
	 * 拒否リスト
	 * @return array
	 */
	function get_list($option=false){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."denylist";
		$fld_name = NULL;
		$where = NULL;
		if(isset($option["user_id"])){
			$where = "user_id=".$option["user_id"];
		}
		if(isset($option["target_id"])){
			$where = "target_id=".$option["target_id"];
		}
		$db_param = array(
		);
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
				$deny = $db_data["target_id"];
				$rtn_arr[$db_data["id"]] = $deny;
			}
			$rtn = $rtn_arr;
		}
		return $rtn;
	}

	function regist($id){
		global $Hanauta;
		global $login_data;
		$rtn = false;
		$rtn_arr = false;

		$sql_arr = array();

		$tbl_name = $Hanauta->site_info["db_prefix"]."denylist";
		if($Hanauta->_pvars["mode"] == "deny"){
			// 拒否
			$reason = NULL;
			if($Hanauta->_pvars["reason"]){
				$reason = $Hanauta->obj["string"]->decode_str($Hanauta->_pvars["reason"]);
			}
			$sql = "insert into ".$tbl_name."(user_id,target_id,reason) values("
					."'".$Hanauta->_svars["token"]["user_id"]."',"
					."'".$id."',"
					."'".$reason."'".")";
			array_push($sql_arr,$sql);
		}elseif($Hanauta->_pvars["mode"] == "clear"){
			// 解除
			$sql = "delete from ".$tbl_name." where user_id='".$Hanauta->_svars["token"]["user_id"]."' and target_id='".$id."'";
			array_push($sql_arr,$sql);
		}

		$msg = NULL;
		foreach($sql_arr as $key => $val){
			$result = $Hanauta->obj["read_db"]->send_query($val,1);
			if(!$result){
				$msg .= $val."\n";
			}
		}
		if(!$msg){
			$rtn_arr["regist"] = true;
		}else{
			$rtn_arr["regist"] = false;
		}

		$rtn = $rtn_arr["regist"];

		return $rtn;
	}

}