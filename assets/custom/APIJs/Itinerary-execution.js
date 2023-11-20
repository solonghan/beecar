// 頁面位置
sessionStorage.setItem("page", "index");
let token = localStorage.getItem("token");
let id = $.urlParam("order_id");
let timer = setInterval(() => {
    $.ajax({
		url: baseUrl + "api/get_order_detail",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			order_no: id,
		},
		success: function (res) {
			if (res.status) {
				if (res.driver_status == "finish") {
					alert("行程已結束");
					location.replace("driver-index");
				}
				render(res);
				// buttonStatus(res['driver_status'])
			} else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
					alert("無法取得訂單資訊，請確認網路連線");
                }
            }
		},
	});
}, 10000)
$(window).bind('beforeunload', function () {
    clearInterval(timer)
})
$.ajax({
	url: baseUrl + "api/get_order_detail",
	type: "POST",
	dataType: "json",
	data: {
		token: token,
		order_no: id,
	},
	success: function (res) {
		if (res.status) {
			if (res.driver_status == "finish") {
				alert("行程已結束");
				location.replace("driver-index");
			}
			render(res);
			// buttonStatus(res['driver_status'])
		} else {
			if(res.token_status == false){
				alert(res.msg);
				localStorage.clear();
				location.href = '../home/login'
			} else {
				alert("無法取得訂單資訊，請確認網路連線");
			}
		}
	},
});
function render(data) {
	console.log(data.order_middle,data.order_owner)
	data.friend_id = (data.order_middle == 0 ? data.order_owner : data.order_middle)
	console.log(data.friend_id)
	let str = `
            <div class="card-body order_card" data-order="${data["order_no"]}">
                <h5 class="card-title">
					${data["date"]}
                    <a href="javascript:;" class="order_log">
                        <span class="status ${orderStatusLight(
													data["driver_status"]
												)}">
                            ${statusCn(data["driver_status"])}
                        </span>
                    </a>
                </h5>
                <p class="card-subtitle">${data["time"]}</p>
                <div class="card-text">
                    <p>起點 : ${data["start_addr"]}</p>
					${AllTarget(data['end_addr'])}
                </div>
                <div class="card-bottom">
                    <div class="remark">
                        <p>聯絡人名稱 : ${data["name"]}</p>
                        <p>聯絡人電話 : ${data["phone"]}</p>
                        <p>航班編號 : ${data["flight"]}</p>
                        <p>車型 : ${data["car_model"]}</p>
                        <p>行李數 : ${data["baggage"]}件</p>
                        <p>乘客數 : ${data["number"]}人</p>
						<div style="display:flex;">
							<div>備註 :&nbsp;</div>
							<div style="white-space:pre-wrap;">${data["remark"]}</div>
						</div>
                        <a href="driver-Information?friend_id=${data["friend_id"]}"><p>派遣人 : ${data["sender_name"]}</p></a>
                    </div>
                    <div class="price">
                        <p>${finalStatus(data["final_status"])} : $${
		data["final_payment"]
	}</p>
                        <p>車資 : $${data["price"]}</p>
                    </div>
                </div>
            </div>
            `;
	$(".js-schedule-details").html(str);
}
function AllTarget(address) {
    console.log(address);
    if (typeof address === 'string') {
        return
    }else {
        let target = ''
        if (address) {
            if (address.length < 2) {
                address.forEach(e => {
                    target += `
                    <p>目的地 : ${e}</p>
                    `
                })
            } else {
                address.forEach((e, i) => {
                    target += `
                    <p>目的地${i+1} : ${e}</p>
                    `
                })
            }
            return target
        }else {
            return '<p>目的地: </p>'
        }
    }
}
function orderStatusLight(statuslight) {
	let statusLightClassName = "";
	switch (statuslight) {
		case "start":
			statusLightClassName = "dispatched";
			break;
		case "to_start":
		case "arrive_start":
		case "start_trip":
			statusLightClassName = "processing";
			break;
	}
	return statusLightClassName;
}
function finalStatus(status) {
	let final_status = "";
	switch (status) {
		case "0":
			final_status = "回金";
			break;
		case "1":
			final_status = "補貼";
			break;
	}
	return final_status;
}
let driver_status = "";
let status_cn = "";
function statusCn(status) {
	console.log(status);
	let status_cn = "";
	if (status == "start") {
		status_cn = "未執行"; // 訂單目前狀態
		driver_status = "start"; // 要post的狀態
		$(".js-status").text("前往起點"); // 按鈕文字
		$("#statusItinerary .modal-title").text("是否要開始行程?"); // modal 文字
	} else if (status == "to_start") {
		status_cn = "前往起點"; // 訂單目前狀態
		driver_status = "to_start"; // 要post的狀態
		$(".js-status").text("抵達起點"); // 按鈕文字
		$("#statusItinerary .modal-title").text("是否抵達起點?"); // modal 文字
	} else if (status == "arrive_start") {
		status_cn = "抵達起點"; // 訂單目前狀態
		driver_status = "arrive_start"; // 要post的狀態
		$(".js-status").text("開始行程"); // 按鈕文字
		$("#statusItinerary .modal-title").text("是否開始行程?"); // modal 文字
	} else if (status == "start_trip") {
		status_cn = "開始行程"; // 訂單目前狀態
		driver_status = "end"; // 要post的狀態
		$(".js-status").text("行程結束"); // 按鈕文字
		$("#statusItinerary .modal-title").text("是否行程結束?"); // modal 文字
	}
	// else if (status == "end") {
	// 	// location.href = "driver-index";
	// 	status_cn = "行程結束"; // 訂單目前狀態
	// 	driver_status = "end"; // 要post的狀態
	// 	$(".js-status").text("行程結束"); // 按鈕文字
	// 	$("#statusItinerary .modal-title").text("行程是否結束?"); // modal 文字
	// }
	return status_cn;
}
$(document).on("click", ".js-status", function (e) {
	$("#statusItinerary").modal("show");
});
$("#statusItinerary .yes").on("click", function (e) {
	console.log(driver_status);
	$.ajax({
		url: baseUrl + "api/drive_action",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			driver_status: driver_status,
			order_no: id,
		},
		success: function (res) {
			if (res.status) {
				console.log(res);
				if (res.driver_status == "end") {
					location.replace("driver-index");
				}
				location.reload();
			} else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
					alert('行程已被取消');
					location.href = 'driver-index'
                }
            }
		},
	});
});

