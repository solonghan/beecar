let token = localStorage.getItem('token');
let id = $.urlParam('order_id');
$.ajax({
    url: baseUrl + 'api/get_edit_order',
    type: 'POST',
    dataType: 'json',
    // async: false,
    data: {
        token: token,
        order_no: id,
    },
    success: function(res) {
        if(res.status) {
            renderForm(res);
        } else {
            alert(res.msg)
        }
    }
})
let areaNum = '' || 1;
function renderForm(data) {
    console.log(data);
    $('input[name="name"]').val(`${data.name}`);
    $('input[name="phone"]').val(`${data.phone}`);
    $('input[name="date"]').val(`${data.date}`);
    let hour = data.time.split(':')[0];
    let min = data.time.split(':')[1];
    if (min < 10) {
        min = min.slice(1)
    }
    if (hour < 10) {
        hour = hour.slice(1)
    }
    $(`select[name="hour"] option[value="${hour}"]`).prop('selected',true);
    $(`select[name="minute"] option[value="${min}"]`).prop('selected',true);
    $('input[name="flight"]').val(`${data.flight}`);
    $(`select[name="car_model"] option[value="${data.car_model}"]`).prop('selected',true);
    $('input[name="number"]').val(`${data.number}`);
    $('input[name="baggage"]').val(`${data.baggage}`);
    $('textarea[name="remark"]').val(`${data.remark}`);
    $('input[name="price"]').val(`${data.price}`);
    $(`input[type="radio"][value="${data['final_status']}"]`).prop('checked',true)
    $('input[name="final_payment"]').val(`${data['final_payment']}`)
    // areaNum = filterOrder.end.length;
    $(`#startCity option[value="${data['start_city']}"]`).prop('selected',true);
    $(`#startAddress`).val(`${data['start_addr']}`)
    let startCity = $('#startCity')
    console.log($('#startCity').children("option:selected").val());
    area(data['start_city'],startCity);
    $(`#startDist option[value="${data['start_dist']}"]`).prop('selected',true);
    let endAry = data.end
    areaNum = data.end.length;
    let cardDetailEndForm = '';
    endAry.forEach((item) => {
        cardDetailEndForm +=
        `
        <div class="form-group boxed form-multiple end_form areaList" data-destination="${item.id}">
            <a href="#" data-toggle="modal">
                <div class="delete">
                    <ion-icon name="remove-circle-outline"></ion-icon>
                    <span>刪除</span>
                </div>
            </a>
            <div class="input-wrapper">
                <label class="label" for="endCity${item.id}">目的地城市</label>
                <select class="form-control custom-select city_select" id="endCity${item.id}" name="end_city" required>
                </select>
                <div class="invalid-feedback">請選擇目的地城市</div>
            </div>
            <div class="input-wrapper">
                <label class="label" for="endDist${item.id}">目的地區域</label>
                <select class="form-control custom-select area_select" id="endDist${item.id}" name="end_area" required>
                </select>
                <div class="invalid-feedback">請選擇目的地區域.</div>
            </div>
            <div class="input-textarea">
                <label class="label d-flex justify-content-between" for="endAddress${item.id}">
                    目的地詳細地址
                    <span>
                        <a href="javascript:;" class="text-primary commonly_county">選擇常用地點</a>
                    </span>
                </label>
                <textarea class="form-control address" name="address" id="endAddress${item.id}" cols="30" rows="10" placeholder="請填寫目的地詳細地址" required></textarea>
                <i class="clear-input">
                    <ion-icon name="close-circle"></ion-icon>
                </i>
                <div class="invalid-feedback">請填寫目的地詳細地址</div>
            </div>
        </div>
        `
        $('.end_List_form').html(cardDetailEndForm);
        $('.end_List_form').find('.city_select').html(citySelect)
        $('.end_List_form').find('.area_select').html(areaSelect)
    })
    for(let i = 0; i < endAry.length; i++) {
        $(`#endCity${endAry[i].id} option[value="${endAry[i].city}"]`).prop('selected',true);
        $(`#endAddress${endAry[i].id}`).val(`${endAry[i].address}`)
        let end_city = $(`#endCity${endAry[i].id}`)
        area(endAry[i].city,end_city);
        $(`#endDist${endAry[i].id} option[value="${endAry[i].area}"]`).prop('selected',true);
    }
}
$('.add').on('click',function(e) {
    e.stopPropagation();
    let str;
    areaNum ++;
    if ( areaNum < 2) {
        areaNum = 2
    }
    str =
    `
    <div class="form-group boxed form-multiple end_form areaList" data-destination="${areaNum}">
        <a href="#" data-toggle="modal">
            <div class="delete">
                <ion-icon name="remove-circle-outline"></ion-icon>
                <span>刪除</span>
            </div>
        </a>
        <div class="input-wrapper">
            <label class="label" for="endCity${areaNum}">目的地城市</label>
            <select class="form-control custom-select city_select" id="endCity${areaNum}" name="end_city" required>
            </select>
            <div class="invalid-feedback">請選擇目的地城市</div>
        </div>
        <div class="input-wrapper">
            <label class="label" for="endDist${areaNum}">目的地區域</label>
            <select class="form-control custom-select area_select" id="endDist${areaNum}" name="end_area" required>
            </select>
            <div class="invalid-feedback">請選擇目的地區域.</div>
        </div>
        <div class="input-textarea">
            <label class="label d-flex justify-content-between" for="endAddress${areaNum}">
                目的地詳細地址
                <span class="commonly_county">
                    <a href="javascript:;" class="text-primary commonly_county">選擇常用地點</a>
                </span>
            </label>
            <textarea class="form-control address" name="address" id="endAddress${areaNum}" cols="30" rows="10" placeholder="請填寫目的地詳細地址" required></textarea>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
            <div class="invalid-feedback">請填寫目的地詳細地址</div>
        </div>
    </div>
    `
    $('.location').append(str)
    $('.location').find(`#endCity${areaNum}`).html(citySelect)
    $('.location').find(`#endDist${areaNum}`).html(areaSelect)
})

