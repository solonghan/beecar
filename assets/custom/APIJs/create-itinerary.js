let token = localStorage.getItem("token");
let searchData;
// $(".order_contact_person").on("keydown", function (e) {
// 	if (e.keyCode == 13) {
// 		sendCardRequest();
// 	}
// });
// $(".search-icon").on("click", function (e) {
// 	sendCardRequest();
// });
function sendCardRequest() {
	const phone = $(".order_contact_person").val().trim();
	$.ajax({
		url: baseUrl + "api/get_order_list",
		type: "POST",
		dataType: "json",
		async: false,
		data: {
			token: token,
			phone: phone,
		},
		success: function (res) {
			console.log(res);
			// $('.order_contact_person').attr('disabled',false)
			// $('.phone_search').css('display','block');
			// $('.searchbar_loading').css('display','none')
			if (res.status) {
				if (res["get_order_list"].length != 0) {
					createItineraryCard(res["get_order_list"]);
					searchData = res["get_order_list"];
				} else if (res["get_order_list"] == 0) {
					$("#sliderCard").html(`<p class="section">無使用紀錄</p>`);
					$('input[name="name"]').focus()
				}
			} else {
				if(res.token_status == false){
					alert(res.msg);
					localStorage.clear();
					location.href = '../home/login'
				}
			}
		},
	});
}
// 卡片輪播
function createItineraryCard(data) {
	console.log(data);
	let itineraryCard = "";
	let test1 = `
    <div class="carousel-single carousel-custom owl-carousel owl-theme carousel_order_card"></div>
    `;
	$("#sliderCard").html(test1);
	data.forEach((item) => {
		console.log(item);
		itineraryCard += `
        <div class="card create_record_card" id="${item["order_no"]}">
            <div class="card-body">
                <h5 class="card-title">
                    ${item.date}
                </h5>
                <p class="card-subtitle">${item.time}</p>
                <div class="card-text">
                    <p>起點 : ${item["address_start"]}</p>
                    <p class="d-flex">目的地 : <span class="d-flex flex-column">${endLoop(
											item.end
										)}</span></p>
                </div>
                <div class="card-bottom">
                    <div class="remark">
                        <p>航班編號 : ${item.flight || "無"}</p>
                        <p>車型 : ${item["car_model"]}</p>
                        <p>行李數 : ${item.baggage}件</p>
                        <p>乘客數 : ${item.number}人</p>
                        <p>備註 : ${item.remark || "無"}</p>
                    </div>
                </div>
            </div>
        </div>
        `;
	});
	$(".carousel-single").append(itineraryCard);
	let owl = $(".carousel-single");
	owl.owlCarousel({
		stagePadding: 30,
		loop: true,
		margin: 16,
		nav: true,
		dots: false,
		responsiveClass: true,
		responsive: {
			0: {
				items: 1,
			},
			768: {
				items: 3,
			},
		},
	});
}
function endLoop(endary) {
	console.log(endary);
	let str = "";
	endary.forEach((item) => {
		// console.log(item);
		str += `
        <span>${item["city"] + item["dist"] + item["address"]}</span>
        `;
	});
	console.log(str);
	return str;
}
{
	/* <div class="item order_item" id="${item['order_no']}">
<div class="card">
    <div class="card-body">
        <h5 class="card-title">${item.date}</h5>
        <div class="card-text">
            <p>起點 : ${item['address_start']}</p>
            <p>目的地 : ${item['address_end']}</p>
        </div>
    </div>
</div>
</div> */
}
// 篩選點到的小卡，並顯示詳細資訊
let chooseOrder = "";
function filterSearchData(item) {
	if (chooseOrder == item["order_no"]) {
		return true;
	}
}
$(document).on("click", ".create_record_card", function (e) {
	// console.log(e);
	let order_id = $(this).attr("id");
	console.log(searchData);
	chooseOrder = order_id;
	let arrById = searchData.filter(filterSearchData);
	detailOrderCard(arrById);
	// console.log(arrById);
});
//顯示大卡片
let filterOrder;
let areaNum = "" || 1;
function detailOrderCard(data) {
	console.log(data);
	$('input[name="name"]').focus()
	$(`input[name="name"]`).val(`${data[0]["name"]}`);
	$(`#remark`).val(`${data[0]["remark"]}`);
	$(`select[name="car_model"] option[value="${data[0]["car_model"]}"]`).prop(
		"selected",
		true
	);
	$('input[name="number"]').val(`${data[0]["number"] || ""}`);
	$('input[name="baggage"]').val(`${data[0]["baggage"] || ""}`);
	$('input[name="remark"]').val(`${data[0]["remark"] || ""}`);
	$(`#startCity option[value="${data[0]["start_city"]}"]`).attr(
		"selected",
		"selected"
	);
	$(`#startAddress`).val(`${data[0]["start_addr"]}`);
	let startCity = $("#startCity");
	area(data[0]["start_city"], startCity);
	$(`#startDist option[value="${data[0]["start_dist"]}"]`).attr(
		"selected",
		"selected"
	);
	let endAry = data[0].end;
	areaNum = data[0].end.length;
	let cardDetailEndForm = "";
	endAry.forEach((item) => {
		cardDetailEndForm += `
        <div class="form-group boxed form-multiple end_form areaList" data-destination="${item.sort}">
            <a href="#" class="delete" data-toggle="modal">
                <ion-icon name="remove-circle-outline"></ion-icon>
                <span>刪除</span>
            </a>
            <div class="input-wrapper">
                <label class="label" for="">目的地城市</label>
                <select class="form-control custom-select city_select" id="endCity${item.sort}" name="end_city" required>
                </select>
                <div class="invalid-feedback">請選擇目的地城市</div>
            </div>
            <div class="input-wrapper">
                <label class="label" for="">目的地區域</label>
                <select class="form-control custom-select area_select" id="endDist${item.sort}" name="end_area" required>
                </select>
                <div class="invalid-feedback">請選擇目的地區域.</div>
            </div>
            <div class="input-textarea">
                <label class="label d-flex justify-content-between" for="">
                    目的地詳細地址
                    <span class="commonly_county">
                        <a href="javascript:;" class="text-primary commonly_county">選擇常用地點</a>
                    </span>
                </label>
                <textarea class="form-control address" name="address" id="endAddress${item.sort}" cols="30" rows="10" placeholder="請填寫目的地詳細地址" required></textarea>
                <i class="clear-input">
                    <ion-icon name="close-circle"></ion-icon>
                </i>
                <div class="invalid-feedback">請填寫目的地詳細地址</div>
            </div>
        </div>
        `;
		$(".end_List_form").html(cardDetailEndForm);
		$(".end_List_form").find(".city_select").html(citySelect);
		$(".end_List_form").find(".area_select").html(areaSelect);
	});
	for (let i = 0; i < endAry.length; i++) {
		$(`#endCity${endAry[i].sort} option[value="${endAry[i].city}"]`).attr(
			"selected",
			"selected"
		);
		$(`#endAddress${endAry[i].sort}`).val(`${endAry[i].address}`);
		let end_city = $(`#endCity${endAry[i].sort}`);
		area(endAry[i].city, end_city);
		$(`#endDist${endAry[i].sort} option[value="${endAry[i].dist}"]`).attr(
			"selected",
			"selected"
		);
	}
	copyOrder("copyorder", 2000);
	// Reload('copyorder', 2000)
}
// function detailOrderCard(data) {
//     filterOrder = data[0]
//     let detailCard =
//     `
//     <div class="card">
//         <div class="card-body">
//             <h5 class="card-title">
//                 ${data[0].date}
//             </h5>
//             <p class="card-subtitle">${data[0].time}</p>
//             <div class="card-text">
//                 <p>起點 : ${data[0]['address_start']}</p>
//                 <p>目的地 : ${data[0]['address_end']}</p>
//             </div>
//             <div class="card-bottom">
//                 <div class="remark">
//                     <p>航班編號 : ${data[0].flight || '無'}</p>
//                     <p>車型 : ${data[0]['car_model']}</p>
//                     <p>行李數 : ${data[0].baggage}件 / 乘客數 : ${data[0].number}人</p>
//                     <p>備註 : ${data[0].remark || '無'}</p>
//                 </div>
//             </div>
//         </div>
//     </div>
//     `
//     $('.detail_card').html(detailCard);
// }
// $(document).on('click','.detail_card',function() {
//     console.log(filterOrder);
//     $(`input[name="name"]`).val(`${filterOrder['name']}`)
//     $(`select[name="car_model"] option[value="${filterOrder['car_model']}"]`).prop('selected',true);
//     $('input[name="number"]').val(`${filterOrder['number'] || ''}`)
//     $('input[name="baggage"]').val(`${filterOrder['baggage'] || ''}`)
//     $('input[name="remark"]').val(`${filterOrder['remark'] || ''}`)
//     $(`#startCity option[value="${filterOrder['start_city']}"]`).attr('selected','selected');
//     $(`#startAddress`).val(`${filterOrder['start_addr']}`)
//     let startCity = $('#startCity')
//     area(filterOrder['start_city'],startCity);
//     $(`#startDist option[value="${filterOrder['start_dist']}"]`).attr('selected','selected');
//     let endAry = filterOrder.end;
//     areaNum = filterOrder.end.length;
//     let cardDetailEndForm = '';
//     endAry.forEach((item) => {
//         cardDetailEndForm +=
//         `
//         <div class="form-group boxed form-multiple end_form areaList" data-destination="${item.sort}">
//             <a href="#" class="delete" data-toggle="modal">
//                 <ion-icon name="remove-circle-outline"></ion-icon>
//                 <span>刪除</span>
//             </a>
//             <div class="input-wrapper">
//                 <label class="label" for="">目的地城市</label>
//                 <select class="form-control custom-select city_select" id="endCity${item.sort}" name="end_city" required>
//                 </select>
//                 <div class="invalid-feedback">請選擇目的地城市</div>
//             </div>
//             <div class="input-wrapper">
//                 <label class="label" for="">目的地區域</label>
//                 <select class="form-control custom-select area_select" id="endDist${item.sort}" name="end_area" required>
//                 </select>
//                 <div class="invalid-feedback">請選擇目的地區域.</div>
//             </div>
//             <div class="input-textarea">
//                 <label class="label d-flex justify-content-between" for="">
//                     目的地詳細地址
//                     <span class="commonly_county">
//                         <a href="javascript:;" class="text-primary commonly_county">選擇常用地點</a>
//                     </span>
//                 </label>
//                 <textarea class="form-control address" name="address" id="endAddress${item.sort}" cols="30" rows="10" placeholder="請填寫目的地詳細地址" required></textarea>
//                 <i class="clear-input">
//                     <ion-icon name="close-circle"></ion-icon>
//                 </i>
//                 <div class="invalid-feedback">請填寫目的地詳細地址</div>
//             </div>
//         </div>
//         `
//         $('.end_List_form').html(cardDetailEndForm);
//         $('.end_List_form').find('.city_select').html(citySelect)
//         $('.end_List_form').find('.area_select').html(areaSelect)
//     })
//     for(let i = 0; i < endAry.length; i++) {
//         $(`#endCity${endAry[i].sort} option[value="${endAry[i].city}"]`).attr('selected','selected');
//         $(`#endAddress${endAry[i].sort}`).val(`${endAry[i].address}`)
//         let end_city = $(`#endCity${endAry[i].sort}`)
//         area(endAry[i].city,end_city);
//         $(`#endDist${endAry[i].sort} option[value="${endAry[i].dist}"]`).attr('selected','selected');
//     }
// })
// let areaNum = 1;
$(".add").on("click", function (e) {
	e.stopPropagation();
	let str;
	let areaList = $(".end_List_form")[0].children
	let lastElementId = areaList[areaList.length-1].attributes[1].nodeValue
	areaNum = Number(lastElementId) +1
	console.log(areaNum)
	// if (areaNum < 2) {
	// 	areaNum = 2;
	// } 
	// else if(areaNum <= 0){
	// 	areaNum = 1;
	// }
	
	str = `
    <div class="form-group boxed form-multiple end_form areaList" data-destination="${areaNum}">
        <a href="#" class="delete" data-toggle="modal">
            <ion-icon name="remove-circle-outline"></ion-icon>
            <span>刪除</span>
        </a>
        <div class="input-wrapper">
            <label class="label" for="">目的地城市</label>
            <select class="form-control custom-select city_select" id="endCity${areaNum}" name="end_city${areaNum}" required>
            </select>
            <div class="invalid-feedback">請選擇目的地城市</div>
        </div>
        <div class="input-wrapper">
            <label class="label" for="">目的地區域</label>
            <select class="form-control custom-select area_select" id="endDist${areaNum}" name="end_area${areaNum}" required>
            </select>
            <div class="invalid-feedback">請選擇目的地區域.</div>
        </div>
        <div class="input-textarea">
            <label class="label d-flex justify-content-between" for="address${areaNum}">
                目的地詳細地址
                <span class="commonly_county">
                    <a href="javascript:;" class="text-primary commonly_county">選擇常用地點</a>
                </span>
            </label>
            <textarea class="form-control address" name="address" id="endAddress${areaNum}" cols="30" rows="10" name="address${areaNum}" placeholder="請填寫目的地詳細地址" required></textarea>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
            <div class="invalid-feedback">請填寫目的地詳細地址</div>
        </div>
    </div>
    `;
	// $(".location").append(str);
    // $(".location").find(`#endCity${areaNum}`).html(citySelect);
    // $(".location").find(`#endDist${areaNum}`).html(areaSelect);
	$(".end_List_form").append(str);
	$(".end_List_form").find(`#endCity${areaNum}`).html(citySelect);
	$(".end_List_form").find(`#endDist${areaNum}`).html(areaSelect);
});

