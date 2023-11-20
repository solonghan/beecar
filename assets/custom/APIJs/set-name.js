const role = localStorage.getItem("role");
$('input[type="submit"]').on("click", function (e) {
	e.preventDefault();
	let name = $('input[name="name"]').val().trim();
	let line = $('input[name="line"]').val().trim();
	const password = JSON.parse(localStorage.getItem("password"));
	const token = JSON.parse(localStorage.getItem("token"));
	let data = {};
	data.password = password;
	data.token = token;
	if (name == "") {
		alert("名稱不可為空");
		return;
	} else {
		data.username = name;
	}

	if (line == "") {
		alert("Line帳號不可為空");
		return;
	} else {
		data["line_id"] = line;
	}
	$.ajax({
		url: baseUrl + "api/first_setting",
		type: "POST",
		dataType: "json",
		data: data,
		success: function (res) {
			if (res.status) {
				if (role == "driver") {
					location.href = "./set-carinfo";
				} else if (role == "dealer") {
					localStorage.removeItem("role");
					localStorage.removeItem("token");
					localStorage.removeItem("password");
					location.href = "./../home/login";
				}
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
