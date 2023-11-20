//頁面位置
sessionStorage.setItem("page", "index");

$(document).ready(function () {
	getUserInfo(); // 駕駛資訊
	getDriverList(); // 已接列表
});
//訊息條
setTimeout(() => {
	notification("notification-welcome", 10000);
}, 2000);

let token = localStorage.getItem("token");
function getUserInfo() {
	$.ajax({
		url: baseUrl + "api/userinfo",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
		},
		success: function (res) {
			if (res.status) {
				renderName(res.user);
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
}
/* <a href="notification-filter">
<ion-icon name="flash-outline"></ion-icon>
</a>     先拿掉*/
function renderName(data) {
	str = `
        <h1>
            ${data.username}，嗨!
            
        </h1>
    `;
	$(".title").html(str);
}
let timer = setInterval(() => {
	getDriverList();
}, 10000);

$(window).bind("beforeunload", function (params) {
	clearInterval(timer);
});
function getDriverList() {
	$.ajax({
		url: baseUrl + "api/get_driver_list",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
		},
		success: function (res) {
			if (res.status) {
				// console.log(res)
				render(res["get_driver_list"]);
			}	else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
					location.href = `${res.url}`
                }
            }
		},
	});
}
function render(data) {
	let str = "";
	if (data.length != 0) {
		data.forEach((item) => {
			str += `
            <div class="card-Itinerary-execution card-list order_card" data-order="${
							item["order_no"]
						}">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            ${item.date}
                            <a href="javascript:;" class="order_log" data-toggle="modal" data-target="#lightdialog">
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
                                <p>派遣人 : ${item["sender_name"] || ""}</p>
                            </div>
                            <div class="price">
                                <p>${finalStatus(item["final_status"])} : $${
				item["final_payment"]
			}</p>
                                <p>車資 : $${item.price}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
		});
	} else {
		str = `
        <div class="no_list">
            <p>暫無已接行程</p>
        </div>
        `;
	}
	$(".js_section").html(str);
}
// ${AllTarget(item['address_end'])}
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
function orderStatusLight(statuslight) {
	let statusLightClassName = "";
	switch (statuslight) {
		case "未執行":
			statusLightClassName = "dispatched";
			break;
		case "前往起點":
		case "抵達起點":
		case "開始行程":
			statusLightClassName = "processing";
			break;
	}
	return statusLightClassName;
}
$(document).on("click", ".card-Itinerary-execution", function (e) {
	let val = e.target.nodeName;
	let orderid = $(this).data("order");
	if (val !== "SPAN") {
		window.location.href = `Itinerary-execution?order_id=${orderid}`;
	}
});
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
