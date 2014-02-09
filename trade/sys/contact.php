<?php
/**
 * contact.php
 *
 * @author	HisatoS.
 * @package Pantter
 * @version 14/01/12 last update
 * @copyright http://www.nono150.com/
 */

/**
 * コンタクト関連クラス
 *
 * @author HisatoS.
 * @access public
 * @package Pantter
 */

class contact{

	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	/**
	 * リスト
	 * @return array
	 */
	function get_list($option=false){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."contacts";
		$fld_name = NULL;
		$where = NULL;
		if(isset($option["id"])){
			$where = "id=".$option["id"];
		}
		if(isset($option["user_id"])){
			$where = "user_id=".$option["user_id"];
		}
		if(isset($option["trade_id"])){
			$where = "trade_id=".$option["trade_id"];
		}
		$db_param = array(
			"orderby" => "created desc"
		);

		if(isset($option["pager"]) && $option["pager"]){
			$offset = $option["page"] - 1;
			$offset = ($offset == 0) ? $offset : $offset * $option["limit"];
			$db_param["offset"] = $offset;
			$db_param["limit"] = $option["limit"];
		}
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));

				//$Hanauta->obj["ponpon"]->pr($deny_list);
				$contact = $db_data;

				if(isset($option["id"])){
					$rtn_arr = $contact;
				}else{
					$rtn_arr[$db_data["id"]] = $contact;
				}
			}

			// 全件数取得
			$fld_name = "id";
			$db_param = array();
			$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
			$total_cnt = $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");
			$rtn_arr["total_cnt"] = $total_cnt;

			$rtn = $rtn_arr;
		}
		return $rtn;
	}

	/**
	 * リスト
	 * @return array
	 */
	function get_list_ids($option=false){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."contacts";
		$fld_name = NULL;
		$where = NULL;
		if(isset($option["user_id"])){
			$where = "user_id=".$option["user_id"];
		}
		$db_param = array(
		);

		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);
		if($db_rtn){
			for($cnt1 = 0;$cnt1 < $Hanauta->obj["read_db"]->get_result($db_rtn,"rows");$cnt1++){
				$db_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));

				//$Hanauta->obj["ponpon"]->pr($deny_list);
				$contact = $db_data;

				if(isset($option["id"])){
					$rtn_arr = $contact;
				}else{
					$rtn_arr[$db_data["id"]] = $contact["trade_id"];
				}
			}

			$rtn = $rtn_arr;
		}
		return $rtn;
	}


	/**
	 * トレード交渉
	 * @return array
	 */
	function regist($trade){
		global $Hanauta;
		global $login_data;
		$rtn = false;
		$rtn_arr = false;

		$now_date = $Hanauta->time_info["year"]."-"
				.$Hanauta->time_info["mon"]."-"
				.$Hanauta->time_info["day"]." "
				.$Hanauta->time_info["time_h"].":"
				.$Hanauta->time_info["time_i"].":"
				.$Hanauta->time_info["time_s"];

		$options = array(
				"user_id" => $trade["user_id"]
		);
		$tw_user = $Hanauta->obj["twitter"]->getUsersShow($login_data,$options);

		if(isset($tw_user["status"]["screen_name"])){
			$text = "@##ATID## ##EVENT## の ##DEPART##部##DEMEM##⇔##MOPART##部##MOMEM## の件お願いしにきましたっ。 ##URL## 【 by #とれぽん 】[id:##ID##]";
			$text = mb_ereg_replace("##ATID##",$tw_user["status"]["screen_name"],$text);
			$text = mb_ereg_replace("##ID##",$trade["id"],$text);
			$text = mb_ereg_replace("##EVENT##",$trade["event"],$text);
			$text = mb_ereg_replace("##DEPART##",$trade["de"]["part"],$text);
			$text = mb_ereg_replace("##DEMEM##",$trade["de"]["member"]["short"],$text);
			$text = mb_ereg_replace("##MOPART##",$trade["mo"]["part"],$text);
			$text = mb_ereg_replace("##MOMEM##",$trade["mo"]["member"]["short"],$text);
			$text = mb_ereg_replace("##URL##",$Hanauta->site_info["url"]."trade/d".$trade["id"]."/",$text);

			$options = array(
					"status" => $text,
			);
			$tl_data = $Hanauta->obj["twitter"]->updateStatus($login_data,$options);

			if(!isset($tl_data["status"]["errors"])){
				$rtn_arr["regist"] = true;
			}else{
				$rtn_arr["regist"] = false;
			}
		}

		if($rtn_arr["regist"]){
			$sql_arr = array();

			// トレード情報にコンタクトカウントプラス、ステータスを取引中に
			$tbl_name = $Hanauta->site_info["db_prefix"]."trades";
			$sql = "update ".$tbl_name." set status=2, contact_cnt=contact_cnt+1 where id='".$trade["id"]."'";
			array_push($sql_arr,$sql);

			// コンタクト情報
			$tbl_name = $Hanauta->site_info["db_prefix"]."contacts";
			$sql = "insert into ".$tbl_name."(user_id,trade_id,created) values("
					."'".$Hanauta->_svars["token"]["user_id"]."',"
					."'".$trade["id"]."',"
					."'".$now_date."'".")";
			array_push($sql_arr,$sql);

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
		}

		$rtn = $rtn_arr["regist"];
		return $rtn;
	}
}
