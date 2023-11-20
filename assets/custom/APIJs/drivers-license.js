let token = localStorage.getItem("token");
let coverImage = document.getElementById("coverImage");
let coverImage2 = document.getElementById("coverImage2");
let cropper;
let related_id;
let ratio = 6 / 4;

$(document).ready(function () {
	let userdata = getUser();
	let front = userdata.driver_info.driverlicense.frontend;
	let backend = userdata.driver_info.driverlicense.backend;
	let expired_date = userdata.driver_info.driverlicense.expired_date;
	if (front != "" || front) {
		coverImg(front, 1);
	}
	if (backend != "" || backend) {
		coverImg(backend, 2);
	}
	if (expired_date != "" || expired_date) {
		$("#expiredDate").val(`${expired_date}`);
	}
});

$(window).bind("beforeunload", function () {
	localStorage.removeItem("frontend");
	localStorage.removeItem("backend");
});

$(document).on("change", ".js-photo-upload", function () {
	related_id = $(this).attr("data-related");
	dir = $(this).attr("data-dir");

	ratio = parseFloat($(this).attr("data-ratio"));
	if (ratio <= 0) ratio = -1;

	var input = this;
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$("#coverImage").attr("src", e.target.result);
			$("#coverImage").width("100%");
		};
		reader.readAsDataURL(input.files[0]);
		$("#coverModal").modal({
			backdrop: "static",
		});
		$("#coverModal").modal("show");
	}
	$(this).val("");
});
$("#coverModal")
	.on("shown.bs.modal", function () {
		cropper = new Cropper(coverImage, {
			aspectRatio: ratio,
			movable: false,
			rotatable: false,
			scalable: false,
			zoomable: false,
			zoomOnTouch: false,
			zoomOnWheel: false,
		});
	})
	.on("hidden.bs.modal", function () {
		cropper.destroy();
	});
$(document).on("change", ".js-photo-upload2", function () {
	related_id = $(this).attr("data-related");
	dir = $(this).attr("data-dir");
	ratio = parseFloat($(this).attr("data-ratio"));
	if (ratio <= 0) ratio = -1;

	let input = this;
	console.log(input.files);
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$("#coverImage2").attr("src", e.target.result);
			$("#coverImage2").width("100%");
		};
		reader.readAsDataURL(input.files[0]);
		$("#coverModal2").modal({
			backdrop: "static",
		});
		$("#coverModal2").modal("show");
	}
	$(this).val("");
});
$("#coverModal2")
	.on("shown.bs.modal", function () {
		cropper = new Cropper(coverImage2, {
			aspectRatio: ratio,
			movable: false,
			rotatable: false,
			scalable: false,
			zoomable: false,
			zoomOnTouch: false,
			zoomOnWheel: false,
		});
	})
	.on("hidden.bs.modal", function () {
		cropper.destroy();
	});
$("#coverSave").on("click", function () {
	var result = cropper.getCroppedCanvas();
	$("#getCroppedCanvasModal").modal().find(".modal-body").html(result);
	$.ajax({
		url: baseUrl + "api/img_upload",
		data: {
			image: result.toDataURL("image/jpeg"),
		},
		type: "POST",
		dataType: "json",
		success: function (res) {
			if (res.status) {
				localStorage.setItem("frontend", res.path);
				coverImg(res["full_path"], 1);
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
$("#coverSave2").on("click", function () {
	var result = cropper.getCroppedCanvas();
	$("#getCroppedCanvasModal").modal().find(".modal-body").html(result);
	$.ajax({
		url: baseUrl + "api/img_upload",
		data: {
			image: result.toDataURL("image/jpeg"),
		},
		type: "POST",
		dataType: "json",
		success: function (res) {
			if (res.status) {
				localStorage.setItem("backend", res.path);
				coverImg(res["full_path"], 2);
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

function coverImg(fullpath, ele) {
	$(`.showImg${ele}`).attr("src", `${fullpath}`);
	$(`.showImg${ele}`).css("width", "100%");
	$(`.js_upload_icon${ele}`).css("display", "none");
}

$('input[type="submit"]').on("click", function (e) {
	e.preventDefault();
	let frontend = localStorage.getItem("frontend");
	let backend = localStorage.getItem("backend");
	let expired_date = $('input[name="expiredDate"]').val().trim();
	if (!frontend) {
		alert("行照正面未更新或未上傳");
		return;
	}
	if (!backend) {
		alert("行照背面未更新或未上傳");
		return;
	}
	if (expired_date == "") {
		alert("有效期限不可為空");
		return;
	}
	$.ajax({
		url: baseUrl + "api/edit_driver_info",
		type: "POST",
		dataType: "json",
		data: {
			token: token,
			type: "driverlicense",
			frontend: frontend,
			backend: backend,
			expired_date: expired_date,
		},
		success: function (res) {
			if (res.status) {
				localStorage.removeItem("frontend");
				localStorage.removeItem("backend");
				alert(res.msg);
				location.reload();
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
