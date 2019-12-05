<?php include dirname(__DIR__) . '/public/head.php'; ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">修改密码</h1>
    </div>
</div>
<div class="form-group input-group">
    <span class="input-group-addon">原密码</span>
    <input type="text" class="form-control" name="opwd">
</div>
<div class="form-group input-group">
    <span class="input-group-addon">新密码</span>
    <input type="text" class="form-control" name="npwd">
</div>
<div class="form-group input-group">
    <span class="input-group-addon">原密码</span>
    <input type="text" class="form-control">
</div>
<button type="button" class="btn btn-primary" onclick="changPwd()">提交</button>
<script>

    function changPwd() {
        var opwd = $("input[name='opwd']").val();
        var npwd = $("input[name='npwd']").val();
        if (opwd && npwd) {
            $.post('/admin/upPwd', {npwd: npwd}, function (json) {
                alert(json.msg)
            });
        } else {
            alert('请输入完整');
        }
    }

    $(function () {
    })
</script>

<?php include dirname(__DIR__) . '/public/foot.php'; ?>