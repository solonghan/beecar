<div class="section mt-2 mb-2">
    <div class="filtergroup">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <label class="label" for="">日期</label>
                <div class="datepick">
                    <input type="text" class="form-control col-5 date_1" id="from" name="from" placeholder="請選擇">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                    <div class="fs-3">~</div>
                    <input type="text" class="form-control col-5 date_2" id="to" name="to" placeholder="請選擇">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>
        </div>

        <div id="timepicker">
            <div class="form-group boxed d-flex justify-content-between align-items-center">
                <div class="input-wrapper col-5 p-0">
                    <label class="label" for="startTime">起始時間</label>
                    <input type="text" class="time start form-control" placeholder="請選擇" name="startTime" required>
                    <div class="invalid-feedback">請選擇時間</div>
                </div>
                <div class="fs-3 pt-3">~</div>
                <div class="input-wrapper col-5 p-0">
                    <label class="label" for="endTime">結束時間</label>
                    <input type="text" class="time end form-control" placeholder="請選擇" name="endTime" required>
                    <div class="invalid-feedback">請選擇時間</div>
                </div>
            </div>
        </div>

        <div class="form-group boxed">
            <div class="input-wrapper filter-input">
                <label class="label" for="model">車型</label>
                <input type="button" class="form-control" id="model" value="請選擇" data-toggle="modal" data-target="#modalFilter">
                <div class="modal_result p-0">
                </div>
            </div>
        </div>

        <div class="form-group boxed">
            <div class="input-wrapper filter-input">
                <label class="label" for="startarea">起點位置</label>
                <input type="button" class="form-control" id="startarea" value="請選擇" data-toggle="modal" data-target="#startFilter">
                <i class="clear-input">
                    <ion-icon name="close-circle"></ion-icon>
                </i>
                <div class="start_city p-0">
                    <!-- <input type="text" class="form-control" id="cash2" value="台北市 全區" disabled> -->
                </div>
            </div>
        </div>

        <div class="form-group boxed">
            <div class="input-wrapper filter-input">
                <label class="label" for="endarea">目的地地區</label>
                <input type="button" class="form-control" id="endarea" value="請選擇" data-toggle="modal" data-target="#endFilter">
                <i class="clear-input">
                    <ion-icon name="close-circle"></ion-icon>
                </i>
                <div class="end_city p-0">
                </div>
            </div>
        </div>
    </div>
    <input type="button" name="filter" class="btn btn-primary btn-lg btn-block" value="新增篩選">
    <input type="button" name="clearfilter" class="btn btn-outline-primary btn-lg btn-block" value="清除篩選">
</div>
<script>
    ;(function() {
        const cityfilter = JSON.parse(localStorage.getItem('start')) || '';
        if (cityfilter != '') {
            const filtertype = cityfilter.type
            const filterVal = cityfilter.val;
            let str = '';
            if (filtertype == 'start') {
                filterVal.forEach((item) => {
                    str += `
                    <li class="cityfilter">
                        <input type="text" class="form-control" id="cash2" value="${item}" disabled>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </li>`
                })
                $('.start_city').html(str)
            } else if (filtertype == 'end') {
                filterVal.forEach((item) => {
                    str += `
                    <li class="cityfilter">
                        <input type="text" class="form-control" id="cash2" value="${item}" disabled>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </li>`
                })
                $('.end_city').html(str)
            }
        }
    })();
    $(document).on('click','.cityfilter .clear-input',function(e) {
        console.log(e);
        $(this).parents('.cityfilter').remove()
    })
</script>