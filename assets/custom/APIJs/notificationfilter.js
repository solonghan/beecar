const token = localStorage.getItem("token");

$.ajax({
	url: baseUrl + "api/superfilter_list",
	type: "POST",
	dataType: "json",
	async: false,
	data: {
		token: token,
	},
	success: function (res) {
		if (res.status) {
			render(res.list);
		} else {
			if(res.token_status == false){
				alert(res.msg);
				localStorage.clear();
				location.href = '../home/login'
			} else {
				alert(res.msg);
			}
		}
	},
	error: function (err) {
		console.log(err);
	},
});
ActiveSuperInfo();
function ActiveSuperInfo() {
	$.ajax({
		url: baseUrl + "api/super_info_check",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
		},
		success: function (res) {
			if (res.type) {
				$('input:radio[name="superFifter"]').filter(`[value="${res.type}"]`).attr('checked', true);
			}
			if(res.token_status == false){
				alert(res.msg);
				localStorage.clear();
				location.href = '../home/login'
			} else {
				$("#superfiltercheck").prop("checked", false);
			}
		},
		error: function (err) {
			console.log(err);
		},
	});
}

function render(data) {
	let str = "";
	data.forEach((item, idx) => {
		let date = "";
		let time = "";
		if (item["start_date"] == "" && item["end_date"] == "") {
			date = "無";
		} else if (item["end_date"] == ""){
			date = `${item["start_date"]}`;
		} else {
			date = `${item["start_date"]} ~ ${item["end_date"]}`;
		}

		if (item["start_time"] == " " && item["end_time"] == " ") {
			time = "無";
		} else if (item["end_time"] == " "){
			time = `${item["start_time"]}`;
		} else {
			time = `${item["start_time"]} ~ ${item["end_time"]}`;
		}
		str += `
        <div class="filter-results">
            <div class="filter-results-header">
                <a href="javascript:;" class="delete" data-filterid="${
									item.id
								}">
                    <ion-icon name="remove-circle-outline"></ion-icon>
                    <span>刪除</span>
                </a>
            </div>
            <ul>
                <li>
                    日期 : ${date}
                </li>
                <li>
                    時間 : ${time}
                </li>
                <li class="d-flex">
					<div>起點地區 : </div>
					<div>${cityRender(item["start_addr"])}</div>
                    
                </li>
                <li class="d-flex">
					<div>目的地地區 : </div>
					<div>${cityRender(item["end_addr"])}</div>
                </li>
            </ul>
        </div>
        `;
	});
	$(".filter_list").html(str);
}
function cityRender(citylist) {
	if (citylist != " ") {
		let strAry = '';
		citylist.forEach((item) => {
			let str = `${item["city"] + " " + item["area"] + "<br>"}`;
			strAry+= str;
		});
		return strAry;
	} else {
		return "無";
	}
}
let deleteId = "";
$(document).on("click", ".delete", function (e) {
	deleteId = $(this).data("filterid");
	$("#delete").modal("show");
});

$(document).on("click", ".delete_y", function (e) {
	$.ajax({
		url: baseUrl + "api/del_superfilter",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			id: deleteId,
		},
		success: function (res) {
			if (res.status) {
				console.log(res);
				location.reload();
			} else {
				if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                }
			}
		},
		error: function (err) {
			console.log(err);
		},
	});
});

$("#superfiltercheck").on("change", function (e) {
	const checkstatus = $(this).prop("checked");
	let action = "off";
	if (checkstatus) {
		action = "on";
	} else {
		action = "off";
	}
	postSuperNotification(action);
});

$('input[type=radio][name=superFifter]').change(function() {
	$.ajax({
		url: baseUrl + "api/active_super_info_check",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			action: this.value,
		},
		success: function (res) {
			if (res.status) {
				Reload("toast-8", 3000);
				$("#toast-8 .text").text(`${res.msg}`);
			}else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                }
            }
		},
		error: function (err) {
			console.log(err);
		},
	});
});

function postSuperNotification(action) {
	$.ajax({
		url: baseUrl + "api/active_super_info_check",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			action: action,
		},
		success: function (res) {
			console.log(res);
			if (res.status) {
				Reload("toast-8", 3000);
				$("#toast-8 .text").text(`${res.msg}`);
			}else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                }
            }
		},
		error: function (err) {
			console.log(err);
		},
	});
}

async function Reload(ele, ms) {
	await creatToastbox(ele, ms);
}
function creatToastbox(target, time) {
	return new Promise((resolve, reject) => {
		var a = "#" + target;
		$(".toast-box").removeClass("show");
		setTimeout(() => {
			$(a).addClass("show");
		}, 100);
		if (time) {
			time = time + 100;
			setTimeout(() => {
				$(".toast-box").removeClass("show");
				resolve();
			}, time);
		}
	});
}

// GET 超級通知說明
function get_super_text(data = {token}) {
    $.ajax({
		url: baseUrl + "api/get_super_text",
		type: "POST",
		dataType: "json",
		data,
		success: function (res) {
			if (res.status) {
                $('#note .superTitle').text(res.data.title)
                $('#note .superdContent').html(res.data.content)
			} else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                }
            }
		},
		error: function (err) {
			console.log(err);
		},
	});
}
get_super_text()

// GET 超級通知 不再顯示 checkbox status
function get_super_text_status(data = {token}) {
    $.ajax({
		url: baseUrl + "api/get_super_text_status",
		type: "POST",
		dataType: "json",
		data,
		success: function (res) {
			if (res.status) {
				$("#note").modal('show')
                // $('#note .superTitle').text(res.data.title)
                // $('#note .superdContent').html(res.data.content)
			} else {
				$("#customCheckb1").prop("checked", true);
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                }
            }
		},
		error: function (err) {
			console.log(err);
		},
	});
}
get_super_text_status()

// POST 超級通知 確定
$(".changeStatus").click(function(e) {
	e.preventDefault();

	var isChecked = $("#customCheckb1").prop("checked");

	change_super_text_status(isChecked)
});
// post 改變超級通知 不再顯示 checkbox status
function change_super_text_status(isChecked){
	const data = {
		token,
		show_text_status:isChecked ? 'off' : 'on'
	}
	$.ajax({
		url: baseUrl + "api/change_super_text_status",
		type: "POST",
		dataType: "json",
		data,
		success: function (res) {
			if (res.status) {
				get_super_text_status()
			} else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                }
            }
		},
		error: function (err) {
			console.log(err);
		},
	});
}