$(document).on("click", ".delete", function (e) {
	if (areaNum <= 1) {
		alert('至少要有一個目的地')
		return
	}
	let destination = $(this).parent();
	console.log(destination)
	$("#deleteDialog").modal("show");
	$(".delete_Y").on("click", function () {
		areaNum--;
		destination.remove();
		if (areaNum === 0) {
			areaNum = 1
		}
		console.log(areaNum)
	});
});

// function endstr(areaNum) {
//     let str = '';
//     str +=
//     `
//     <div class="form-group boxed form-multiple end_form areaList" data-destination="${areaNum}">
//         <a href="#" data-toggle="modal">
//             <div class="delete">
//                 <ion-icon name="remove-circle-outline"></ion-icon>
//                 <span>刪除</span>
//             </div>
//         </a>
//         <div class="input-wrapper">
//             <label class="label" for="city${areaNum}">目的地城市</label>
//             <select class="form-control custom-select city_select" id="city${areaNum}" name="end_city" required>
//             </select>
//             <div class="invalid-feedback">請選擇目的地城市</div>
//         </div>
//         <div class="input-wrapper">
//             <label class="label" for="dist${areaNum}">目的地區域</label>
//             <select class="form-control custom-select area_select" id="dist${areaNum}" name="end_area" required>
//             </select>
//             <div class="invalid-feedback">請選擇目的地區域.</div>
//         </div>
//         <div class="input-textarea">
//             <label class="label d-flex justify-content-between" for="address${areaNum}">
//                 目的地詳細地址
//                 <span class="commonly_county">
//                     <a href="javascript:;" class="text-primary commonly_county">選擇常用地點</a>
//                 </span>
//             </label>
//             <textarea class="form-control address" name="address" id="address${areaNum}" cols="30" rows="10" placeholder="請填寫目的地詳細地址" required></textarea>
//             <i class="clear-input">
//                 <ion-icon name="close-circle"></ion-icon>
//             </i>
//             <div class="invalid-feedback">請填寫目的地詳細地址</div>
//         </div>
//     </div>
//     `
//     return str
// }
//選擇常用地點
$("#countyModal").on("show.bs.modal", function (e) {
	sendRequestAddressList();
});
let a_id = "";
let chooseLocation;
$(document).on("click", ".commonly_county", function (e) {
	e.stopPropagation();
	$("#countyModal").modal("show");
	a_id = $(this).parents(".end_form").data("destination");
	chooseLocation = $(this);
	// localStorage.setItem('a_id',a_id);
});
function sendRequestAddressList() {
	$.ajax({
		url: baseUrl + "api/address_list",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
		},
		success: function (res) {
			if (res.status) {
				render(res["addr_list"]);
			} else {
				if(res.token_status == false){
					alert(res.msg);
					localStorage.clear();
					location.href = '../home/login'
				}
			}
		},
	});
}
function render(data) {
	let str = "";
	if (data === false) {
		str += `
        `;
	} else {
		data.forEach((item) => {
			str += `
			<li data-end="${item.id}">
				<div class="custom-control custom-radio">
					<input type="radio" id="${
										item.id
									}" name="commonlyCity" class="custom-control-input">
					<label class="custom-control-label" for="${item.id}">${
				item["city_str"] + item["dist_str"] + item["address"]
			}</label>
				</div>
				<div class="delete-icon delete_county">
					<a href="javascript:;" data-toggle="modal" data-target="#DialogBasic">
						<ion-icon name="remove-circle-outline"></ion-icon>
					</a>
				</div>
			</li>
			`;
		});
	}
	$(".commonly_modal_county").html(str);
}

