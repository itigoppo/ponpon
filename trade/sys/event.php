<?php
/**
 * event.php
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

class event{

	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	/**
	 * イベントリスト
	 * @return array
	 */
	function get_list($option=false){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		$pref_list = $Hanauta->obj["address"]->get_pref("key");
		$unit_list = $Hanauta->obj_ext["masterdata"]->get_unit();
		$type_list = $Hanauta->obj_ext["masterdata"]->get_type();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."events";
		$fld_name = NULL;
		$where = NULL;
		if(isset($option["id"])){
			$where = "id=".$option["id"];
		}
		if(isset($option["now_date"])){
			$where = "day>='".$option["now_date"]."'";
		}
		$db_param = array(
				"orderby" => "day asc"
		);
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
				$event = $db_data;
				$event["v_pref"] = preg_replace("/都|道|府|県/","",$pref_list[$db_data["pref"]]);
				$event["v_unit"] = $unit_list[$db_data["unit"]];
				$event["v_type"] = $type_list[$db_data["type"]];
				$event["v_day"] = $Hanauta->obj["string"]->format_date($db_data["day"],false,"y/m/d");

				$times = $this->get_event_times($db_data["id"]);
				if($times){
					$event["times"] = $times;
				}
				if(isset($option["id"])){
					$rtn_arr = $event;
				}else{
					$rtn_arr[$db_data["id"]] = $event;
				}
			}
			$rtn = $rtn_arr;
		}
		return $rtn;
	}

	function get_event_times($id){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = false;

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."event_times";
		$fld_name = NULL;
		$where = "event_id=".$id;
		$db_param = array(
		);
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			$rtn_arr = array();
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
				$event = $db_data;

				$format_date = $Hanauta->time_info["year"]."-".$Hanauta->time_info["mon"]."-".$Hanauta->time_info["day"]." ".$db_data["time"];
				$event["v_time"] = $Hanauta->obj["string"]->format_date(strtotime($format_date),true,"H:i");

				$rtn_arr[$db_data["id"]] = $event;
			}
			$rtn = $rtn_arr;
		}
		return $rtn;
	}

	function regist(){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		$tbl_name = $Hanauta->site_info["db_prefix"]."events";
		$sql = "insert into ".$tbl_name."(day,unit,type,pref,place) values("
				."'".$Hanauta->_pvars["day"]."',"
				."'".$Hanauta->_pvars["unit"]."',"
				."'".$Hanauta->_pvars["type"]."',"
				."'".$Hanauta->_pvars["pref"]."',"
				."'".$Hanauta->_pvars["place"]."'".")";

		$result = $Hanauta->obj["read_db"]->send_query($sql,1);
		$last_id = mysql_insert_id();

		$sql_arr = array();

		for($cnt1 = 1;$cnt1 <= 10;$cnt1++){
			$key = "part".$cnt1;
			if(isset($Hanauta->_pvars[$key]) && $Hanauta->_pvars[$key]){
				$tbl_name = $Hanauta->site_info["db_prefix"]."event_times";
				$sql = "insert into ".$tbl_name."(event_id,part,time) values("
						."'".$last_id."',"
						."'".$cnt1."',"
						."'".$Hanauta->_pvars[$key]."'".")";
				array_push($sql_arr,$sql);
			}
		}


		$msg = NULL;
		foreach($sql_arr as $key => $val){
			$result = $Hanauta->obj["read_db"]->send_query($val,1);
			if(!$result){
				$msg .= $val."\n";
			}
		}
		print $msg;
		if(!$msg){
			$rtn_arr["regist"] = true;
		}else{
			$rtn_arr["regist"] = false;
		}
		$rtn = $rtn_arr;
		return $rtn;
	}

}
