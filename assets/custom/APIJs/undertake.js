let token = localStorage.getItem("token");
const nowPageURL = location.href;
const NEW_PAGE_URL = new URL(nowPageURL);
const URL_Params = NEW_PAGE_URL.searchParams;
let timer = setInterval(() => {
	filterData();
}, 10000);
$(window).bind("beforeunload", function () {
	clearInterval(timer);
});
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
		getUnderTakeList();
	}
}
filterData();
function sendFilterRequest(filterdata) {
	$.ajax({
		url: baseUrl + "api/undertake_list_search",
		type: "POST",
		dataType: "json",
		data: filterdata,
		success: function (res) {
			if (res.status) {
				render(res.data);
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
function getUnderTakeList() {
	$.ajax({
		url: baseUrl + "api/undertake_list",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
		},
		success: function (res) {
			console.log(res)
			if (res.status) {
				render(res["list"]);
			} else {
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
	if (data[0] !=null) {
		data.forEach((item) => {
			str += `
			<div class="card card-list undertake_order" data-order="${item["order_no"]}">
				<a href="undertake-detail?order_id=${item["order_no"]}">
					<div class="card-body">
						<h5 class="card-title justify-content-start">
							${item["is_super"] == "1" ? `<img src="${baseUrl}assets/custom/img/super_icon.png" alt="image" class="mr-1"></img>` : ''}
							${item.date}
						</h5>
						<p class="card-subtitle">${item.time}</p>
						<div class="card-text">
							<p>起點 : ${item["address_start"]}</p>
							${AllTarget(item['address_end'])}
						</div>
						<div class="card-bottom">
							<div class="remark">
								<p>車型 : ${item["car_model"]}</p>
								<p>派遣人 : ${item["sender_name"]}</p>
							</div>
							<span class="price">實收 : $${item.price}</span>
						</div>
					</div>
				</a>
			</div>
			`;
		});
	} else {
		str = `
		<div class="no_list">
			<p>
				暫無可接行程
			</p>
		</div>
		`;
	}
	$(".undertake_list").html(str);
}
// ${AllTarget(item['address_end'])}
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