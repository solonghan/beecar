<div class="section mt-2 mb-2">
    <div class="filtergroup">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <label class="label" for="">日期</label>
                <div class="datepick">
                    <input type="text" class="form-control col-5" id="from" name="from" placeholder="請選擇" required>
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                    <div class="fs-3">~</div>
                    <input type="text" class="form-control col-5" id="to" name="to" placeholder="請選擇" required>
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
                <label class="label" for="startarea">狀態</label>
                <!-- onclick="location.href='<?=base_url()?>driver/status';" -->
                <input type="button" class="form-control" id="startarea" data-filter="status" value="請選擇" data-toggle="modal" data-target="#statusFilter">
                <!-- <i class="clear-input">
                    <ion-icon name="close-circle"></ion-icon>
                </i> -->
                <div class="status_result p-0">
                </div>
                <!-- <input type="text" class="form-control" id="cash2" value="待承接、已承接" disabled> -->
            </div>
        </div>

        <div class="form-group boxed">
            <div class="input-wrapper filter-input">
                <label class="label" for="model">車型</label>
                <!-- onclick="location.href='<?=base_url()?>driver/modal';" -->
                <input type="button" class="form-control" data-filter="modal" id="model" value="請選擇" data-toggle="modal" data-target="#modalFilter">
                <div class="modal_result p-0">
                </div>
            </div>
        </div>
        <!-- onclick="location.href='<?=base_url()?>driver/city?start';" -->
        <div class="form-group boxed">
            <div class="input-wrapper filter-input">
                <label class="label" for="startarea">起點位置</label>
                <!-- onclick="location.href='<?=base_url()?>driver/city?type=start';" -->
                <input type="button" class="form-control" data-filter="start" id="startarea" value="請選擇" data-toggle="modal" data-target="#startFilter">
                <div class="start_city p-0">
                    <!-- <input type="text" class="form-control" id="cash2" value="台北市 全區" disabled> -->
                </div>
            </div>
        </div>

        <div class="form-group boxed">
            <div class="input-wrapper filter-input">
                <label class="label" for="endarea">目的地地區</label>
                <!-- onclick="location.href='<?=base_url()?>driver/city?type=end';" -->
                <input type="button" class="form-control" data-filter="end" id="endarea" value="請選擇" data-toggle="modal" data-target="#endFilter">
                <div class="end_city p-0">
                </div>
            </div>
        </div>
    </div>
    <input type="button" name="filter" class="btn btn-primary btn-lg btn-block" value="篩選">
    <input type="button" name="clearfilter" class="btn btn-outline-primary btn-lg btn-block" value="清除篩選">
</div>