// 選擇常用地點並把值塞到欄位
$(document).on("click", ".commonly_city_confirm", function () {
	let addr_id = $('input[name="commonlyCity"]:checked').attr("id");
	$.ajax({
		url: baseUrl + "api/addr_add_to_order",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			a_id: a_id,
			addr_id: addr_id,
		},
		success: function (res) {
			if (res.status) {
				renderEndForm(res);
			} else {
				if(res.token_status == false){
					alert(res.msg);
					localStorage.clear();
					location.href = '../home/login'
				}
			}
		},
	});
});
function renderEndForm(data) {
	let newLocation = new Object();
	let city = data["address_data"].city;
	let dist = data["address_data"].area;
	let address = data["address_data"].address;
	chooseLocation
		.parents(".end_form")
		.find(`.city_select option[value="${city}"]`)
		.prop("selected", true);
	chooseLocation.parents(".end_form").find(`.address`).val(address);
	let cityVal = chooseLocation.parents(".end_form").find(".city_select").val();
	area(cityVal, chooseLocation);
	chooseLocation
		.parents(".end_form")
		.find(`.area_select option[value="${dist}"]`)
		.prop("selected", true);
}

// 刪除常用地點
$(document).on("click", ".delete_county", function (e) {
	const address_id = $(this).parent().data("end");
	localStorage.setItem('address_id', address_id)
});
$(".delete_county_Y").on("click", function (e) {
	const address_id = localStorage.getItem('address_id')
	$.ajax({
		url: baseUrl + "api/del_address",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			address_id: address_id,
		},
		success: function (res) {
			if (res.status) {
				sendRequestAddressList();
				$("#DialogBasic").modal("hide");
			} else {
				if(res.token_status == false){
					alert(res.msg);
					localStorage.clear();
					location.href = '../home/login'
				}
			}
		},
	});
	localStorage.setItem('address_id', '')
});
// 增加常用地點
$(document).on("click", ".add_county", function (e) {
	$("#countyModal").modal("hide");
	$("#addCounty").modal("show");
});
$("#addCounty").on("hidden.bs.modal", function (e) {
	$("#modalCity").val("");
	$("#modalDist").val("");
	$("#modalAddress").val("");
});
$(document).on("click", ".add_county_Y", function (e) {
	let city = $("#modalCity").val();
	let dist = $("#modalDist").val();
	let address = $("#modalAddress").val().trim();
	let data = {};
	data.token = token;
	data.city = city;
	data.dist = dist;
	data.address = address;
	if (data.address === "" || data.city === null || data.dist === null) {
		alert('常用地點資訊不能為空')
		return
	}
	$.ajax({
		url: baseUrl + "api/add_address",
		type: "POST",
		dataType: "json",
		data: data,
		success: function (res) {
			if (res.status) {
				// sendRequestAddressList();
				$("#addCounty").modal("hide");
				$("#countyModal").modal("show");
			} else {
				if(res.token_status == false){
					alert(res.msg);
					localStorage.clear();
					location.href = '../home/login'
				}
			}
		},
	});
});
let submit = function () {
	let token = localStorage.getItem("token");
	let name = $('input[name="name"]').val().trim();
	let phone = $(".order_contact_person").val().trim();
	let date = $('input[name="date"]').val();
	let hour = $('select[name="hour"]').val();
	let minute = $('select[name="minute"]').val();
	let flight = $('input[name="flight"]').val().trim();
	let carmodel = $('select[name="car_model"]').val();
	let people = $('input[name="number"]').val().trim();
	let baggage = $('input[name="baggage"]').val().trim();
	let remark = $('textarea[name="remark"]').val().trim();
	let price = $('input[name="price"]').val().trim();
	let final_status = $('input[name="customRadioInline"]:checked').val();
	let final_payment = $('input[name="final_payment"]').val().trim();
	let outset = new Object();
	outset.city = $('select[name="outset_city"]').val();
	outset.area = $('select[name="outset_area"]').val();
	outset.address = $('textarea[name="outset_address"]').val();
	let endAry = [];
	$(".areaList").each((index, ele) => {
		let testObj = {};
		console.log('index' + index)
		let dataIndex = ele.attributes[1].value
		if (dataIndex) {
			let city = $(`#endCity${dataIndex} option:selected`).text();
			let area = $(`#endDist${dataIndex} option:selected`).text();
			let address = $(`#endAddress${dataIndex}`).val();
			console.log(city)
			console.log(area)
			console.log(address)
			testObj.id = dataIndex;
			testObj.city = city;
			testObj.area = area;
			testObj.address = address;
			endAry.push(testObj);
		}
	});
	endAry.forEach(item => {
		if (item.address === '' || item.area === '請選擇' || item.city === '請選擇') {
			alert('請檢查是否有目的地資訊為空')
			return
		}
	})
	let data = {};
	data.token = token;
	data.name = name;
	data.phone = phone;
	data.date = date;
	if (minute < 10) {
        data.minute= '0' + minute
    }else {
        data.minute= minute
    }
    if (hour < 10) {
        data.hour= '0' + hour
    }else {
        data.hour= hour
    }
	data.flight = flight;
	data.car_model = carmodel;
	data.number = people;
	data.baggage = baggage;
	data.remark = remark;
	data.price = price;
	data.final_status = final_status;
	data.final_payment = final_payment;
	data.outset = outset;
	data.end = endAry;
	console.log(endAry)
	$.ajax({
		url: baseUrl + "api/order",
		type: "POST",
		dataType: "json",
		data: data,
		success: function (res) {
			if (res.status) {
				Reload("toast-4", 3000);
			} else {
				if(res.token_status == false){
					alert(res.msg);
					localStorage.clear();
					location.href = '../home/login'
				}
			}
		},
	});
};
async function Reload(ele, ms) {
	await creatToastbox(ele, ms);
	window.location.href = 'dispach'
}
async function copyOrder(ele, ms) {
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

