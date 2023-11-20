let token = localStorage.getItem("token");
let id = $.urlParam("friend_id");

$.ajax({
	url: baseUrl + "api/friend_driver_detail",
	type: "POST",
	dataType: "json",
	data: {
		token: token,
		driver_id: id,
	},
	success: function (res) {
		if (res.status) {
			rendor(res.data);
			localStorage.setItem("showname", JSON.stringify(res.data.showname));
			copy(res.data);
		} else {
            if(res.token_status == false){
                alert(res.msg);
                localStorage.clear();
                location.href = '../home/login'
            } else {
                alert(res.msg);
                window.history.go(-1);
            }
        }
	},
	error: function (err) {
		throw new Error(res.msg);
		console.log(err);
	},
});
function rendor(data) {
	let title = data.showname;
	str = `
    <div class="form-group basic">
        <div class="input-wrapper">
            <label class="label" for="name1">駕駛名稱</label>
            <input type="text" class="form-control" id="name1" value="${data.showname}" disabled>
            <a href="edit-driver-name?friend_id=${data.id}">
                <span class="icon-edit"><ion-icon name="open-outline"></ion-icon></span>
            </a>
        </div>
    </div>

    <div class="form-group basic">
        <div class="input-wrapper">
            <label class="label" for="driverMobile">電話</label>
            <input type="text" class="form-control" id="driverMobile" name="driverMobile" value="${data.mobile}" disabled>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group basic">
        <div class="input-wrapper">
            <label class="label" for="lineAccount">Line帳號</label>
            <input type="text" class="form-control" id="lineAccount" value="${data["line_id"]}" disabled>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group basic">
        <div class="input-wrapper">
            <label class="label" for="brand">車輛品牌</label>
            <input type="text" class="form-control" id="brand" value="${data.brand}" disabled>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group basic">
        <div class="input-wrapper">
            <label class="label" for="model">車輛型號</label>
            <input type="text" class="form-control" id="model" value="${data.model}" disabled>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group basic">
        <div class="input-wrapper">
            <label class="label" for="type">車型</label>
            <input type="text" class="form-control" id="type" value="${data.type}" disabled>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group basic">
        <div class="input-wrapper">
            <label class="label" for="year">出廠年份</label>
            <input type="text" class="form-control" id="year" value="${data.year}" disabled>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group basic">
        <div class="input-wrapper">
            <label class="label" for="color">顏色</label>
            <input type="text" class="form-control" id="color" value="${data.color}" disabled>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group basic">
        <div class="input-wrapper">
            <label class="label" for="licensePlateNumber">車牌號碼</label>
            <input type="text" class="form-control" id="licensePlateNumber" name="licensePlateNumber" value="${data.plate}" disabled>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>
    `;
	$(".pageTitle").text(title);
	$(".driverInfo").html(str);
	$("a#add_group").attr("href", `add-group?friend_id=${data.id}`);
	$("#blockadeFriendDialog .modal-title").text(`是否封鎖${data.showname}?`);
    $("#addfriendDialog .modal-title").text(`是否將${data.showname}加為好友?`);
	// $("#delFriendDialog .modal-title").text(`是否刪除${data.showname}?`);
}

$(".add_Y").on("click", function (e) {
	$.ajax({
		url: baseUrl + 'api/add_friend',
		type: 'POST',
		dataType: 'json',
		data: {
			token: token,
			driver_id: id
		},
		success: function(res) {
			if (res.status) {
				alert("已加為好友");
				location.href = "member";
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
	})
});

$(".block_Y").on("click", function (e) {
	$.ajax({
		url: baseUrl + 'api/friend_to_black',
		type: 'POST',
		dataType: 'json',
		data: {
			token: token,
			driver_id: id
		},
		success: function(res) {
			if (res.status) {
				alert("已封鎖");
				location.href = "member";
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
	})
});