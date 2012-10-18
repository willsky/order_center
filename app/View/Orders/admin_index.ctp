<div id="maingrid"></div>

<script type="text/javascript">
var manager = null, grid_table = null, user_win= null;

$(function(){
    _grid_init = {
        columns: [
            { display: '订单号', name: 'id', width: 100, type: 'int', align:'left'},
            { display: '产品', name: 'product_name', type: 'text', align:'left', minWidth:100},
            { display: '客户姓名', name: 'customer_realname', type: 'text', isSort:false, minWidth:80, align:'left'},
            { display: '客户电话', name: 'customer_telephone', type: 'text', minWidth:100, align:'left'},
            { display: '客户邮件', name: 'customer_email', type: 'text', isSort:false, minWidth:150, align:'left'},
            { display: '客户邮编', name: 'customer_zipe_code', type: 'text', isSort:false, minWidth:100, align:'left'},
            { display: '客户地址', name: 'customer_address', type: 'text', isSort:false, minWidth:200, align:'center'},
            { display: '订单状态', name: 'state', type: 'text', isSort:false, minWidth:80, align:'center'},
            { display: '物流', name: 'transport', type: 'text', isSort:false, minWidth:100, align:'center'},
            { display: '支付方式', name: 'payment', type: 'text', isSort:false, minWidth:100, align:'center'},
            { display: '发货人', name: 'sender', type: 'text', isSort:false, minWidth:100, align:'center'},
            { display: '创建时间', name: 'created', type: 'text', isSort:false, minWidth:100, align:'center'},
            { display: '发货时间', name: 'updated', type: 'text', isSort:false, minWidth:100, align:'center'}
            ],
            enabledEdit: true,  
            enabledSort: true,
            rownumbers:true,
            checkbox: true,
            dataAction: 'server',
            url: '/admin/orders',
            method: 'post',
            pageSize: 20,
            height: '100%',
            pagesizeParmName: 'limit',
            root: 'data',
            record: 'total',
            sortnameParmName: 'sort',
            sortorderParmName: 'order'
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
