let token = localStorage.getItem("token");
let id = $.urlParam("id");

// GET 消費紀錄列表
function get_spend_record_detail(data = {token, id}) {
    $.ajax({
		url: baseUrl + "api/get_spend_record_detail",
		type: "POST",
		dataType: "json",
		data:{
            token,id
        },
		success: function (res) {
			if (res.status) {
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
get_spend_record_detail()

// 渲染消費紀錄列表
function  render_record(data){
    $('.transcation_date').text(data.transcation_date)
    $('.discount_price').text(data.discount_price)
    $('.month_content').text(data.content)

    $('.address_start').text(data.detail.address_start)
    $('.address_end').text(data.detail.address_end)
    $('.baggage').text(data.detail.baggage)
    $('.number').text(data.detail.number)
    $('.date').text(data.detail.date)
    $('.time').text(data.detail.time)
    $('.sender_name').text(data.detail.sender_name)
    $('.final_payment').text(data.detail.final_payment)
    $('.carPrice').text(data.detail.price)
    $('.car_model').text(data.detail.car_model)

    if(data.detail.price_type){
        $('.price_type').text('轉帳')
    } else {
        $('.price_type').text('收現')
    }

    if(data.detail.final_status){
        $('.final_status').text('補貼 : ')
    } else {
        $('.final_status').text('回金 : ')
    }

}