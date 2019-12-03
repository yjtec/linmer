<?php include dirname(__DIR__) . '/public/head.php'; ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">总览</h1>
    </div>
</div>
<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            禅道
        </div>
        <div class="panel-body">
            <form action="http://chandao.360vrsh.com/zentao/user-login.html" method="POST" onsubmit="bindChandao()" target="_black">
                <div class="form-group input-group">
                    <span class="input-group-addon">账号</span>
                    <input type="text" class="form-control" name="account" value="<?php echo isset($adminInfo['chandao']['acc']) ? $adminInfo['chandao']['acc'] : ""; ?>">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon">密码</span>
                    <input type="password" class="form-control" name="password" value="<?php echo isset($adminInfo['chandao']['pwd']) ? $adminInfo['chandao']['pwd'] : ""; ?>">
                </div>
                <button class="btn btn-success pull-right" type="submit">打开</button>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            Jenkins
        </div>
        <div class="panel-body">
            <form action="http://jenkins.360vrsh.com/j_acegi_security_check" method="POST" onsubmit="bindJenkins()" target="_black">
                <div class="form-group input-group">
                    <span class="input-group-addon">账号</span>
                    <input type="text" class="form-control" name="j_username" value="<?php echo isset($adminInfo['jenkins']['acc']) ? $adminInfo['jenkins']['acc'] : ""; ?>">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon">密码</span>
                    <input type="password" class="form-control" name="j_password" value="<?php echo isset($adminInfo['jenkins']['pwd']) ? $adminInfo['jenkins']['pwd'] : ""; ?>">
                </div>
                <input type="hidden" class="form-control" name="from" value="/">
                <button class="btn btn-success pull-right" type="submit" value="Sign in">打开</button>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            常用网站
        </div>
        <div class="panel-body">
            <a class="btn btn-success" href="https://dev.tencent.com" target="_black">coding</a>
            <a class="btn btn-success" href="https://packagist.org" target="_black">packagist</a>
            <a class="btn btn-success" href="https://github.com" target="_black">githup</a>
            <a class="btn btn-success" href="https://git.php.net" target="_black">php源码库</a>
            <a class="btn btn-success" href="https://pecl.php.net" target="_black">pecl</a>
        </div>
    </div>
</div>
<script>

    function bindChandao() {
        var acc = $("input[name='account']").val();
        var pwd = $("input[name='password']").val();
        if (acc && pwd) {
            $.post('/admin/bindChandao', {acc: acc, pwd: pwd}, function (json) {
                console.log(json);
            });
        } else {
            alert('请输入账号密码');
        }
    }

    function bindJenkins() {
        var acc = $("input[name='j_username']").val();
        var pwd = $("input[name='j_password']").val();
        if (acc && pwd) {
            $.post('/admin/bindJenkins', {acc: acc, pwd: pwd}, function (json) {
                console.log(json);
            });
        } else {
            alert('请输入账号密码');
        }
    }
    $(function () {
    })
</script>

<?php include dirname(__DIR__) . '/public/foot.php'; ?>