$(document).on('click','.delete',function(e) {
        let destination = $(this).parent().parent();
        $('#deleteDialog').modal('show')
        $('.delete_Y').on('click',function() {
            areaNum --;
            $(destination).remove();
    })
})

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
                } else {
                    alert(res.msg);
                }
            }
		},
	});
}
function render(data) {
	console.log(data);
	let str = "";
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
                } else {
                    alert(res.msg);
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
	let address_id = $(this).parent().data("end");
	$(".delete_county_Y").on("click", function (e) {
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
					$("#countyModal").modal("hide");
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
		});
	});
});
// 增加常用地點
$(document).on("click", ".add_county", function (e) {
	$("#countyModal").modal("hide");
	$("#addCounty").modal("show");
});
$("#addCounty").on("hidden.bs.modal", function (e) {
	console.log(e);
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
	$.ajax({
		url: baseUrl + "api/add_address",
		type: "POST",
		dataType: "json",
		data: data,
		success: function (res) {
			if (res.status) {
				sendRequestAddressList();
				$("#countyModal").modal("show");
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


let submit = function() {
    let name = $('input[name="name"]').val().trim();
    let phone = $('input[name="phone"]').val().trim();
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
    $('.areaList').each((index,ele) => {
        let testObj = {};
        let city = $(`#endCity${ index + 1 } option:selected`).text();
        let area = $(`#endDist${ index + 1 } option:selected`).text();
        let address = $(`#endAddress${ index + 1 }`).val();
        testObj.id = index + 1;
        testObj.city = city;
        testObj.area = area;
        testObj.address = address;
        endAry.push(testObj);
    })
    let data = {};
    data.token= token
    data.name= name
    data.order_no = id
    data.phone= phone
    data.date= date
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
    data.flight= flight
    data.car_model= carmodel
    data.number= people
    data.baggage=baggage
    data.remark= remark
    data.price= price
    data.final_status= final_status
    data.final_payment= final_payment
    data.outset= outset
    data.end= endAry
    $.ajax({
        url: baseUrl + 'api/order_edit',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(res) {
            if(res.status) {
                alert('編輯成功');
                location.href="dispach"
            } else {
                alert(res.msg)
            }
        }
    })
}
