<div id='login_form' style="width:260px; height:120px; margin:35px 50px; display:none;"> 
    <div style="height:90px; width:260px; line-height: 45px;">
        <table style="width:100%;">
            <tr style="height:45px;">
                <td width="60px" align="right">帐户：</td>
                <td width="200px" align="left"><input type="text" value="" id="username" style="width:180px;" /></td>
            </tr>
            <tr style="height:45px;">
                <td align="right">密码：</td>
                <td align="left"><input type="password" id="password" value="" style="width:180px;" /></td>
            </tr>
        </table>
    </div> 
    <div style="height:30px; line-height:30px; text-align:center;">
        <a class="l-button" id="sign_in" style="width:40px; margin-left:80px; float:left;">登录</a>
        <a class="l-button" id="reset" style="width:40px; margin-left:20px; float:left;">重置</a>
    </div>
</div>

<script type="text/javascript">
$(function(){
    $.ligerDialog.open({target:$("#login_form"), width:400, allowClose:false, title:'管理中心登录界面' });
    $("#username").ligerTextBox({nullText:'请输入用户名, 不能为空'});
    $("#password").ligerTextBox({nullText:'请输入密码， 不能为空'});
    var username = $("#username").ligerGetTextBoxManager(), password = $("#password").ligerGetTextBoxManager();

    $("#sign_in").bind('click', function(){
        var _username = username.getValue(), _password = password.getValue(); 
        
        if ( !_username ){
            $.ligerDialog.error('用户不能为空', '注意啦');
            return false;
        }

        if ( !_password ) {
            $.ligerDialog.error('密码不能为空', '注意啦');
            return false;
        }

        $.post("/login", {username:_username, password:_password}, function(data){
            var _code = data.code | 0;

            if ( 0 == _code ) {
                location.href = "/admin/pages/index";
            } else {
                $.ligerDialog.warn(data.msg, '提示');
            }
        }, 'json');
    });

    $("#reset").bind('click', function(){
        $("#username").val("");
        $("#password").val("");
    });
});
</script>

