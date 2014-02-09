<?php
/**
 * trade.php
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

class trade{

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
		global $deny_list;
		global $contact_list;
		$rtn = false;
		$rtn_arr = array();

		$status_list = $Hanauta->obj_ext["masterdata"]->get_status();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."trades";
		$fld_name = NULL;
		$where = NULL;
		// トレードID
		if(isset($option["id"])){
			$where = "id=".$option["id"];
			if(isset($option["search"]) && $option["search"]){
				unset($option["id"]);
			}
		}
		// ユーザーID
		if(isset($option["user_id"])){
			if(isset($option["search"]) && $option["search"] && $where){
				$where .= " and ";
			}
			$where = "user_id=".$option["user_id"];
		}
		// イベントID
		if(isset($option["event_id"])){
			if(isset($option["search"]) && $option["search"] && $where){
				$where .= " and ";
			}
			$where = "event_id=".$option["event_id"];
		}
		// [出]部
		if(isset($option["de_part"])){
			if(isset($option["search"]) && $option["search"] && $where){
				$where .= " and ";
			}
			$where = "de_part=".$option["de_part"];
		}
		// [出]メンバー
		if(isset($option["de_member"])){
			if(isset($option["search"]) && $option["search"] && $where){
				$where .= " and ";
			}
			$where = "de_member=".$option["de_member"];
		}
		// [求]部
		if(isset($option["mo_part"])){
			if(isset($option["search"]) && $option["search"] && $where){
				$where .= " and ";
			}
			$where = "mo_part=".$option["mo_part"];
		}
		// [求]メンバー
		if(isset($option["mo_member"])){
			if(isset($option["search"]) && $option["search"] && $where){
				$where .= " and ";
			}
			$where = "mo_member=".$option["mo_member"];
		}


		// 終了分を出すか
		if(isset($option["end"]) && $option["end"]){
			if($where){
				$where .= " and ";
			}
			$where .= "status!=3";
		}

		$db_param = array(
			"orderby" => "status asc,id asc"
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
				// イベント
				$event_option = array(
					"id" => $db_data["event_id"]
				);
				$event = $Hanauta->obj_ext["event"]->get_list($event_option);
				$event_title ="【".$event["v_pref"]."】"
							.$event["v_day"]
							." ".$event["v_unit"]["short"]
							." ".$event["v_type"];
				$de = array(
						"id" => $db_data["de_part"],
						"member_id" => $db_data["de_member"],
						"time" => $event["times"][$db_data["de_part"]]["v_time"],
						"part" => $event["times"][$db_data["de_part"]]["part"],
						"member" => $event["v_unit"]["members"][$db_data["de_member"]]
				);
				$mo = array(
						"id" => $db_data["mo_part"],
						"member_id" => $db_data["mo_member"],
						"time" => $event["times"][$db_data["mo_part"]]["v_time"],
						"part" => $event["times"][$db_data["mo_part"]]["part"],
						"member" => $event["v_unit"]["members"][$db_data["mo_member"]]
				);

				// 拒否
				$deny_flg = false;
				if($deny_list){
					$deny_flg = in_array($db_data["user_id"],$deny_list);
				}

				// すでに問い合わせ済みか
				$contact_flg = false;
				if($contact_list){
					$contact_flg = in_array($db_data["id"],$contact_list);
				}

				//$Hanauta->obj["ponpon"]->pr($deny_list);
				$trade = array(
						"id" => $db_data["id"],
						"status" => $db_data["status"],
						"v_status" => $status_list[$db_data["status"]],
						"user_id" => $db_data["user_id"],
						"event_id" => $db_data["event_id"],
						"event" => $event_title,
						"event_place" => $event["place"],
						"de" => $de,
						"mo" => $mo,
						"note" => $db_data["note"],
						"deny" => $deny_flg,
						"contact" => $contact_flg,
						"contact_cnt" => $db_data["contact_cnt"],
				);
				//$Hanauta->obj["ponpon"]->pr($trade);

				if(isset($option["id"])){
					$rtn_arr = $trade;
				}else{
					$rtn_arr[$db_data["id"]] = $trade;
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
	 * 登録
	 * @return array
	 */
	function regist(){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// エラーチェック
		$chk_arr = array(
				"event" => array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","イベント",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","イベント",$Hanauta->error["E0002"])
						),
				),
				"de_part" => array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","【出品】部",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","【出品】部",$Hanauta->error["E0002"])
						),
				),
				"de_member" => array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","メンバー",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","メンバー",$Hanauta->error["E0002"])
						),
				),
				"mo_part" => array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","部",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","部",$Hanauta->error["E0002"])
						),
				),
				"mo_member" => array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","メンバー",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","メンバー",$Hanauta->error["E0002"])
						),
				),
				"note" => array(
						array(
								"rule" => "len",
								"msg" => mb_ereg_replace("##MSG##","一言",$Hanauta->error["E0011"]),
								"param" => array(
										"max" => 140
								)
						),
				),
		);
		$error = $Hanauta->obj["validate"]->error_msg($chk_arr);
		$rtn_arr["error"] = $error;
		$rtn_arr["regist"] = false;

		if(!$error["error"]){

			$now_date = $Hanauta->time_info["year"]."-"
					.$Hanauta->time_info["mon"]."-"
					.$Hanauta->time_info["day"]." "
					.$Hanauta->time_info["time_h"].":"
					.$Hanauta->time_info["time_i"].":"
					.$Hanauta->time_info["time_s"];

			$sql_arr = array();
			$tbl_name = $Hanauta->site_info["db_prefix"]."trades";
			$sql = "insert into ".$tbl_name."(status,user_id,event_id,de_part,de_member,mo_part,mo_member,note,created,modified) values("
					."1,"
					."'".$Hanauta->_svars["token"]["user_id"]."',"
					."'".$Hanauta->_pvars["event"]."',"
					."'".$Hanauta->_pvars["de_part"]."',"
					."'".$Hanauta->_pvars["de_member"]."',"
					."'".$Hanauta->_pvars["mo_part"]."',"
					."'".$Hanauta->_pvars["mo_member"]."',"
					."'".$Hanauta->obj["string"]->decode_str($Hanauta->_pvars["note"])."',"
					."'".$now_date."',"
					."'".$now_date."'".")";
			array_push($sql_arr,$sql);

			$msg = NULL;
			foreach($sql_arr as $key => $val){
				$result = $Hanauta->obj["read_db"]->send_query($val,1);
				$last_id = mysql_insert_id();
				if(!$result){
					$msg .= $val."\n";
				}
			}
			if(!$msg){
				$rtn_arr["regist"] = true;
				$rtn_arr["trade_id"] = $last_id;
			}else{
				$rtn_arr["regist"] = false;
			}

		}

		$rtn = $rtn_arr;
		return $rtn;
	}

	/**
	 * 編集
	 * @return array
	 */
	function edit($contact){
		global $Hanauta;
		$rtn = false;
		$rtn_arr = array();

		// エラーチェック
		$chk_arr = array(
				"id" => array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","ID",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","ID",$Hanauta->error["E0002"])
						),
				),
				"note" => array(
						array(
								"rule" => "len",
								"msg" => mb_ereg_replace("##MSG##","一言",$Hanauta->error["E0011"]),
								"param" => array(
									"max" => 140
								)
						),
				),
		);
		if(!$contact){
			// 取引なし
			$chk_arr["de_part"] = array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","【出品】部",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","【出品】部",$Hanauta->error["E0002"])
						),
					);
			$chk_arr["de_member"] = array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","メンバー",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","メンバー",$Hanauta->error["E0002"])
						),
					);
			$chk_arr["mo_part"] = array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","【出品】部",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","【出品】部",$Hanauta->error["E0002"])
						),
					);
			$chk_arr["mo_member"] = array(
						array(
								"rule" => "noempty",
								"msg" => mb_ereg_replace("##MSG##","メンバー",$Hanauta->error["E0002"])
						),
						array(
								"rule" => "han_num",
								"msg" => mb_ereg_replace("##MSG##","メンバー",$Hanauta->error["E0002"])
						),
					);
		}
		$error = $Hanauta->obj["validate"]->error_msg($chk_arr);
		$rtn_arr["error"] = $error;
		$rtn_arr["regist"] = false;

		if(!$error["error"]){

			$now_date = $Hanauta->time_info["year"]."-"
					.$Hanauta->time_info["mon"]."-"
					.$Hanauta->time_info["day"]." "
					.$Hanauta->time_info["time_h"].":"
					.$Hanauta->time_info["time_i"].":"
					.$Hanauta->time_info["time_s"];

			$sql_arr = array();
			$tbl_name = $Hanauta->site_info["db_prefix"]."trades";

			$sql = "update ".$tbl_name." set ".
					"status='".$Hanauta->_pvars["status"]."',";
			if(!$contact){
				$sql .= "de_part='".$Hanauta->_pvars["de_part"]."',".
					"de_member='".$Hanauta->_pvars["de_member"]."',".
					"mo_part='".$Hanauta->_pvars["mo_part"]."',".
					"mo_member='".$Hanauta->_pvars["mo_member"]."',";
			}
			$sql .= "note='".$Hanauta->_pvars["note"]."',".
					"modified='".$now_date."'".
					" where id='".$Hanauta->_pvars["id"]."'";
			array_push($sql_arr,$sql);

			$msg = NULL;
			foreach($sql_arr as $key => $val){
				$result = $Hanauta->obj["read_db"]->send_query($val,1);
				$last_id = mysql_insert_id();
				if(!$result){
					$msg .= $val."\n";
				}
			}
			if(!$msg){
				$rtn_arr["regist"] = true;
				$rtn_arr["trade_id"] = $last_id;
			}else{
				$rtn_arr["regist"] = false;
			}

		}

		$rtn = $rtn_arr;
		return $rtn;
	}
}
