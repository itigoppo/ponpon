<?php
/**
 * cal.php
 *
 * @author	HisatoS.
 * @package MorningPorker
 * @version 11/12/09 last update
 * @copyright http://www.nono150.com/
 */

/**
 * ゲーム設定関連クラス
 *
 * @author HisatoS.
 * @access public
 * @package MorningPorker
 */

class cal{

	var $morngin_musume = "https://www.google.com/calendar/ical/hf7qiq23gbltmnj3lg1pcifafk%40group.calendar.google.com/public/basic.ics";
	var $berryz_kobo = "https://www.google.com/calendar/ical/fpj0s3ks3icufc6eqnamua377k%40group.calendar.google.com/public/basic.ics";
	var $cute = "https://www.google.com/calendar/ical/ne57drdrbl4cn2q96ntk71sp9o%40group.calendar.google.com/public/basic.ics";
	var $smileage = "https://www.google.com/calendar/ical/njo79u6jenijqemk0jag4nfmh8%40group.calendar.google.com/public/basic.ics";
	var $mitsui = "https://www.google.com/calendar/ical/4jsukm5es9kpuf4c24hcm96og4%40group.calendar.google.com/public/basic.ics";
	var $juice_juice = "https://www.google.com/calendar/ical/65sc2583tqhbh4rtnhvmvmjd18%40group.calendar.google.com/public/basic.ics";
	var $kensyu = "https://www.google.com/calendar/ical/lst616hv95ljpc49ht5u3o68ho%40group.calendar.google.com/public/basic.ics";
	var $og = "https://www.google.com/calendar/ical/roc4rsqp4usngbti5kmokfm8m4%40group.calendar.google.com/public/basic.ics";
	var $lovendor = "https://www.google.com/calendar/ical/7bbr1qed7fe7jiuldvd5nb3gno%40group.calendar.google.com/public/basic.ics";
	var $deadline = "https://www.google.com/calendar/ical/96gma3uvjo6icfjjbh12dn5924%40group.calendar.google.com/public/basic.ics";

	/**
	 * コンストラクタ
	 */
	function cal(){
	}

	function get_ical(){
		$rtn = false;
		$unit_list = array(
				"mm" => "モ。",
				"bk" => "BK",
				"cu" => "℃",
				"sm" => "ス",
				"mi" => "光",
				"jj" => "JJ",
				"ke" => "研",
				"og" => "OG",
				"lv" => "LЯ",
				"dl" => "締切",
		);
		$cal_list = array(
				"mm" => $this->morngin_musume,
				"bk" => $this->berryz_kobo,
				"cu" => $this->cute,
				"sm" => $this->smileage,
				"mi" => $this->mitsui,
				"jj" => $this->juice_juice,
				"ke" => $this->kensyu,
				"og" => $this->og,
				"lv" => $this->lovendor,
				"dl" => $this->deadline,
		);


		$event_list = array();
		foreach($unit_list as $u_key => $u_val){
			$cal_txt = file_get_contents($cal_list[$u_key]);
			// 正規表現でイベントを抜き出す
			//$sRegex = "(?P<header>((?!BEGIN:VEVENT).)+)BEGIN:VEVENT(?P<event>((?!END:VEVENT).)+)END:VEVENT";
			$sRegex = "BEGIN:VEVENT((?!END:VEVENT).)+END:VEVENT";
			if(preg_match_all("/".$sRegex."/is",$cal_txt,$matches)){
				foreach($matches[0] as $key => $val){
					// 配列化
					$val = explode("\n",$val);
					$val = array_map("trim",$val);
					$val = array_filter($val,"strlen");
					$val = array_values($val);
					$event = array();

					foreach($val as $c_key => $c_val){
						$c_val = explode(":",$c_val);
						// 開始日取得
						if($c_val[0] == "DTSTART"){
							$event["key"] = date("Ymd",strtotime($c_val[1]));
							$event["start_day"] = date("Y/m/d",strtotime($c_val[1]));
							$event["start_time"] = date("H:i",strtotime($c_val[1]));
						}
						// 終了日取得
						if($c_val[0] == "DTEND"){
							$event["end_day"] = date("Y/m/d",strtotime($c_val[1]));
							$event["end_time"] = date("H:i",strtotime($c_val[1]));
						}
						// 開催地
						if($c_val[0] == "LOCATION"){
							$event["location"] = $c_val[1];
							if(preg_match("/http/",$c_val[1])){
								$event["location"] .= ":".$c_val[2];
							}
						}
						// 内容
						if($c_val[0] == "SUMMARY"){
							$event["name"] = $c_val[1];
						}
						// 参加者
						if($c_val[0] == "DESCRIPTION"){
							$event["member"][] = $c_val[1];
						}
					}
					// ユニット
					$event["unit"][] = $u_key;
					$event["unit_name"][] = $u_val;
					if(isset($event["key"])){
						$event_list[$event["key"]][] = $event;
					}
				}
			}
		}

		// 数日またぎ
		foreach($event_list as $d_key => $d_val){
			foreach($d_val as $e_key => $e_val){
				if($e_val["start_day"] != $e_val["end_day"]){
					$stime = strtotime($e_val["start_day"]);
					$etime = strtotime($e_val["end_day"]);
					$day_sec = 60*60*24;
					// 期間中終日イベント
					for($cnt1=$stime; $cnt1<=$etime; $cnt1+=$day_sec){
						$event_copy = $e_val;
						$event_copy["key"] = date("Ymd",$cnt1);
						//$event_copy["start_day"] = date("Y/m/d",$cnt1);
						$event_copy["start_time"] = "00:00";
						$event_copy["end_time"] = "24:00";
						if($cnt1 == $etime){
							// 最終日
							$event_copy["end_time"] = $e_val["end_time"];
						}
						$event_list[$event_copy["key"]][] = $event_copy;
					}
					// 初日終了時間削除
					$e_val["end_time"] = "-";
					$d_val[$e_key] = $e_val;
				}
			}
			$event_list[$d_key] = $d_val;
		}
		// 同イベント整理
		foreach($event_list as $d_key => $d_val){
			$day_list = array();
			$key_list = array();
			$cnt1 = 0;
			$d_val_copy = $d_val;
			foreach($d_val as $e_key => $e_val){
				$event = $e_val["location"].$e_val["start_time"].$e_val["name"];
				$hit_key = array_search($event,$day_list);
				if($hit_key !== false){
					// ユニット追加して配列から削除
					$d_val[$key_list[$hit_key]]["unit"][] = $e_val["unit"][0];
					$d_val[$key_list[$hit_key]]["unit_name"][] = $e_val["unit_name"][0];
					$d_val[$key_list[$hit_key]]["member"][] = $e_val["member"][0];
					unset($d_val[$e_key]);
				}else{
					$day_list[$cnt1] = $event;
					$key_list[$cnt1] = $e_key;
				}
				$cnt1++;
			}
			$event_list[$d_key] = $d_val;

		}
		// 時間順にソート
		foreach($event_list as $d_key => $d_val){
			$time_sort = array();
			foreach($d_val as $e_key => $e_val){
				$time_sort[$e_key] = $e_val["start_time"];
			}
			array_multisort($time_sort,SORT_ASC,$d_val);
			$event_list[$d_key] = $d_val;
		}

		$rtn = $event_list;
		return $rtn;
	}



