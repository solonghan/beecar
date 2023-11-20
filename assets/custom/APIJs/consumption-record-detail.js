let token = localStorage.getItem("token");
let id = $.urlParam("id");

// GET 消費紀錄列表
function get_spend_record_list(data = {token, id}) {
    $.ajax({
		url: baseUrl + "api/get_spend_record_list",
		type: "POST",
		dataType: "json",
		data:{
            token,id
        },
		success: function (res) {
			if (res.status) {
                render_record({
                    data:res.data,
                    total_price: res.total_price,
                    pay_status: res.pay_status,
                    title: res.title
                })
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
get_spend_record_list()

// 渲染消費紀錄列表
function  render_record({data,total_price,pay_status,title}){
    let str = "";
	if (data[0] !=null) {
		data.forEach((item) => {
			str += `
            <li class="border-bottom">
                <a href="${baseUrl}driver/consumption-record-detail-detail?id=${item.id}" class="item" style="padding-right: 60px;">
                    <div class="in">
                        <div>
                            ${item.date}
                            <footer>${item.summary}</footer>
                        </div>
                        <span class="text-muted">${item.price}</span>
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

    if(total_price){
        $('.total_price').text(`
        ${pay_status == 'pending' ? '當月未繳總金額' : '當月總金額'} : ${total_price}`)
    }

    if(pay_status == 'paid') {
        $('.toPay').hide()
    }

    $('.pageTitle').text(title)

}