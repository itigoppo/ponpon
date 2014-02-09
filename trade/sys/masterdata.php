<?php
/**
 * masterdata.php
 *
 * @author	HisatoS.
 * @package Pantter
 * @version 14/01/12 last update
 * @copyright http://www.nono150.com/
 */

/**
 * イベント関連クラス
 *
 * @author HisatoS.
 * @access public
 * @package Pantter
 */

class masterdata{

	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	function get_blstatus(){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."blstatus";
		$fld_name = NULL;
		$where = NULL;
		$db_param = array();
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
				$rtn_arr[$db_data["id"]] = $db_data["val"];
			}
			$rtn = $rtn_arr;
		}
		return $rtn;
	}

	function get_unit(){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."units";
		$fld_name = NULL;
		$where = NULL;
		$db_param = array();
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
				$unit = array(
						"unit" => $db_data["val"],
						"short" => $db_data["short"]
				);

				$members = $this->get_members($db_data["id"]);
				$unit["members"] = $members;

				$rtn_arr[$db_data["id"]] = $unit;
			}
			$rtn = $rtn_arr;
		}
		return $rtn;
	}

	function get_members($id){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."members";
		$fld_name = NULL;
		$where = "unit_id=".$id;
		$db_param = array();
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
				$member = array(
						"val" => $db_data["member"],
						"short" => $db_data["short"]
				);
				$rtn_arr[$db_data["id"]] = $member;
			}
			$rtn = $rtn_arr;
		}
		return $rtn;
	}

	function get_type(){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."type";
		$fld_name = NULL;
		$where = NULL;
		$db_param = array();
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
				$rtn_arr[$db_data["id"]] = $db_data["val"];
			}
			$rtn = $rtn_arr;
		}
		return $rtn;
	}

	function get_status(){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."trade_status";
		$fld_name = NULL;
		$where = NULL;
		$db_param = array();
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
				$rtn_arr[$db_data["id"]] = $db_data["val"];
			}
			$rtn = $rtn_arr;
		}
		return $rtn;
	}

}