	function get_calendar($event_list,$year=false,$month=false){
		global $Hanauta;
		if(!$year){
			$year = date("Y");
		}
		if(!$month){
			$month = date("m");
		}
		$month = sprintf("%02d",$month);

		$s_day = $year."/".$month."/01";
		$e_day = date("t",strtotime($s_day));

		$day_list = array();
		for($cnt1=1; $cnt1<=$e_day; $cnt1++){
			$d_key = $year.$month.sprintf("%02d",$cnt1);
			$d_day = $year."-".$month."-".sprintf("%02d",$cnt1);
			$day_list[$d_key] = array(
					"day" => $d_day,
					"week" => $Hanauta->obj["string"]->get_week(explode("-",$d_day)),
			);
			if(isset($event_list[$d_key])){
				$day_list[$d_key]["cnt"] = count($event_list[$d_key]);
				$day_list[$d_key]["event"] = $event_list[$d_key];
			}
		}
		$rtn = $day_list;
		return $rtn;
	}


	/**
	 * iCalファイルをパースする
	 * @param  string $sFilePath iCalパス
	 * @param  string $iLimit    イベント制限数
	 * @return string            ical形式の文字列
	 */
	function getLimitCal($sFilePath,$iLimit = 100){
		$sReturn = '';
		//if(file_exists($sFilePath)){
			$sContents = file_get_contents($sFilePath); //ファイルを読み込む

			//正規表現でイベントを抜き出す
			//$sRegex = '(?P<header>((?!BEGIN:VEVENT).)+)BEGIN:VEVENT(?P<event>((?!END:VEVENT).)+)END:VEVENT';
			$sRegex = 'BEGIN:VEVENT((?!END:VEVENT).)+END:VEVENT';
			if(preg_match_all("/".$sRegex."/is",$sContents,$aMatch)){
				$aLimit = $aMatch[0];
				if($iLimit > 0){ //出力制限（ループしながらパースすれば○週間前とかも出来る）
					$aLimit = array_slice($aLimit,-$iLimit);
				}
				//正規表現でイベントを置き換える
				$sRegex = 'BEGIN:VEVENT.+END:VEVENT';
				//$sReturn = preg_replace("/" . $sRegex . "/is", '1', $sContents);
				$sReturn = preg_replace("/".$sRegex."/is",implode("\n",$aLimit),$sContents);
				//echo '<textarea rows=30 cols=100>' . $sReturn . '</textarea>';
			}
		//}
		return $sReturn;
	}

}

?>
