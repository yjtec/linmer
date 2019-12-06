<?php include dirname(__DIR__) . '/../public/head.php'; ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">服务提供者</h1>
    </div>
</div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>key</th>
                <th>group</th>
                <th>host</th>
                <th>注册</th>
                <th>心跳</th>
                <th>存活</th>
                <th>心跳参数</th>
            </tr>
        </thead>
        <tbody id="serviceList"></tbody>
    </table>
</div>
<script>
    $(function () {
        getServiceLst();
        setInterval(getServiceLst, 1000);
        function getServiceLst() {
            $.post('/admin/service', {}, function (json) {
                if (json.status == 1) {
                    showIn(json.data);
                }
            });
        }
        function showIn(data) {
            var serviceList = $("#serviceList");
            serviceList.empty();
            $.each(data, function (i, e) {
                var row = $("<tr></tr>");
                row.append('<td>' + e.key + '</td>');
                row.append('<td>' + e.group + '</td>');
                row.append('<td>' + e.host + '</td>');
                row.append('<td>1</td>');
                row.append('<td>' + e.heart_enable + '</td>');
                row.append('<td>' + e.live_time + '</td>');
                row.append('<td>' + e.status + '</td>');
                row.append('<td>心跳地址' + e.heart_url + '<br/>最后心跳' + e.utime + '<br/>' + '</td>');
                serviceList.append(row);
            });
        }
    })
</script>

<?php
include dirname(__DIR__) . '/../public/foot.php';
