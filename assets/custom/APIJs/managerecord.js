const token = localStorage.getItem("token");
const nowPageURL = location.href;
const NEW_PAGE_URL = new URL(nowPageURL);
const URL_Params = NEW_PAGE_URL.searchParams;
let datalength = "";
function filterData() {
	const data = {};
	const { searchParams } = NEW_PAGE_URL;
	if (NEW_PAGE_URL.search != "" && NEW_PAGE_URL.search != undefined) {
		for (let [key, value] of searchParams.entries()) {
			data[`${key}`] = JSON.parse(value);
			data["token"] = token;
		}
		sendFilterRequest(data);
	} else {
		getManageRecord();
	}
}
filterData();
function sendFilterRequest(filterdata) {
	$.ajax({
		url: baseUrl + "api/manage_record_search",
		type: "POST",
		dataType: "json",
		data: filterdata,
		success: function (res) {
			if (res.status) {
				render(res.data);
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

function getManageRecord() {
	$.ajax({
		url: baseUrl + "api/get_manage_record",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
		},
		success: function (res) {
			console.log(res)
			if (res.status) {
				render(res.list.data);
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

function render(data) {
	console.log('有更新吧..');
	let str = "";
	if (data.length == 0) {
		str = `
        <div class="no_list">
            尚無紀錄可顯示
        </div>
        `;
	} else {
		data.forEach((item) => {
			console.log(item);
			console.log(item["driver_id"]);
			str += `
            <div class="card order_card" data-order="${item["order_no"]}">
                <div class="card-body">
                    <h5 class="card-title">
                        ${item.date}
                        <a href="javascript:;" class="order_log">
                            <span class="status ${orderStatusLight(
															item["status_str"]
														)}">
                                ${item["status_str"]}
                            </span>
                        </a>
                    </h5>
                    <p class="card-subtitle">${item.time}</p>
                    <div class="card-text">
                        <p>起點 : ${item["address_start"]}</p>
                        ${AllTarget(item['address_end'])}
                    </div>
                    <div class="card-bottom">
                        <div class="remark">
                            <p>聯絡人名稱 : ${item.name}</p>
                            <p>聯絡人電話 : ${item.phone}</p>
                            <p>航班編號 : ${
															item.flight ? item.flight : "無"
														}</p>
                            <p>車型 : ${item["car_model"]}</p>
                            <p>行李數 : 2件</p>
                            <p>乘客數 : ${item.number}</p>
                            <p>備註 : ${item.remark ? item.remark : "無"}</p>
                            <a href="${
															item["driver_id"] != ""
																? `driver-Information?friend_id=${item["driver_id"]}`
																: "javascript:;"
														}">
                                <p>駕駛名稱 : ${
																	item["driver_name"] != ""
																		? item["driver_name"]
																		: "無指定"
																}</p>
                            </a>
                        </div>
                        <div class="price">
                            <p>${orderStatus(item["final_status"])} : $${
				item["final_payment"]
			}</p>
                            <p>車資 : $${item["price"]}</p>
                        </div>
                    </div>
                </div>
            </div>
            `;
		});
	}
	$(".manage_record").html(str);
}

function AllTarget(address) {
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

function orderStatus(status) {
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

function statusCn(status) {
	let status_cn = "";
	if (status == "start") {
		status_cn = "未執行"; // 訂單目前狀態
		driver_status = "start"; // 要post的狀態
	} else if (status == "to_start") {
		status_cn = "前往起點"; // 訂單目前狀態
		driver_status = "to_start"; // 要post的狀態
	} else if (status == "arrive_start") {
		status_cn = "抵達起點"; // 訂單目前狀態
		driver_status = "arrive_start"; // 要post的狀態
	} else if (status == "start_trip") {
		status_cn = "開始行程"; // 訂單目前狀態
		driver_status = "start_trip"; // 要post的狀態
	} else if (status == "end") {
		// location.href = "driver-index";
		status_cn = "行程結束"; // 訂單目前狀態
		driver_status = "end"; // 要post的狀態
	} else if (status == "finish") {
		status_cn = "抵達起點"; // 訂單目前狀態
	}else if (status == "make") {
		status_cn = "未派遣"; // 訂單目前狀態
	}
	return status_cn;
}

// function orderStatusLight(statuslight) {
// 	let statusLightClassName = "";
// 	switch (statuslight) {
// 		case "start":
// 			statusLightClassName = "dispatched";
// 			break;
// 		case "to_start":
// 		case "arrive_start":
// 		case "start_trip":
// 		case "finish":
// 			statusLightClassName = "processing";
// 			break;
// 	}
// 	return statusLightClassName;
// }

function orderStatusLight(statuslight) {
    let statusLightClassName = ''
    switch (statuslight) {
		case '未執行':
			statusLightClassName = 'dispatched'
            break
        case '未派遣':
            statusLightClassName = 'notdispatched'
            break
        case '已接到轉單':
            statusLightClassName = 'notdispatched'
            break
        case '待承接':
            statusLightClassName = 'undertaken'
            break
        case '已轉單':
            statusLightClassName = 'dispatched'
            break
        case '已有駕駛承接':
            statusLightClassName = 'dispatched'
            break
        case '已指定駕駛':
            statusLightClassName = 'dispatched'
            break
		case '完成行程':
        case "前往起點":
        case "抵達起點":
        case "開始行程":
            statusLightClassName = "processing";
            break;
    }
    return statusLightClassName
}

// 右上角行程modal
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
			console.log(res);
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
function rendorLog(data) {
	let str = "";
	for (let item in data) {
		console.log(item);
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

//右上角派遣紀錄/行程記錄匯出
$(document).on("click", ".download-dispatch", function (e) {
	e.preventDefault();

	$.ajax({
		url: baseUrl + "/api/export_manage_record",
		type: "POST",
		dataType: "text",
		data: {
			token: token,
		},
		success: function (res) {
			console.log(res);
			location.href = `${baseUrl}${res}`
		},
		error: function (err) {
			console.log(err);
		}
	});
});

$(document).on("click", ".download-undertake", function (e) {
	e.preventDefault();

	$.ajax({
		url: baseUrl + "/api/export_under_take_record",
		type: "POST",
		dataType: "text",
		data: {
			token: token,
		},
		success: function (res) {
			console.log(res);
			location.href = `${baseUrl}${res}`
		},
		error: function (err) {
			console.log(err);
		}
	});
});