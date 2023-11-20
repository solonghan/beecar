let token = localStorage.getItem("token");

// GET 消費紀錄說明
function get_spend_text(data = {token}) {
    $.ajax({
		url: baseUrl + "api/get_spend_text",
		type: "POST",
		dataType: "json",
		data,
		success: function (res) {
			if (res.status) {
                $('#note .spendTitle').text(res.data.title)
                $('#note .spendContent').html(res.data.content)
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
get_spend_text()

// GET 消費紀錄列表
function get_spend_record(data = {token}) {
    $.ajax({
		url: baseUrl + "api/get_spend_record",
		type: "POST",
		dataType: "json",
		data,
		success: function (res) {
			if (res.status) {
                console.log(res.data.id, res.data.date, res.data.pay_status, res.data.price );
                render_record(res.data)
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
get_spend_record()

// 渲染消費紀錄列表
function  render_record(data){
    let str = "";
	if (data[0] !=null) {
		data.forEach((item) => {
			str += `
            <li class="border-bottom">
                <a href="${baseUrl}driver/consumption-record-detail?id=${item.id}" class="item" style="padding-right:16px">
                    <div class="in grid">
                        <div class="col-4">
                        ${item.date}
                        </div>
                        <div class="col-4 text-center ${item.pay_status == 'pending' ? `text-danger` : ''}">
                        ${
                            item.pay_status == 'pending' ? '未付款' :
                            item.pay_status == 'paid' ? '已付款' : 'null'
                        }
                        </div>
                        <div class="text-muted col-4 text-right" style="padding-right: 60px;">
                            ${item.price}
                        </div>
                    </div>
                </a>
            </li>
			`;
		});
	} else {
		str = `
		<div class="no_list">
			<p>
				暫無紀錄
			</p>
		</div>
		`;
	}
    $(".record").html(str);

}