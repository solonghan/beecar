function getUser() {
	let userData = {};
	$.ajax({
		url: baseUrl + "api/driver_info",
		type: "POST",
		dataType: "json",
		async: false,
		data: {
			token: token,
		},
		success: function (res) {
			console.log(res);
			if (res.status) {
				driver_info = res.driver_info;
				userData["car_info"] = res.car_info;
				userData["driver_info"] = res.driver_info;
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
	return userData;
}
