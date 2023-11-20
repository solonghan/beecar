$(document).ready(function () {
	let userdata = getUser();
	let photo = userdata.driver_info.photo.frontend;
	if (photo != "" || photo) {
		imgCover(photo);
	}
});
let token = localStorage.getItem("token");
window.addEventListener("DOMContentLoaded", function () {
	let coverImage = document.getElementById("coverImage");
	let cropper;
	let related_id;
	let ratio = 6 / 4;
	$(document).on("change", ".js-photo-upload", function () {
		related_id = $(this).attr("data-related");
		dir = $(this).attr("data-dir");

		ratio = parseFloat($(this).attr("data-ratio"));
		if (ratio <= 0) ratio = -1;
		var input = this;
		console.log(input.files[0]);
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
		console.log($(".js-photo-upload"));
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
					imgCover(res["full_path"], res.path);
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
function imgCover(fullpath, path) {
	$("img").attr("src", `${fullpath}`);
	$("img").css("width", "100%");
	$(".js_upload_icon").css("display", "none");
	updataphoto(path);
}
function updataphoto(data) {
	$('input[type="submit"]').on("click", function (e) {
		e.preventDefault();
		$.ajax({
			url: baseUrl + "api/edit_driver_info",
			type: "POST",
			dataType: "json",
			data: {
				token: token,
				type: "photo",
				frontend: data,
			},
			success: function (res) {
				if (res.status) {
					alert("資料已更新");
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
}
