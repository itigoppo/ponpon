/**
 *
 * とれぽん！
 *
 */
$(document).ready(function() {
	// コンタクト
	var contact = $("a#send_contact");
	if(contact.size()){
		var contact_data = contact.data();
		contact.click(function () {
			$("#contact input#id").val(contact_data.tid);
			$("#contact input#pant").val("1");
			$("#contact").attr("action", contact_data.url);
			$("#contact").submit();
		});
	}

	// 拒否
	var deny = $("a#send_deny");
	if(deny.size()){
		var deny_data = deny.data();
		deny.click(function () {
			$("#deny input#id").val(deny_data.tid);
			$("#deny input#mode").val(deny_data.mode);
			$("#deny input#pant").val("1");
			$("#deny").attr("action", deny_data.url);
			$("#deny").submit();
		});
	}

	// 検索時
	var search = $(".search select#event");
	if(search.size()){
		// option追加
		for (var key in event_list) {
			$("select#event").append($("<option>").html(event_list[key]["val"]).val(key));
		}
		$("select.part").prop("disabled",true);

		// 初期値設定
		var events_data = search.data();
		var events_key = "-1";
		if(events_data.select) events_key = events_data.select;
		if(events_key != "-1"){
			search.val(events_key);
			// option追加
			create_select(events_key);

			// 出品
			var de_part_data = $("select#de_part").data();
			var de_part_key = "-1";
			if(de_part_data.select) de_part_key = de_part_data.select;
			if(de_part_key != "-1"){
				$("select#de_part").val(de_part_key);
			}

			// 求む
			var mo_part_data = $("select#mo_part").data();
			var mo_part_key = "-1";
			if(mo_part_data.select) mo_part_key = mo_part_data.select;
			if(mo_part_key != "-1"){
				$("select#mo_part").val(mo_part_key);
			}
		}else{
			search.val("-1");
			create_select_member();
		}

		// 出品
		var de_member_data = $("select#de_member").data();
		var de_member_key = "-1";
		if(de_member_data.select) de_member_key = de_member_data.select;
		if(de_member_key != "-1"){
			$("select#de_member").val(de_member_key);
		}

		// 求む
		var mo_member_data = $("select#mo_member").data();
		var mo_member_key = "-1";
		if(mo_member_data.select) mo_member_key = mo_member_data.select;
		if(mo_member_key != "-1"){
			$("select#mo_member").val(mo_member_key);
		}

		$("select#event").change(function(){
			var event_key = $("select#event option:selected").val();

			// option追加
			if(event_key != "-1"){
				create_select(event_key);
			}else{
				create_select_member();
			}

			$("select.part").prop("disabled",false);
		});
	}

	// 登録時
	var events = $(".trade select#event");
	if(events.size()){
		// option追加
		for (var key in event_list) {
			$("select#event").append($("<option>").html(event_list[key]["val"]).val(key));
		}
		$("select.part").prop("disabled",true);
		$("select.member").prop("disabled",true);

		// 初期値設定
		var events_data = events.data();
		var events_key = "-1";
		if(events_data.select) events_key = events_data.select;
		if(events_key != "-1"){
			events.val(events_key);
			// option追加
			create_select(events_key);

			// 出品
			var de_part_data = $("select#de_part").data();
			var de_part_key = "-1";
			if(de_part_data.select) de_part_key = de_part_data.select;
			if(de_part_key != "-1"){
				$("select#de_part").val(de_part_key);
			}
			var de_member_data = $("select#de_member").data();
			var de_member_key = "-1";
			if(de_member_data.select) de_member_key = de_member_data.select;
			if(de_member_key != "-1"){
				$("select#de_member").val(de_member_key);
			}

			// 求む
			var mo_part_data = $("select#mo_part").data();
			var mo_part_key = "-1";
			if(mo_part_data.select) mo_part_key = mo_part_data.select;
			if(mo_part_key != "-1"){
				$("select#mo_part").val(mo_part_key);
			}
			var mo_member_data = $("select#mo_member").data();
			var mo_member_key = "-1";
			if(mo_member_data.select) mo_member_key = mo_member_data.select;
			if(mo_member_key != "-1"){
				$("select#mo_member").val(mo_member_key);
			}
		}else{
			events.val("-1");
		}

		$("select#event").change(function(){
			var event_key = $("select#event option:selected").val();

			// option追加
			create_select(event_key);

			$("select.part").prop("disabled",false);
			$("select.member").prop("disabled",false);
		});

		// 編集時
		var edit_form = $("form#edit");
		if(edit_form.size()){
			var edit_data = edit_form.data();
			$("select#event").prop("disabled",true);

			if(edit_data.contact == 0){
				$("select.part").prop("disabled",false);
				$("select.member").prop("disabled",false);

			}
		}
	}

});

/**
 * 各selectのoptionを埋める
 * @return
 */
function create_select(event_key){

	// 部
	$("select.part option.add").remove();
	for (var key in event_list[event_key]["times"]) {
		$("select.part").append($("<option class=\"add\">").html(event_list[event_key]["times"][key]).val(key));
	}

	// メンバー
	$("select.member option.add").remove();
	for (var key in event_list[event_key]["members"]) {
		$("select.member").append($("<option class=\"add\">").html(event_list[event_key]["members"][key]).val(key));
	}

}
function create_select_member(){
	// 部
	$("select.part option.add").remove();
	// メンバー
	$("select.member option.add").remove();
	for (var key in member_list) {
		$("select.member").append($("<option class=\"add\">").html(member_list[key]).val(key));
	}

}