$(".cancel_trip").on("click", function () {
	$.ajax({
		url: baseUrl + "api/drive_cancel",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			order_no: id,
		},
		success: function (res) {
			if (res.status) {
				location.replace("driver-index");
				console.log(res);
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
	});
});
$(document).on("click", ".order_log", function () {
	$(".order_log_modal").modal("show");
	let orderNo = $(this).parents(".order_card").data("order");
	$.ajax({
		url: baseUrl + "api/get_order_log",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			order_no: orderNo,
		},
		success: function (res) {
			if (res.status) {
				rendorLog(res.list);
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
	});
});
// <div class="divider bg-primary mt-2 mb-2"></div>
function rendorLog(data) {
	let str = "";
	for (let item in data) {
		if (item !== "status" && item !== "msg" && item !== "debug_post") {
			str += `
                    <div class="orderRecord">
                        <p class="text-left">${item}</p>
                        <ul class="orderRecordList">
                            ${logContent(data[item])}
                        </ul>
                    </div>
                    `;
		}
	}
	$(".order_log_modal .modal-body").html(str);
}
function logContent(arr) {
	let logStr = "";
	arr.forEach((item) => {
		logStr += `
                <li class="${item["status"] ? "" : "d-none"}">
                    <div class="dialog-content">${item["time"]}</div>
                    <div class="dialog-content">${item["status"]}</div>
                    <div class="dialog-content">
                        <p>${item["member"]}</p>
                    </div>
                </li>
                `;
	});
	return logStr;
}
