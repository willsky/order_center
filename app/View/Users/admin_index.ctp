<div>
	<a class="l-button" style="width:80px; float:left; margin-right:10px;" id="new_row">添加</a>
	<a class="l-button" style="width:80px; float:left;" id="del_row">删除</a>
</div>
<div class="l-clear"></div>
<div id="maingrid" style="margin: 10px 0px;"></div>

<div id='user_form' style="width:260px; height:120px; margin:35px 50px; display:none;"> 
    <div style="height:90px; width:260px; line-height: 45px;">
        <table style="width:100%;">
            <tr style="height:45px;">
                <td width="60px" align="right">用户：</td>
                <td width="200px" align="left"><input type="text" value="" id="username" style="width:180px;" /></td>
            </tr>
            <tr style="height:45px;">
                <td align="right">密码：</td>
                <td align="left"><input type="password" id="password" value="" style="width:180px;" /></td>
            </tr>
        </table>
    </div> 
    <div style="height:30px; line-height:30px; text-align:center;">
        <a class="l-button" id="ok" style="width:40px; margin-left:80px; float:left;">确定</a>
        <a class="l-button" id="cancel" style="width:40px; margin-left:20px; float:left;">取消</a>
    </div>
</div>

<script type="text/javascript">
var manager = null, grid_table = null, user_win= null;

$(function(){
    _grid_init = {
        columns: [
            { display: '主键', name: 'id', width: 50, type: 'int',frozen:true },
            { display: '名字', name: 'name', type: 'text', align:'center', minWidth:150, width:150},
            { display: '昵称', name: 'nickname', type: 'text', isSort:false, minWidth:150, align:'center', editor:{type:'text'}},
            { display: '操作人', name: 'operate', type: 'text', minWidth:100, align:'center'},
            { display: '创建时间', name:'created', type: 'text', width:150, isSort: false, align:'center', render: function(_row, _index){ return top.strftime(_row.created);}}
            ],
            enabledEdit: true,  
            enabledSort: true,
            //clickToEdit: false,
            isScroll: true, 
            rownumbers:true,
            checkbox: true,
            dataAction: 'server',
            url: '/admin/users',
            method: 'post',
            pageSize: 20,
            height: '100%',
            pagesizeParmName: 'limit',
            root: 'data',
            record: 'total',
            sortnameParmName: 'sort',
            sortorderParmName: 'order',
            onAfterEdit: function(e){
                var _id = e.record.id, _value = e.value, _field = e.column.columnname;

                $.post('<?php echo $this->Html->url('/admin/users/update'); ?>', {id:_id, field:_field, value: _value}, function(_data){
                    var _code = _data.code | 0;
                    if ( _code ) $.ligerDialog.warn(_data.msg, '提示');
                }, 'json');
            }
    };

    grid_table = manager = $("#maingrid").ligerGrid(_grid_init);
    $("#username").ligerTextBox({nullText:'请输入用户名, 不能为空'});
    $("#password").ligerTextBox({nullText:'请输入密码， 不能为空'});

    $("#new_row").bind('click', function(){
		if ( user_win ) {
			var _username = $("#username").val('');
			var _password = $("#password").val('');
			user_win.show();
		} else 
			user_win = $.ligerDialog.open({target:$("#user_form"), width:400, allowClose:true, title:'添加用户'});
    });

    $("#del_row").bind('click', function(){
		_rows = grid_table.getCheckedRows();
		if ( _rows.length )
		{
			var _id = '';
			
			for(var i in _rows) {

				if ( _id ) {
					_id += ","+ _rows[i].id;
				} else {
					_id = _rows[i].id;
				}
			}

			$.post("/admin/users/delete", {id:_id}, function(_data){
				var _code = _data.code | 0;

				if ( _code ) {
					$.ligerDialog.error(_data.msg);
				} else {
					grid_table.loadData();
				}
				
			}, 'json');
		}
    });

    $("#cancel").bind("click", function() {
		if ( user_win ) {
		   	user_win.hidden();
//		   	user_win.close();
//			user_win = null;
		}
    });

    $("#ok").bind("click", function() {
        var _username = $("#username").val();
        var _password = $("#password").val();

        if ( _username.length < 5){
            $.ligerDialog.warn('用户名必须大于4个字符', '提示');
            return false;
        }

        if ( _password.length < 1) {
            $.ligerDialog.warn('密码不能为空', '提示');
            return false;
        }

        $.post('/admin/users/add', {username:_username, password:_password}, function(_data) {
            var _code = _data.code | 0;

			if ( user_win ) {
				user_win.hidden();
				//user_win.close();
				//user_win = null;
			}

            if ( _code ) {
                $.ligerDialog.error(_data.msg, '提示');
            } else {
                grid_table.loadData();
            }
        }, 'json');
    });
});
</script>
