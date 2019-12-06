<?php include dirname(__DIR__) . '/../public/head.php'; ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">服务订阅者</h1>
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
                <th>订阅服务</th>
                <th>推送</th>
                <th>推送参数</th>
            </tr>
        </thead>
        <tbody id="dispatchList"></tbody>
    </table>
</div>
<script>
    $(function () {
        getDispatchLst();
        setInterval(getDispatchLst, 1000);
        function getDispatchLst() {
            $.post('/admin/dispatch', {}, function (json) {
                if (json.status == 1) {
                    showIn(json.data);
                }
            });
        }
        function showIn(data) {
            var dispatchList = $("#dispatchList");
            dispatchList.empty();
            $.each(data, function (i, e) {
                var row = $("<tr></tr>");
                row.append('<td>' + e.key + '</td>');
                row.append('<td>' + e.group + '</td>');
                row.append('<td>' + e.host + '</td>');
                row.append('<td>1</td>');
                var str = "<td>";
                for (i = 0; i < e.service.length; i++) {
                    str += e.service[i] + "<br/>";
                }
                str += "</td>";
                row.append(str);
                row.append('<td>' + e.dispatch + '</td>');
                row.append('<td>推送地址' + e.dispatch_url + '<br/>最后推送' + e.utime + '<br/>' + '</td>');
                dispatchList.append(row);
            });
        }
    })
</script>

<?php
include dirname(__DIR__) . '/../public/foot.php';
